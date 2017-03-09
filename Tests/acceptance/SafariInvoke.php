<?php
require_once 'BaseTest.php';
require_once 'LocationPopUpTestcases.php';
class test extends BaseTest
{
	

	public function testTitle()
	{
		$this->url('/');
		sleep(10);
		$this->byName ( "mainCategories.button" )->click ();
		$this->configObject->readConfigData($key);
		//$this-
		//$this->
	}
}
?>