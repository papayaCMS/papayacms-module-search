<?php
require_once(dirname(__FILE__).'/../../bootstrap.php');

require_once(dirname(__FILE__).'/../../../src/Util/Dialog/Message.php');

class SearchUtilDialogMessageTest extends SearchTestCase {

  /**
  * @covers SearchUtilDialogMessage::createDialog
  */
  public function testCreateDialog() {
    $msgDialog = new SearchUtilDialogMessageProxy;
    $dialog = $msgDialog->createDialog($this, 'b', array(), 'message', 'info');
    $this->assertTrue($dialog instanceof base_msgdialog);
  }

}

class SearchUtilDialogMessageProxy extends SearchUtilDialogMessage {
  public function getBaseLink() {
    return TRUE;
  }

  public function getApplication() {
    return new SearchUtilDialogMessageApplicationMock;
  }
}

class SearchUtilDialogMessageApplicationMock {
  public function hasObject() {
    return TRUE;
  }
}
