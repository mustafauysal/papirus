<?php

/**
 * @package Papirus
 * @author Mesut Erdemir <erdemirmesut@gmail.com>
 * @copyright 2013 Papirus (http://egolabs.org)
 * @license Read LICENSE file under root folder
 * @link https://github.com/egolabs/papirus
 */

/**
 * Papirus Bootstrap File
 */

// Directory Definitions
define('PAPIRUS_PATH_ROOT', dirname(__FILE__) . "/../");
define('PAPIRUS_PATH_LIBRARY', dirname(__FILE__) . "/");
define('PAPIRUS_PATH_MODULE', dirname(__FILE__) . "/../module/");
define('PAPIRUS_PATH_CONFIG', dirname(__FILE__) . "/../config/");
define('PAPIRUS_PATH_TEMPLATE', dirname(__FILE__) . "/../template/");
define('PAPIRUS_PATH_UPLOAD', dirname(__FILE__) . "/../uplaod/");
define('PAPIRUS_PATH_CACHE', dirname(__FILE__) . "/../cache/");

// Load Papirus Class File
require_once PAPIRUS_PATH_LIBRARY . "Papirus.php";

// Run Papirus, Run!
$papirus = new Papirus();

// Start Engine
$papirus -> init();

// Set Papirus Configuration File Directories
$papirus -> config -> attachDirectory(PAPIRUS_PATH_CONFIG);

// Get Papirus Configuration
$papirus_config = $papirus -> config -> get("papirus");

// Set Error Reporting
switch ($papirus_config['environment']) {
	case 'development':
		error_reporting(E_ALL);
	break;
	case 'testing':
	case 'production':
		error_reporting(0);
	break;
}

// Set Error Handler
set_error_handler(array("Papirus_Exception", "_error_handler"));


// End of bootstrap.php
