<?php
require_once 'BaseTest.php';
require_once __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Utils'.DIRECTORY_SEPARATOR.'TestDataReader.php';
require_once 'ApplicationFunctions.php';

class LocationSearchTestcases extends BaseTest {

	/**
	 * This Testcase checks the functionality of entering the desired location.
	 */
// 	public function testSelectLocation() {
// 		$getCurrentLocation = $this->locatorObj->readConfigData ( "getLocationName" );
// 		$this->currentWindow ()->maximize ();
// 		$this->url ( "/" );
// 		$this->logger->info ( "*************** start of SelectLocation Testcase*********** " );
// 		$this->applicationFunctionObj->navigateToMainPage ( $this );
// 		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
// 		$data = $this->dataReader->readTestDataFromExcelFile("Location_Page_tc02","Location");
// 		$this->searchLocation($data["Location"]);
// 		$locationText = $this->byXPath ( $getCurrentLocation )->text ();
// 		$parts = explode ( ' ', $locationText );
// 		$location = array_values ( $parts ) [0];
// 		$this->logger->info ( "get the displayed location in the location box" );
// 		$locationValue = explode ( ',', $location )[0];
// 		$this->assertEquals ( $locationValue, $data["Location"]);
// 		$this->logger->info ( "*************** end of SelectLocation testcase********** " );
// 	}

	/**
	 * This functions helps to split the string name of the location variable.
	 */
	public function keyBoardPress($StringValue) {
		foreach ( str_split ( $StringValue ) as $keyValue ) {
			$this->keys ( $keyValue );
			sleep ( 1 );
		}
	}

	/**
	 * This functions searches the location box and enters the desired location value.
	 */
	public function searchLocation($sLocationName) {
		$locationSearchBox = $this->locatorObj->readConfigData ( "locationSearchBoxLocator" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $locationSearchBox, "xpath" );
		$this->byXPath ( $locationSearchBox )->click ();
		$this->logger->info ( "The location search box is displayed" );
		$this->keyBoardPress ($sLocationName );
		$this->keys ( "\xEE\x80\x87" );
		sleep ( 10 );
	}

	/**
	 * This Testcase deals with the assertion of actual and expected location in the location search.
	 */
	public function testReloadResults() {
		$getCurrentLocation = $this->locatorObj->readConfigData ( "getLocationName" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of ReloadResults Testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$data = $this->dataReader->readTestDataFromExcelFile("Location_Page_tc01","Location");
		$this->searchLocation($data["Location"]);
		$this->logger->info ( "The desired location is entered in the location search box is displayed" );
		$locationText = $this->byXPath ( $getCurrentLocation )->text ();
		$parts = explode ( ' ', $locationText );
		$location = array_values ( $parts ) [0];
		$locationValue = explode ( ',', $location )[0];
		$this->assertEquals ( $locationValue, $data["Location"] );
		$this->refresh ();
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $getCurrentLocation, "xpath" );
		$newLocationText = $this->byXPath ( $getCurrentLocation )->text ();
		$this->logger->info ( "get the location displayed on the location search box" );
		$parts = explode ( ' ', $newLocationText );
		$newLocation = array_values ( $parts ) [0];
		$this->logger->info ( "*************** end of ReloadResults testcase********** " );
		$locationValue = explode ( ',', $location )[0];
		$this->assertEquals ( $locationValue, $data["Location"] );
	}

	/**
	 * This Testcase tests the functionality of distance in kilometers of the desired location.
	 */
// 	public function testResultTilesDistance() {
// 		$distanceLocator =  $this->locatorObj->readConfigData ( "distanceFinder" );
// 		$this->currentWindow ()->maximize ();
// 		$this->url ( "/" );
// 		$this->logger->info ( "*************** start of ResultTilesDistance testcase*********** " );
// 		$this->applicationFunctionObj->navigateToMainPage ( $this );
// 		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline");
// 		$data = $this->dataReader->readTestDataFromExcelFile("Location_Page_tc02","Location");
// 		$this->searchLocation($data["Location"]);
// 		$this->logger->info ( "The desired location is entered in the location search box is displayed" );
// 		$distanceText = $this->byXPath ( $distanceLocator )->text ();
// 		echo $distanceText;
// 		$parts = explode ( ' ', $distanceText );
// 		$kilometers = array_values ( $parts ) [1];
// 		echo "\n".$kilometers;
// 		$this->logger->info ( "Distance of the first result is fetched and asserted");
// 		$this->assertContains($kilometers, $parts);
// 		$this->logger->info ( "*************** end of ResultTilesDistance testcase********** " );
// 	}

	/**
	 * This Testcase tests the functionality of distance in kilometers of the desired location and verifies the distance.
	 */
	public function testSortingOptionDistance() {
		$distanceLocator =  $this->locatorObj->readConfigData ( "distanceFinder" );
		$filterForm = $this->locatorObj->readConfigData ( "filterFormDropDown" );
		$selectDistance = $this->locatorObj->readConfigData ( "sortOptionDistance" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of SortingOptionDistance testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$data = $this->dataReader->readTestDataFromExcelFile("Location_Page_tc01","Location");
		$this->searchLocation($data["Location"]);
		$city = $data["Location"];
		$distanceText = $this->byXPath ( $distanceLocator )->text ();
		echo $distanceText;
		$parts = explode ( ' ', $distanceText );
		$kilometers = array_values ( $parts ) [1];
		$this->logger->info ( "Distance of the first result is fetched and asserted");
		$this->assertContains($kilometers, $parts);
		$this->logger->info ( "Distance in kilometers is printed" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $filterForm, "xpath" );
		$this->byXPath ( $filterForm )->click ();
		$this->logger->info ( "Location drop down is worked" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $selectDistance, "xpath" );
		$this->byXPath ( $selectDistance )->click ();
		$this->logger->info ( "Distance is sorted..." );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $distanceLocator, "xpath" );
		$newKilometers = $this->byXPath ( $distanceLocator )->text ();
		$kmparts = explode ( ' ', $newKilometers );
		$newkm = array_values ( $kmparts ) [1];
		if ($newkm < $kilometers) {
			$this->logger->info ( "Article sorted according to distance(1km)" );
		}
		$this->logger->info ( "*************** end of SortingOptionDistance testcase********** " );
	}

	/**
	 * This testcase deals with the functionality of location search cross button
	 */
// 	public function testClearLocationFilter() {
// 		$locationSearchBox = $this->locatorObj->readConfigData ( "locationSearchBoxLocator" );
// 		$this->currentWindow ()->maximize ();
// 		$this->url ( "/" );
// 		$this->logger->info ( "*************** start of ClearLocationFilter testcase*********** " );
// 		$this->applicationFunctionObj->navigateToMainPage ( $this );
// 		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
// 		$data = $this->dataReader->readTestDataFromExcelFile("Location_Page_tc02","Location");
// 		$this->searchLocation($data["Location"]);
// 		$city = $data["Location"];
// 		$filterTagElement = $this->locatorObj->readConfigData ( "locationFilterCross" );
// 		$filterTagElement = str_replace("xyz",$city,$filterTagElement);
// 		$searchText=$this->byXPath ( $locationSearchBox )->attribute('value');
// 		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $filterTagElement, "xpath" );
// 		$this->byXPath($filterTagElement)->click();
// 		$this->refresh();
// 		$this->logger->info ( "Reload after clicking price cross button" );
// 		$searchNewText=$this->byXPath ( $locationSearchBox )->attribute('value');
// 		$this->logger->info ( "*************** end of ClearLocationFilter testcase********** " );
// 		$this->assertEquals ( $searchText, $searchNewText );
// 	}

// 	public function testLocationEnteredIsNotDisplayedAfterClearing() {
// 		$this->logger->info ( "***************Start Of LocationEnteredIsNotDisplayedAfterClearing testcase*******************" );
// 		$this->currentWindow ()->maximize ();
// 		$getLocationText= $this->locatorObj->readConfigData ( "getLocationText" );
// 		$getKilometersText=$this->locatorObj->readConfigData ( "getKilometersText" );
// 		$getNewLocationText=$this->locatorObj->readConfigData ( "getNewLocationText" );
// 		$this->url ( "/" );
// 		$this->applicationFunctionObj->navigateToMainPage ( $this );
// 		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
// 		$data = $this->dataReader->readTestDataFromExcelFile("Location_Page_tc01","Location");
// 		$this->searchLocation($data["Location"]);
// 		$city = $data["Location"];
// 		$locationFilterCross = $this->locatorObj->readConfigData ( "locationFilterCross" );
// 		$locationFilterCross = str_replace("xyz", $city, $locationFilterCross);
// 		$this->applicationFunctionObj->waitForVisibility();
// 		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this,$getLocationText, "xpath" );
// 		$enteredLocation=$this->byXPath($getLocationText)->text();
// 		echo "\n".$enteredLocation;
// 		$this->logger->info ( "Entered city is present" );
// 		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this,$getKilometersText, "xpath" );
// 		$distanceText=$this->byXPath($getKilometersText)->text();
// 		echo "\n".$distanceText;
// 		$this->logger->info ( "Distance in kilometers is present" );
// 		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this,$locationFilterCross, "xpath" );
// 		$this->byXPath($locationFilterCross)->click();
// 		$this->logger->info ( "Clicked on price filter cross button" );
// 		$this->applicationFunctionObj->waitForVisibility();
// 		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this,$getNewLocationText, "xpath" );
// 		$newLocation=$this->byXPath($getNewLocationText)->text();
// 		echo "\n".$newLocation;
// 		$this->assertNotEquals ($enteredLocation, $newLocation );
// 		$this->logger->info ( "New Location is displayed after clicking cross button" );
// 		$this->logger->info ( "***************End Of LocationEnteredIsNotDisplayedAfterClearing testcase*******************" );
// 	}

}


?>