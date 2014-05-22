<?php
/**
* Default loader
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
* @tutorial Search/SearchLoaderDefault.cls
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Default.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Load mandatory libraries
*/
require_once(dirname(__FILE__).'/../Interface/Loader.php');

/**
* Default loader.
*
* @package Papaya-Modules
* @subpackage Search
*/
class SearchLoaderDefault implements SearchInterfaceLoader {

  /**
  * Indicator to determine if the calling dataprovider shall stop processing after this loader.
  * @var boolean
  */
  private $_stopPropagation = FALSE;

  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Execute search process
  *
  * @param string $searchString
  *
  * @see SearchInterfaceLoader::run()
  */
  public function run($searchString) {
    return array();
  }

  /**
  * Possibility to stop loader iteration sequence
  *
  * @return boolean TRUE, if propagation ist to be stopped, else FALSE
  */
  public function stopPropagation() {
    return $this->_stopPropagation;
  }

  /**
  * Reset the current instance of the loader.
  */
  public function reset() {
    $this->_stopPropagation = FALSE;
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

}
?>