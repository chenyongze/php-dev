<?php
namespace BC\Tools;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use SoapClient;

final class IOTool {
    // WebService-Key-Secret
    const APP_KEY_WEB = 14070901;
    const APP_SECRETE_WEB = "FEB497C6D0DB627D93F1811AE794BF14";
    const APP_FROM_WEB = "PC";
    const APP_KEY_APP = 14071001;
    const APP_SECRETE_APP = "8A6E8024C50ABEDB784FACCCD1B1404F";
    const APP_KEY_H5 = 14090221;
    const APP_SECRETE_H5 = "35199CB192C85323";
    const APP_FROM_H5 = "H5";

    const SUCCESS = 100000;

    public static function getIpInfo()
    {
        // 通过第三方接口判定用户所在省市
        $client_ip = IOTool::getIP();
        $ip_info = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php' . '?ip=' . $client_ip);
//        如http://ip.taobao.com/service/getIpInfo.php?ip=42.56.79.78
//        {
//            "code": 0,
//             "data": {
//            "country": "中国",
//            "country_id": "CN",
//            "area": "东北",
//            "area_id": "200000",
//            "region": "辽宁省",
//            "region_id": "210000",
//            "city": "沈阳市",
//            "city_id": "210100",
//            "county": "",
//            "county_id": "-1",
//            "isp": "联通",
//            "isp_id": "100026",
//            "ip": "42.56.79.78"
//            }
//        }
        return json_decode($ip_info, true);

    }
    /**
     * 通过taobao的接口获取指定IP的所属省份信息 njz20141209
     *
     * @param $default_value 默认值
     * @return mixed  接口异常或数据错误等情况下，返回默认取值  所返数据标识当前用户IP的所在省份中文名称
     */
    public static function getProvinceByIpInfo($default_value)
    {
        $ip_info = IOTool::getIpInfo() ;

        if (empty($ip_info)
            || 0 != $ip_info['code']
            || empty($ip_info['data']['region_id'])
        ) {
            // 接口异常或数据错误等情况下，返回默认取值
            return $default_value;
        }
        return $ip_info['data']['region'];
    }

    # 获取真实IP
    public static function getIP() {
        $dataList = array(
            isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:'',
            isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER["HTTP_CLIENT_IP"]:'',
            isset($_SERVER['REMOTE_ADDR'])?$_SERVER["REMOTE_ADDR"]:''
        );

        foreach ($dataList as $data) {
            if (isset($data) && $data && strcasecmp($data, 'unknown')) {
                if (strpos($data, ',') !== FALSE) {
                    $ip = explode(',', $data)[0];
                } else {
                    $ip = $data;
                }

            }
        }
        return $ip;
    }
    /**
     * Service获取请求参数
     *
     * @param string $key
     * @return mixed
     */
    public static function getRequestParams($key = 'params') {
        $params = json_decode(Input::get($key), TRUE);

        // 全局
        $GLOBALS['trace_id'] = $params['trace_id'] ?: GlobalTool::generateTraceId();

        return $params['data'];
    }


    /**
     * Service标准成功返回
     *
     * @param array $data
     * @return array
     */
    public static function formatApiReturnSuccess($data = array()) {
        return array(
            'code' => self::SUCCESS,
            'message' => 'success', 
            'data' => $data
        );
    }


    /**
     * Service标准失败返回
     *
     * @param int $code
     * @param string $message
     * @param array $data
     * @return array
     */
    public static function formatApiReturnFailure($code, $message, $data = array()) {
        return array(
            'code' => $code, 
            'message' => $message, 
            'data' => $data
        );
    }


    /**
     * Service格式化返回参数
     *
     * @param array $return
     * @return string
     */
    public static function getResponseParams($return) {
        return json_encode($return);
    }


    /**
     * Service解析请求返回
     *
     * @param $ret
     * @return mixed
     */
    public static function getResponseResult($ret) {
        return json_decode($ret, TRUE);
    }


    /**
     * Request By WebService
     *
     * @param string $system
     * @param string $method
     * @param array $request
     * @param int $retry
     * @param int $cacheTime
     * @param string $cacheKey
     * @return mixed
     */
    public static function requestBySoap($system, $method, $request = array(), $retry = 0, $cacheTime = 0, $cacheKey = '') {
    	# cache
    	// 有需要则取缓存
    	if ($cacheTime) {
    		$cacheKey = $cacheKey ?: "{$system}-{$method}-" . md5(json_encode($request));
    		if ($cacheData = \BC\Tools\BCCache::get($cacheKey)) {
    			return $cacheData;
    		}
    	}
    	
    	# action
        $req = array(
            'AppKey' => self::APP_KEY_WEB,
            'AppSecrete' => self::APP_SECRETE_WEB,
            'Request' => json_encode($request)
        );

        $startTime = microtime(TRUE);
        do {
            $wsdl = Config::get("api.soap.wsdls.{$system}");
            $soap = new SoapClient($wsdl,array(
                'connection_timeout' => Config::get('api.soap.timeout', 10),
                'cache_wsdl' => WSDL_CACHE_NONE,
                'keep_alive' => false,
            ));

            $response = $soap->$method(array('requestString' => json_encode($req)));
            $isRetry = ! $response && $retry --;
            $endTime = microtime(TRUE);
            LogTool::logApi($system, $method, $endTime - $startTime, $request, $response);
        } while ($isRetry);

        # return
        $resultKey = "{$method}Result";
        if(! isset($response->$resultKey)) {
            return FALSE;
        }

        $response = json_decode($response->$resultKey, TRUE);
        if (! is_array($response)) {
            return FALSE;
        } else {
            // 有需要则存储缓存
            if ($cacheTime) {
                \BC\Tools\BCCache::set($cacheKey, $response, $cacheTime);
            }
            return $response ?: TRUE;
        }
    }


    /**
     * Request By NameService
     *
     * @param string $system
     * @param string $service
     * @param array $request
     * @param int $retry
     * @param int $cacheTime
     * @param string $cacheKey
     * @return mixed
     */
    public static function requestByNameService($system, $service, $request = array(), $retry = 0, $cacheTime = 0, $cacheKey = '') {
    	# cache
    	// 有需要则取缓存
    	if ($cacheTime) {
    		$cacheKey = $cacheKey ?: "{$system}-{$service}-" . md5(json_encode($request));
    		if ($cacheData = \BC\Tools\BCCache::get($cacheKey)) {
    			return $cacheData;
    		}
    	}
    	
    	# action
        $req = array(
            'params' => json_encode(array(
                'trace_id' => $GLOBALS['trace_id'] ?: GlobalTool::generateTraceId(),
                'data' => $request
            ))
        );
        
        $startTime = microtime(TRUE);
        do {
            $response = NameService::request($system, $service, $req);
            $isRetry = ! $response && $retry --;
        } while ($isRetry);
        $endTime = microtime(TRUE);
        LogTool::logApi($system, $service, $endTime - $startTime, $request, $response);
        
        # return
        if(! $response) {
            return FALSE;
        }

        $response = json_decode($response, TRUE);
        if (! is_array($response) || $response['code'] != self::SUCCESS) {
            return FALSE;
        } else {
        	// 有需要则存储缓存
        	if ($cacheTime) {
        		\BC\Tools\BCCache::set($cacheKey, $response['data'], $cacheTime);
        	}
            return $response['data'] ?: TRUE;
        }
    }



    /**
     * Request By Http
     *
     * @param string $system
     * @param string $service
     * @param array $request
     * @param int $cacheTime
     * @param string $cacheKey
     * @param string $method
     * @return mixed
     */
	public static function request ($system, $service, $request = array(), $retry = 0, $cacheTime = 0, $cacheKey = '', $method = 'get') {
		# cache
		// 有需要则取缓存
		if ($cacheTime) {
			$cacheKey = $cacheKey ?: "{$system}-{$service}-" . md5(json_encode($request));
			if ($cacheData = \BC\Tools\BCCache::get($cacheKey)) {
				return $cacheData;
			}
		}
		
		# data
		$startTime = microtime(TRUE);
        $url = Config::get("api.http.{$system}.{$service}");
        do {
            $response = self::httpRequest($url, $method, $request);
            $isRetry = ! $response && $retry --;
        } while ($isRetry);
		$endTime = microtime(TRUE);
		LogTool::logApi($system, $service, $endTime - $startTime, array(
            'url' => $url,
            'params' => $request
        ), $response);

        # return
        $response = json_decode($response, TRUE);
        if (! $response) {
            return FALSE;
        } else {
            // 有需要则存储缓存
            if ($cacheTime) {
                \BC\Tools\BCCache::set($cacheKey, $response, $cacheTime);
            }
            return $response;
        }
	}
    /**
     * OrderManageFinancialRequest By Http
     * 适配订单系统财务接口
     * @param string $system
     * @param string $service
     * @param array $request
     * @param int $cacheTime
     * @param string $cacheKey
     * @param string $method
     * @return mixed
     */
    public static function OrderManageFinancialRequest ($system, $service, $request = array(),$methodName, $retry = 0, $cacheTime = 0, $cacheKey = '', $method = 'post') {
        # cache
        // 有需要则取缓存
        if ($cacheTime) {
            $cacheKey = $cacheKey ?: "{$system}-{$service}-{$methodName}-" . md5(json_encode($request));
            if ($cacheData = \BC\Tools\BCCache::get($cacheKey)) {
                return $cacheData;
            }
        }
        # data
        //调用开始时间
        $startTime = microtime(TRUE);
        //拼串APIurl
        $url = Config::get("api.http.{$system}.{$service}").$methodName;
        //组合请求参数
        $inputParams = array(
            'requestStr'=>json_encode($request),
        );
        do {
            //调用接口
            $response = self::httpRequest($url, $method, $inputParams);
            $isRetry = ! $response && $retry --;
        } while ($isRetry);
        //调用结束时间
        $endTime = microtime(TRUE);
        //记录日志
        // LogTool::logApi($system, $service, $endTime - $startTime, $url."?requestStr=".$inputParams['requestStr'], $response);
        if(Config::get('app.debug')) {
            Log::info($system . $service . $url . "?requestStr=" . $inputParams['requestStr'] . $response);
        }
        # return
        $response = json_decode($response, TRUE);
        if (! $response) {
            return FALSE;
        } else {
            // 有需要则存储缓存
            if ($cacheTime) {
                \BC\Tools\BCCache::set($cacheKey, $response, $cacheTime);
            }
            return $response;
        }
    }

    /**
     * Request By Http
     * 主要用于新版的boss端http协议的接口调用
     *
     * @param string $system
     * @param string $service
     * @param array $request
     * @param int $cacheTime
     * @param string $cacheKey
     * @param string $method
     * @return mixed
     */
    public static function HttpRequestWithParams ($system, $service, $request = array(),$methodName, $retry = 4, $cacheTime = 0, $cacheKey = '', $method = 'post') {  
        //初始化配置数据(默认PC请求)
        $req = array(
            'AppKey' => self::APP_KEY_WEB, 
            'AppSecrete' => self::APP_SECRETE_WEB,
            'Request' => json_encode($request)
        );
        //默认请求标志位PC
        $RequestFrom = "{$system}-{$service}-{$methodName}-".self::APP_FROM_WEB;
        //判断是否H5请求
        $server_name =  $_SERVER['SERVER_NAME'];
        if(preg_match('/^m/i',$server_name,$rs)){
            if(current($rs)=='m'){
                $req['AppKey'] = self::APP_KEY_H5;
                $req['AppSecrete'] = self::APP_SECRETE_H5;
                $RequestFrom = "{$system}-{$service}-{$methodName}-".self::APP_FROM_H5;
            }
        }

        //招商订单来源H5
        if(preg_match('/^ch.m/i',$server_name,$rs)){
            if(current($rs)=="ch.m"){
                $req['AppKey'] = self::APP_KEY_H5;
                $req['AppSecrete'] = self::APP_SECRETE_H5;
                $RequestFrom = "{$system}-{$service}-{$methodName}-".self::APP_FROM_H5;
            }
        }
        //组合请求参数
        $inputParams = array(
            'requestString'=>json_encode($req),
            'methodIndex'=>$methodName
        );
        //缓存KEY
        $cacheKey = $cacheKey ?$cacheKey: $RequestFrom.'-'. md5(json_encode($req));
        //判断是否使用缓存
        if ($cacheTime) {
            //记录日志
            if(Config::get('app.debug')){
                Log::info($RequestFrom.' need cache');
            }
            //获取缓存数据
            if ($cacheData = \BC\Tools\BCCache::get($cacheKey)) {
                //存在缓存数据记录日志
                if(Config::get('app.debug')){
                    Log::info($RequestFrom . 'cache data:'.json_encode($cacheData));
                }
                //获取缓存开始时间
                $cache_start_time = $cacheData['cache_start_time'];
                //获取缓存超时时间
                $diff_time = time() - $cache_start_time - $cacheTime * 60;
                //记录日志
                if(Config::get('app.debug')){
                   Log::info($RequestFrom.': execute  cache Flag :'.$diff_time);   
                }
                //判断缓存是否超时
                if($diff_time>0){           
                    if(Config::get('app.debug')){
                        Log::info($RequestFrom.' return data that get from source');
                    } 
                    //超时获取最新数据
                    return self::cacheHttpRequestWithParamsData($system,$service,$inputParams,$cacheKey,$RequestFrom,$method,$retry);
                }else{
                    //未超时 销毁上次缓存时间
                    unset($cacheData['cache_start_time']);
                    //记录日志
                    if(Config::get('app.debug')){
                        Log::info($RequestFrom.' return cache data');
                        Log::info($RequestFrom.' cache data:'.json_encode($cacheData)); 
                     }
                    //返回缓存数据
                    return $cacheData;
                }
            }else{          
                //不存在缓存数据 获取新数据
                return self::cacheHttpRequestWithParamsData($system,$service,$inputParams,$cacheKey,$RequestFrom,$method,$retry);
            }
        }else{
            //记录日志
            if(Config::get('app.debug')){ 
                Log::info($RequestFrom.' not need cache');
            }
            //返回数据
            $service_data = self::HttpRequestWithParamsNewest($system,$service,$inputParams,$cacheKey,$RequestFrom,$method,$retry);
            return $service_data;
        }
        
    }
    /**
     * @todo 缓存数据
     *
     * @param $system
     * @param $service
     * @param $inputParams
     * @param $cacheKey
     * @param $RequestFrom
     * @param $method
     * @param $retry
     * @return array|bool
     */
    public static function cacheHttpRequestWithParamsData($system,$service,$inputParams,$cacheKey,$RequestFrom,$method,$retry)
    {
        //获取最新数据
        $paramsData = self::HttpRequestWithParamsNewest($system,$service,$inputParams,$cacheKey,$RequestFrom,$method,$retry);
        //判断是否获取成功
        if(!$paramsData){
            return false;
        }else{
            //设置缓存开始时间 添加缓存
            $paramsData['cache_start_time'] = time();
            \BC\Tools\BCCache::set($cacheKey,$paramsData,60*60*24);
            return $paramsData;
        }
    }
    /**
     * Request By Http
     * 主要用于新版的boss端http协议的接口调用
     *
     * @param string $system
     * @param string $service
     * @param array $inputParams
     * @param int $cacheTime
     * @param string $cacheKey
     * @param string $RequestFrom
     * @param string $method
     * @param string $retry
     * @return mixed
     */
    public static function HttpRequestWithParamsNewest($system,$service,$inputParams,$cacheKey,$RequestFrom,$method,$retry) {
        //设置超时时间
        $timeout = 60;
        ini_set("default_socket_timeout", $timeout);
        # data
        //开始时间
        $startTime = microtime(TRUE);
        //请求接口URL
        $url = Config::get("api.http.{$system}.{$service}");
        //如果开启dug 记录完整请求url
        if(Config::get("app.debug"))
        {
            $tmp = "";
            foreach($inputParams as $k => $v){
                if($tmp){
                    $tmp .= '&'.$k.'='.$v;
                }else{
                    $tmp = $k .'='.$v;
                }
            }
            if(Config::get('app.debug')) {
                Log::info("$RequestFrom:" . $url . '?' . $tmp);
            }
        }
        //初始化返回数据
        $response = null;
        //获取数据(获取失败循环再次获取)
        do {
            $response = self::httpRequest($url, $method, $inputParams);
            $isRetry = ! $response && $retry --;
        } while ($isRetry);
        //结束时间
        $endTime = microtime(TRUE);
        //记录日志
        LogTool::logApi($system, $service, $endTime - $startTime, array(
            'url' => $url,
            'params' => $inputParams
        ), $response);
        //json转义
        $response = json_decode($response, TRUE);
        //如果获取数据失败 从缓存中获取数据
        if(!$response){
            if($cacheKey){
                $cacheData = \BC\Tools\BCCache::get($cacheKey);
                return $cacheData;
            }else{
                return false;
            }
        } 
        return $response;
    }

    public static function HttpRequestByPassport ($system, $service, $address, $request = array(), $trace_id='', $retry = 0, $cacheTime = 0, $cacheKey = '', $method = 'get') {
        # cache
        // 有需要则取缓存
        if ($cacheTime) {
            $cacheKey = $cacheKey ?: "{$system}-{$service}-" . md5(json_encode($request));
            if ($cacheData = \BC\Tools\BCCache::get($cacheKey)) {
                return $cacheData;
            }
        }
        $inputParams = array(
            'trace_id'=>$trace_id,
            'data'=>$request
        );

        $req = array(
            'data' => json_encode($inputParams)
        );

        # data
        $startTime = microtime(TRUE);
        $url = Config::get("api.http.{$system}.{$service}") . $address;
        do {
            $response = self::httpRequest($url, $method, $req);
            $isRetry = ! $response && $retry --;
        } while ($isRetry);
        $endTime = microtime(TRUE);
        LogTool::logApi($system, $service, $endTime - $startTime, array(
            'url' => $url,
            'params' => $request
        ), $response);

        # return
        $response = json_decode($response, TRUE);
        if (! $response) {
            return FALSE;
        } else {
            // 有需要则存储缓存
            if ($cacheTime) {
                \BC\Tools\BCCache::set($cacheKey, $response, $cacheTime);
            }
            return $response;
        }
    }

    /**
     * HTTP请求
     *
     * @param string $url
     * @param string $method
     * @param array $fields
     * @return mixed
     */
	public static function httpRequest ($url, $method, $fields) {
		# action
		$ch = curl_init();

		if (strtolower($method) == 'post') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		} else {
			if (strpos($url, '?') !== FALSE) {
				foreach ($fields as $k => $v) {
					$url .= "&{$k}={$v}";
				}
			} else {
				$url .= '?';
				foreach ($fields as $k => $v) {
					$url .= "{$k}={$v}&";
				}
			}
		}

        if(Config::get('app.debug')){
            Log::info('HttpRequest:'.$url);
        }
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		
		$result = curl_exec($ch);

        //echo $result;
		curl_close($ch);

		# return
		return $result;
	}


    /**
     * 解析Soap调用结果为仿NameService
     *
     * @param $result
     * @return array
     */
    public static function parseResult($result){
        $result = json_decode($result, TRUE);
        
        return array(
        	'code' => $result['ErrorCode'] ?: self::SUCCESS,
            'message' => $result['ErrorMsg'],
            'data' => $result['Response'],
        );
    }


    /**
     * Ajax标准返回
     *
     * @return array
     */
    public static function formatAjaxReturn() {
        return array(
            'status' => TRUE,
            'message' => '',
            'data' => array(),
            'url' => '',
            'html' => ''
        );
    }
}
