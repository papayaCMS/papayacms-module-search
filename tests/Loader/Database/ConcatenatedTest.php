<?php
require_once(dirname(__FILE__).'/../../bootstrap.php');

require_once(dirname(__FILE__).'/../../../src/Loader/Database/Concatenated.php');
require_once(dirname(__FILE__).'/../../../src/Loader/Database/Single.php');
require_once(dirname(__FILE__).'/../../../src/Loader/Default.php');

class SearchLoaderDatabaseConcatenatedTest extends SearchTestCase {

  /**
  * Get an instance of the {@link SearchLoaderDatabaseConcatenated} class
  * @return SearchLoaderDatabaseConcatenated
  */
  private function getLoaderObjectFixture() {
    return new SearchLoaderDatabaseConcatenated;
  }

  /**
  * Get a proxy instance of the {@link SearchLoaderDatabaseConcatenatedProxy} class
  * @return SearchLoaderDatabaseConcatenatedProxy
  */
  private function getLoaderProxyObjectFixture() {
    return new SearchLoaderDatabaseConcatenatedProxy;
  }

  /**
  * Get a mock object of a loader.
  *
  * @param string $loaderClassname
  * @param array|string $methods
  * @param boolean $addRand
  * @return SearchLoaderDefault
  */
  private function getLoaderFixture($loaderClassname, $methods = array(), $addRand = FALSE) {
    if (! is_array($methods)) {
      $methods = array( $methods );
    }

    if (TRUE === $addRand) {
      $loaderClassname = $loaderClassname.md5(__FILE__.microtime());
    }

    return $this->getMock(
      'SearchLoaderDefault',
      $methods,
      array(),
      $loaderClassname
    );
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Loader interface implementation
  ************************************/

  /**
  * @covers SearchLoaderDatabaseConcatenated::run
  */
  public function testRun() {
    $loader = $this->getLoaderObjectFixture();

    $loaderZip = $this->getLoaderFixture(
      'SearchLoaderZip',
      array('run', 'stopPropagation'),
      TRUE
    );
    $loaderZip
      ->expects($this->once())
      ->method('run')
      ->will($this->returnValue(array('12345 Berlin' => 'Berlin')));
    $loaderZip
      ->expects($this->once())
      ->method('stopPropagation')
      ->will($this->returnValue(FALSE));

    $loaderRegion = $this->getLoaderFixture(
      'SearchLoaderRegion',
      array('run', 'stopPropagation'),
      TRUE
    );
    $loaderRegion
      ->expects($this->once())
      ->method('run')
      ->will($this->returnValue(array('45678 Bad Musterstadt' => 'Bad Musterstadt')));
    $loaderRegion
      ->expects($this->once())
      ->method('stopPropagation')
      ->will($this->returnValue(FALSE));

    $loader->setLoaders(array($loaderZip, $loaderRegion));

    $expected = array(
      '12345 Berlin' => 'Berlin',
      '45678 Bad Musterstadt' => 'Bad Musterstadt',
    );
    $this->assertEquals($expected, $loader->run('Berlin'));
  }

  /**
  * @covers SearchLoaderDatabaseConcatenated::run
  */
  public function testRunStopPropagation() {
    $loader = $this->getLoaderObjectFixture();

    $loaderZip = $this->getLoaderFixture(
      'SearchLoaderZip',
      array('run', 'stopPropagation'),
      TRUE
    );
    $loaderZip
      ->expects($this->once())
      ->method('run')
      ->will($this->returnValue(array('12345 Berlin' => 'Berlin')));
    $loaderZip
      ->expects($this->once())
      ->method('stopPropagation')
      ->will($this->returnValue(TRUE));

    $loader->setLoaders(array($loaderZip));

    $expected = array(
      '12345 Berlin' => 'Berlin'
    );
    $this->assertSame($expected, $loader->run('Berlin'));
  }

  /**
  * @covers SearchLoaderDatabaseConcatenated::stopPropagation
  */
  public function testStopPropagation() {
    $loader = $this->getLoaderObjectFixture();
    $this->assertFalse($loader->stopPropagation());
  }

  /**
  * @covers SearchLoaderDatabaseConcatenated::reset
  */
  public function testReset() {
    $loader = $this->getLoaderObjectFixture();
    $loader->reset();
    $this->assertAttributeSame(FALSE, '_stopPropagation', $loader);
  }


  /**
  * Dataprovider interface implementation
  ***************************************/

  /**
  * @covers SearchLoaderDatabaseConcatenated::register
  */
  public function testRegister() {
    $loader = $this->getLoaderObjectFixture();
    $externalLoader = $loaderZip = $this->getLoaderFixture('SearchLoaderLocationRegion');
    $loader->register($externalLoader);

    $attributeLoaders = $this->readAttribute($loader, '_loaders');
    $this->assertEquals($externalLoader, $attributeLoaders['SearchLoaderLocationRegion']);
  }

  /**
  * @covers SearchLoaderDatabaseConcatenated::load
  */
  public function testLoad() {

    $returnValueZip = array (
      '12345 Berlin' => 12345,
    );

    $returnValueDefault = array (
      '12340 Berlin' => 12340,
      '12341 Berlin' => 12341,
      '12342 Berlin' => 12342,
      '12343 Berlin' => 12343,
      '12344 Berlin' => 12344,
      '12345 Berlin' => 12345,
      '12349 Berlin' => 12349,
    );
    $expected = array_merge($returnValueZip, $returnValueDefault);

    $loader = $this->getLoaderObjectFixture();
    $loaderZip = $this->getLoaderFixture(
      'SearchLoaderLocationZip', array('run', 'stopPropagation'), TRUE);
    $loaderZip
      ->expects($this->once())
      ->method('run')
      ->will($this->returnValue($returnValueZip));
    $loaderZip
      ->expects($this->once())
      ->method('stopPropagation')
      ->will($this->returnValue(FALSE));

    $loaderDefault = $this->getLoaderFixture(
      'SearchLoaderLocationZip', array('run', 'stopPropagation'), TRUE);
    $loaderDefault
      ->expects($this->once())
      ->method('run')
      ->will($this->returnValue($returnValueDefault));
    $loaderDefault
      ->expects($this->once())
      ->method('stopPropagation')
      ->will($this->returnValue(FALSE));

    $loader->register($loaderZip);
    $loader->register($loaderDefault);
    $this->assertEquals($expected, $loader->load('Berlin'));
  }

  /**
  * @covers SearchLoaderDatabaseConcatenated::load
  */
  public function testLoadStopPropagation() {
    $expected = $returnValueZip = array (
      '12345 Berlin' => 12345,
    );

    $loader = $this->getLoaderObjectFixture();
    $loaderZip = $this->getLoaderFixture(
      'SearchLoaderLocationZip', array('run', 'stopPropagation'), TRUE);
    $loaderZip
      ->expects($this->once())
      ->method('run')
      ->will($this->returnValue($returnValueZip));
    $loaderZip
      ->expects($this->once())
      ->method('stopPropagation')
      ->will($this->returnValue(TRUE));

    $loaderDefault = $this->getLoaderFixture('SearchLoaderLocationZip', array(), TRUE);

    $loader->register($loaderZip);
    $loader->register($loaderDefault);
    $this->assertEquals($expected, $loader->load('Berlin'));
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

  /**
  * @covers SearchLoaderDatabaseConcatenated::setLoaders
  */
  public function testSetLoaders() {
    $loader = $this->getLoaderObjectFixture();
    $externalLoader = new SearchLoaderDatabaseSingle;
    $loader->setLoaders(array($externalLoader));

    $attributeLoaders = $this->readAttribute($loader, '_loaders');
    $this->assertEquals($externalLoader, $attributeLoaders['SearchLoaderDatabaseSingle']);
  }

  /**
  * @covers SearchLoaderDatabaseConcatenated::setLoaders
  */
  public function testSetLoadersExpectingInvalidArgumentException() {
    $loader = $this->getLoaderObjectFixture();
    try {
      $loader->setLoaders(array(new stdClass));
      $this->fail('Expected exception not thrown');
    } catch (InvalidArgumentException $e) {
    }
  }

  /**
  * @covers SearchLoaderDatabaseConcatenated::initLoaders
  */
  public function testInitLoaders() {
    $loader = $this->getLoaderProxyObjectFixture();
    $loader->initLoaders();

    $expected = new SearchLoaderDatabaseSingle;
    $actual = $this->readAttribute($loader, '_loaders');
    $this->assertEquals($expected, $actual['SearchLoaderDatabaseSingle']);
  }

  /**
  * @dataProvider splitStringDataprovider
  * @covers SearchLoaderDatabaseConcatenated::splitString
  */
  public function testSplitString($string, $expected) {
    $loader = $this->getLoaderProxyObjectFixture();
    $this->assertEquals($expected, $loader->splitString($string));
  }


  /***************************************************************************/
  /** DataProvider                                                           */
  /***************************************************************************/

  public static function splitStringDataprovider() {
    return array(
      array('Berlin', array('Berlin')),
      array('Berlin+Schoenefeld', array('Berlin', 'Schoenefeld')),
      array('Berlin, Schoenefeld', array('Berlin', 'Schoenefeld')),
    );
  }
}

/**
* Proxy class to make protected methods testable
*/
class SearchLoaderDatabaseConcatenatedProxy
  extends SearchLoaderDatabaseConcatenated {

  public function splitString($term) {
    return parent::splitString($term);
  }

  public function initLoaders() {
    parent::initLoaders();
  }
}