<?php
require_once(dirname(__FILE__).'/../../bootstrap.php');

require_once(dirname(__FILE__).'/../../../src/Util/Dialog/Builder.php');

class SearchUtilDialogBuilderTest extends SearchTestCase {

  public function testCreateDialog() {
    $builder = new SearchUtilDialogBuilder;
    $dialog = $builder->createDialog($this, 'b', array(), array(), array());
    $this->assertTrue($dialog instanceof base_dialog);
  }

  public function testCreateMsgDialog() {
    $builder = new SearchUtilDialogBuilder;
    $dialog = $builder->createMsgDialog($this, 'b', array(), 'message', 'question');
    $this->assertTrue($dialog instanceof base_msgdialog);
  }
}
