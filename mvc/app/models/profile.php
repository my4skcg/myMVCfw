<?php
namespace App\Models;

class profile {

	private $id;   // do I want this???
	private $uid;
	private $firstname;
	private $lastname;
	private $address1;
	private $address2;
	private $city;
	private $state;
	private $zip;
	private $zip4;

	function __construct() {
		
	}

	public function toArray($obj = NULL) {

		$vars = get_object_vars ( $this );
    $array = array ();
    foreach ( $vars as $key => $value ) {
			$GLOBALS['appLog']->log('key: ' . print_r($key, 1), \Lib\appLogger::INFO, __METHOD__);
      $array [$key] = $value;
    }
    return $array;
	}

}

?>
