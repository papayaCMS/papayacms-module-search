<?php
/**
* Interface definition for a Search loader
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
* @tutorial Search/SearchInterfaceLoader.cls
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Loader.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Interface definition for a Search loader
*
* @package Papaya-Modules
* @subpackage Search
*/
interface SearchInterfaceLoader {

  /**
  * Execute the loader to determine the search result
  * @param string $searchString
  * @return array List of information about the found items
  */
  public function run($searchString);
  /**
  * Possibility to stop loader iteration sequence
  *
  * @return boolean TRUE, if propagation ist to be stopped, else FALSE
  */
  public function stopPropagation();

  /**
  * Reset the loader instance to start over with a clean instance
  */
  public function reset();
}