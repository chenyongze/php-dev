<?php
/**
 * Created by PhpStorm.
 * User: chao
 * Date: 16/6/26
 * Time: 下午2:59
 */
defined('APPID')        OR define('APPID','wx21e0936ee8f1ba5b');
defined('APPSECRET')    OR define('APPSECRET','0954a0639d1cf98c051913f147067ab0');
defined('TOKEN')        OR define('TOKEN','weixin');
defined('DOMAIN_NAME')  OR define('DOMAIN_NAME','http://i-vip.cn/');


class WXsdk{

    const APPID = APPID;
    const APPSECRET = APPSECRET;


    private static function _getAccessToken(){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.self::APPID.'&secret='.self::APPSECRET;
        $res_json = \HttpRequest::get($url);
        return $res_json;
    }

    private static function _createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public static function getAccessToken(){
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(@file_get_contents(PUBLIC_PATH. "/access_token.json"),1);
        if ($data['expire_time'] < time()) {
            $res = json_decode(self::_getAccessToken(),1);
            $access_token = $res['access_token'];
            if ($access_token) {
                $data['expire_time'] = time() + 7000;
                $data['access_token'] = $access_token;
                $fp = fopen(PUBLIC_PATH."access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data['access_token'];
        }
        return $access_token;
    }

    public static function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(@file_get_contents(PUBLIC_PATH. "/jsapi_ticket.json"),1);
        if ($data['expire_time'] < time()) {
            $accessToken = self::getAccessToken();
            $url = 'http://api.weixin.qq.com/cgi-bin/ticket/getticket?type=1&access_token='.$accessToken;
            $res = json_decode(\HttpRequest::get($url),1);
            $ticket = $res['ticket'];
            if ($ticket) {
                $data['expire_time'] = time() + 7200;
                $data['jsapi_ticket'] = $ticket;
                $fp = fopen(PUBLIC_PATH ."jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data['jsapi_ticket'];
        }
        return $ticket;
    }


    public static function getSignPackage() {
        $jsapiTicket = self::getJsApiTicket();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = self::_createNonceStr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);

        $signPackage = array(
            "appId"     => self::APPID,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

}