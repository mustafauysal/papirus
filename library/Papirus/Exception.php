<?php

/**
 * @package Papirus
 * @author Mesut Erdemir <erdemirmesut@gmail.com>
 * @copyright 2013 Papirus (http://egolabs.org)
 * @license Read LICENSE file under root folder
 * @link https://github.com/egolabs/papirus
 */
class Papirus_Exception extends Exception {

	/**
	 * PHP error code => human readable name
	 * @var  array  
	 */
	public static $php_errors = array(
		E_ERROR => 'ERROR', 
		E_WARNING => 'WARNING', 
		E_PARSE => 'PARSING ERROR', 
		E_NOTICE => 'NOTICE', 
		E_CORE_ERROR => 'CORE ERROR', 
		E_CORE_WARNING => 'CORE WARNING', 
		E_COMPILE_ERROR => 'COMPILE ERROR', 
		E_COMPILE_WARNING => 'COMPILE WARNING', 
		E_USER_ERROR => 'USER ERROR', 
		E_USER_WARNING => 'USER WARNING', 
		E_USER_NOTICE => 'USER NOTICE', 
		E_STRICT => 'STRICT NOTICE', 
		E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR'
	);

	/**
	 * PHP Error Handler
	 * 
	 * @param ...
	 */
	public static function _error_handler($errno, $errstr, $errfile, $errline, $errcontext) {
		print "<b>" . self::$php_errors[$errno] . ":</b> <i>$errstr</i> in <b>$errfile</b> on line <b>$errline</b>\n";
	}

}

// End of Papirus_Exception.php
