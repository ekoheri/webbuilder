<?php
class singleton {
	private static $instance;

	public function __construct(){
		self::$instance = &$this;
	}
	public static function getInstance(){
		return self::$instance;
	}
}
?>