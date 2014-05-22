<?php
/**
* The Dialogs class provides means of creating administration message dialogs.
*
* It is intended to separate the dialogs from the business logic in the Administration class.
*
* @copyright 2002-2010 by papaya Software GmbH - All rights reserved.
* @link http://www.papaya-cms.com/
* @license papaya Commercial License (PCL)
*
* Redistribution of this script or derivated works is strongly prohibited!
* The Software is protected by copyright and other intellectual property
* laws and treaties. papaya owns the title, copyright, and other intellectual
* property rights in the Software. The Software is licensed, not sold.
*
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Message.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Include papaya base dialog class.
*/
require_once(PAPAYA_INCLUDE_PATH.'system/base_msgdialog.php');

/**
* TODO use base_dialog or base_msgdialog directly and remove this
* @package Papaya-Modules
* @subpackage Search
*/
class SearchUtilDialogMessage extends base_msgdialog {

  /**
  * This method overloads the constructor in order to enable the class to be tested.
  */
  public function __construct() {
  }

  /**
  * This method creates a dialog
  *
  * @param object $owner
  * @param string $paramName
  * @param array $hidden
  * @param string $msg
  * @param string $type
  * @return base_dialog
  */
  public function createDialog($owner, $paramName, $hidden, $msg, $type) {
    parent::__construct($owner, $paramName, $hidden, $msg, $type);
    return $this;
  }

}
