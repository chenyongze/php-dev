<?php
class TimeFormat {
	
	/**
	 * 
	 * @param string $timeStr like 20141030135105
	 * @return string
	 */
	public static function fromTimeStr($timeStr) {
			$dateTime = substr($timeStr,0, 4);
			$dateTime .= '-';
			$dateTime .= substr($timeStr, 4, 2);
			$dateTime .= '-';
			$dateTime .= substr($timeStr, 6, 2);
			$dateTime .= ' ';
			$dateTime .= substr($timeStr, 8, 2);
			$dateTime .= ':';
			$dateTime .= substr($timeStr, 10, 2);
			$dateTime .= ':';
			$dateTime .= substr($timeStr, 12);
			return $dateTime;	
	}
}