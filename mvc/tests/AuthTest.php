<?php

class AuthTest extends PHPUnit_Framework_TestCase {

	protected function setup()
	{
		require_once ('/var/www/mvc/lib/auth.php');
		require_once ('/var/www/mvc/lib/model.php');
		require_once ('/var/www/mvc/models/user.php');
	}

	public function testAuthenticate() {

		$this->assertFalse(\Lib\Auth::authenticate('marion','dummy'));
		$this->assertGreaterThanOrEqual(1, \Lib\Auth::authenticate('marion','marion'));
		$this->assertFalse(\Lib\Auth::authenticate('dummy','dummy'));
	}

	public function testEncrypt() {
		$this->assertEquals(md5('testpassword'), \Lib\Auth::encrypt('testpassword'));

	}

}

?>
