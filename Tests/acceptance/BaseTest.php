<?php
require_once __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Utils'.DIRECTORY_SEPARATOR.'ConfigFileReader.php';
require_once __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Utils'.DIRECTORY_SEPARATOR.'TestDataReader.php';
require_once 'ApplicationFunctions.php';

class BaseTest extends PHPUnit_Extensions_Selenium2TestCase {

	public $configObject;
	public $logger;
	public $dataReader;
	public $locatorObj;
	public $applicationFunctionObj;

	public static function setUpBeforeClass() {
		// logger configuration
		Logger::configure ( __DIR__ . DIRECTORY_SEPARATOR."..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.xml" );
	}

	public static function tearDownAfterClass() {
		echo "---------------------- not yet implemented-----------";
	}

	protected function setUp() {
		// setting up the config file
		$this->configObject = new ConfigFileReader ( __DIR__ . DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.'TestConfiguration'.DIRECTORY_SEPARATOR.'Config.ini' );
		$this->dataReader = new TestDataReader( __DIR__ .$this->configObject->readConfigData ( "TestDataFileName" ));
		$this->locatorObj = new ConfigFileReader ( __DIR__ . DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.'Locators'.DIRECTORY_SEPARATOR.'ObjectLocators.ini' );
		$this->applicationFunctionObj = new ApplicationFunctions();
		
		// take screenshot on failures
		$this->_saveScreenshot ();

		$this->logger = Logger::getLogger ( "BaseTest" );
		$browserName = $this->configObject->readConfigData ( "BrowserName" );
		$projectUrl = $this->configObject->readConfigData ( "Baseurl" );
// 		$hostName = $this->configObject->readConfigData ( "HostName" );
// 		$this->setHost ($hostName);
		//$this->setPort(47642);
		$this->setBrowser ( $browserName );
		$this->setBrowserUrl ( $projectUrl );
	}

	protected function tearDown() {
		$this->stop ();
	}

	private function _saveScreenshot() {
		$path = realpath ( __DIR__ . "/" . $this->configObject->readConfigData ( "ScreenshotDir" ) );
		$screenshots_dir = $path;
		$this->listener = new PHPUnit_Extensions_Selenium2TestCase_ScreenshotListener ( $screenshots_dir );
	}

	public function onNotSuccessfulTest($e) {
		$this->listener->addError ( $this, $e, null );
		parent::onNotSuccessfulTest ( $e );
	}

}

?>