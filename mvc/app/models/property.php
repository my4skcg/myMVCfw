<?php
namespace Models;

/**
 * Description of property
 *
 * @author marnscott
 * 
 */
class property {

	private $id;
	private $mlsId;
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
	 * @param type $id  if 0, then create new property, else get property from db
	 * @param type $property  $id is 0, the property data to insert into db
	 * @return \Models\property
	 */
	public function  __construct($id, $property = array())
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		if ($id == 0)
		{
			// create a new property in the db
			$this->mlsId = $property['mlsId'];
			$this->address1 = $property['address1'];
			$this->address2 = $property['address2'];
			$this->city = $property['city'];
			$this->state = $property['state'];
			$this->zip = $property['zip'];
			$this->zip4 = $property['zip4'];
			$this->createNewProperty($property);
			return $this;
		}
 		else
		{
			// get the data for this property id from the db
			$this->getPropertyData($id);
			$this->id = $id;
			return $this;
		}
	}

	/**
	 * gets property data from database
	 */
	private function getPropertyData($id)
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

  		$results = $db->select(PROPERTIES_TABLE, $selectClause, $whereClause, $whereData);
  		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
  		// @todo use Object Mapping instead???
  		if ($results['count'] === 1)
  		{
				$this->mlsId = $results['data'][0]['mlsId'];
				$this->address1 = $results['data'][0]['address1'];
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

	} // end getPropertyData

	public static function getAllProperties() {

		try
		{
  		$results = $db->select(PROPERTIES_TABLE, '*');
  		return ($results['count'] > 0 ? $results : false);

		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

	} // end getAllProperties

	/**
	 * creates property in database
	 */
	private function createNewProperty($property)
	{
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);

		try
		{
  		$results = $db->insert(PROPERTIES_TABLE, $property);
  		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
			// returns the property id, if error the property id will be 0
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
	} // end createNewProperty

	
}

?>
