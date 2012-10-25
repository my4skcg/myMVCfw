<?php
namespace Lib;

	class Registry {

		private static $instance;

		private $storage;

		public static function getInstance()
		{
			if (!self::$instance instanceof self)
			{
				self::$instance = new Registry;
//				$GLOBALS['appLog']->log('New Registry', appLogger::DEBUG, __METHOD__);
			}
//			$GLOBALS['appLog']->log('Registry instance: ' . print_r(self::$instance,1), appLogger::DEBUG, __METHOD__);
			return self::$instance;
		}

		public function set($key, $val)
		{
//			$GLOBALS['appLog']->log('Set ' . $key . '->' . print_r($val,1), appLogger::DEBUG, __METHOD__);
			$this->storage[$key] = $val;
//			if (!is_string($key)){
//        return false;
//      }
//      self::getInstance()->$key = $val;
		}

		public function get($key)
		{
//			$GLOBALS['appLog']->log('Get ' . $key, appLogger::DEBUG, __METHOD__);
			if (isset($this->storage[$key]))
				return $this->storage[$key];
			else return false;
//			return self::getInstance()->$key;
		}

		/**
     * Delete a value key paired from registry
     * @param string $key
     *
     * @return bool
     */
//    public static function delete($key){
//        $return = false;
//        if (self::exist($key)){
//            unset ( self::getInstance()->$key );
//            $return = true;
//        }
//        return $return;
//    }

    /**
     * Get trueif key given exist inside registry
     * @param string $key
     * @return boolean
     */
//    public static function exist($key) {
//        $return = false;
//        if (self::getInstance()->$key){
//            $return = true;
//        }
//        return $return;
//    }

    /*** PRIVATE METHODS ***/

//    private function __set($key, $val){
//        $this->$key = $val;
//    }
//
//    private function __get($key){
//        return $this->$key;
//    }

		private function __construct() { }
		private function __clone() { }

	}
	
?>
