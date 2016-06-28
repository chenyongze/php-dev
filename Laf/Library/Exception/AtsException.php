<?php
class AtsException extends Exception
{
	public function __construct($message, $code = NULL)
	{
		$this->code = $code;
		$this->message = $message;

		$traceData = array(
			'message' => $this->getMessage() !== NULL ? $this->getMessage() : NULL,
			'trace'   => $this->getTraceAsString(),
		);

		AtsLog::write($code, json_encode($traceData));
		
		unset($traceData, $traces);
	}
}