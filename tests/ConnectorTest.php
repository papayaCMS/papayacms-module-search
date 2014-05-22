<?php
require_once(dirname(__FILE__).'/bootstrap.php');

require_once(dirname(__FILE__).'/../src/Connector.php');
require_once(dirname(__FILE__).'/../src/Search.php');
require_once(dirname(__FILE__).'/../src/Dataprovider.php');
require_once(dirname(__FILE__).'/../src/Loader/Default.php');

class SearchConnectorTest extends SearchTestCase {

  /**
  * Get an instance of the connector class to be tested
  * @return SearchConnector
  */
  private function getSearchConnectorObjectFixture() {
    return new SearchConnector(new stdClass);
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * @covers SearchConnector::registerLoader
  */
  public function testRegisterLoader() {
    $dataProvider = $this->getMock('SearchDataprovider');
    $dataProvider
      ->expects($this->once())
      ->method('register')
      ->with($loader = new SearchLoaderDefault);
    $connector = $this->getSearchConnectorObjectFixture();
    $connector->setSearchDataproviderObject($dataProvider);
    $connector->registerLoader($loader);
  }

  /**
  * @covers SearchConnector::searchXml
  */
  public function testSearchXml() {
    $connector = $this->getSearchConnectorObjectFixture();

    $returnValue = $expected = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<response xmlns="http://www.w3.org/1999/xhtml">
  <items query="Berlin" limit="10" offset="0">
    <item>12345 Berlin</item>
  </items>
</response>';

    $Search = $this->getMock('Search');
    $connector->getSearchDataproviderObject();
    $Search
      ->expects($this->once())
      ->method('searchXml')
      ->will($this->returnValue($returnValue));

    $connector->setSearchBaseObject($Search);
    $this->assertXmlStringEqualsXmlString($expected, $connector->searchXML("Berlin"));
  }

  /**
  * @covers SearchConnector::searchArray
  */
  public function testSearchArray() {
    $connector = $this->getSearchConnectorObjectFixture();
    $connector->getSearchDataproviderObject();
    $returnValue = $expected = array(
     '12345' => 'Berlin',
     '45678' => 'Eine Stadt'
    );

    $Search = $this->getMock('Search');
    $Search
      ->expects($this->once())
      ->method('searchArray')
      ->will($this->returnValue($returnValue));

    $connector->setSearchBaseObject($Search);
    $this->assertSame($expected, $connector->searchArray('Berlin'));
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

  /**
  * @covers SearchConnector::setConfiguration
  */
  public function testSetConfiguration() {
    $connector = $this->getSearchConnectorObjectFixture();
    $configuration = $this->getMockConfigurationObject();
    $connector->setConfiguration($configuration);
    $this->assertAttributeEquals($configuration, '_configuration', $connector);
  }

  /**
  * @covers SearchConnector::getSearchBaseObject
  */
  public function testGetSearchBaseObject() {
    $connector = $this->getSearchConnectorObjectFixture();
    $SearchBaseObject = $connector->getSearchBaseObject();

    $this->assertAttributeEquals($SearchBaseObject, '_SearchBaseObject', $connector);
  }

  /**
  * @covers SearchConnector::getSearchBaseObject
  */
  public function testGetSearchBaseObjectFromCache() {
    $connector = $this->getSearchConnectorObjectFixture();
    $SearchBaseObject = new Search;
    $connector->setSearchBaseObject($SearchBaseObject);

    $this->assertSame($SearchBaseObject, $connector->getSearchBaseObject());
  }

  /**
  * @covers SearchConnector::setSearchBaseObject
  */
  public function testSetSearchBaseObject() {
    $connector = $this->getSearchConnectorObjectFixture();
    $SearchBaseObject = new Search;
    $connector->setSearchBaseObject($SearchBaseObject);

    $this->assertAttributeEquals($SearchBaseObject, '_SearchBaseObject', $connector);
  }

  /**
  * @covers SearchConnector::getSearchDataproviderObject
  */
  public function testGetSearchDataproviderObject() {
    $connector = $this->getSearchConnectorObjectFixture();
    $SearchDataproviderObject = $connector->getSearchDataproviderObject();

    $this->assertAttributeEquals(
      $SearchDataproviderObject, '_SearchDataproviderObject', $connector);
  }

  /**
  * @covers SearchConnector::getSearchDataproviderObject
  */
  public function testGetSearchDataproviderObjectFromCache() {
    $connector = $this->getSearchConnectorObjectFixture();
    $SearchDataproviderObject = new SearchDataprovider;
    $connector->setSearchDataproviderObject($SearchDataproviderObject);

    $this->assertSame($SearchDataproviderObject, $connector->getSearchDataproviderObject());
  }

  /**
  * @covers SearchConnector::setSearchDataproviderObject
  */
  public function testSetSearchDataproviderObject() {
    $connector = $this->getSearchConnectorObjectFixture();
    $SearchDataproviderObject = new SearchDataprovider;
    $connector->setSearchDataproviderObject($SearchDataproviderObject);

    $this->assertAttributeEquals(
      $SearchDataproviderObject, '_SearchDataproviderObject', $connector);
  }


  /***************************************************************************/
  /** DataProvider                                                           */
  /***************************************************************************/

}