<?php
/**
* Loader handles concatenated strings.
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
* @tutorial Search/SearchLoaderLocationConcatenated.cls
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Concatenated.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Load mandatory libraries
*/
require_once(dirname(__FILE__).'/../../Interface/Loader.php');
require_once(dirname(__FILE__).'/../../Interface/Dataprovider.php');

/**
* Loader handles concatenated strings.
*
* @package Papaya-Modules
* @subpackage Search
*/
class SearchLoaderDatabaseConcatenated
  implements SearchInterfaceLoader, SearchInterfaceDataprovider {

  /**
  * Registry of attached loaders
  * @var array
  */
  protected $_loaders = NULL;

  /**
  * Indicator to determine if the calling dataprovider shall stop processing after this loader.
  * @var boolean
  */
  private $_stopPropagation = FALSE;

  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Loader interface implementation
  ************************************/

  /**
  * Execute search process
  *
  * @param string $searchString
  *
  * @see SearchInterfaceLoader::run()
  */
  public function run($searchString) {
    $result = array();
    $this->reset();
    $this->initLoaders();
    $searchArray = $this->splitString($searchString);

    foreach ($searchArray as $term) {
      $result = array_merge($result, $this->load($term));
      if (TRUE === $this->stopPropagation()) {
        break;
      }
    }
    return $result;
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


  /**
  * Dataprovider interface implementation
  ***************************************/

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
    foreach ($this->_loaders as $loader) {
      $searchResult = array_merge($searchResult, $loader->run($searchString));
      if (TRUE === $loader->stopPropagation()) {
        $this->_stopPropagation = TRUE;
        break;
      }
    }
    return $searchResult;
  }

  /**
  * Register the given loader to be processed
  *
  * @param SearchLoader $loader
  */
  public function register(SearchInterfaceLoader $loader) {
    $this->_loaders[get_class($loader)] = $loader;
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

  /**
  * Set loaders to be used instead of the predefined
  *
  * @param array $loaders
  */
  public function setLoaders($loaders) {
    foreach ($loaders as $loader) {
      if (!($loader instanceof SearchInterfaceLoader)) {
        throw new InvalidArgumentException('Array contains invalid loader object');
      }
      $this->register($loader);
    }
  }

  /**
  * Attach necessary loaders to internal dataprovider
  */
  protected function initLoaders() {
    if (!is_array($this->_loaders)) {
      include_once(dirname(__FILE__).'/../../Loader/Database/Single.php');
      $this->register(new SearchLoaderDatabaseSingle);
    }
  }

  /**
  * Split a string by its punktuation
  *
  * @param string $term
  * @return array List of splitted strings
  */
  protected function splitString($term) {
    $pattern = "(([a-z0-9]+)[+ -,\/_;:]*)i";
    preg_match_all($pattern, $term, $matches, PREG_PATTERN_ORDER);
    return $matches[1];
  }

}
?>