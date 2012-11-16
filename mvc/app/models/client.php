<?php
namespace Models;

/**
 * Description of client
 *
 * @author marnscott
 * 
 */
class client {

	private $id;
	private $userId;   // agent id of the agent for this client
	private $firstname;
	private $lastname;
	private $dlstate;
	private $dlnumber;
	private $address1;
	private $address2;
	private $city;
	private $state;
	private $zip;
	private $zip4;

	/**
	 * 
	 * function __construct
	 * 
	 * @param type $id  if 0, then create new client, else get client from db
	 * @param type $client  $id is 0, the client data to insert into db
	 * @return \Models\client
	 */
	public function  __construct($id, $client = array())
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		if ($id == 0)
		{
			// create a new client in the db
			$this->userId = $client['userId'];
			$this->firstname = $client['firstname'];
			$this->lastname = $client['lastname'];
			$this->dlstate = $client['dlstate'];
			$this->dlnumber = $client['dlnumber'];
			$this->address1 = $client['address1'];
			$this->address2 = $client['address2'];
			$this->address2 = $client['address2'];
			$this->city = $client['city'];
			$this->state = $client['state'];
			$this->zip = $client['zip'];
			$this->zip4 = $client['zip4'];
			$this->createNewClient($client);
			return $this;
		}
 		else
		{
			// get the data for this client id from the db
			$this->getClientData($id);
			$this->id = $id;
			return $this;
		}
	}

	public function getFirstname() {
		return $this->firstname;
	}

	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}

	public function getLastname() {
		return $this->lastname;
	}

	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}

	public function getDlstate() {
		return $this->dlstate;
	}

	public function setDlstate($dlstate) {
		$this->dlstate = $dlstate;
	}

	public function getDlnumber() {
		return $this->dlnumber;
	}

	public function setDlnumber($dlnumber) {
		$this->dlnumber = $dlnumber;
	}
	public function getAddress1() {
		return $this->address1;
	}

	public function setAddress1($address1) {
		$this->address1 = $address1;
	}

	public function getAddress2() {
		
	}

	public function setAddress2($address2) {
		$this->address2 = $address2;
	}

	public function getCity() {
		return $this->city;
	}

	public function setCity($city) {
		$this->city = $city;
	}

	public function getState() {
		return $this->state;
	}

	public function setState($state) {
		$this->state = $state;
	}

	public function getZip() {
		return $this->zip;
	}

	public function setZip($zip) {
		$this->zip = $zip;
	}

	public function getZip4() {
		return $this->zip4;
	}

	public function setZip4($zip4) {
		$this->zip4 = $zip4;
	}

	
	/**
	 * gets client data from database
	 */
	private function getClientData($id)
	{
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);

		$selectClause = '*';
		$whereClause = '`id`=:id';
		$whereData = array(
				'id' => $id
		);
		
		try
		{

  		$results = $db->select(CLIENTS_TABLE, $selectClause, $whereClause, $whereData);
  		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
  		// @todo use Object Mapping instead???
  		if ($results['count'] === 1)
  		{
				$this->userId = $results['data'][0]['userId'];
				$this->firstname = $results['data'][0]['firstname'];
				$this->lastname = $results['data'][0]['lastname'];
				$this->dlstate = $results['data'][0]['dlstate'];
				$this->dlnumber = $results['data'][0]['dlnumber'];
				$this->address1 = $results['data'][0]['address1'];
				$this->address2 = $results['data'][0]['address2'];
				$this->address2 = $results['data'][0]['address2'];
				$this->city = $results['data'][0]['city'];
				$this->state = $results['data'][0]['state'];
				$this->zip = $results['data'][0]['zip'];
				$this->zip4 = $results['data'][0]['zip4'];
  		}
  		else
  		{
  			// exception
  		}
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

	} // end getClientData

	public static function getAllClients() {

		try
		{
  		$results = $db->select(CLIENTS_TABLE, '*');
  		return ($results['count'] > 0 ? $results : false);

		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

	} // end getAllClients

	/**
	 * creates user in database
	 */
	private function createNewClient($client)
	{
		// @todo - make sure unique on dlstate and dlnumber
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);

		try
		{
  		$results = $db->insert(CLIENTS_TABLE, $client);
  		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
			// returns the user id, if error the user id will be 0
  		if ($results['count'] === 1)
  		{
  			$this->id = $db->lastInsertId();
  		}
			else
			{
  			// some kind of error 
  			// @todo handle this error
  			die ("Database Insert Error");
			}
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}
	} // end createNewClient

}

?>
