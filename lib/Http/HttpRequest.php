<?php
class HttpRequest
{
	public static $cert = null;


	public static function get($url, $params = array(), $type = 'get')
	{
		return self::_Http($url, $params, $type);
	}


	public static function post($url, $params = array(), $type = 'post')
	{
		return self::_Http($url, $params, $type);
	}

	/**
	 * @param $url
	 * @param array $data
	 * @param $type
	 * @return bool|mixed
	 * @throws Exception
	 */
	private static function _Http($url, $data, $type)
	{
//		$debug = \Illuminate\Support\Facades\Config::get('app.debug',FALSE);
//		if($debug)
//		{
//			$log_data = [
//				'url'  => $url,
//				'type' => $type,
//				'data' => $data,
//			];
//			LogTool::logData($log_data);
//		}
		$ch = curl_init();
		
		if ( ! $ch) {
			return false;
		}
		
		if (strtolower($type) == 'post') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		} else {
			if (strripos($url, '?') !== FALSE) {
				foreach ($data as $k => $v) {
					$url .= "&{$k}={$v}";
				}
			} else {
				$url .= '?';
				foreach ($data as $k => $v) {
					$url .= "{$k}={$v}&";
				}
			}
		}
		
		if ( ! is_null(self::$cert)) {
			($cert = self::$cert) && (self::$cert = null);
			
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_CAINFO, $cert);
		}
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,120);
		curl_setopt($ch, CURLOPT_HEADER, 0);
	
		
		$result = curl_exec($ch);
		
		if (!$result) {
			$error = curl_error($ch);
			$errno = curl_errno($ch);
			throw new \Exception($error, $errno);
		}
		
		curl_close($ch);
//		if($debug)   LogTool::logData($result);
		return $result;
	}
}
