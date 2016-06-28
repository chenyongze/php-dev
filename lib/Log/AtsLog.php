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
	 * @param $code
	 * @param String $output
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
		return self::$time . "\t" . self::$traceId . "\t" . self::$execTime . "\t" . 'PayCenter' . "\t" . $_SERVER['REQUEST_URI']. "\t" . $code . "\t" . json_encode(self::$input) . "\t" . $output . "\t". $httpRefer . "\r\n\r\n\r\n\r\n";
	}
	
	private static function _send($message)
	{
		error_log($message."\r\n", 3, LOG_PATH . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log');
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