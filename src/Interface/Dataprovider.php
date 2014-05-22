<?php
/**
* Interface definition for a Search data provider
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
* @tutorial Search/SearchInterfaceDataprovider.cls
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Dataprovider.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Load mandatory libraries
*/
require_once(dirname(__FILE__).'/Loader.php');

/**
* Interface definition for a Search loader
*
* @package Papaya-Modules
* @subpackage Search
*/
interface SearchInterfaceDataprovider {

  /**
  * Execute the registered loaders
  *
  * @param string $searchString
  * @return array Results of run loaders
  */
  function load($searchString);

  /**
  * Register given loader
  * @param SearchInterfaceLoader $loader
  */
  function register(SearchInterfaceLoader $loader);

}