<?php
require_once 'BaseTest.php';
require_once __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Utils'.DIRECTORY_SEPARATOR.'TestDataReader.php';
require_once 'ApplicationFunctions.php';
class ListPagesTestcases extends BaseTest {

	/**
	 * This Testcase validates the presence of all the category pages is loaded
	 */
	public function testCategoryPageLoads() {
		$articleCountLocator = $this->locatorObj->readConfigData ( "articleCounter" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of CategoryPageLoads testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $articleCountLocator,"xpath");
		$catCountString = $this->byXPath ( $articleCountLocator )->text ();
		$this->logger->info ( "Category page is loaded successfully" );
		$parts = explode ( ' ', $catCountString );
		$count = ( int ) array_values ( $parts ) [0];
		echo $count;
		if ($count > 2000) {
			$this->logger->info ( "Category page is loaded successfully Category count is greater than 2000" );
		} else {
			$this->fail ( "Category page is not fully loaded" );
		}
		$this->logger->info ( "*************** end of CategoryPageLoads testcase********** " );
	}

	/**
	 * This Testcase validates loading of article pages and fetching the no of available articles in the page
	 */
	public function testGroupPagesLoads() {
		$categoryElementLocator = $this->locatorObj->readConfigData ( "categoryLocator" );
		$articleCountLocator = $this->locatorObj->readConfigData ( "articleCounter" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of GroupPagesLoads testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this,$categoryElementLocator,"name" );
		$this->byName ( $categoryElementLocator)->click ();
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this,$articleCountLocator,"xpath");
		$GrouppageCount = $this->byXPath ( $articleCountLocator )->text ();
		$this->logger->info ( "The count value of the available results is fetched" );
		$parts = explode ( ' ', $GrouppageCount );
		$count = ( int ) array_values ( $parts ) [0];
		if ($count > 1500) {
			$this->logger->info ( "Group page is loaded successfully and count is greater than 1500" );
		} else {
			$this->fail ( "Group page is not fully loaded" );
		}
		$this->logger->info ( "*************** end of GroupPagesLoads testcase********** " );
	}

	/**
	 * This Testcase validates loading of article pages and fetching the count of available articles in the main article page
	 */
	public function testMainArticlePageLoads() {
		$articleElement = $this->locatorObj->readConfigData ( "mainArticleLocator" );
		$articleCountLocator = $this->locatorObj->readConfigData ( "articleCounter" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of MainArticlePageLoads testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->waitUntilElementIsVisible ($this,$articleElement,"name" );
		$this->byName($articleElement)->click ();
		$this->logger->info ( "Clicked Successfully on Main Article Page menu" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this,$articleCountLocator ,"xpath" );
		$MainArticleCount = $this->byXPath ( $articleCountLocator )->text ();
		$this->logger->info ( "The count value of the available results is fetched" );
		$parts = explode ( ' ', $MainArticleCount );
		$count = ( int ) array_values ( $parts ) [0];
		if ($count > 25) {
			$this->logger->info ( "Main Article page is loaded successfully and cunt is greaterthan 25" );
		} else {
			$this->fail ( "Main article page is not fully loaded" );
		}
		$this->logger->info ( "*************** end of MainArticlePageLoads testcase********** " );
	}

	/**
	 * This testcase validates the presence of all the articles depending on the loading of new web pages
	 */
	public function testArticlePageLoads() {
		$articleElement = $this->locatorObj->readConfigData ( "mainArticleLocator" );
		$mainArticleElement =  $this->locatorObj->readConfigData ( "subArticleLocator" );
		$articleCountLocator = $this->locatorObj->readConfigData ( "articleCounter" );
		$this->currentWindow ()->maximize ();
		$this->url ( "/" );
		$this->logger->info ( "*************** start of ArticlePageLoads testcase*********** " );
		$this->applicationFunctionObj->navigateToMainPage ( $this );
		$this->applicationFunctionObj->waitUntilElementIsVisible ($this, $articleElement,"name" );
		$this->byName ( $articleElement )->click ();
		$this->logger->info ( "Clicked Successfully on Article Page" );
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $mainArticleElement,"name");
		$this->byName ( $mainArticleElement)->click ();
		$this->applicationFunctionObj->waitUntilElementIsVisible ( $this, $articleCountLocator,"xpath" );
		$ArticleCount = $this->byXPath ( $articleCountLocator )->text ();
		$parts = explode ( ' ', $ArticleCount );
		$this->logger->info ( "Main article page is loaded" );
		$count = ( int ) array_values ( $parts ) [0];
		if ($count > 15) {
			$this->logger->info ( "Main Article page is loaded successfully and count is greaterthan 15" );
		}
		else {
			$this->fail ( "Article page is not fully loaded" );
		}
		$this->logger->info ( "*************** end of ArticlePageLoads testcase********** " );
	}

}
?>
