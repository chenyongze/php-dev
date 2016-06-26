<?php
final class AtsHook extends AtsHookBase {
	private static $instance = null;
	
	final private function __clone(){}
	
	public static function getInstance() {
		self::$instance || self::$instance = new self();
		return self::$instance;
	}
	
	public function __construct() {
		$cache = storage_path().DIRECTORY_SEPARATOR.'hook'.DIRECTORY_SEPARATOR.'cache';
		
		if ( ! is_dir($cache)) {
			@mkdir($cache, 0777, true);
		}
		
		parent::__construct(
			app_path().DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'module',
			$cache,
			true
		);
	}
}