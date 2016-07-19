<?php
class AtsPushMessage
{
	public static function sendMail($smsMessage)
	{
		if (! Config::get ( 'pay.pushErrorWarning' )) {
			return true;
		}
		$params ['subject'] = '百程收银台报警邮件';
		$params ['data'] = $smsMessage;
		$params ['recipients'] = array (
				'zhaohongshao@byecity.com',
				'hanzheng@byecity.com',
				'libin001@byecity.com'
		);
		$rs = Mail::send ( 'emails.warn', $params, function ($message) use($params) {
			$recipients = $params ['recipients'];
			$message->to ( $recipients )->subject ( $params ['subject'] );
			if (isset ( $params ['path'] ) && $params ['path']) {
				$message->attach ( $params ['path'] );
			}
		} );
		return true;
	}
	
	
	
	public static function sendMessage($smsMessage)
	{
		return true;
		
	}
}
