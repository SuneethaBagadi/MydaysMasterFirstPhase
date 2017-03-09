<?php

class ConfigFileReader {

	 private $configFileName; //assiging the filename

	function __construct($FileName) {
		$this->configFileName = $FileName;
	}
	
	//function to read the config file data
	public function readConfigData($key){
		global $configFileName;
		$ini_array = parse_ini_file($this->configFileName);
		return $ini_array[$key];
	}
}
?>