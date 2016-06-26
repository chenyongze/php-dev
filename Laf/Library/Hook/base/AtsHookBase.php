<?php
class AtsHookBase
{
	public $directory = null;
	public $cacheDirectory = null;
	protected static $listeners = array();
	protected static $imported = array();
	protected static $directories = array();
	protected static $traces = array();
	protected $debugMode = false;
	
	public function __construct($directory, $cacheDirectory = null, $debugMode = false)
	{
		if (!is_dir($directory)) {
			throw new Exception('Please specify the hook directory', 0);
		}
		
		is_null($cacheDirectory) && $cacheDirectory = sys_get_temp_dir();
		
		if (!is_dir($cacheDirectory)) {
			throw new Exception('Please specify the cache directory for hook', 0);
		}
		$this->directory = rtrim($directory, '\/');
		$this->cacheDirectory = rtrim($cacheDirectory, '\/');
		$this->debugMode = $debugMode;
	}
	
	/**
	 * Tells whether the filename is a regular file
	 * @param string $filename
	 * @return boolean
	 */
	private function isFile($filename)
	{
		clearstatcache();
		return is_file($filename);
	}
	
	private function directorySeparator()
	{
		$args = func_get_args();
		return implode(DIRECTORY_SEPARATOR, $args);
	}
	
	/**
	 * Get the hook filename
	 * 
	 * @param string $hook
	 * @param string $hookName
	 * @return string
	 */
	private function getHookFilename($directory, $hookName)
	{
		return $this->directorySeparator($directory, $hookName . 'Hook.php');
	}
	
	/**
	 * Get filename via cached
	 *
	 * @param string $hookName
	 * @return string
	 */
	private function getCacheFilename($hookName)
	{
		return $this->directorySeparator($this->cacheDirectory, $hookName . 'Hook.Cached.php');
	}
	
	/**
	 * Get hook directories, Except `lib` directory.
	 * and begin with char `_` is only for debug mode.
	 * 
	 * @return array
	 */
	private function getHookDirectories($dir = null)
	{
		is_null($dir) && $dir = $this->directory;
		
		$directories = array();
		
		if (!$dirHandle = opendir($dir)) return $directories;
		
		while (($file = readdir($dirHandle)) !== false) {
			if ($file === "." || $file === ".." || $file === "lib") continue;
			if (!$this->debugMode && $file{0} === '_') continue;
			$directory = $this->directorySeparator($dir, $file);
			if (is_dir($directory)) {
				$directories[] = $directory;
				$directories = array_merge($directories, $this->getHookDirectories($directory));
			}
		}
		closedir($dirHandle);
		return $directories;
	}
	
	/**
	 * Complie a php file
	 * 
	 * @param string $filename
	 * @return string
	 */
	private static function compilePhpFile($filename)
	{
		$content = file_get_contents($filename);
		$stripStr = '';
		$tokens =   token_get_all ($content);
		$last_space = false;
		$tag_number = 0;
		for ($i = 0, $j = count ($tokens); $i < $j; $i++) {
			if (is_string ($tokens[$i])) {
				$last_space = false;
				$stripStr .= $tokens[$i];
			} else {
				switch ($tokens[$i][0]) {
					case T_OPEN_TAG:
						$tag_number++;
						$stripStr .= $tokens[$i][1];
						break;
					case T_CLOSE_TAG:
						$tag_number--;
						$stripStr .= $tokens[$i][1];
						break;
					case T_COMMENT:
					case T_DOC_COMMENT:
						break;
					case T_WHITESPACE:
						if (!$last_space) {
							$stripStr .= ' ';
							$last_space = true;
						}
						break;
					default:
						$last_space = false;
						$stripStr .= $tokens[$i][1];
				}
			}
		}
		
		$tag_number && $stripStr .= "\n?>";
		return $stripStr;
	}
	
	/**
	 * Register a hook
	 *
	 * @param string $hookClassName Prefix_For_Hook_[AfterCreateTmpOrder]Hook => In [a-zA-Z0-9]+ is hook for trigger name.
	 * @param number $priority
	 * @return boolean
	 */
	public function register($hookClassName, $priority = 10)
	{
		list($hookClassName, $priority) = array(strval($hookClassName), intval($priority));
		$hookName = explode('_', substr($hookClassName, 0, -4)); //strlen('Hook') => 4
		$hookName = end($hookName);
		if (!$hookName) return false;
		self::$listeners[$hookName][$priority][] = $hookClassName;
		return true;
	}
	
	/**
	 * Cache all code for one hook to a complied file.
	 * 
	 * @param string $hookName
	 * @param array $hookFilenames
	 * @return boolean
	 */
	private function cache($hookName, array $hookFilenames)
	{
		$hookCacheFilename = $this->getCacheFilename($hookName);
		if ($this->isFile($hookCacheFilename)) return false;
		
		$compiledContents = array();
		foreach ($hookFilenames as $hookFilename) {
			$compiledContents[] = self::compilePhpFile($hookFilename);
		}
		file_put_contents($hookCacheFilename, implode("\n", $compiledContents), LOCK_EX);
		return true;
	}
	
	/**
	 * Import a hook, and begin with char `_` is only for debug mode.
	 * 
	 * @param string $hookName
	 * @return boolean
	 */
	private function import($hookName)
	{
		if (array_key_exists($hookName, self::$imported)) return true;
		self::$imported[$hookName] = true;
		
		if (!$this->debugMode) {
			$hookCacheFilename = $this->getCacheFilename($hookName);
			if ($this->isFile($hookCacheFilename)) {
				require_once $hookCacheFilename;
				return true;
			}
		}
		
		$hookFilenames = array();
		
		foreach ($this->getHookDirectories() as $directory) {
			$hookFilename = $this->getHookFilename($directory, $hookName);
			if ($this->isFile($hookFilename)) {
				require_once $hookFilename;
				$hookFilenames[] = $hookFilename;
			} else if ($this->debugMode) {
				$hookFilename = $this->getHookFilename($directory, '_' . $hookName);
				if ($this->isFile($hookFilename)) {
					require_once $hookFilename;
					$hookFilenames[] = $hookFilename;
				}
			}
		}
		
		$this->debugMode || $this->cache($hookName, $hookFilenames);
		return true;
	}

	protected function set_trigger_trace($summary, $message = null, $isError = false)
	{
		if (!$this->debugMode) return false;

		if ($isError) {
			$backtrace = array();
			$traces = array_slice(debug_backtrace(false), 0, 5);
			foreach($traces as $k => $trace) {
				$backtrace[] = array(
					'file' => $trace['file'],
					'line' => $trace['line'],
					'class' => $trace['class'],
					'function' => $trace['function'],
				);
				
				if ($trace['function'] == 'trigger') {
					break;
				}
			}
			self::$traces[] = array('summary' => $summary, 'message' => $message, 'debug_backtrace' => $backtrace);
		} else {
			self::$traces[] = array('summary' => $summary, 'message' => $message);
		}
	}

	public function get_trigger_trace()
	{
		return self::$traces;
	}

	/**
	 * Trigger a hook
	 * 
	 * @param string $hookName
	 * @param mixed $data
	 * @return mixed
	 */
	public function trigger($hookName, $data = null)
	{
		$this->import($hookName);
		if (empty(self::$listeners[$hookName])) return 0;

		$this->set_trigger_trace('start hook ', $hookName);
		krsort(self::$listeners[$hookName], SORT_NUMERIC);
		$this->set_trigger_trace('trigger order by', self::$listeners[$hookName]);

		foreach (self::$listeners[$hookName] as $hookClassNames) {
			foreach ($hookClassNames as $hookClassName) {
				try {
					$instance = new $hookClassName();
					$instance->apply($data);
					unset($instance);
					$this->set_trigger_trace('apply class' . $hookClassName, 'success');
				} catch (Exception $e) {
					$this->set_trigger_trace('apply class ' . $hookClassName, 'error: ' . json_encode($e->getMessage()), true);
					throw $e;
				}
			}
		}

		return $data;
	}
}