<?php
namespace App\Models;

/**
 * Description of profiledoa
 *
 * @author marnscott
 */
class contactdoa extends \Lib\doa {

	function __construct($class, $table) {
		parent::__construct($class, $table);
	}

	public function contactExists($c) {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		$selectClause = '`id`';
		$whereClause = '`firstname`=:firstname AND `lastname`=:lastname AND `userId`=:userId';
		$whereData = array(
				'userId' => $c['userId'],
				'firstname' => $c['firstname'],
				'lastname' => $c['lastname']
		);
		
		$results = $this->db->select($this->tablename, $selectClause, $whereClause, $whereData, $this->classname);
//		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);

		if ($results['count'] == 0)
			return false;
		else
			return true;

	}

	public function getAllContactsForUserId($userId) {

		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		$selectClause = '*';
		$whereClause = '`userId`=:userId';
		$whereData = array(
				'userId' => $userId
		);
		
		try
		{
  		$results = $this->db->select($this->tablename, $selectClause, $whereClause, $whereData, $this->classname);
  		$GLOBALS['appLog']->log('results of select: ' . print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
  		if ($results['count'] > 0)
  		{
				// return all contacts
  			return $results['data'];
  		}
  		else
  		{
				// data does not exist for this uid
  			return false;
  		}

		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}
	}

}

?>
