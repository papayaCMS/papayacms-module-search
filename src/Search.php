<?php
/**
* Search module to enable a form to show suggestions while typing in an input field.
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
* @tutorial Search/Search.cls
*
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Search.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Loade necessary libraries
*/
require_once(PAPAYA_INCLUDE_PATH.'system/papaya_strings.php');

/**
* Search base module
*
* @package Papaya-Modules
* @subpackage Search
*/
class Search {

  /**
  * Instance of a dataprovider
  * @var Dataprovider
  * @see SearchIntefaceDataprovider
  */
  private $_dataprovider = NULL;

  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Execute the search process and gather the results as a XML formatteed string
  *
  * The returned XML shall match the expactations described in
  * {@tutorial Search/SearchConnector.cls#class-methods.class-methods-searchXml}.
  *
  * @param string $searchString
  * @return string XML formatted string representing the search result.
  */
  public function searchXml($searchString) {
    return $this->getXml($searchString, $this->searchArray($searchString));
  }

  /**
  * Execute the search process and return the result array
  *
  * @param string $searchString
  * @return array Search result returned from dataprovider
  */
  public function searchArray($searchString) {
    return $this->getDataprovider()->load($searchString);
  }

  /**
  * Render a XML formatted string using the passed information.
  *
  * @param string $searchRresult
  * @return string XML formatted string representing the search result
  */
  protected function getXml($searchString, $searchRresult) {

    $result = '<response xmlns="http://www.w3.org/1999/xhtml">';
    $result .= sprintf(
      '<items query="%s" limit="10" offset="0">'.LF,
      papaya_strings::escapeHTMLChars($searchString)
    );
    if (!empty($searchRresult)) {
      foreach ($searchRresult as $item => $value) {
        $result .= sprintf(
          '<item>%s</item>'.LF,
          papaya_strings::escapeHTMLChars($item)
        );
      }
      $result .= '</items>'.LF;
    }
    $result .= '</response>';
    return $result;
  }


  /***************************************************************************/
  /** Helper                                                                 */
  /***************************************************************************/

  /**
  * Set the dataprovider object to be used instead of the former initialized.
  *
  * @param SearchInterfaceDataprovider $dataprovider
  */
  public function setDataprovider(SearchInterfaceDataprovider $dataprovider) {
    $this->_dataprovider = $dataprovider;
  }

  /**
  * Get an instance of a dataprovider.
  *
  * @return SearchInterfaceDataprovider
  */
  public function getDataprovider() {
    if (!(isset($this->_dataprovider) && is_object($this->_dataprovider))) {
      include_once(dirname(__FILE__).'/Dataprovider.php');
      $this->_dataprovider = new SearchDataprovider();
    }
    return $this->_dataprovider;
  }

}