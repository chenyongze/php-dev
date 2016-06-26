<?php
/**
 * Created by PhpStorm.
 * User: njz
 * Date: 14-9-22
 * Time: 下午3:25
 */

namespace BC\Tools;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Whoops\Example\Exception;
use SoapWrapper;
/**
 * Class SMS ：短信服务
 * @package BC\Tools
 *
 */
class SMS
{
    /**
     * 发送短信 实时到达（只限验证码等通知类消息）
     * @param string $MsgContent 短信内容
     * @param int $Mobile 收取短信的手机号
     * @return bool
     */
    public static function Send($MsgContent, $Mobile)
    {
        $MsgContent = trim($MsgContent);
        $Mobile = trim($Mobile);

        \Validator::extend('mobile', function ($attribute, $value, $parameters) {
            if (preg_match("/^13[0-9]{9}$|15[0-9]{9}$|18[0-9]{9}$/", $value)) {
                return true;
            } else {
                return false;
            }
        });

//        $CustomValidatorMsg = array('mobile'=>' :attribute 格式不正确，正确的格式应该是：13********* 或者15********* 或者18*********');
        $CustomValidatorMsg = array('mobile' => ' :attribute The format is not correct, the correct format should be:13********* or 15********* or 18*********');

        $validator = \Validator::make(
            array(
                'contents' => $MsgContent,
                'mobiles' => $Mobile),
            array('contents' => array('required', 'min:2', 'max:480'),
                'mobiles' => array('required', 'mobile')),
            $CustomValidatorMsg
        );
        if ($validator->fails()) {
            return $validator->messages();
        }
        $inputdata = array(
            'MsgContent' => $MsgContent,
            'mobiles' => $Mobile,
            'sys' => 1 // 1：百城网站2：Boss 系统；3：CRM 系统；4：同业平台
        );
        $serviceUrl = \Config::get('service.SMS_Config.serviceUrl') == null ? 'http://service.baicheng.com/ShortMsgService.asmx?wsdl' : \Config::get('service.SMS_Config.serviceUrl');
        $method = 'BestHightSpeedShortMsgByDieXin';
        $service_output = null;
        try {
            $service_output = WebService::Call($serviceUrl, $method, $inputdata);
        } catch (\Exception $error) {
            $service_output = '调用服务时[' . $serviceUrl . $method . ']出现系统异常，参数：' . implode('|', $inputdata) . '原因可能是：' . $error->getMessage();
            if(Config::get('app.debug')) {
                ServiceLog::log($service_output, 'EXCEPTION');
            }
        }
        return $service_output;
    }

    /**
     * 新版短信发送方法,不在直接发送短信内容,而是根据nodeid和branchid来适配后端的短信
     * (建议在需要发送短信的地方直接调用,不要再封装了)
     * @param $platform -平台 1 pc 7 H5 8 微信(其它见春龙的短信文档)
     * @param $mobile -手机号
     * @param $nodeid -节点id
     * @param $branchid -短信编号
     * @param $memo -认为需要备注的其他信息
     * @param $args -需要替换的短信中的变量（需要按顺序传入，且与短信中变量的个数匹配)[一维数组]
     * @return mixed
     */
    public static function SendMessage($platform, $mobile, $nodeid, $branchid, $memo,$args){
        $backtrace = debug_backtrace();
        $callmethodInfo = $backtrace[0];

        $SearchConJson = array(
            'NodeId'=>$nodeid ,
            'BranchID'=>$branchid
        );
        $OtherInfoJson = array(
            "DomanName"=> $_SERVER['HTTP_HOST'] ,
            "FileURL"=> $callmethodInfo['file'],
            "FileName"=> basename($callmethodInfo['file']),
            "FunctionName"=>$backtrace[1]['function'],
            "System"=> $platform,
            "Memo"=>$memo
        );
        //print_r($OtherInfoJson);die;

        $inputdata = array(
            'SearchConJson' => json_encode($SearchConJson) ,
            'mobile' => $mobile,
            'OtherInfoJson' =>json_encode($OtherInfoJson) ,
            'args'=>$args
        );



        $serviceUrl = Config::get('service.SMS_Config.serviceUrl') == null ? 'http://service.baicheng.com/ShortMsgService.asmx?wsdl' : Config::get('service.SMS_Config.serviceUrl');
        $method = 'SendShortMsgByNodeID';
        $service_output = null;
        $service_output = WebService::Call($serviceUrl, $method, $inputdata);

        $arr_result = json_decode($service_output,true);

        return $arr_result['SendShortMsgByNodeIDResult'];
    }

    public static function getErrorMsg($code){
        $message = array(
            1 => '发送短信成功',
            0  => '发送短信失败，具体原因请查看日志详情',
            -1 => '信息查询条件不能为空',
            -2 => '用于记录的重要信息不能为空',
            -3 => '手机号不能为空',
            -4  =>'查询短信的条件格式不正确',
            -5  =>'用于记录关键信息的格式不正确',
            -6  =>'信息查询条件均不正确',
            -7  =>'关键信息除 Memo 外，均不能为空',
            -8  =>'配置的短信信息列表为空，请联系相关人员配置短信',
            -9  =>'您要发送的节点短信不存在',
            -10  =>'相应的发送节点有多条数据，请先清理不正确的数据后进行发送',
            -11  =>'配置的节点短信内容为空',
            -12  =>'传递参数与配置节点的参数个数不匹配',
        );
        return $message[$code];
    }

    /**
     * [sendWeiXin description]
     * 发送微信消息你必须要跟微信在48小时内有交互才可以用这个
     * @param  [type] $username  [手机号]
     * @param  [type] $Info [发送正文]
     * @param  [type] $OrderId [订单]
     * @param  [type] $ProductIds [产品]
     * @return [type]       [description]
     */
    public static function sendWeiXin($username, $content, $OrderId = 0, $ProductIds = 0) {
        $openid = \BC\Tools\User::getOpenIdByUid(\BC\Tools\User::getUidByMobile($username));
        if(!$openid) return;
        $url = Config('api.http.PC_H5_App.wap123').'/ws/WSPromotionProduct.asmx/PushBossMessage';
        $post = "OpenIDs=".$openid."&type=2&Content=".$content."&OrderId=0&ProductIds=0";
        //由于此接口没有返回值，不能用原始返回，故此处独立处理，接口对接人魏建，日志独立添加
        $curlObj = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => TRUE, //使用post提交
            CURLOPT_RETURNTRANSFER => TRUE, //接收服务端范围的html代码而不是直接浏览器输出
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => $post, //post的数据
        );
        curl_setopt_array($curlObj, $options);
        $response = curl_exec($curlObj);
        curl_close($curlObj);
        if(Config::get('app.debug')) {
            Log::info('发送微信push;url:' . $url . ';' . $post . ';res:' . $response);
        }
        return $openid;
    }

     /**
     * app push
     * @param  [type] $username  [手机号]
     * @param  [type] $content [zhengwen]
     * @return [type]          [description]
     */
    static function sendAppPUSH($username, $content, $tradeid = 0, $orderid = 0) {
        $cid = \BC\Tools\User::getCidByMobile($username);
        $data = [
            //要发送的
            'clientid' => $cid,
            //通知栏标题
            'title'  =>  $content,
            //通知栏内容
            'text'  =>  $content,
            //透传内容
            'content'  =>  $content,
            //交易订单编号
            'tradeid'  =>  $tradeid,
            //子订单编号
            'orderid'  =>  $orderid,
            //打开的页面,1:签证大厅首页，2：订单列表
            'pagetype'  =>  2,
            //手机号
            'mobile'  =>  $username,
            //佰程用户id
            'customerid'  =>  0,
            // 节点编号
            'nodeid'  =>  0,
            //分支编号
            'branchid'  =>  0,
            //设备系统类型
            'ctype'  =>  1
        ];
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('messagepush', 'message', $data, 'PushMessageToSingle');
        if($result['code'] != 0) {
            if(Config::get('app.debug')) {
                Log::info(var_export($result, 1));
            }
        }
        return $cid;
    }

    /**
     * 获取clientid
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    static function getClientIdByUid($uid){
        $host = Config('api.http.interface.passport').'/member/get_userinfo';
        //http://passport.internal.test.baicheng.com/api/member/get_userinfo?data={%22trace_id%22:1436247228,%22data%22:{%22uid%22:%22316031%22}}
        //$data = "OpenIDs=".$openid."&type=2&Content=".$content."&OrderId=&ProductIds=";
        $data = "data={%22trace_id%22:1436247228,%22data%22:{%22uid%22:%".$uid."%22}";
        return \BC\Tools\HttpRequest::send($host, $data);
    }

}