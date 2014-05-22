<?php
/**
* This class provides means of creating administration dialogs.
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
* @tutorial Search/Util/SearchUtilDialogBuilder.cls
*
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Builder.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Provides a number of papaya dialogs
* TODO use base_dialog or base_msgdialog directly and remove this
*
* @package Papaya-Modules
* @subpackage Search
*/
class SearchUtilDialogBuilder {

  /**
  * This method creates a dialog
  *
  * @param object $owner
  * @param string $paramName
  * @param array $fields
  * @param array $data
  * @param array $hidden
  * @return base_dialog
  */
  public function createDialog($owner, $paramName, $fields, $data, $hidden) {
    include_once(dirname(__FILE__).'/Basic.php');
    $dialog = new SearchUtilDialogBasic;
    return $dialog->createDialog($owner, $paramName, $fields, $data, $hidden);
  }

  /**
  * Create an instance of the msgdialog objects
  *
  * @param object $owner
  * @param string $paramName
  * @param array $hidden
  * @param string $msg
  * @param string $type
  * @return base_msgdialog
  */
  public function createMsgDialog($owner, $paramName, $hidden, $msg, $type) {
    include_once(dirname(__FILE__).'/Message.php');
    $dialog = new SearchUtilDialogMessage;
    return $dialog->createDialog($owner, $paramName, $hidden, $msg, $type);
  }

}

