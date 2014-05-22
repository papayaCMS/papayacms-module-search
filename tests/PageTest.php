<?php
require_once(dirname(__FILE__).'/bootstrap.php');

require_once(dirname(__FILE__).'/../src/Page.php');
require_once(dirname(__FILE__).'/../src/Page/Base.php');

class SearchPageTest extends SearchTestCase {

  /**
  * Get a fixture to use it in the tests
  */
  private function loadSearchPageFixture() {
    $SearchPage = new SearchPageProxy();
    return $SearchPage;
  }


  /***************************************************************************/
  /** Helper                                                                 */
  /***************************************************************************/

  /**
  * @covers SearchPage::setConfiguration
  */
  public function testSetConfiguration() {
    $SearchPage = $this->loadSearchPageFixture();
    $configuration = $this->getMockConfigurationObject();
    $SearchPage->setConfiguration($configuration);
    $this->assertAttributeSame(
      $configuration,
      '_configuration',
      $SearchPage
    );
  }

  /**
  * @covers SearchPage::setSearchPageBase
  */
  public function testSetSearchPageBase() {
    $SearchPage = $this->loadSearchPageFixture();
    $SearchPageBase = $this->getMock('SearchPageBase');
    $SearchPage->setSearchPageBase($SearchPageBase);
    $this->assertSame(
      TRUE,
      $this->readAttribute(
        $SearchPage,
        '_SearchPageBase'
      ) instanceof SearchPageBase
    );
  }

  /**
  * @covers SearchPage::getSearchPageBase
  */
  public function testGetSearchPageBase() {
    $SearchPage = $this->loadSearchPageFixture();
    $configuration = $this->getMockConfigurationObject();
    $SearchPage->setConfiguration($configuration);
    $SearchPage->getSearchPageBase();
    $this->assertAttributeInstanceOf(
      'SearchPageBase',
      '_SearchPageBase',
      $SearchPage
    );
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * @covers SearchPage::getParsedData
  */
  public function testGetParsedData() {
    $SearchPage = $this->loadSearchPageFixture();
    $configuration = $this->getMockConfigurationObject();
    $SearchPage->setConfiguration($configuration);
    $SearchPageBase = $this->getMock('SearchPageBase');
    $SearchPageBase->expects($this->once())
              ->method('getPageXml')
              ->will($this->returnValue('<data>some xml</data>'));
    $SearchPage->setSearchPageBase($SearchPageBase);
    $expected = '<data>some xml</data>';
    $this->assertEquals($expected, $SearchPage->getParsedData());
  }

  /**
  * @covers SearchPage::getParsedTeaser
  */
  public function testGetParsedTeaser() {
    $SearchPage = $this->loadSearchPageFixture();
    $configuration = $this->getMockConfigurationObject();
    $SearchPage->setConfiguration($configuration);
    $expected = '<teaser>some xml</teaser>';
    $this->assertEquals($expected, $SearchPage->getParsedTeaser());
  }


  /***************************************************************************/
  /** DataProvider                                                           */
  /***************************************************************************/

}

/**
* proxyobject to use instead of the real one
*/
class SearchPageProxy extends SearchPage {
  public function __construct() {
    return;
  }

  public function setDefaultData() {
    return;
  }

  public function initializeParams() {
    return;
  }
}
?>