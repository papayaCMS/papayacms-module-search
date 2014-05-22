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
* @tutorial Search/SearchLoaderLocationSingle.cls
* @package Papaya-Modules
* @subpackage Search
* @version $Id: Single.php 2 2013-12-09 15:11:21Z weinert $
*/

/**
* Load mandatory libraries
*/
require_once(dirname(__FILE__).'/../../Interface/Loader.php');
require_once(dirname(__FILE__).'/../../Loader/Database.php');

/**
* Loader to handle the given search string as a single term
*
* @package Papaya-Modules
* @subpackage Search
*/
class SearchLoaderDatabaseSingle extends SearchLoaderDatabase implements SearchInterfaceLoader {

  /**
  * Instance of the {link SearchDatabaseAccess} class
  * @var SearchDatabaseAccess
  */
  protected $_databaseAccess = NULL;

  /**
  * Indicator to determine if the calling dataprovider shall stop processing after this loader.
  * @var boolean
  */
  private $_stopPropagation = FALSE;

  /***************************************************************************/
  /** Methods                                                                */
  /***************************************************************************/

  /**
  * Execute loader
  *
  * @param string $searchString
  *
  * @see SearchInterfaceLoader::run()
  */
  public function run($searchString) {
    $result = array();
    $this->reset();

    $database = $this->getDatabaseAccessObject();

    if ($searchString === intval($searchString)) {
      // assume a zipcode was passed
      $result = $database->getCityListByZipcode($searchString);

      if (count($result) == 1 && strlen(intval($searchString)) == 5) {
        $this->_stopPropagation = TRUE;
      }
    } else {
      $result = $database->getCityListFulltextSearch($searchString);
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


  /***************************************************************************/
  /** Helper / instances                                                     */
  /***************************************************************************/

}

?>