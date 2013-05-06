<?php

/**
 * @package Papirus
 * @author Mesut Erdemir <erdemirmesut@gmail.com>
 * @copyright 2013 Papirus (http://egolabs.org)
 * @license Read LICENSE file under root folder
 * @link https://github.com/egolabs/papirus
 */
class Papirus {
	/**
	 * Papirus Version
	 * @const	string
	 */
	const VERSION = "0.0.1";
	
	/**
	 * Papirus Configuration Object
	 * @var		object
	 */
	public $config;
	
	/**
	 * Papirus Auto-Load Method
	 * 
	 * @param	string		$class_name
	 * @return	void
	 */
	public static function auto_load($class_name) {
		if (!class_exists($class_name)) {
			$class_path = sprintf("%s/%s.php", dirname(__FILE__), str_replace("_", DIRECTORY_SEPARATOR, $class_name));
			
			if (!file_exists($class_path)) {
				throw new Exception("Class Not Found ({$class_name})");
			}
			
			require_once $class_path;
		}
	}
	
	public function init() {
		// Load Configuration Class
		if (!$this -> config instanceof Papirus_Config) {
			$this -> config = new Papirus_Config;
		}
	}
}

// SPL Autoloader
spl_autoload_register(array('Papirus', 'auto_load'));

// End of Papirus.php
