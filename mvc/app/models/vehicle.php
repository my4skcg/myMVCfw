<?php
namespace Models;

/**
 * Description of vehicle
 *
 * @author marnscott
 * 
 */
class vehicle {

	private $id;
	private $plates;
	private $make;
	private $model;
	private $year;
	private $color;

	/**
	 * 
	 * function __construct
	 * 
	 * @param type $id  if 0, then create new vehicle, else get vehicle from db
	 * @param type $vehicle  $id is 0, the vehicle data to insert into db
	 * @return \Models\vehicle
	 */
	public function  __construct($id, $vehicle = array())
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		if ($id == 0)
		{
			// create a new vehicle in the db
			$this->plates = $vehicle['plates'];
			$this->make = $vehicle['make'];
			$this->model = $vehicle['model'];
			$this->year = $vehicle['year'];
			$this->color = $vehicle['color'];
			$this->createNewVehicle($vehicle);
			return $this;
		}
 		else
		{
			// get the data for this vehicle id from the db
			$this->getVehicleData($id);
			$this->id = $id;
			return $this;
		}
	}

	/**
	 * gets vehicle data from database
	 */
	private function getVehicleData($id)
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

  		$results = $db->select(VEHICLES_TABLE, $selectClause, $whereClause, $whereData);
  		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
  		// @todo use Object Mapping instead???
  		if ($results['count'] === 1)
  		{
				$this->plates = $results['data'][0]['plates'];
				$this->make = $results['data'][0]['make'];
				$this->model = $results['data'][0]['model'];
				$this->year = $results['data'][0]['year'];
				$this->color = $results['data'][0]['color'];
  		}
  		else
  		{
  			// exception
  		}
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

	} // end getVehicleData

	public static function getAllVehicles() {

		try
		{
  		$results = $db->select(VEHICLES_TABLE, '*');
  		return ($results['count'] > 0 ? $results : false);

		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

	} // end getAllVehicles

	/**
	 * creates vehicle in database
	 */
	private function createNewVehicle($vehicle)
	{
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);

		try
		{
  		$results = $db->insert(VEHICLES_TABLE, $vehicle);
  		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
			// returns the vehicle id, if error the vehicle id will be 0
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
	} // end createNewVehicle
}

?>
