<?php
/**
* Base test case abstraction
*
* Here you will find global fixtures, generic data providers, and/or constants.
* E.g.:
*
* Fixtures for connectors
*   Data provider for generic values like true/false sequence, all scalar types except objects, …
*
*/

/**
* Load papaya base test case abstraktion
*/

// predefine constants
PapayaTestCase::defineConstantDefaults(
  'DB_FETCHMODE_ASSOC',
  'PAPAYA_DB_TBL_MODULES',
  'PAPAYA_DB_TBL_LNG',
  'PAPAYA_URL_EXTENSION',
  'PAPAYA_DB_TBL_TOPICS_PUBLIC',
  'PAPAYA_DB_TBL_TOPICS_PUBLIC_TRANS',
  'PAPAYA_DB_TBL_TOPICS_VERSIONS',
  'PAPAYA_DB_TBL_TOPICS_VERSIONS_TRANS'
);

abstract class SearchTestCase extends PapayaTestCase {

  /**
  * Generate a mock object of the Search connector object
  *
  * @param array $functions List of methods to be reflected
  * @return SearchConnector
  */
  public function getSearchConnectorFixture($functions = array()) {
    include_once (dirname(__FILE__).'/../src/Connector.php');

    if (!is_array($functions)) {
      $functions = array($functions);
    }

    $SearchConnector = $this->getMock(
      'SearchConnector',
      $functions,
      array(),
      'SearchConnector'.md5(__CLASS__.microtime()),
      FALSE
    );

    return $SearchConnector;
  }

}