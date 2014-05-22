<?php
/**
* Abstract base class to provide loaders with a set methods handling a database
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
* @tutorial Search/SearchLoaderLocationSingle.cls
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Database.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Abstract base class to provide loaders with a set methods handling a database
*
* @package Papaya-Modules
* @subpackage Search
*/
abstract class SearchLoaderDatabase {

  /**
  * Configuration object
  * @var PapayaConfiguration
  */
  protected $_configuration = NULL;

  /**
  * Instance of the {link SearchDatabaseAccess} class
  * @var SearchDatabaseAccess
  */
  protected $_databaseAccess = NULL;

  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Set configuration object
  *
  * @param PapayaConfiguration $configuration
  */
  public function setConfiguration($configuration) {
    $this->_configuration = $configuration;
  }

  /**
  * Get an instance of {@link SearchDatabaseAccess} class.
  *
  * If the instance has not been created,, it will be.
  *
  * @return SearchDatabaseAccess
  */
  public function getDatabaseAccessObject() {
    if (!(isset($this->_databaseAccess) && is_object($this->_databaseAccess))) {
      include_once(dirname(__FILE__).'/../Database/Access.php');
      $this->_databaseAccess = new SearchDatabaseAccess;
      $this->_databaseAccess->setConfiguration($this->_configuration);
    }
    return $this->_databaseAccess;
  }

  /**
  * Set the database access object to be used instead of the original one.
  *
  * @param object $object
  */
  public function setDatabaseAccessObject($object) {
    $this->_databaseAccess = $object;
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

}