<?php
/**
 * Created by PhpStorm.
 * User: baicheng
 * Date: 14-11-25
 * Time: 下午1:24
 */
namespace BC\Tools;
use Illuminate\Support\Facades\Config;
class User
{

    //取得当前登录的Uid
    private static $uid = 0;
    public static function id()
    {
        //先检查session
        $user = \Session::get('user',array());
        !empty($user) && isset($user['uid']) && self::$uid = (int)$user['uid'];
        if(self::$uid){
            return self::$uid;
        }
        //再检查cookie
        $alc = isset($_COOKIE['alc'])?trim($_COOKIE['alc']):'';
        if(!empty($alc)){
            self::$uid = (int)self::decode($alc);
        }

        return self::$uid;
    }

    //获取当前用户信息
    public static function info()
    {
        $uri = 'apiv4/alc?data='.json_encode(array(
                'trace_id'=>time(),
                'data'=>array(
                    'alc'=> urlencode(trim($_COOKIE['alc'])) ,
                ),
            ));
        $data = json_decode(file_get_contents(URLHelper::Api_Passport($uri)),1);

        return $data;
    }
    //添加 修改用户信息
    public static function updateinfo($info)
    {
        $uri = Config::get("app.domain_info.passportinternal").'/api/passenger/save?data='.json_encode($info);

        $data = json_decode(file_get_contents($uri,1));

        return $data;
    }
    private static $key = '62bb13fbce26d25e'; //加密用的key
    //加密
    //参数: $string 数据, $expire 密文有效期(单位:秒,0 为永久有效)
    public static function encode($string,$expire=0)
    {
        return self::authcode($string,'ENCODE',self::$key,$expire);
    }

    //解密
    //参数: $string 密文
    public static function decode($string)
    {
        return self::authcode($string,'DECODE',self::$key);
    }

    /**
    主方法:
     * @param string $string 原文或者密文
     * @param string $operation 操作(ENCODE | DECODE), 默认为 DECODE
     * @param string $key 密钥
     * @param int $expiry 密文有效期, 加密时候有效， 单位 秒，0 为永久有效
     * @return string 处理后的 原文或者 经过 base64_encode 处理后的密文
     *
     * @example
     *
     *  $a = authcode('abc', 'ENCODE', 'key');
     *  $b = authcode($a, 'DECODE', 'key');  // $b(abc)
     *
     *  $a = authcode('abc', 'ENCODE', 'key', 3600);
     *  $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空
     */
    private static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 3600)
    {

        $ckey_length = 4;
        // 随机密钥长度 取值 0-32;
        // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
        // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        // 当此值为 0 时，则不产生随机密钥

        $key = md5("$key");
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }

    }

    /**
     * [获取用户微信绑定openid]
     * @return [type] [description]
     */
    public static function getOpenIdByUid($uid){
        $host = Config('api.http.interface.passport').'/member/weixin';
        $data = 'data={"trace_id":1458646206,"data":{"uid":"'.$uid.'"}}';
        $res = \BC\Tools\HttpRequest::send($host, $data);
        $res = json_decode($res);
        if(isset($res->data->openid) && !empty($res->data->openid))
            return $res->data->openid;
        else
            return '';
    }

    /**
     * [通过手机号获得uid]
     * @param  [type] $mobile [description]
     * @return [type]         [description]
     */
    public static function getUidByMobile($mobile){
        $url = Config('api.http.interface.passport').'/v1/account/show?params={%22trace_id%22:%2220160223110749%22,%22data%22:{%22cond%22:{%22username%22:%22'.$mobile.'%22}}}';
        $res = \BC\Tools\HttpRequest::send($url);
        $res = json_decode($res);
        return @$res->data->uid;
    }

    /**
     * [通过手机号获得cid]
     * @param  [type] $mobile [description]
     * @return [type]         [description]
     */
    public static function getCidByMobile($mobile){
        $uid = self::getUidByMobile($mobile);
        $url = Config('api.http.interface.passport').'/member/get_userinfo';
        $params = [
            'data'  =>  [
                'uid'   =>  $uid
            ]
        ];
        $url = $url.'?data='.json_encode($params);
        // echo $url;
        $res = \BC\Tools\HttpRequest::send($url);
        $res = json_decode($res);
        return @$res->data->base->cid;
    }

}
