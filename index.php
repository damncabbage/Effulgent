<?php
// Define path to application directory
if(!defined('APPLICATION_PATH')) {
	define('APPLICATION_PATH', realpath(dirname(__FILE__).'/app'));
}

// Define application environment
if(!defined('APPLICATION_ENV')) {
	define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
}

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
	realpath(APPLICATION_PATH . '/lib'),
	get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';  

// Create application, bootstrap, and run
$application = new Zend_Application(
		APPLICATION_ENV,
		APPLICATION_PATH . '/config/main.ini'
		);
$application->bootstrap()->run();
