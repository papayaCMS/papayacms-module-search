<?php
/**
* Search page module to return the requested data.
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
* @tutorial Search/SearchPage.cls
*
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Page.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* require necessary libraries
*/
require_once(PAPAYA_INCLUDE_PATH.'system/base_content.php');

/**
 * Search page module
 *
* @package Papaya-Modules
* @subpackage Search
*/
class SearchPage extends base_content {

  /*
  * define if a papaya backend preview is available
  * @var boolean $preview
  */
  public $preview = TRUE;

  /**
  * the param name used to identify the module in the request data
  * @var string $paramName
  */
  public $paramName = 'ls';

  /**
  * the edit fields array contains the data used in the page
  * @var array $editFields
  */
  public $editFields = array(
    'suggest_caption' => array('Radiobutton caption', 'isNoHTML', TRUE, 'input', 200)
  );

  /**
  * System configuration
  * @var PapayaConfiguration
  */
  protected $_configuration = NULL;

  /**
  * instance of the base object holding the logic
  * @var SearchPageBase $_SearchPageBase
  */
  protected $_SearchPageBase = NULL;

  /***************************************************************************/
  /** Helper                                                                 */
  /***************************************************************************/

  /**
  * Set the configuration of the module
  * @param PapayaConfiguration $configuration
  */
  public function setConfiguration($configuration) {
    $this->_configuration = $configuration;
  }

  /**
  * Set the base object of the page class
  * @param SearchPageBase $SearchPageBase
  */
  public function setSearchPageBase(SearchPageBase $SearchPageBase) {
    $this->_SearchPageBase = $SearchPageBase;
  }

  /**
  * get the base object of the page module
  * @return SearchPageBase
  */
  public function getSearchPageBase() {
    if (!is_object($this->_SearchPageBase) ||
        !$this->_SearchPageBase instanceof SearchPageBase) {
      include_once(dirname(__FILE__).'/Page/Base.php');
      $this->_SearchPageBase = new SearchPageBase($this);
      $this->_SearchPageBase->setConfiguration($this->_configuration);
    }
    return $this->_SearchPageBase;
  }


  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * get the page data
  * @see base_content::getParsedData()
  * @return string XML to use in the XSL transformation
  */
  public function getParsedData() {
    $baseObject = $this->getSearchPageBase($this);
    $xml = $baseObject->getPageXml();
    return $xml;
  }

  /**
  * get xml to use to parse a teaser for the page
  * @see base_content::getParsedTeaser()
  * @return string XML to use in the XSL transformation
  */
  public function getParsedTeaser() {
    $baseObject = $this->getSearchPageBase($this);
    $xml = $baseObject->getTeaserXml();
    return $xml;
  }
}