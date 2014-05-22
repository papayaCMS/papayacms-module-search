<?php
require_once(dirname(__FILE__).'/../bootstrap.php');

require_once(dirname(__FILE__).'/../../src/Page/Base.php');
require_once(dirname(__FILE__).'/../../src/Connector.php');
require_once(dirname(__FILE__).'/../../src/Util/Dialog/Builder.php');

class SearchPageBaseTest extends SearchTestCase {

  /**
  * Get a fixture to use it in the tests
  */
  private function loadSearchPageBaseFixture($owner = NULL) {
    $SearchPageBase = new SearchPageBase($owner);
    return $SearchPageBase;
  }

  private function loadOwnerObjectFixture($methods = array()) {
    return $this->getMock(
      'SearchPage',
      $methods,
      array(),
      'Mock_'.md5(__CLASS__.microtime()),
      FALSE
    );
  }


  /***************************************************************************/
  /** Helper                                                                 */
  /***************************************************************************/

  /**
  * @covers SearchPageBase::setConfiguration
  */
  public function testSetConfiguration() {
    $owner = $this->loadOwnerObjectFixture();
    $SearchPageBase = $this->loadSearchPageBaseFixture($owner);
    $configuration = $this->getMockConfigurationObject();
    $SearchPageBase->setConfiguration($configuration);
    $this->assertAttributeSame(
      $configuration,
      '_configuration',
      $SearchPageBase
    );
  }

  /**
  * @covers SearchPageBase::__construct
  */
  public function testConstructor() {
    $owner = $this->loadOwnerObjectFixture();
    $SearchPageBase = new SearchPageBase($owner);
    $this->assertAttributeSame($owner, '_owner', $SearchPageBase);
  }

  /**
  * @covers SearchPageBase::initialize
  */
  public function testInitialize() {
    $owner = $this->loadOwnerObjectFixture();
    $SearchPageBase = new SearchPageBase($owner);
    $this->assertAttributeSame($owner, '_owner', $SearchPageBase);
  }

  /**
  * @covers SearchPageBase::setPluginLoader
  */
  public function testSetPluginLoader() {
    $SearchPageBase = $this->loadSearchPageBaseFixture();
    $SearchPageBase->setPluginLoader(TRUE);
    $this->assertAttributeEquals(TRUE, '_pluginLoader', $SearchPageBase);
  }

  /**
  * @covers SearchPageBase::getPluginLoader
  */
  public function testGetPluginLoader() {
    $SearchPageBase = $this->loadSearchPageBaseFixture();
    $pluginLoaderObject = $SearchPageBase->getPluginLoader();
    $this->assertTrue($pluginLoaderObject instanceof base_pluginloader);
  }

  /**
  * @covers SearchPageBase::getSearchConnector
  */
  public function testGetSearchConnector() {
    $connector = $this->getSearchConnectorFixture();
    $SearchPageBase = $this->loadSearchPageBaseFixture();
    $pluginLoaderObject = $this->getMock('base_pluginloader', array('getPluginInstance'));
    $pluginLoaderObject
      ->expects($this->once())
      ->method('getPluginInstance')
      ->will($this->returnValue($connector));
    $SearchPageBase->setPluginLoader($pluginLoaderObject);
    $this->assertTrue(
      $SearchPageBase->getSearchConnector() instanceof SearchConnector
    );
  }

  /**
  * @covers SearchPageBase::setSearchConnector
  */
  public function testSetSearchConnector() {
    $connector = $this->getSearchConnectorFixture();
    $SearchPageBase = $this->loadSearchPageBaseFixture();
    $SearchPageBase->setSearchConnector($connector);
    $this->assertSame(
      TRUE,
      $this->readAttribute(
        $SearchPageBase,
        '_SearchConnector'
      ) instanceof SearchConnector
    );
  }

  /**
  * @covers SearchPageBase::setDialogBuilder
  */
  public function testSetDialogBuilder() {
    $builder = $this->getMock('SearchUtilDialogBuilder');
    $SearchPageBase = $this->loadSearchPageBaseFixture();
    $SearchPageBase->setDialogBuilder($builder);
    $this->assertSame($builder, $this->readAttribute($SearchPageBase, '_dialogBuilder'));
  }

  /**
  * @covers SearchPageBase::getDialogBuilder
  */
  public function testGetDialogBuilder() {
    $SearchPageBase = $this->loadSearchPageBaseFixture();
    $this->assertTrue($SearchPageBase->getDialogBuilder() instanceof SearchUtilDialogBuilder);
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * @covers SearchPageBase::getPageXml
  */
  public function testGetPageXml() {
    $owner = $this->loadOwnerObjectFixture();
    $owner->params = array(
      'query' => 'Berlin'
    );
    $owner->paramName = 'ls';
    $owner->data = array(
      'suggest_caption' => 'Search'
    );
    $SearchPageBase = $this->loadSearchPageBaseFixture($owner);
    $pluginloader = $this->getMock('base_pluginloader');
    $results = array(
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
    $connector = $this->getSearchConnectorFixture();
    $connector->expects($this->any())
              ->method('registerLoader');
    $connector->expects($this->any())
              ->method('searchArray')
              ->will($this->returnValue($results));
    $pluginloader
      ->expects($this->once())
      ->method('getPluginInstance')
      ->will($this->returnValue($connector));
    $SearchPageBase->setPluginLoader($pluginloader);
    $dialog = $this->getMock('SearchUtilDialogBasic', array('getDialogXML'));
    $dialog->expects($this->once())
            ->method('getDialogXML')
            ->will($this->returnValue('<dialog>dialog</dialog>'));
    $builder = $this->getMock('SearchUtilDialogBuilder');
    $builder->expects($this->once())
            ->method('createDialog')
            ->will($this->returnValue($dialog));
    $SearchPageBase->setDialogBuilder($builder);
    $expected = '<dialog>dialog</dialog>';
    $result = $SearchPageBase->getPageXml();
    $this->assertEquals($expected, $result);
  }

  /**
  * @covers SearchPageBase::getTeaserXml
  */
  public function testGetTeaserXml() {
    $owner = $this->loadOwnerObjectFixture();
    $SearchPageBase = $this->loadSearchPageBaseFixture($owner);
    $expected = '<teaser>some xml</teaser>';
    $result = $SearchPageBase->getTeaserXml();
    $this->assertEquals($expected, $result);
  }


  /***************************************************************************/
  /** DataProvider                                                           */
  /***************************************************************************/

}
?>