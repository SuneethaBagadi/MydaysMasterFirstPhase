<?php
require_once 'BaseTest.php';
require_once __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Utils'.DIRECTORY_SEPARATOR.'TestDataReader.php';

class ApplicationFunctions {

	/**
	 * The function helps to navigate to main category page, does selecting subcategory menu
	 */
	public function navigateToMainPage($driver) {
		$mainCategoryElement =  $driver->locatorObj->readConfigData ( "mainCategory" );
		$subCategoryElement =  $driver->locatorObj->readConfigData ( "subCategory" );
		$driver->logger = Logger::getLogger ( "RegressionTestHelper" );
		$this->waitUntilElementIsVisible ( $driver, $mainCategoryElement, "name" );
		$driver->byName ( $mainCategoryElement )->click ();
		$driver->logger->info ( "Clicked Successfully on Main Category Menu" );
		$this->waitUntilElementIsVisible ( $driver,$subCategoryElement, "name" );
		$driver->byName ( $subCategoryElement )->click ();
		$driver->logger->info ( "Clicked Successfully on SubCategory Menu" );
	}

	/**
	 * This function helps to accept or decline the location suggested in the location popUp box
	 */
	public function hanldeLocationPopUp($driver, $action) {
		$acceptLocator =  $driver->locatorObj->readConfigData ( "acceptLocation" );
		$declineLocator =  $driver->locatorObj->readConfigData ( "declineLocation" );
		if ($action == "decline") {
			$this->waitUntilElementIsVisible ( $driver, $declineLocator, "id" );
			$driver->byId ( $declineLocator )->click ();
			$driver->logger->info ( "the location has been declined successfully" );
		}
		else if ($action == "accept") {
			$this->waitUntilElementIsVisible ( $driver, $acceptLocator, "id" );
				
			$driver->byId ( $acceptLocator )->click ();
			$driver->logger->info ( "the location has been accepted successfully" );
		}
	}

	/**
	 * This function helps get the array of price values displayed on the article box.
	 */
	public function getPriceValues($driver){
		sleep(3);
		for($articleCount=1;$articleCount<=5;$articleCount++){
			$price=$driver->byXPath("//article[$articleCount]//div[@class='pricevalue']")->text();
			$priceArray[$articleCount-1]=(float)explode(" �", $price)[0];
		}
		return $priceArray;
	}

	/**
	 * this function helps to wait until the locator is availble to perform the actions on the element.
	 */
	public function waitUntilElementIsVisible($driver, $locator, $type) {
		if ($type)
				
			for($second = 0;; $second ++) {
				if ($second >= 30)
					$driver->fail ( "Timeout Element ".$locator." is not displayed" );
					try {
						if ($type == "xpath") {
							if ($driver->byXPath ( $locator )->displayed ()) {
								break;
							}
						}
							
						if ($type == "id") {
							if ($driver->byId ( $locator )->displayed ()) {
								break;
							}
						}
							
						if ($type == "name") {
							if ($driver->byName ( $locator )->displayed ()) {
								break;
							}
						}
							
						if ($type == "classname") {
							if ($driver->byClassName ( $locator )->displayed ()) {
								break;
							}
						}
					} catch ( Exception $e ) {
						echo "*********************** cant see anything";
					}
					echo "sleeping time";
					$this->waitForVisibility();
			}
	}

	/**
	 * this function helps to slipt the string and enter the string in to the desired text box.
	 */
	public function keyBoardPress($StringValue) {
		foreach ( str_split ( $StringValue ) as $keyValue ) {
			$this->keys ( $keyValue );
			$this->waitForVisibility();
		}
		$this->waitForVisibility();
		$this->keys ( DIRECTORY_SEPARATOR."xEE\x80\x87" );
	}

	public function waitForVisibility(){
		sleep(2);
	}

	/**
	 * This function helps to input the price values into the price value input box.
	 */
	public function searchItemsWithPrices($driver, $minValue, $maxValue) {
		$priceFilterElement =  $driver->locatorObj->readConfigData ( "priceFilterLocator" );
		$submitPrice =  $driver->locatorObj->readConfigData ( "submitPriceRange" );
		$minPriceInputLocator = $driver->locatorObj->readConfigData ( "minimumPriceInputBox" );
		$maxPriceInputLocator = $driver->locatorObj->readConfigData ( "maximumpriceInputBox" );
		$this->waitForVisibility();
		$this->waitUntilElementIsVisible ( $driver, $priceFilterElement, "xpath");
		$driver->byXPath( $priceFilterElement)->click ();
		$driver->logger->info ( "price filter has been selected" );
		$this->waitUntilElementIsVisible ( $driver, $minPriceInputLocator, "id" );
		$driver->byId ( $minPriceInputLocator )->clear ();
		$driver->byId ( $minPriceInputLocator )->value ( $minValue );
		$driver->logger->info ( "The minimum price has been cleared and new price value is entered" );
		$this->waitUntilElementIsVisible ( $driver, $maxPriceInputLocator, "id" );
		$driver->byId ($maxPriceInputLocator )->clear ();
		$driver->byId ( $maxPriceInputLocator )->value ( $maxValue);
		$driver->logger->info ( "The maximum price has been cleared and new price value is entered" );
		$this->waitUntilElementIsVisible ( $driver, $submitPrice, "xpath" );
		$driver->byXPath ( $submitPrice )->click ();
	}



}
?>