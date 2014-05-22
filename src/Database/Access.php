<?php
/**
* Loader to handle the given search string as a single term
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
* @tutorial Search/SearchDatabaseAccess.cls
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Access.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Load mandatory libraries
*/
require_once(PAPAYA_INCLUDE_PATH.'system/base_pluginloader.php');

/**
* Loader to handle the given search string as a single term
*
* @package Papaya-Modules
* @subpackage Search
*/
class SearchDatabaseAccess {

  /**
  * Configuration object
  * @var PapayaConfiguration
  */
  private $_configuration = NULL;

  /**
  * The connector object, which is used for communication with the geosearch db
  * @var GeosearchConnector
   */
  protected $_geosearchConnector = NULL;

  /**
  * The geosearch connector guid
  * @var string
  */
  private $_geosearchConnectorGuid = 'b3652a2669aae6923e574cbba7430e1a';

  /**
  * The plugin loader object to get the geosearch connector
  * @var base_pluginloader
  */
  protected $_pluginLoader = NULL;

  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Find the given searchstring in a defined set of database fields
  *
  * @param string $searchString
  * @return array
  */
  public function getCityListFulltextSearch($searchString) {
    $connector = $this->getGeosearchConnector();
    return $connector->getCityListFulltextSearch($searchString);
  }

  /**
  * Find the corresponding cities by given zipcode
  *
  * @param string $zipcode
  * @return array
  */
  public function getCityListByZipcode($zipcode) {
    $connector = $this->getGeosearchConnector();
    return $connector->getCityListByZipcode($zipcode);
  }


  /***************************************************************************/
  /** Helper / instances                                                     */
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
  * Set a specified liveseearch connector
  *
  * @param GeosearchConnector $connector
  */
  public function setGeosearchConnector(GeosearchConnector $connector) {
    $this->_geosearchConnector = $connector;
  }

  /**
  * Get a GeosearchConnector instance via plugin loader
  *
  * @return GeosearchConnector
  */
  public function getGeosearchConnector() {
    if (
         !(
           is_object($this->_geosearchConnector) &&
           $this->_geosearchConnector instanceof GeosearchConnector
         )
       ) {
      $pluginLoaderObject = $this->getPluginLoader();
      $this->_geosearchConnector = $pluginLoaderObject->getPluginInstance(
        $this->_geosearchConnectorGuid, $this
      );
    }
    return $this->_geosearchConnector;
  }

  /**
  * Set the plugin loader to be used instead of the real one.
  *
  * @param base_pluginloader $pluginLoader
  */
  public function setPluginLoader($pluginLoader) {
    $this->_pluginLoader = $pluginLoader;
  }

  /**
  * Initialize the plugin loader
  *
  * @return base_pluginloader
  */
  public function getPluginLoader() {
    if (!(isset($this->_pluginLoader) && is_object($this->_pluginLoader))) {
      $this->_pluginLoader = base_pluginloader::getInstance();
    }
    return $this->_pluginLoader;
  }

}