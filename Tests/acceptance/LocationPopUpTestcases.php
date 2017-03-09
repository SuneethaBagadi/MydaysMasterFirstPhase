<?php
require_once 'BaseTest.php';
require_once __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Utils'.DIRECTORY_SEPARATOR.'TestDataReader.php';
require_once 'ApplicationFunctions.php';
class LocationPopUpTestcases extends BaseTest {

	/**
	 * this test scenarion deals with location popup feature.
	 * It checks whether the location poup is displayed, when the browser is launched.
	 */
	public function testCheckLocationPopUpPresence() {
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of CheckLocationPopUpPresence testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, "setLocation", "classname" );
		$isLocationBoxDisplayed = $this->byClassName ( "setLocation" )->displayed ();
		$this->logger->info ( "Location popup is displayed" );
		$this->logger->info ( "*************** end of CheckLocationPopUpPresence testcase********** " );
		$this->assertEquals ( true, $isLocationBoxDisplayed );
	}

	/**
	 * In this testcase we accept the location suggestion on the popup box based on our location. Refresh the page. Then the popup should be disabled.
	 */
	public function testAcceptTheLocationPopUpAndRefresh() {
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of AcceptTheLocationPopUpAndRefresh testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "accept" );
		$this->refresh ();
		$this->logger->info ( "The page is refreshed to check the popup availability" );
		try {
			$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, "setLocation", "classname" );
			$this->fail ( "Location popup is displayed even after refresh" );
		} catch ( Exception $e ) {
		}
		$this->logger->info ( "*************** end of AcceptTheLocationPopUpAndRefresh testcase********** " );
	}

	/**
	 * In this testcase we decline the location popup, delete the current session. After that refresh the page to find the location popup is enabled again
	 */
	public function testDeleteSessionAndLocationPopUpShouldBeVisible() {
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of DeleteSessionAndLocationPopUpShouldBeVisible testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$this->cookie ()->clear ();
		$this->logger->info ( "cookie has been deleted successfully" );
		$this->refresh ();
		$this->logger->info ( "The page is refreshed to check the popup availability after the session deletion" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, "setLocation", "classname" );
		$this->logger->info ( "*************** end of DeleteSessionAndLocationPopUpShouldBeVisible testcase********** " );
	}

	/**
	 * In this testcase we decline the suggest location on popup box, and enter the location of our own choice.
	 */
	public function testGoToLocationAfterDecliningThePopUp() {
		$getCurrentLocation = $this->locatorObj->readConfigData ( "getLocationName" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of SelectLocation Testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$data = $this->dataReader->readTestDataFromExcelFile("Location_Page_tc01","Location");
		$this->searchLocation($data["Location"]);
		$locationText = $this->byXPath ( $getCurrentLocation )->text ();
		$parts = explode ( ' ', $locationText );
		$location = array_values ( $parts ) [0];
		$this->logger->info ( "get the displayed location in the location box" );
		$locationValue = explode ( ',', $location )[0];
		$this->assertEquals ( $locationValue, $data["Location"]);
		$this->logger->info ( "*************** end of SelectLocation testcase********** " );
	}

	public function keyBoardPress($StringValue) {
		foreach ( str_split ( $StringValue ) as $keyValue ) {
			$this->keys ( $keyValue );
			sleep ( 1 );
		}
		sleep ( 1 );
		$this->keys ( "\xEE\x80\x87" );
	}

	public function searchLocation($sLocationName) {
		$locationSearchBox = $this->locatorObj->readConfigData ( "locationSearchBoxLocator" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $locationSearchBox, "xpath" );
		$this->byXPath ($locationSearchBox )->click ();
		$this->logger->info ( "The location search box is displayed" );
		$this->keyBoardPress ($sLocationName );
		$this->keys ( "\xEE\x80\x87" );
		sleep ( 10 );
	}
}
?>