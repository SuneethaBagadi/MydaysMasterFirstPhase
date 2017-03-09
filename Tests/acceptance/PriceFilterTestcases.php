<?php
require_once 'BaseTest.php';
require_once __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Utils'.DIRECTORY_SEPARATOR.'TestDataReader.php';
require_once 'ApplicationFunctions.php';

class PriceFilterTestcases extends BaseTest {




	/**
	 * This testcase tests, entering the price values through input boxes is available.
	 */

	public function testSetPriceViaInput() {
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$minPrice = "123";
		$maxPrice = "145";
		$this->logger->info ( "*************** start of PriceFilterSearch testcase *****************" );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$this->applicationFunctionObj->searchItemsWithPrices ($this, $minPrice, $maxPrice );
		$this->logger->info ( "Price range is set and search is clicked" );
		sleep(4);
		$priceValue = $this->applicationFunctionObj->getPriceValues($this);
		for($i=0; $i<sizeof($priceValue);$i++)
		{
			echo (int)array_values($priceValue)[$i];
		}
		$this->logger->info ( "*************** end of PriceFilterSearch testcase *****************" );


	}

	/**
	 * This testcase tests, comparing the price values after refreshing or reloading the page..
	 */

	public function testReloadAfterSettingPriceAndCheckResultsAreSame() {
		$priceTag = $this->locatorObj->readConfigData ( "priceTag" );
		$minPriceInputLocator = $this->locatorObj->readConfigData ( "minimumPriceInputBox" );
		$maxPriceInputLocator = $this->locatorObj->readConfigData ( "maximumpriceInputBox" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$minPrice = "123";
		$maxPrice = "145";
		$this->logger->info ( "*************** start of PriceFilterSearch testcase *****************" );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$this->applicationFunctionObj->searchItemsWithPrices ( $this, $minPrice, $maxPrice );
		sleep(4);
		$this->refresh();
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $priceTag, "xpath");
		$this->byXPath( $priceTag )->click ();
		$this->logger->info ( "Price filter is clicked" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $minPriceInputLocator, "id" );
		$min = $this->byId ($minPriceInputLocator)->attribute('value');
		$this->assertEquals ($minPrice, $min );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $maxPriceInputLocator, "id" );
		$max = $this->byId ( $maxPriceInputLocator )->attribute('value');
		$this->logger->info ( "*************** end of PriceFilterSearch testcase *****************" );
		$this->assertEquals ($maxPrice, $max );
	}

	/**
	 * In this testcase tests, if we get the first article price value provide the minus one and plus one price to the filter tag to check if related results are within the range
	 */
	public function testSetTheMinPriceRange() {
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of SetTheMinPriceRange testcase *****************" );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$price = $this->applicationFunctionObj->getPriceValues($this);
		sleep(1);
		$firstArticlePrice = (int)array_values($price)[0];
		echo $firstArticlePrice;
		$this->applicationFunctionObj->searchItemsWithPrices ( $this, $firstArticlePrice-1, $firstArticlePrice+1 );
		$price1 = $this->applicationFunctionObj->getPriceValues($this);
		sleep(2);
		$getArticlePrice = (int)array_values($price)[0];
		if($getArticlePrice>=$firstArticlePrice-1)
			echo "Price value is within the range";
			else
				echo "There is an error";
				$this->logger->info ( "*************** end of SetTheMinPriceRange testcase *****************" );



	}

	/**
	 * This test case tests the price slider movement functionality.
	 */
	public function testPriceChangesOnSliderMovement() {
		$priceSlider = $this->locatorObj->readConfigData ( "priceFilterSliderLocator" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of PriceChangesOnSliderMovement testcase *****************" );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $priceSlider, "name" );
		$this->byName ( $priceSlider )->click ();
		$this->logger->info ( "Price filter is clicked" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, "priceMin", "id" );
		$minPrice = $this->byId ( "priceMin" )->value ();
		$leftSliderElement = $this->execute ( array (
				'script' => "document.getElementsByClassName('ui-slider-handle ui-state-default ui-corner-all')[0].setAttribute('style', 'left:36%;');",
				'args' => array ()
		) );
		$this->logger->info ( "Price slider is moved right" );
	
		$rightSliderElement = $this->execute ( array (
				'script' => "document.getElementsByClassName('ui-slider-handle ui-state-default ui-corner-all')[1].setAttribute('style', 'left:55%;');",
				'args' => array ()
		) );
		$this->logger->info ( "Price slider is moved left" );
		$this->logger->info ( "*************** end of PriceChangesOnSliderMovement testcase *****************" );
	}

	/**
	 * In this testcase we close the price filter box and after we reload the prices should be same to normal state
	 */
	public function testClearPriceFilter() {
	 $this->currentWindow ()->maximize ();
	 $priceFilterTagElement = $this->locatorObj->readConfigData ( "PriceFilterCross" );
	 $this->url ( "/" );
	 $minPrice = "123";
	 $maxPrice = "145";
	 $this->logger->info ( "*************** start of PriceFilterSearch testcase *****************" );
	 $this->applicationFunctionObj->navigateToMainPage ( $this );
	 $this->applicationFunctionObj->hanldeLocationPopUp ( $this, "decline" );
	 $this->applicationFunctionObj->searchItemsWithPrices($this, $minPrice, $maxPrice );
	 $this->logger->info ( "Price values are set" );
	 $this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $priceFilterTagElement, "xpath" );
	 $this->byXPath($priceFilterTagElement)->click();
	 $this->logger->info ( "Price filter cross appeared" );
	 $this->logger->info ( "Price filter Cross is cleared" );
	 $this->refresh();
	 $this->logger->info ( "Reload after clearing Price cross button" );
	 $this->logger->info ( "***************End Of ClearPriceFilter testcase*******************" );
	}
}
?>