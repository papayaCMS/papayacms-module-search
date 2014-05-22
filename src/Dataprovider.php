<?php
/**
* Dataprovider implementation of a loader
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
* @tutorial Search/SearchDataProvider.cls
*
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Dataprovider.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Load necessary libraries
*/
require_once(dirname(__FILE__).'/Interface/Dataprovider.php');
require_once(dirname(__FILE__).'/Loader/Default.php');

/**
* Gather results form each attached loader
*
* @package Papaya-Modules
* @subpackage Search
*/
class SearchDataprovider implements SearchInterfaceDataprovider {

  /**
  * Amount of result items to be returned
  * @var integer
  */
  private $resultCount = 10;

  /**
  * Registry of attached loaders
  * @var array
  */
  private $loaders = array();

  /**
  * Constructor of the class
  */
  public function __construct() {
    $this->initialize();
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Register the given loader to be processed
  *
  * @param SearchLoader $loader
  */
  public function register(SearchInterfaceLoader $loader) {
    $loaderKeys = array_keys($this->loaders);
    if (count($loaderKeys) == 1 && in_array('default', $loaderKeys)) {
      $this->loaders = array();
    }
    $this->loaders[get_class($loader)] = $loader;
  }

  /**
  * Execute each registered loader
  *
  * Depending on the already recieved results limited by the resultCount the set of loaders will be
  * iterated. If the amount of recieved results exceeds the resultCount the following loaders
  * will be skipped.
  *
  * @param string $searchString String to be found
  * @return array Results of run loaders
  */
  public function load($searchString) {
    $searchResult = array();
    foreach ($this->loaders as $loader) {
      if ($this->resultCount > count($searchResult)) {
        $searchResult = array_merge($searchResult, $loader->run($searchString));
        if (TRUE === $loader->stopPropagation()) {
          break;
        }
      } else {
        break;
      }
    }
    return $searchResult;
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

  /**
  * Initialize the base set of loaders
  */
  protected function initialize() {
    $this->loaders = array(
      'default' => new SearchLoaderDefault()
    );
  }

}