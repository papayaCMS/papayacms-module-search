<?php
/**
* Search page module base class.
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
* @tutorial Search/Search.pkg
* @tutorial Search/SearchPageBase.cls
*
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Base.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Load necessary libraries
*/
require_once(dirname(__FILE__).'/../Loader/Database/Single.php');
require_once(dirname(__FILE__).'/../Loader/Database/Concatenated.php');

/**
* Base module class for {@link SearchPage}
*
* @package Papaya-Modules
* @subpackage Search
*/
class SearchPageBase {

  /**
  * System configuration
  * @var PapayaConfiguration
  */
  protected $_configuration = NULL;

  /**
  * The owner of the base class
  * @var SearchPage
   */
  protected $_owner = NULL;

  /**
  * The connector object, which is used for communication
  * @var SearchConnector
   */
  protected $_SearchConnector = NULL;

  /**
  * The lieve search connector guid
  * @var string
  */
  private $_SearchConnectorGuid = 'd317710ff2c7a431f1f64b086121b57d';

  /**
  * The plugin loader object
  * @var base_pluginloader
  */
  protected $_pluginLoader = NULL;

  /**
  * The dialog builder object
  * @var UtilDialogBuilder
  */
  protected $_dialogBuilder = NULL;

  /**
  * List of loaders, to attach to the Search dataprovider
  * @var array
  */
  protected $_loaders = array();

  /***************************************************************************/
  /** Helper / Instances                                                     */
  /***************************************************************************/

  /**
  * Constructor of the base object
  *
  * @param SearchPage $owner
  */
  public function __construct(SearchPage $owner = NULL) {
    $this->initialize($owner);
  }

  /**
  * initialize the loaders used by the page
  * @param SearchPage $owner
  */
  public function initialize($owner) {
    $this->_owner = $owner;
    $this->_loaders = array(
      'single' => new SearchLoaderDatabaseSingle(),
      'concatenated' => new SearchLoaderDatabaseConcatenated()
    );
  }

  /**
  * set the system configuration
  * @param PapayaConfiguration $configuration
  */
  public function setConfiguration($configuration) {
    $this->_configuration = $configuration;
  }

  /**
  * Set a specified liveseearch connector
  *
  * @param SearchConnector $connector
  */
  public function setSearchConnector(SearchConnector $connector) {
    $this->_SearchConnector = $connector;
  }

  /**
  * Get a SearchConnector instance via plugin loader
  *
  * @return SearchConnector
  */
  public function getSearchConnector() {
    if (
      !is_object(
        $this->_SearchConnector ||
        !$this->_SearchConnector instanceof SearchConnector
      )
    ) {
        $pluginLoaderObject = $this->getPluginLoader();
        $this->_SearchConnector = $pluginLoaderObject->getPluginInstance(
          $this->_SearchConnectorGuid, $this);
    }
    return $this->_SearchConnector;
  }

  /**
  * Set the base plugin loader to be used instead of the real one.
  *
  * @param base_pluginloader $pluginLoader
  */
  public function setPluginLoader($pluginLoader) {
    $this->_pluginLoader = $pluginLoader;
  }

  /**
  * Initialize the base plugin loader
  *
  * @return base_pluginloader
  */
  public function getPluginLoader() {
    if (!(isset($this->_pluginLoader) && is_object($this->_pluginLoader))) {
      $this->_pluginLoader = base_pluginloader::getInstance();
    }
    return $this->_pluginLoader;
  }

  /**
  * Set the dialog builder object
  *
  * @param UtilDialogBuilder $dialogBuilder
  */
  public function setDialogBuilder(SearchUtilDialogBuilder $dialogBuilder) {
      $this->_dialogBuilder = $dialogBuilder;
  }

  /**
  * Retrieve the dialog builder object and initialize it if necessary
  *
  * @return UtilDialogBuilder $dialogBuilder
  */
  public function getDialogBuilder() {
    if (!isset($this->_dialogBuilder) ||
        !$this->_dialogBuilder instanceof SearchUtilDialogBuilder) {
      include_once(dirname(__FILE__).'/../Util/Dialog/Builder.php');
      $this->setDialogBuilder(new SearchUtilDialogBuilder);
    }
    return $this->_dialogBuilder;
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Get the page xml
  * @return string $pageXml
  */
  public function getPageXml() {
    $xml = '';
    $params = $this->_owner->params;
    $searchString = $params['query'];
    $paramName = $this->_owner->paramName;
    $ownerData = $this->_owner->data;
    $connector = $this->getSearchConnector();
    foreach ($this->_loaders as $loader) {
      $connector->registerLoader($loader);
    }
    $results = $connector->searchArray($searchString);

    if ($builder = $this->getDialogBuilder()) {
      $fields = array(
        'suggest' => array($ownerData['suggest_caption'], '', TRUE, 'radio',
          $connector->searchArray($searchString))
      );
      $data = array();
      $hidden = $params;
      $dialog = $builder->createDialog($this, $paramName, $fields, $data, $hidden);
      $xml .= $dialog->getDialogXML();
    }
    return $xml;
  }


  /**
  * Get the xml of a teaser
  * @return string $teaserXml
  */
  public function getTeaserXml() {
    return '<teaser>some xml</teaser>';
  }

}
?>