<?php
require_once 'BaseTest.php';
require_once __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Utils'.DIRECTORY_SEPARATOR.'TestDataReader.php';
require_once 'ApplicationFunctions.php';
class SortingTestcases extends BaseTest {
	/**
	 * This Test Cases Tests the functionality of select prices based on Best results.
	 */
	public function testSortingBestResults() {
		$SortingElement = $this->locatorObj->readConfigData ( "SortingFilter" );
		$SortBest = $this->locatorObj->readConfigData ( "SortingBestResult" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "***************Start Of SortingBestResults testcase*******************" );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$data = $this->dataReader->readTestDataFromExcelFile ( "Sorting_filter_tc01", "Location" );
		$this->searchLocation ( $data ["Location"] );
		$article1starElements = $this->elements ( $this->using ( 'xpath' )->value ( "//article[1]//*[@class='icon-star-full']" ) );
		;
		$article2StarElements = $this->elements ( $this->using ( 'xpath' )->value ( "//article[2]//*[@class='icon-star-full']" ) );
		;
		if (count ( $article2StarElements ) >= count ( $article1starElements )) {
			$this->fail ( "best mathces has error" );
		}
		$this->logger->info ( "***************End Of SortingBestResults testcase*******************" );
	}

	/**
	 * This Test Cases Tests the functionality of select prices in descending order.
	 * Reload after Descending Articles
	 */
	public function testSelectPriceDescending() {
		$SortingElement = $this->locatorObj->readConfigData ( "SortingFilter" );
		$SortDescending = $this->locatorObj->readConfigData ( "SortingDescending" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "***************Start Of SelectPriceDescending testcase*******************" );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$data = $this->dataReader->readTestDataFromExcelFile ( "Sorting_filter_tc02", "Location" );
		$this->searchLocation ( $data ["Location"] );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $SortingElement, "xpath" );
		$this->byXPath ( $SortingElement )->click ();
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, "//li[@class='m-sort is-active']/ul", "xpath" );
		$this->byXPath ( $SortDescending )->click ();
		$this->waitForAjax ();
		$pricevalues = $this->applicationFunctionObj->getPriceValues ( $this );
		$sorted = $pricevalues;
		rsort ( $sorted );
		$this->logger->info ( "Articles sorted in descending order" );
		$this->assertEquals ( $sorted, $pricevalues );
		$this->logger->info ( "Articles are displayed in Descending order" );
		$this->refresh ();
		$this->waitForAjax ();
		$this->logger->info ( "Reload Page" );
		$NewSortedpricevalues = $this->applicationFunctionObj->getPriceValues ( $this );
		$this->logger->info ( "Get price values after Reload" );
		$this->assertEquals ( $NewSortedpricevalues, $sorted );
		$this->logger->info ( "Articles are displayed in Descending order.....After Reload" );
		$this->logger->info ( "***************End Of SelectPriceDescending testcase*******************" );
	}

	/**
	 * This Test Cases Tests the functionality of select prices in ascending order.
	 * Reload after Ascending Articles
	 */
	public function testSelectPriceAscending() {
		$SortingElement = $this->locatorObj->readConfigData ( "SortingFilter" );
		$SortAscending = $this->locatorObj->readConfigData ( "SortingAscending" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "***************Start Of SelectPriceAscending testcase*******************" );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$data = $this->dataReader->readTestDataFromExcelFile ( "Sorting_filter_tc02", "Location" );
		$this->searchLocation ( $data ["Location"] );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $SortingElement, "xpath" );
		$this->byXPath ( $SortingElement )->click ();
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, "//li[@class='m-sort is-active']/ul", "xpath" );
		$this->byXPath ( $SortAscending )->click ();
		$this->waitForAjax ();
		$pricevalues = $this->applicationFunctionObj->getPriceValues ( $this );
		$sorted = $pricevalues;
		sort ( $sorted );
		$this->logger->info ( "Articles sorted in ascending order" );
		$this->assertEquals ( $pricevalues, $sorted );
		$this->logger->info ( "Articles are displayed in ascending order" );
		$this->refresh ();
		$this->waitForAjax ();
		$this->logger->info ( "Reload Page" );
		$Newpricevalues = $this->applicationFunctionObj->getPriceValues ( $this );
		$this->logger->info ( "Get price values after Reload" );
		$this->assertEquals ( $Newpricevalues, $sorted );
		$this->logger->info ( "Articles are displayed in Ascending order.....After Reload" );
		$this->logger->info ( "***************End Of SelectPriceAscending testcase*******************" );
	}
	public function waitForAjax() {
		sleep ( 3 );
		while ( true ) {
			$pageLoadStatus = $this->execute ( array (
					'script' => "return jQuery.active == 0",
					'args' => array ()
			) );
			echo "$$$$$" . $pageLoadStatus;
			if ($pageLoadStatus) {
				break;
			}
		}
	}

	/**
	 * This functions searches the location box and enters the desired location value.
	 */
	public function searchLocation($sLocationName) {
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, "//span[text()='Ort oder Region']", "xpath" );
		$this->byXPath ( "//span[text()='Ort oder Region']" )->click ();
		$this->logger->info ( "The location search box is displayed" );
		$this->keyBoardPress ( $sLocationName );
		$this->keys ( "\xEE\x80\x87" );
		sleep ( 10 );
	}

	/**
	 * This functions helps to split the string name of the location variable.
	 */
	public function keyBoardPress($StringValue) {
		foreach ( str_split ( $StringValue ) as $keyValue ) {
			$this->keys ( $keyValue );
			sleep ( 1 );
		}
	}
}
?>