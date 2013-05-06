<?php

/**
 * @package Papirus
 * @author Mesut Erdemir <erdemirmesut@gmail.com>
 * @copyright 2013 Papirus (http://egolabs.org)
 * @license Read LICENSE file under root folder
 * @link https://github.com/egolabs/papirus
 */
class Papirus_Config {
	
	/**
	 * Instance of Class
	 * 
	 * @var		object
	 */
	protected static $_instance;
	
	/**
	 * Configuration File Directories
	 * 
	 * @var		array
	 */
	private $_config_directory = array();
	
	/**
	 * Creates an Instance of Class
	 * 
	 * @return	object
	 */
	public static function getInstance() {
		// Create a new config instance
		Papirus_Config::$_instance = new Papirus_Config;
		return Papirus_Config::$_instance;
	}
	
	/**
	 * Attach Configuration Directory(ies)
	 * 
	 * @param	string|array		$directory
	 * @return	void
	 */
	public function attachDirectory($directory) {
		if (is_array($directory)) {
			foreach ($directory as $dir) {
				$this -> _config_directory[] = $dir;
			}
		}
		else {
			$this -> _config_directory[] = $directory;
		}
	}
	
	/**
	 * Get Configuration
	 * 
	 * @param	string		$file_name
	 * @return	array|false
	 */
	public function get($file_name) {
		foreach ($this -> _config_directory as $config_directory) {
			$config_file = $config_directory . DIRECTORY_SEPARATOR .$file_name . ".php";
			if (file_exists($config_file)) {
				return include $config_file;
			}
			else return FALSE;
		}
		
		throw new Papirus_Exception("Unable to Get Configuration File");
	}
}

// End of Papirus_Config.php
