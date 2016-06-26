<?php
/**
 * Created by PhpStorm.
 * User: chao
 * Date: 16/6/25
 * Time: 下午5:03
 */

require "init.php";

use App\WXsdk;
use App\Controllers\Controller;


//class Test extends Controller{
//
//    public function __construct() {
//        parent::__construct();
//    }
//
//    public function index(){
//        $this->smarty->display("test/index.html");
//    }
//
//}
//
//$obj = new Test();
//$obj->index();



//$access_token = WXsdk::getAccessToken();
//$ticket = WXsdk::getJsApiTicket();
//$sign = WXsdk::getSignPackage();
//dd($access_token);

//\Log::warning("sdvdfaaaaaa");
//$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APPID.'&secret='.APPSECRET;
//$res= httpGet($url);
//dd($res);


//记录日志
//\AtsLog::init($fields);
//AtsLog::write(AtsMessages::SUCCESS, 'aaa');
//AtsResponse::success(array('a'=>1,'b'=>2));
AtsResponse::failure(-1,'aaa');


