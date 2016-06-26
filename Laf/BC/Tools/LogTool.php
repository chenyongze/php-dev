<?php
namespace BC\Tools;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cookie;
use Whoops\Example\Exception;

class LogTool {

    /**
     * 输入日志
     */
    public static function logInput() {
		if(!isset($GLOBALS['trace_id'])){
			 // 全局
			$GLOBALS['trace_id'] =  GlobalTool::generateTraceId();
		 }
        $logInfo = array(
            'EVENT' => 'BEGIN', 
            'SYSTEM' => Config::get('app.sys.name'), 
            'ENV' => $GLOBALS['env'], 
            'ACTION' => Route::currentRouteAction(), 
            'TRACE_ID' => $GLOBALS['trace_id'], 
            'SESSION_ID' => session_id(), 
            'URL' => Request::url(),
            'URI' => Route::getCurrentRoute()->uri(), 
            'REQUEST' => Input::all()
        );
        
        $actionName = str_replace('@', '/', Route::currentRouteAction());
        self::log($actionName, $logInfo);
    }


    /**
     * 输出日志
     *
     * @param mixed $response
     */
    public static function logOutput($response) {
		if(!isset($GLOBALS['trace_id'])){
			 // 全局
			$GLOBALS['trace_id'] =  GlobalTool::generateTraceId();
		 }
        $logInfo = array(
            'EVENT' => 'END', 
            'SYSTEM' => Config::get('app.sys.name'), 
            'ENV' => $GLOBALS['env'], 
            'TRACE_ID' => $GLOBALS['trace_id'], 
            'SESSION_ID' => session_id(), 
            'RESPONSE' => $response
        );
        
        if ($_SERVER['SCRIPT_NAME'] != 'artisan') {
            $logInfo['ACTION'] = Route::currentRouteAction();
        }
        
        $actionName = str_replace('@', '/', Route::currentRouteAction());
        self::log($actionName, $logInfo);
    }


    /**
     * 错误日志(500)
     *
     * @param mixed $trace
     * @param string $message
     */
    public static function logError($trace, $message) {
		if(!isset($GLOBALS['trace_id'])){
			 // 全局
			$GLOBALS['trace_id'] = GlobalTool::generateTraceId();
		 }
        $logInfo = array(
            'EVENT' => 'ERROR', 
            'SYSTEM' => Config::get('app.sys.name'), 
            'ENV' => $GLOBALS['env'], 
            'TRACE_ID' => $GLOBALS['trace_id'], 
            'SESSION_ID' => session_id(), 
            'MESSAGE' => $message, 
            'TRACE' => $trace
        );
        
        if ($_SERVER['SCRIPT_NAME'] != 'artisan') {
            $logInfo['ACTION'] = Route::currentRouteAction();
        }

        self::log('error/error', $logInfo);
    }


    /**
     * 找不到页面日志(404)
     */
    public static function logMiss() {
        $logInfo = array(
            'EVENT' => 'MISS', 
            'SYSTEM' => Config::get('app.sys.name'), 
            'ENV' => $GLOBALS['env'], 
            'URL' => Request::url(),
            'SESSION_ID' => session_id(), 
        );

        self::log('error/miss', $logInfo);
    }


    /**
     * 接口日志
     *
     * @param $system
     * @param $service
     * @param $spendTime
     * @param $request
     * @param $response
     */
    public static function logApi($system, $service, $spendTime, $request, $response) {
		if(!isset($GLOBALS['trace_id'])){
			 // 全局
			$GLOBALS['trace_id'] = GlobalTool::generateTraceId();
		 }
        $logInfo = array(
            'EVENT' => 'API', 
            'SYSTEM' => Config::get('app.sys.name'), 
            'ENV' => $GLOBALS['env'],
            'TRACE_ID' => $GLOBALS['trace_id'], 
            'SESSION_ID' => session_id(), 
            'SERVICE' => "{$system}-{$service}", 
            'SPEND_TIME' => $spendTime, 
            'REQUEST' => $request, 
            'RESPONSE' => $response
        );

        self::log("api/{$system}-{$service}", $logInfo);
    }


    /**
     * 业务点日志
     */
    public static function logBiz() {
        $saveList = array(
            'utm_source', 
            'utm_medium', 
            'utm_term', 
            'atscreative'
        );
        
        foreach ($saveList as $item) {
            if (Input::get($item)) {
                Cookie::queue($item, Input::get($item));
                $data[$item] = Input::get($item);
            } else {
                $data[$item] = Cookie::get($item);
            }
        }
        
        $logInfo = array(
            'TIME' => date('Y-m-d H:i:s'), 
            'IP' => IOTool::getIP(), 
            'SESSION_ID' => session_id(), 
            'ACTION' => Route::currentRouteAction(), 
            'URL' => Request::url(), 
            'BROWSER' => $_SERVER['HTTP_USER_AGENT'], 
            'REFERER' => $_SERVER["HTTP_REFERER"], 
            'UTM_SOURCE' => $data['utm_source'], 
            'UTM_MEDIUM' => $data['utm_medium'], 
            'UTM_TERM' => $data['utm_term'], 
            'ATS_CREATIVE' => $data['atscreative']
        );
        
        self::log("biz/biz", $logInfo);
    }


    /**
     * 记录日志
     *
     * @param string $path x/y格式
     * @param mixed $data
     */
    public static function log($path, $data) {
		if(!isset($GLOBALS['trace_id'])){
			 // 全局
			$GLOBALS['trace_id'] = GlobalTool::generateTraceId();
		 }
        # action
        list($dir, $file) = explode('/', $path);

        // 目录不存在则建立目录
        $dir = \storage_path() . '/storage/logs/' . $dir;
        if(! file_exists($dir)) {
            mkdir($dir, 0777, TRUE);
            chmod($dir, 0777);
        }

        // 文件不存在则建立目录
        $file = $dir . '/' . $file . '-' . date('Y-m-d') . '.log';
        if(! file_exists($file)) {
            touch($file);
            chmod($file, 0777);
        }

        // 记录日志
        $msg = date('Y-m-d H:i:s') . "\t" . $GLOBALS['trace_id'] . "\t" . (is_string($data) ? $data : @json_encode($data)) . "\n";
        error_log($msg, 3, $file);
    }

    /**
     *
     * 调用这个函数会把日志记录到固定的目录，而不是每个项目下的storage 目录
     *
     * @param 记录日志
     */
    public static function logData($data)
    {
return;
        global $trace_id;
        if (!isset($trace_id)) {
            $trace_id = md5(date('YmdHis') . rand(10000000, 99999999));
        }
        $dir = '/webSiteLog/' . Envirement::getProject() . '/';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, TRUE);
            chmod($dir, 0777);
        }
        $dir .= date('Y-m') . "/";
        if (!file_exists($dir)) {
            mkdir($dir, 0777, TRUE);
            chmod($dir, 0777);
        }

        $logInfo = array(
            'input' => Input::all(),
            'ENV' => $GLOBALS['env'],
            'data' => is_object($data) ? (array)$data : $data,
            'SESSION_ID' => session_id(),
            'URL' => Request::url(),
            'URI' => Request::getRequestUri(),
            'Referer' => $_SERVER['HTTP_REFERER'],
            "HTTP_USER_AGENT" => $_SERVER['HTTP_USER_AGENT']
        );
        $file = $dir . date('Y-m-d') . '.log';

        // 记录日志
        $msg = date('Y-m-d H:i:s') .  "\t" .  $trace_id . "\t" . json_encode($logInfo) . "\n";
        error_log($msg, 3, $file);
        return $logInfo;
    }

    /**
     *
     *
     * 记录日志并发送报警邮件
     * @param $toMails  邮件接收者 可以是单个收件人，也可以是多个收件人（数组)
     * @param $data   可以是任何类型
     * @param $title  邮件标题 可以不传
     */
    public static function logAndMail($toMails, $data, $title = '')
    {
        $logInfo = self::logData($data);
        if (!is_array($toMails)) {
            $toMails = array($toMails);
        }
        if (!empty($toMails) && !empty($logInfo)) {
            $title = $title ? : \BC\Tools\Envirement::getProject() . '报警';
            \BC\Tools\Mail::send($toMails, $title, json_encode($logInfo));
        }
    }
}