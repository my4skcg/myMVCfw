<?php
namespace Lib;

	class request {

		private $_controller;
		private $_method;
		private $_args;
		private $_post = array();

		public function __construct() {
			
			$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
			$GLOBALS['appLog']->log('_GET = ' . print_r($_GET,1), appLogger::DEBUG, __METHOD__);
			$GLOBALS['appLog']->log('_POST = ' . print_r($_POST,1), appLogger::DEBUG, __METHOD__);
			
			$url = isset($_GET['url']) ? $_GET['url'] : null;
			$GLOBALS['appLog']->log('$_GET[url] = ' . $url, appLogger::DEBUG, __METHOD__);

			$parts = explode('/', $url);
			$parts = array_filter($parts);
			$GLOBALS['appLog']->log('$parts = ' . print_r($parts,1), appLogger::DEBUG, __METHOD__);

			$this->_controller = ($c = array_shift($parts))? $c : 'index';
			$this->_method = ($c = array_shift($parts))? $c: 'index';
			$this->_args = (isset($parts[0])) ? $parts : array();
			$this->_post = $_POST;

			$GLOBALS['appLog']->log('_controller = ' . $this->_controller, appLogger::DEBUG, __METHOD__);
			$GLOBALS['appLog']->log('_method = ' . $this->_method, appLogger::DEBUG, __METHOD__);
			$GLOBALS['appLog']->log('_args = ' . print_r($this->_args,1), appLogger::DEBUG, __METHOD__);
			$GLOBALS['appLog']->log('_post = ' . print_r($this->_post,1), appLogger::DEBUG, __METHOD__);
			
			$GLOBALS['appLog']->log('---   ' . __METHOD__, appLogger::INFO, __METHOD__);

		}

		public function getController() {
			return $this->_controller;
		}

		public function getMethod() {
			return $this->_method;
		}

		public function getArgs() {
			return $this->_args;
		}
	}
?>
