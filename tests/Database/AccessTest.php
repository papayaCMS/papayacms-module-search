<?php
require_once(dirname(__FILE__).'/../bootstrap.php');

require_once(dirname(__FILE__).'/../../src/Database/Access.php');

class SearchDatabaseAccessTest extends SearchTestCase {

  /**
  * Get an instance of the {@link SearchDatabaseAccess} class
  * @return SearchDatabaseAccess
  */
  private function getDatabaseAccessObjectFixture() {
    return new SearchDatabaseAccess;
  }

  /**
  * Generate a mock object of the geosearch connector object
  *
  * @param array $functions List of methods to be reflected
  * @return GeosearchConnector
  */
  private function getGeosearchConnectorFixture($functions = array()) {
    if (!is_array($functions)) {
      $functions = array($functions);
    }

    $geosearchConnector = $this->getMock(
      'GeosearchConnector',
      $functions,
      array(),
      'GeosearchConnector'.md5(__CLASS__.microtime()),
      FALSE
    );
    return $geosearchConnector;
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * @covers SearchDatabaseAccess::getCityListFulltextSearch
  */
  public function testGetCityFulltextSearch() {
    $database = $this->getDatabaseAccessObjectFixture();
    $expected = array(
      array(
        'zip' => '10115',
        'city' => 'Berlin',
        'suburb' => 'Schönefeld'
      ),
      array(
        'zip' => '10116',
        'city' => 'Berlin',
        'suburb' => 'Köpenick'
      ),
      array(
        'zip' => '10117',
        'city' => 'Berlin',
        'suburb' => 'Charlottenburg'
      )
    );
    $pluginloader = $this->getMock('base_pluginloader', array('getPluginInstance'));
    $connector = $this->getGeosearchConnectorFixture(array('getCityListFulltextSearch'));
    $connector->expects($this->once())
              ->method('getCityListFulltextSearch')
              ->will($this->returnValue($expected));
    $pluginloader
      ->expects($this->once())
      ->method('getPluginInstance')
      ->will($this->returnValue($connector));
    $database->setPluginLoader($pluginloader);

    $this->assertEquals($expected, $database->getCityListFulltextSearch('Berlin'));
  }

  /**
  * @covers SearchDatabaseAccess::getCityListByZipcode
  */
  public function testGetCityListByZipcode() {
    $database = $this->getDatabaseAccessObjectFixture();
    $expected = array(
      array(
        'zip' => '53881',
        'city' => 'Euskirchen',
        'suburb' => 'Großbüllesheim'
      ),
      array(
        'zip' => '53881',
        'city' => 'Euskirchen',
        'suburb' => 'Wüschheim'
      ),
      array(
        'zip' => '53881',
        'city' => 'Euskirchen',
        'suburb' => 'Stotzheim'
      )
    );
    $pluginloader = $this->getMock('base_pluginloader', array('getPluginInstance'));
    $connector = $this->getGeosearchConnectorFixture(array('getCityListByZipcode'));
    $connector->expects($this->once())
              ->method('getCityListByZipcode')
              ->will($this->returnValue($expected));
    $pluginloader
      ->expects($this->once())
      ->method('getPluginInstance')
      ->will($this->returnValue($connector));
    $database->setPluginLoader($pluginloader);
    $this->assertEquals($expected, $database->getCityListByZipcode(53881));
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

  /**
  * @covers SearchDatabaseAccess::setConfiguration
  */
  public function testSetConfiguration() {
    $database = $this->getDatabaseAccessObjectFixture();
    $configuration = $this->getMockConfigurationObject();
    $database->setConfiguration($configuration);
    $this->assertAttributeEquals($configuration, '_configuration', $database);
  }

  /**
  * @covers SearchDatabaseAccess::setPluginLoader
  */
  public function testSetPluginLoader() {
    $accessObject = $this->getDatabaseAccessObjectFixture();
    $accessObject->setPluginLoader(TRUE);
    $this->assertAttributeEquals(TRUE, '_pluginLoader', $accessObject);
  }

  /**
  * @covers SearchDatabaseAccess::getPluginLoader
  */
  public function testGetPluginLoader() {
    $accessObject = $this->getDatabaseAccessObjectFixture();
    $pluginLoaderObject = $accessObject->getPluginLoader();
    $this->assertInstanceOf('base_pluginloader', $pluginLoaderObject);
  }

  /**
  * @covers SearchDatabaseAccess::getGeosearchConnector
  */
  public function testGetGeosearchConnector() {
    $connector = $this->getGeosearchConnectorFixture();
    $accessObject = $this->getDatabaseAccessObjectFixture();
    $pluginLoaderObject = $this->getMock('base_pluginloader', array('getPluginInstance'));
    $pluginLoaderObject
      ->expects($this->once())
      ->method('getPluginInstance')
      ->will($this->returnValue($connector));
    $accessObject->setPluginLoader($pluginLoaderObject);
    $this->assertInstanceOf(
      'GeosearchConnector',
      $accessObject->getGeosearchConnector()
    );
  }

  /**
  * @covers SearchDatabaseAccess::setGeosearchConnector
  */
  public function testSetGeosearchConnector() {
    $connector = $this->getGeosearchConnectorFixture();
    $accessObject = $this->getDatabaseAccessObjectFixture();
    $accessObject->setGeosearchConnector($connector);
    $this->assertAttributeInstanceOf('GeosearchConnector', '_geosearchConnector', $accessObject);
  }


  /***************************************************************************/
  /** DataProvider                                                           */
  /***************************************************************************/

}
?>