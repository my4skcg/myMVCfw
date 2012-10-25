<?php
namespace Lib;

/**
 * Description of Auth
 *
 * @author marnscott
 */

/** 
 * based off of http://snipplr.com/view/33829/
 * 
 * @todo secure passwords
 * see http://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
*/

class auth {
	
/**
	 * 
	 * @param type $username
	 * @param type $pwd password
	 */
	static function authenticate ($username, $pwd)
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		// @todo : sanitize input vars; don't think I need to since I'm using PDO
		/********
		 *   http://phpmaster.com/input-validation-using-filter-functions/
		 */

		/*
		 * @todo use class userDoa
		 */
		$password = static::encrypt($pwd);
		$GLOBALS['appLog']->log(sprintf('$pwd: %s; $password: %s', $pwd, $password), \Lib\appLogger::DEBUG, __METHOD__);

		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);

//		$selectClause = '`id`, `username`, `password`';
//		$whereClause = '`username`=:username';
//		$whereData = array(
//				'username' => $username
//		);

		$selectClause = '`id`, `username`, `password`';
		$whereClause = '`username`=:username AND `password`=:password';
		$whereData = array(
				'username' => $username,
				'password' => $password
		);

		$results = $db->select(USERS_TABLE, $selectClause, $whereClause, $whereData, "\Models\user");
		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);

		if ($results['count'] == 1) {
			return $results['data'][0]->getId();
		}
		else if ($results['count'] == 0)
			return false;
		else {
			// exception; more than one row found
		}
	}
	
	/**
	 * 
	 * @param type $p
	 */
	/*
	 * @assert ('testpassword') == 'e16b2ab8d12314bf4efbd6203906ea6c'
	 * @assert ('testfailed') == 'e16b2ab8d12314bf4efbd6203906ea6c'
	 */
	static function encrypt($p)
	{

		 return md5($p);
	}
}

?>
