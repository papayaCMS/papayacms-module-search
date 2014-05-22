<?php
require_once(dirname(__FILE__).'/../../bootstrap.php');

require_once(dirname(__FILE__).'/../../../src/Util/Dialog/Basic.php');

class SearchUtilDialogBasicTest extends SearchTestCase {

  /**
  * @covers SearchUtilDialogBasic::createDialog
  */
  public function testCreateDialog() {
    $basicDialog = new SearchUtilDialogBasicProxy;
    $dialog = $basicDialog->createDialog($this, 'b', array(), array(), array());
    $this->assertTrue($dialog instanceof base_dialog);
  }
}

class SearchUtilDialogBasicProxy extends SearchUtilDialogBasic {
  public function getBaseLink() {
    return TRUE;
  }

  public function getApplication() {
    return new SearchUtilDialogBasicApplicationMock;
  }
}

class SearchUtilDialogBasicApplicationMock {
  public function hasObject() {
    return TRUE;
  }
}
