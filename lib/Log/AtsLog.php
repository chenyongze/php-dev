<?php

defined("LOG_PATH") or define("LOG_PATH",APPPATH);

class AtsLog
{	
	private static $startTime;
	
	private static $input;
	
	private static $traceId;
	
	private static $time;
	
	private static $execTime;


	/**
	 * @param Array $input
	 */
	public static function init($input)
	{
		self::$input = $input;
		self::$traceId = array_key_exists('trace_id', $input) ? $input['trace_id'] : self::_createTraceId();
		self::$startTime = microtime(true);
	}

	/**
	 * @param int  $code
	 * @param json $output
	 */
	public static function write($code, $output)
	{
		$execTime = self::_processTime();
		
		$logInfo = self::_packing( $code, $output);
		
		self::_send($logInfo);
		
		self::_sendMonitorMessages($code, $logInfo);
	}

	private static function _createTraceId()
	{
		return date('YmdHis').mt_rand(1000,9999);
	}
	
	private static function _processTime()
	{
		self::$time = date('Y-m-d H:i:s');
		
		$endTime = microtime(true);
		
		self::$execTime = round($endTime - self::$startTime, 4);
		
		return true;
		
	}
	
	private static function _packing($code, $output)
	{
		$httpRefer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'where';
		return '['.self::$time .']'. "\t" . self::$traceId . "\t" . self::$execTime . "\t" . 'LogCenter' . "\t" . "uri:".$_SERVER['REQUEST_URI']. "\t" . "statusCode:".$code . "\t" . "input:".json_encode(self::$input) . "\t" . "output:".$output . "\t". "refer:".$httpRefer . "\r\n";
	}
	
	private static function _send($message)
	{
		// 目录不存在建立log目录
		$dir =  LOG_PATH . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
		if(! file_exists($dir)) {
			mkdir($dir, 0777, TRUE);
			chmod($dir, 0777);
		}

		// 文件不存在建立log文件
		$file = $dir . DIRECTORY_SEPARATOR.'Ats-' . date('Y-m-d') . '.log';
		if(! file_exists($file)) {
			touch($file);
			chmod($file, 0777);
		}
		error_log($message."\r\n", 3, $file);
	}
	
	private static function _sendMonitorMessages($code, $logInfo)
	{
		if ($code == 100000) {
			return true;
		}
		
//		AtsPushMessage::sendMail($logInfo);
//		AtsPushMessage::sendMessage($logInfo);
		
		return true;
	}
}