<?php
/**
 * @file Log.php
 * @author zhujt(zhujianting@baidu.com)
 * @date 2009/08/04 10:31:44
 * @version $Revision: 1.2 $
 * @brief class for logging
 *
 **/

class Bd_Log {
	const LOG_LEVEL_NONE    = 0x00;
	const LOG_LEVEL_FATAL   = 0x01;
	const LOG_LEVEL_WARNING = 0x02;
	const LOG_LEVEL_NOTICE  = 0x04;
	const LOG_LEVEL_TRACE   = 0x08;
	const LOG_LEVEL_DEBUG   = 0x10;
	const LOG_LEVEL_ALL     = 0xFF;

	public static $arrLogLevels = array(
		self::LOG_LEVEL_NONE    => 'NONE',
		self::LOG_LEVEL_FATAL   => 'FATAL',
		self::LOG_LEVEL_WARNING => 'WARNING',
		self::LOG_LEVEL_NOTICE  => 'NOTICE',
		self::LOG_LEVEL_TRACE   => 'TRACE',
		self::LOG_LEVEL_DEBUG   => 'DEBUG',
		self::LOG_LEVEL_ALL     => 'ALL',
	);

	protected $intLevel;
	protected $strLogFile;
	protected $arrSelfLogFiles;
	protected $intLogId;
	protected $intMaxFileSize;
	protected $addNotice = '';

	private static $instance = null;

	public function __construct($arrLogConfig = '') {
		$arrLogConfig = is_array($arrLogConfig)?$arrLogConfig:array(
			'intLevel'        => 0xFF,
			'strLogFile'      => LOG_PATH.'applog.'.date('Y-m-d.G').'.log',
			'arrSelfLogFiles' => '',
			'intMaxFileSize'  => 0,
		);
		$this->intLevel        = intval($arrLogConfig['intLevel']);
		$this->strLogFile      = $arrLogConfig['strLogFile'];
		$this->arrSelfLogFiles = $arrLogConfig['arrSelfLogFiles'];
		// use framework logid as default
		$this->intLogId       = 0;
		$this->intMaxFileSize = $arrLogConfig['intMaxFileSize'];
	}

	public static function init($arrLogConfig) {
		if (self::$instance == null) {
			self::$instance = new Log($arrLogConfig);
		}
	}
	/*
	用新的配置重新创建一个log实例
	 */
	public static function newInstance($arrLogConfig) {
		if (self::$instance !== null) {
			self::$instance = null;
		}
		self::$instance = new Log($arrLogConfig);
	}

	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new Log();
		}

		return self::$instance;
	}

	public function writeLog($intLevel, $str, $errno = 0, $arrArgs = null, $depth = 0) {
		if (!($this->intLevel&$intLevel) || !isset(self::$arrLogLevels[$intLevel])) {
			return;
		}

		$strLevel = self::$arrLogLevels[$intLevel];

		$strLogFile = $this->strLogFile;

		if (($intLevel&self::LOG_LEVEL_WARNING) || ($intLevel&self::LOG_LEVEL_FATAL)) {
			$strLogFile .= '.wf';
		}

		$trace = debug_backtrace();
		if ($depth >= count($trace)) {
			$depth = count($trace)-1;
		}
		$file = basename($trace[$depth]['file']);
		$line = $trace[$depth]['line'];

		$strArgs = '';
		if (is_array($arrArgs) && count($arrArgs) > 0) {
			foreach ($arrArgs as $key => $value) {
				$strArgs .= "{$key}[$value]";
			}
		}

		if (isset($this->addNotice {2})) {
			$strArgs .= $this->addNotice;
		}

		$str = sprintf("%s: %s [%s:%d] errno[%d] ip[%s] logId[%u] mod[%s] uri[%s] refer[%s] cookie[%s] %s %s\n",
			$strLevel,
			date('m-d H:i:s:', time()),
			$file, $line, $errno,
			self::getClientIP(),
			'LOG_ID',
			'APP',
			isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'',
			isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'',
			isset($_SERVER['HTTP_COOKIE'])?$_SERVER['HTTP_COOKIE']:'',
			$strArgs,
			$str);
		if ($this->intMaxFileSize > 0) {
			clearstatcache();
			$arrFileStats = stat($strLogFile);
			if (is_array($arrFileStats) && floatval($arrFileStats['size']) > $this->intMaxFileSize) {
				$strLogFile .= date('YmdH');
			}
		}
		return file_put_contents($strLogFile, $str, FILE_APPEND);
	}

	public function writeSelfLog($strKey, $str, $arrArgs = null) {
		if (isset($this->arrSelfLogFiles[$strKey])) {
			$strLogFile = $this->arrSelfLogFiles[$strKey];
		} else {
			return;
		}

		$strArgs = '';
		if (is_array($arrArgs) && count($arrArgs) > 0) {
			foreach ($arrArgs as $key => $value) {
				$strArgs .= "{$key}[$value] ";
			}
		}

		$str = sprintf("%s: %s ip[%s] logId[%u] uri[%s] %s%s\n",
			$strKey,
			date('m-d H:i:s:', time()),
			self::getClientIP(),
			$this->intLogId,
			isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'',
			$strArgs, $str);

		if ($this->intMaxFileSize > 0) {
			clearstatcache();
			$arrFileStats = stat($strLogFile);
			if (is_array($arrFileStats) && floatval($arrFileStats['size']) > $this->intMaxFileSize) {
				$strLogFile .= date('YmdH');
				//unlink($strLogFile);
			}
		}
		return file_put_contents($strLogFile, $str, FILE_APPEND);
	}

	public static function selflog($strKey, $str, $arrArgs = null) {
		$log = Log::getInstance();
		return $log->writeSelfLog($strKey, $str, $arrArgs);
	}

	public static function debug($str, $errno = 0, $arrArgs = null, $depth = 0) {
		$log = Log::getInstance();
		return $log->writeLog(self::LOG_LEVEL_DEBUG, $str, $errno, $arrArgs, $depth+1);
	}

	public static function trace($str, $errno = 0, $arrArgs = null, $depth = 0) {
		$log = Log::getInstance();
		return $log->writeLog(self::LOG_LEVEL_TRACE, $str, $errno, $arrArgs, $depth+1);
	}

	public static function notice($str, $errno = 0, $arrArgs = null, $depth = 0) {
		$log = Log::getInstance();
		return $log->writeLog(self::LOG_LEVEL_NOTICE, $str, $errno, $arrArgs, $depth+1);
	}

	public static function addNotice($key, $value) {
		$log  = Log::getInstance();
		$info = is_array($value)?var_export($value, true):$value;
		$log->addNotice .= " {$key}[$info]";
	}

	public static function warning($str, $errno = 0, $arrArgs = null, $depth = 0) {
		$log = Log::getInstance();
		return $log->writeLog(self::LOG_LEVEL_WARNING, $str, $errno, $arrArgs, $depth+1);
	}

	public static function fatal($str, $errno = 0, $arrArgs = null, $depth = 0) {
		$log = Log::getInstance();
		return $log->writeLog(self::LOG_LEVEL_FATAL, $str, $errno, $arrArgs, $depth+1);
	}

	public static function setLogId($intLogId) {
		Log::getInstance()->intLogId = $intLogId;
	}

	public static function getClientIP() {
		$uip = '';
		if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$uip = getenv('HTTP_CLIENT_IP');
		} elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$uip = getenv('REMOTE_ADDR');
		} elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$uip = $_SERVER['REMOTE_ADDR'];
		}
		return $uip;
	}

	static function getLogID() {
		//HTTP_X_BD_LOGID64
		if (isset($_SERVER['HTTP_X_BD_LOGID'])) {
			return intval($_SERVER['HTTP_X_BD_LOGID']);
		} else {
			$arr = gettimeofday();
			return ((($arr['sec']*100000+$arr['usec']/10)&0x7FFFFFFF)|0x80000000);
		}
	}
}
