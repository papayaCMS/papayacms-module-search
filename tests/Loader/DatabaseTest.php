<?php
require_once(dirname(__FILE__).'/../bootstrap.php');

require_once(dirname(__FILE__).'/../../src/Loader/Database.php');

class SearchLoaderDatabaseTest extends SearchTestCase {

  /**
  * Get a proxy instance of the {@link SearchLoaderDatabaseProxy} class
  * @return SearchLoaderDatabaseProxy
  */
  private function getDatabaseProxyObjectFixture() {
    return new SearchLoaderDatabaseProxy;
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * @covers SearchLoaderDatabase::setConfiguration
  */
  public function testSetConfiguration() {
    $database = $this->getDatabaseProxyObjectFixture();
    $database->setConfiguration(new stdClass);
    $this->assertAttributeEquals(new stdClass, '_configuration', $database);
  }

  /**
  * @covers SearchLoaderDatabase::getDatabaseAccessObject
  */
  public function testGetDatabaseAccessObject() {
    $database = $this->getDatabaseProxyObjectFixture();
    $database->setConfiguration($this->getMockConfigurationObject());
    $this->assertInstanceOf('SearchDatabaseAccess', $database->getDatabaseAccessObject());
  }

  /**
  * @covers SearchLoaderDatabase::getDatabaseAccessObject
  */
  public function testGetDatabaseAccessObjectFromCache() {
    $database = $this->getDatabaseProxyObjectFixture();
    $database->setConfiguration($this->getMockConfigurationObject());
    $database->setDatabaseAccessObject(new stdClass);
    $this->assertInstanceOf('stdClass', $database->getDatabaseAccessObject());
  }

  /**
  * @covers SearchLoaderDatabase::setDatabaseAccessObject
  */
  public function testSetDatabaseAccessObject() {
    $database = $this->getDatabaseProxyObjectFixture();
    $database->setDatabaseAccessObject(TRUE);
    $this->assertAttributeEquals(TRUE, '_databaseAccess', $database);
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/


  /***************************************************************************/
  /** DataProvider                                                           */
  /***************************************************************************/

}

class SearchLoaderDatabaseProxy extends SearchLoaderDatabase {
  public function setConfiguration($configuration) {
    parent::setConfiguration($configuration);
  }

  public function getDatabaseAccessObject() {
    return parent::getDatabaseAccessObject();
  }

  public function setDatabaseAccessObject($object) {
    parent::setDatabaseAccessObject($object);
  }
}
?>