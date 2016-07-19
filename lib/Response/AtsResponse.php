<?php
class AtsResponse
{
	public static function success($data)
	{
		self::view(AtsMessages::SUCCESS, AtsMessages::getMessage(AtsMessages::SUCCESS), $data);
	}
	
	public static function failure($code, $message = null)
	{
		$error = AtsMessages::getMessage($code);
		
		if ( ! is_null($message)) {
			$error .= ' <' . serialize($message) . '>';
		}
		
		self::view($code, $error);
	}

	private static function view($code, $message, $data = array())
	{
		header('Content-type: application/json');
		
		echo self::format($code, $message, $data); exit;
	}

	private static function format($code, $message, $data = array())
	{
		$format = array(
			'code' => $code,
			'message' => $message,
			'data' => $data
		);

		return json_encode($format);
	}
}