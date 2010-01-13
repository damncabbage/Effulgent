<?php

define('EFFULGENT_VERSION', '0.01');

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
		$autoloader = new Zend_Application_Module_Autoloader(array(
			'namespace' => 'Default',
			'basePath'  => dirname(__FILE__),
		));
		return $autoloader;
	}

	protected function _initDb()
	{
		Zend_Registry::set('db', $this->getPluginResource('db')->getDbAdapter());
	}

}//end class

