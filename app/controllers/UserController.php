<?php

/**
* Handles logout and getting user details only; this is very, very basic authentication that we're using.
* (I do only have two hours to write most of this application.)
*/

require_once APPLICATION_PATH.'/models/User.php';

class UserController extends Zend_Controller_Action 
{
    public function indexAction() 
    {
		// HACK TODO: Use default controller configuration
		$this->_forward('index', 'tickets');
    }

	public function logoutAction()
	{
		User::logout();
	}

}
