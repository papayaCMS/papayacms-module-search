<?php
require_once(dirname(__FILE__).'/../bootstrap.php');

require_once(dirname(__FILE__).'/../../src/Loader/Default.php');

class SearchLoaderDefaultTest extends SearchTestCase {

  /**
  * Get an instance of the {@link SearchLoaderDefault} class
  * @return SearchLoaderDefault
  */
  private function getLoaderObjectFixture() {
    return new SearchLoaderDefault();
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * @covers SearchLoaderDefault::run
  */
  public function testRun() {
    $loader = $this->getLoaderObjectFixture();
    $this->assertSame(array(), $loader->run('Berlin'));
  }

  /**
  * @covers SearchLoaderDefault::stopPropagation
  */
  public function testStopPropagation() {
    $loader = $this->getLoaderObjectFixture();
    $this->assertFalse($loader->stopPropagation());
  }

  /**
  * @covers SearchLoaderDefault::reset
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

}
?>