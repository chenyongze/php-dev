<?php
/**
 * Created by PhpStorm.
 * User: wang ming
 * Create Time: 14-9-17 18:34
 * Modify Time: 14-9-17 18:34
 */

namespace BC\Tools;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Debug\ExceptionHandler;

class WebService
{
    /**
     *soap调用结果适配
     *
     */
    private static $appKey = '14070901';
    private static $appSecret = 'FEB497C6D0DB627D93F1811AE794BF14';
    private static function parseResult($result)
    {
        $key = array_keys((array)$result)[0];
        try{
            $result = json_decode($result->$key, 1);
        }catch (\Exception $e){
            return ['code'=>'error'];
        }
        return array
        (
            'code' => $result['ErrorCode'] === 0 ? 'SUCCESS' : $result['ErrorCode'],
            'message' => $result['ErrorMsg'] == null ? '' : $result['ErrorMsg'],
            'data' => $result['Response'] == null ? new \stdClass : $result['Response']
        );
    }

    /**
     * @todo 执行接口调用请求
     * @param type $method
     * @param type $param
     * @param type $flag
     * @param type $timeout
     * @param type $cache_time
     * @param type $cache_key
     * @return type
     */
    public static function execute($method, $param, $flag = 'default', $timeout = 10, $cache_time = 0, $cache_key = '')
    {
        $app_key = Config::get('service.' . $flag . '.app_key_web');
        $app_secret = Config::get('service.' . $flag . '.app_secret_web');
        $url = Config::get('service.' . $flag . '.service_ip');

        if(Config::get('app.debug')) Log::info($method.'execute');
        $params['AppKey'] = $app_key;
        $params['AppSecrete'] = $app_secret;
        $params['Request'] = json_encode($param);
        $cache_key = "{$method}-{$cache_key}-".md5(json_encode($param));
        if ($cache_time) {
            //$cache_time = 30;
            if(Config::get('app.debug')) Log::info($method.' need cache');
            if ($cache_data = Cache::get($cache_key)) {
                if(Config::get('app.debug')) {
                    Log::info($method . 'cache data:' . json_encode($cache_data));
                }
                $cache_start_time = $cache_data['cache_start_time'];
                $diff_time = time() - $cache_start_time - $cache_time * 60;
                if(Config::get('app.debug')) Log::info($method.': execute cache Flag :'.$diff_time);
                if($diff_time>0){
                    if(Config::get('app.debug')) Log::info($method.' return data that get from source');
                    return self::cacheServiceData($url,$method,$params,$cache_key,$cache_time);
                }else{
                    unset($cache_data['cache_start_time']);
                    if(Config::get('app.debug')) {
                        Log::info($method . ' return cache data');
                        Log::info($method . ' cache data:' . json_encode($cache_data));
                    }
                    return $cache_data;
                }
            }else{
                return self::cacheServiceData($url,$method,$params,$cache_key,$cache_time);
            }
        }else{
            if(Config::get('app.debug')) Log::info($method.' not need cache');
            $service_data = self::soapClient($url,$method,$params,$cache_key);
            return $service_data;
        }

    }

    /**
     * @todo 缓存数据
     *
     * @author Justin.W
     * @param $url
     * @param $method
     * @param $params
     * @param $cache_key
     * @param $cache_time
     * @return array|bool
     */
    public static function cacheServiceData($url,$method,$params,$cache_key,$cache_time)
    {
        $service_data = self::soapClient($url,$method,$params,$cache_key);
        if(!$service_data){
            return false;
        }else{
            $service_data['cache_start_time'] = time();
            Cache::put($cache_key,$service_data,Carbon::now()->addDay());
            return $service_data;
        }
    }
    /**
     * @todo 简单执行SOAP请求,若失败连续执行三次
     *
     * @author Justin.W
     * @param $service_url
     * @param $method
     * @param $params
     * @param $cache_key
     * @param $count
     * @return array|bool
     */
    public static function soapClient($service_url,$method,$params,$cache_key,$count=0){
        $timeout = 60;
        ini_set("default_socket_timeout", $timeout);
        $result = null;
        try {
            $soap = new \SoapClient
            (
                $service_url, ['connection_timeout' => $timeout,'cache_wsdl' => WSDL_CACHE_NONE ]
            );
            $soap->soap_defencoding = 'utf-8';
            $soap->decode_utf8 = false;
            $soap->xml_encoding = 'utf-8';
            $params['method'] = $method;
            if(Config::get('app.debug')){
                Log::info($method.'service url:'.$service_url);
                Log::info($method.':'.var_export($params,true));
                Log::info($params);
            }
            ++$count;
            if(Config::get('app.debug')) {
                Log::info($method . '第几次调用：' . $count);
            }
            $result = $soap->$method(array('requestString' => json_encode($params)));

        } catch (\Exception $e) {
            if(Config::get('app.debug')) Log::info($method.'|'.$count.'|'.$e->getMessage());
            if($count<4){
                return self::soapClient($service_url,$method,$params,$cache_key,$count);
            }else{
                if($cache_key){
                    $cache_data = Cache::get($cache_key);
                    return $cache_data;
                }else{
                    return false;
                }
            }
        }

        $rs = self::parseResult($result);
        if ($rs['code']!='SUCCESS'&&$rs['code'] != '1' && $rs['code'] != '100000') {
            if(Config::get('app.debug')) Log::info($method.'|'.$count.'|数据格式有误|'.json_encode($rs));
            if($count<4){
                return self::soapClient($service_url,$method,$params,$cache_key,$count);
            }else{
                if($cache_key){
                    $cache_data = Cache::get($cache_key);
                    return $cache_data;
                }else{
                    return false;
                }
            }
        } else {
            return $rs;
        }
    }

    /**
     * @todo 裸奔调用web service
     *
     * @author Justin.W
     * @param $method
     * @param $param
     * @param string $flag
     * @param int $timeout
     * @return array
     */
    public static function streakingExecute($method, $param, $flag = 'default', $timeout = 10)
    {
        ini_set("default_socket_timeout", $timeout);
        $result = null;
        $serviceHost = \Illuminate\Support\Facades\Config::get('service.' . $flag . '.service_ip');
        try {

            $soap = new \SoapClient
            (
                $serviceHost,
                array
                (
                    'connection_timeout' => $timeout,
                    'cache_wsdl' => WSDL_CACHE_NONE
                )
            );
            $soap->soap_defencoding = 'utf-8';
            $soap->decode_utf8 = false;
            $soap->xml_encoding = 'utf-8';
            LogTool::logData($param);

            $result = $soap->$method($param);

        } catch (\Exception $e) {
            LogTool::logData($e->getMessage());
            //ServiceLog::log($e->getMessage(), 'EXCEPTION');
            exit();
        }
        LogTool::logData($result);
        return $result->SendVisaProductTemplateResult->Code;

    }

    /**
     * @param string $serviceUrl webservice服务地址
     * @param string $method webservice服务方法
     * @param array $params 输入参数 数组
     * @return null|string webservice返回值或者调用时的异常信息
     */
    public static function Call($serviceUrl, $method, $params)
    {
        ini_set("default_socket_timeout", 10);
        $result = null;
        try {
            $soap = new \SoapClient
            (
                $serviceUrl,
                array
                (
                    'connection_timeout' => 10,
                    'cache_wsdl' => WSDL_CACHE_NONE
                )
            );
            $soap->soap_defencoding = 'utf-8';
            $soap->decode_utf8 = false;
            $soap->xml_encoding = 'utf-8';
            $result = $soap->$method($params);

//            $result_Result = $method . 'Result'; //组织调用后对象里的属性 方法名+Result
//            $result = $result->$result_Result;
            //var_dump($result);
        } catch (\Exception $error) {
            //调用服务异常时记录日志
            $log_name = \Config::get($serviceUrl . $method);
            if(Config::get('app.debug')) {
                ServiceLog::log('调用服务时[' . $serviceUrl . $method . ']出现系统异常，参数：' . implode('|', $params) . '原因可能是：' . $error->getMessage(), 'EXCEPTION', $log_name);
            }
            $result = $error->getMessage();
        }
        return json_encode($result);
    }

    public static function callMethod($service_host, $method, $param, $timeout = 30, $cache_time = 0, $cache_key = '') {
        $timeout = 60;
        ini_set("default_socket_timeout", $timeout);

        $cache_key = "{$method}-" . md5(json_encode($param));
        $params['method'] = "$method";
        $params['AppKey'] = self::$appKey;
        $params['AppSecrete'] = self::$appSecret;
        $params['Request'] = json_encode($param);
        $url = $service_host;
        if ($cache_time) {
            //$cache_time = 30;
            if(Config::get('app.debug')) Log::info($method.':need cache');
            if ($cache_data = Cache::get($cache_key)) {
                $cache_start_time = $cache_data['cache_start_time'];
                $diff_time = time() - $cache_start_time - $cache_time * 60;
                if(Config::get('app.debug')) Log::info($method.': CallMethod cache time flag:'.$diff_time);
                if($diff_time>0){
                    if(Config::get('app.debug')) Log::info($method.':Get data from Interface');
                    return self::cacheServiceData($url,$method,$params,$cache_key,$cache_time);
                }else{
                    unset($cache_data['cache_start_time']);
                    if(Config::get('app.debug')) Log::info($method.':Get data from cache');
                    if(Config::get('app.debug')) Log::info($method.':CallMethod cache data len:'.count(json_encode($cache_data)));
                    return $cache_data;
                }
            }else{
                return self::cacheServiceData($url,$method,$params,$cache_key,$cache_time);
            }
        }else{
            if(Config::get('app.debug')) Log::info($method.' not need cache');
            $service_data = self::soapClient($url,$method,$params,$cache_key);
            return $service_data;
        }
        $rs = self::parseResult($result);
        if ($rs['code'] !== 'SUCCESS') {
            LogTool::logData($rs);
            return Cache::get($cache_key);
        } else {
            LogTool::logData($rs);
        }
		// 有需要则存储缓存
		if ($cacheTime && ($rs['code'] == 1 || $rs['code'] == 'SUCCESS' || $rs['code']=='100000')) {
			\BC\Tools\BCCache::set($cache_key, $rs, $cacheTime);
		}
        return $rs;
    }
}
