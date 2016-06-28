<?php
/**
 * 注意：该类名Generators就是Generator；出现两个的原因是php5.5内置了Generator，导致原名重名，后续请尽量使用Generators
 */
class Generators
{
	public static function createTradeNo()
	{
		$ratio = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
		$mapping = array(0=>6, 1=>3, 2=>5, 3=>7, 4=>9, 5=>1, 6=>8, 7=>4, 8=>2, 9=>0);
		
		$base = date('YmdHis') . rand(100, 999);
		
		$result = 0;
		for ($i = 0; $i < 17; $i++) {
			$result += $base{$i} * $ratio[$i];
		}
		
		$last = $result % 10;
		
		return $base . $last;
	}
	
	public static function createBatchNo()
	{
		return date('YmdHis').mt_rand(1000,9999);
	}
	
	public static function createTraceId()
	{
		return date('YmdHis').mt_rand(1000,9999);
	}
	
	public static function xml2Array($xml, $arr=null)
	{
		if (empty($xml))
			return array();
	 
		if(is_string($xml))
			return self::xml2Array(simplexml_load_string($xml), $arr=array());
	 
		$beforeKey = '';
		$index = 0;
		foreach($xml as $k => $v)
		{
			$child = $v->children();
			if (empty($child)) {
				$arr[$k] = trim((string)$v);
			} else {
				if($beforeKey == $k) {
					if($index < 1) {
						$tmpArr[$index] = $arr[$k];
					}
					$subArr = self::xml2Array($child, $subArr=array());
					$tmpArr[++$index] = $subArr;
					$arr = array_merge($arr, array($k => $tmpArr));
				}
				else
					$arr = array_merge($arr, array($k => self::xml2Array($child, $arr[$k]=array())));
			}
			$beforeKey = $k;
		}
		return $arr;
	}
	
	public static function arrayToXml($array, $root='resultSet', $attrs=array(), $indent=true, $indentString='  ')
	{
		$xml = new XmlWriter();
		$xml->openMemory();
		$xml->setIndent(true);
		$xml->setIndentString($indentString);
		$xml->startDocument('1.0', 'UTF-8');
		$xml->startElement($root);
		self::attribute($xml, $attrs);
		self::write($xml, $array);
		$xml->endElement();
		
		return $xml->outputMemory(true);
	}
	
	private static function write(XMLWriter $xml, $data, $pkey = null)
	{
		foreach($data as $key => $value) 
		{
			if (is_array($value)) {
				if(!is_int($key)) {// 如error, result
					$xml->startElement($key);
				} else if ( $key != 0 ) {// result的下一级，第一个tag由父级输出，其它tag本处输出
					$xml->endElement();
					$xml->startElement($pkey);
				}
				self::write($xml, $value, $key);
				
				if(!is_int($key)) {
					$xml->endElement();
				}
	
				continue;
			} else {
				if(!is_int($key)) {// 如count
					$xml->writeElement($key, $value);
				} else {// 如keyword
					if( $key == 0 ) {// keyword的第一个，tag由父级输出
						$xml->text($value);
					} else {// keyword的其它tag本处输出
						$xml->endElement();
						$xml->startElement($pkey);
						$xml->text($value);
					}
				}
			}
		}
	}
	
	private static function attribute(XMLWriter $xml, $attrs)
	{
		if (false == empty($attrs)) {
			foreach( $attrs as $key => $value ) {
				$xml->writeAttribute($key, $value);
			}
		}
	}
}