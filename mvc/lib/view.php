<?php
namespace Lib;

class view {
	private $viewDir;

	function __construct() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
		$this->viewDir = 'views/';
	}

	public function setViewDir ($dir)
	{
		$this->viewDir = $dir . '/';
	}

	public function render ($name, $noHeader = false) {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
		
		//$view = 'views/' . $name . '.php';
		$view = $this->viewDir . $name . '.php';
		$GLOBALS['appLog']->log('VIEW ' . $view, appLogger::INFO, __METHOD__);
		
		if ($noHeader) 
			require $view;
		else
		{
			require 'views/header.php';
			require $view;
			require 'views/footer.php';
		}
	}
}
?>
