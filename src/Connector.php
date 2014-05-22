<?php
/**
* Search connector class used to wrap the live search base class
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
* @tutorial Search/SearchConnector.cls
*
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Connector.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Load necessary libraries
*/
require_once(PAPAYA_INCLUDE_PATH.'system/base_connector.php');
require_once(dirname(__FILE__).'/Dataprovider.php');


/**
* Search connector module
*
* @package Papaya-Modules
* @subpackage Search
*/
class SearchConnector extends base_connector {

  /**
  * Instance of the base livrsearch class
  * @var Search
  */
  protected $_SearchBaseObject = NULL;

  /**
  * Instance of the dataprovider used by the Search moduel
  * @var SearchDataprovider
  */
  protected $_SearchDataproviderObject = NULL;

  /**
  * Configuration object
  * @var PapayaConfiguration
  */
  private $_configuration = NULL;

  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Databprovider implementation
  ************************************/

  /**
  * Register a loader to the Search dataprovider
  * @param SearchInterfaceLoader $loader
  */
  public function registerLoader(SearchInterfaceLoader $loader) {
    $dataprovider = $this->getSearchDataproviderObject();
    $dataprovider->register($loader);
  }


  /**
  * Loader implementation
  ************************************/

  /**
  * Provide a XML formatted search result.
  *
  * The returned XML shall match the expactations described in
  * {@tutorial Search/SearchConnector.cls#class-methods.class-methods-searchXml}.
  *
  * @param string $searchString
  * @return string XML formatted string representing the search result
  */
  public function searchXml($searchString) {
    $Search = $this->getSearchBaseObject();
    $Search->setDataprovider($this->_SearchDataproviderObject);
    return $Search->searchXml($searchString);
  }

  /**
  * Provide the search result as an array.
  *
  * @param string $searchString
  * @return array
  */
  public function searchArray($searchString) {
    $Search = $this->getSearchBaseObject();
    $Search->setDataprovider($this->_SearchDataproviderObject);
    return $Search->searchArray($searchString);
  }


  /***************************************************************************/
  /** Helper                                                                 */
  /***************************************************************************/

  /**
  * Get an instance of the Search base class ({@link Search})
  * @return Search
  */
  public function getSearchBaseObject() {
    if (!(isset($this->_SearchBaseObject) && is_object($this->_SearchBaseObject))) {
      include_once(dirname(__FILE__).'/Search.php');
      $this->_SearchBaseObject = new Search();
    }
    return $this->_SearchBaseObject;
  }

  /**
  * Set the Search instance to be used instead of the original one.
  * @param Search $object
  */
  public function setSearchBaseObject(Search $object) {
    $this->_SearchBaseObject = $object;
  }

  /**
  * Get an instance of the {@link SearchDataprovider}
  * @return SearchDataprovider
  */
  public function getSearchDataproviderObject() {
    if (!(isset($this->_SearchDataproviderObject) && is_object($this->_SearchDataproviderObject))) {
      $this->_SearchDataproviderObject = new SearchDataprovider();
    }
    return $this->_SearchDataproviderObject;
  }

  /**
  * Set the Search dataprovider instance to be used instead of the original one.
  * @param SearchDataprovider $object
  */
  public function setSearchDataproviderObject(SearchDataprovider $object) {
    $this->_SearchDataproviderObject = $object;
  }

  /**
  * Set the connector configuration
  * @param $configuration
  */
  public function setConfiguration($configuration) {
    $this->_configuration = $configuration;
  }

}
?>