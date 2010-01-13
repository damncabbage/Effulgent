<?php

/**
* Bare-bones, simple class to handle things like is-this-user-an-admin, logout, etc.
*/

class User
{
	protected static $username;

	public static function getUsername()
	{
		if (is_null(self::$username)) {
			if (isset($_SERVER['REMOTE_USER'])) {
				// PARANOIA: A rather bad idea. Fortunately, the .htpasswd list acts a whitelist.
				self::$username = $_SERVER['REMOTE_USER'];
			} else {
				// HACK PARANOIA: Making the assumption that if we can see this page, then we've already
				//                successfully authenticated via HTTP Basic Auth.
				self::$username = 'Booth';
			}
		}
		return self::$username;
	}

	public static function logout()
	{
		// TODO: I'm not even sure this is possible with HTTP Basic Auth.
	}

	public static function isAdmin()
	{
		// HACK: Should be stored in a database; instead, it's hardcoded here.
		$username = self::getUsername();
		switch ($username) {
			case 'booth1':
			case 'booth2':
			case 'booth3':
			case 'rovingbooth':
				return FALSE;
			break;

			case 'admin':
				return TRUE;
			break;
		}
		return false;
	}

}//end class
