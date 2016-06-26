<?php

namespace BC\Tools;
/**
 * 
 * 目前仅支持md5加密
 * 文档说明地址 http://192.168.3.172/ats-backend/paysystem/wikis/home
 *
 */
class PaySign {

	/**
	 * 
	 * @param params $params
	 * @param 秘钥 $key
	 * @return string
	 */
	public static function sign($params, $key) {
	
		$linkStr = array();
		
		$mergeTrade = $params['merge_info'];
		unset($params['merge_info']);
		
		$linkStr[] = self::createLinkstring($params);
		
		foreach($mergeTrade as $trade) {
			$linkStr[] = self::createLinkstring($trade);
		}
	    $signStr = implode('&', $linkStr);
	    $signStr .= $key;
	    return md5($signStr);
	}

	public static function checkSign($params, $key) {
		
		$sign_ori = $params['sign'];
		
		$sign = self::sign($params, $key);
		
		return $sign === $sign_ori;
	}
	
	public static function createLinkstring($params) {
		$params = self::filter($params);
		$params = self::sort($params);
		$arg  = '';
		foreach ($params as $key => $value) {
			$arg .= $key . '="' . $value . '"&';
		}
		$arg = rtrim($arg, '&');
		return $arg;
	}
	
	//除去数组中的空值和签名参数
	private static function filter($params)
	{
		$filter= array();
		foreach ($params as $key => $value) {
			if ($key == 'sign' || $key == 'sign_type' || $value == '') {
				continue;
			}	
			$filter[$key] = $params[$key];
		}
		return $filter;
	}
	
	private static function sort($params)
	{
		ksort($params);
		reset($params);	
		return $params;
	}	
}