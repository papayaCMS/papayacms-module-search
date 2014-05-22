<?php
require_once(dirname(__FILE__).'/../../bootstrap.php');

require_once(dirname(__FILE__).'/../../../src/Loader/Database/Single.php');
require_once(dirname(__FILE__).'/../../../src/Database/Access.php');

class SearchLoaderDatabaseSingleTest extends SearchTestCase {

  /**
  * Get an instance of the {@link SearchLoaderDatabaseSingle} class
  * @return SearchLoaderDatabaseSingle
  */
  private function getLoaderObjectFixture() {
    return new SearchLoaderDatabaseSingle;
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * @covers SearchLoaderDatabaseSingle::run
  */
  public function testRunFulltextSearch() {
    $loader = $this->getLoaderObjectFixture();

    $expected = $returnValue = array(
      '12345 Berlin' => 'Berlin',
      '45678 Bad Musterstadt' => 'Bad Musterstadt',
    );

    $database = $this->getMock('SearchDatabaseAccess');
    $database
      ->expects($this->once())
      ->method('getCityListFulltextSearch')
      ->will($this->returnValue($returnValue));
    $loader->setDatabaseAccessObject($database);

    $this->assertSame($expected, $loader->run('Berlin'));
    $this->assertAttributeSame(FALSE, '_stopPropagation', $loader);
  }

  /**
  * @dataProvider searchByZipcodeDataprovider
  * @covers SearchLoaderDatabaseSingle::run
  */
  public function testRunSearchByZipcode($expected, $returnValue, $stop) {
    $loader = $this->getLoaderObjectFixture();
    $database = $this->getMock('SearchDatabaseAccess');
    $database
      ->expects($this->once())
      ->method('getCityListByZipcode')
      ->will($this->returnValue($returnValue));
    $loader->setDatabaseAccessObject($database);

    $this->assertSame($expected, $loader->run(53881));
    $this->assertAttributeSame($stop, '_stopPropagation', $loader);
  }

  /**
  * @covers SearchLoaderDatabaseSingle::stopPropagation
  */
  public function testStopPropagation() {
    $loader = $this->getLoaderObjectFixture();
    $this->assertFalse($loader->stopPropagation());
  }

  /**
  * @covers SearchLoaderDatabaseSingle::reset
  */
  public function testReset() {
    $loader = $this->getLoaderObjectFixture();
    $loader->reset();
    $this->assertAttributeSame(FALSE, '_stopPropagation', $loader);
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/


  /***************************************************************************/
  /** DataProvider                                                           */
  /***************************************************************************/

  public static function searchByZipcodeDataprovider() {
    return array(
      'multiple results' => array(
        array(
          '53881 Großbüllesheim' => 'Großbüllesheim',
          '53881 Stotzheim' => 'Stotzheim',
          '53881 Wüschheim' => 'Wüschheim',
        ),
        array(
          '53881 Großbüllesheim' => 'Großbüllesheim',
          '53881 Stotzheim' => 'Stotzheim',
          '53881 Wüschheim' => 'Wüschheim',
        ),
        FALSE
      ),
      'single result; stop propagation' => array(
        array(
          '53881 Großbüllesheim' => 'Großbüllesheim',
        ),
        array(
          '53881 Großbüllesheim' => 'Großbüllesheim',
        ),
        TRUE
      ),
    );
  }

}