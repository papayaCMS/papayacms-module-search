<?php
require_once(dirname(__FILE__).'/bootstrap.php');

require_once(dirname(__FILE__).'/../src/Search.php');
require_once(dirname(__FILE__).'/../src/Interface/Dataprovider.php');

class SearchTest extends SearchTestCase {

  public function setUp() {
    if (!defined('LF')) {
      define('LF', "\n");
    }
  }

  /**
  * Provides an instance of the Search class as a fixture
  * @return Search
  */
  public function getSearchObjectFixture() {
    return new Search;
  }

  /**
  * Provides a proxy instance of the Search class as a fixture
  * @return Search
  */
  public function getSearchProxyObjectFixture() {
    return $this->getProxy('Search');
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * @covers Search::searchXml
  */
  public function testSearchXml() {

    $expected = '<response xmlns="http://www.w3.org/1999/xhtml">
  <items query="Berlin" limit="10" offset="0">
    <item>12345 Berlin</item>
  </items>
</response>';

    $Search = new getSearchObjectSearchXML();
    $dataprovider = $this->getMock(
      'SearchInterfaceDataprovider',
      array('load', 'register')
    );
    $dataprovider
      ->expects($this->once())
      ->method('load')
      ->will($this->returnValue(array('12345 Berlin' => 'Berlin')));
    $Search->setDataprovider($dataprovider);

    $this->assertXmlStringEqualsXmlString($expected, $Search->searchXml('Berlin'));
  }

  /**
  * @covers Search::searchArray
  */
  public function testSearchArray() {
    $expected = $returnValue = array(
     '12345 Berlin' => 12345,
     '12346 Berlin' => 12346,
    );

    $Search = new getSearchObjectSearchXML();
    $dataprovider = $this->getMock(
      'SearchInterfaceDataprovider',
      array('load', 'register')
    );
    $dataprovider
      ->expects($this->once())
      ->method('load')
      ->will($this->returnValue($returnValue));
    $Search->setDataprovider($dataprovider);

    $this->assertSame($expected, $Search->searchArray('Berlin'));
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

  /**
  * @covers Search::getXml
  */
  public function testGetXml() {

    $expected = '<response xmlns="http://www.w3.org/1999/xhtml">
  <items query="Berlin" limit="10" offset="0">
    <item>12345 Berlin</item>
  </items>
</response>';

    $result = array(
      '12345 Berlin' => 'Berlin'
    );
    $Search = $this->getSearchProxyObjectFixture();
    $this->assertXmlStringEqualsXmlString($expected, $Search->getXml('Berlin', $result));
  }

  /**
  * @covers Search::setDataprovider
  */
  public function testSetDataprovider() {
    $Search = $this->getSearchObjectFixture();
    $dataprovider = $this->getMock('SearchInterfaceDataprovider');
    $Search->setDataprovider($dataprovider);

    $this->assertAttributeInstanceOf(
      'SearchInterfaceDataprovider',
      '_dataprovider',
      $Search
    );
  }

  /**
  * @covers Search::getDataprovider
  */
  public function testGetDataprovider() {
    $Search = $this->getSearchObjectFixture();
    $Search->getDataprovider();

    $this->assertAttributeInstanceOf(
      'SearchDataprovider',
      '_dataprovider',
      $Search
    );
  }

  /**
  * @covers Search::getDataprovider
  */
  public function testGetDataproviderWithSetDepedency() {
    $Search = $this->getSearchObjectFixture();
    $dataprovider = $this->getMock(
      'SearchDataprovider',
      array('load', 'register')
    );
    $Search->setDataprovider($dataprovider);
    $Search->getDataprovider();

    $this->assertAttributeEquals(
      $dataprovider,
      '_dataprovider',
      $Search
    );
  }


  /***************************************************************************/
  /** DataProvider                                                           */
  /***************************************************************************/

}

class getSearchObjectSearchXML extends Search {

  public function validateInput($userInput) {
    return $userInput;
  }
}
?>