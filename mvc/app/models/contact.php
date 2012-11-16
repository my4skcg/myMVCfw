<?php
namespace App\Models;

class contact {

	private $id;   
	private $uid;  // user name this contact belongs to
	private $firstname;
	private $lastname;
	private $homeph;
	private $cellph;
	private $workph;

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
