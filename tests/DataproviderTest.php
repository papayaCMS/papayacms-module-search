<?php
require_once(dirname(__FILE__).'/bootstrap.php');

require_once(dirname(__FILE__).'/../src/Dataprovider.php');

class SearchDataproviderTest extends SearchTestCase {

  /**
  * Get an instance of the {@link SearchDataprovider} class
  * @return SearchDataprovider
  */
  private function getDataproviderObjectFixture() {
    return new SearchDataprovider;
  }

  /**
  * Get a mock object of a loader.
  *
  * @param string $loaderClassname
  * @param array|string $methods
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
  * @covers SearchDataprovider::__construct
  */
  public function testConstructor() {
    $dataprovider = new SearchDataprovider;
    $loader = $this->readAttribute($dataprovider, 'loaders');
    $this->assertInstanceOf('SearchLoaderDefault', $loader['default']);
  }

  /**
  * @covers SearchDataprovider::register
  */
  public function testRegister() {
    $dataprovider = $this->getDataproviderObjectFixture();

    $loaderZip = $this->getLoaderFixture('SearchLoaderLocationZip');
    $expected['SearchLoaderLocationZip'] = $loaderZip;
    $dataprovider->register($loaderZip);

    $loaderDefault = $this->getLoaderFixture('SearchLoaderLocationDefault');
    $expected['SearchLoaderLocationDefault'] = $loaderDefault;
    $dataprovider->register($loaderDefault);

    $this->assertAttributeEquals($expected, 'loaders', $dataprovider);
  }

  /**
  * @covers SearchDataprovider::load
  */
  public function testLoad() {
    $dataprovider = $this->getDataproviderObjectFixture();

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
      'SearchLoaderLocationDefault', array('run', 'stopPropagation'), TRUE);
    $loaderDefault
      ->expects($this->once())
      ->method('run')
      ->will($this->returnValue($returnValueDefault));
    $loaderDefault
      ->expects($this->once())
      ->method('stopPropagation')
      ->will($this->returnValue(FALSE));

    $dataprovider->register($loaderZip);
    $dataprovider->register($loaderDefault);
    $this->assertEquals($expected, $dataprovider->load('Berlin'));
  }

  /**
  * @covers SearchDataprovider::load
  */
  public function testLoadLoaderStopsPropagation() {
    $dataprovider = $this->getDataproviderObjectFixture();

    $expected = $returnValue = array (
      '12345 Berlin' => 12345,
    );

    $loaderZip = $this->getLoaderFixture(
      'SearchLoaderLocationZip', array('run', 'stopPropagation'), TRUE);
    $loaderZip
      ->expects($this->once())
      ->method('run')
      ->will($this->returnValue($returnValue));
    $loaderZip
      ->expects($this->once())
      ->method('stopPropagation')
      ->will($this->returnValue(TRUE));

    $dataprovider->register($loaderZip);
    $this->assertEquals($expected, $dataprovider->load('Berlin'));
  }

  /**
  * @covers SearchDataprovider::load
  */
  public function testLoadResultCountExccedsInFirstLoader() {
    $dataprovider = $this->getDataproviderObjectFixture();

    $expected = $returnValueZip = array (
      '12340 Berlin' => 12340,
      '12341 Berlin' => 12341,
      '12342 Berlin' => 12342,
      '12343 Berlin' => 12343,
      '12344 Berlin' => 12344,
      '12345 Berlin' => 12345,
      '12346 Berlin' => 12346,
      '12347 Berlin' => 12347,
      '12348 Berlin' => 12348,
      '12349 Berlin' => 12349,
    );

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

    $loaderDefault = $this->getLoaderFixture('SearchLoaderLocationDefault', array(), TRUE);

    $dataprovider->register($loaderZip);
    $dataprovider->register($loaderDefault);
    $this->assertEquals($expected, $dataprovider->load('Berlin'));
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

  /**
  * @covers SearchDataprovider::initialize
  */
  public function testInitialize() {
    $dataprovider = new SearchDataprovider;
    $loader = $this->readAttribute($dataprovider, 'loaders');
    $this->assertInstanceOf('SearchLoaderDefault', $loader['default']);
  }


  /***************************************************************************/
  /** DataProvider                                                           */
  /***************************************************************************/

}