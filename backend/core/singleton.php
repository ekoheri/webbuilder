<?php
/* 
* Becak MVC Framework version 1.0 
*
* File		: base.php
* Directory	: system/core
* Author	: Eko Heri Susanto
* Description 	: class base adalah class yang digunakan untuk menyimpan instance object
*/
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