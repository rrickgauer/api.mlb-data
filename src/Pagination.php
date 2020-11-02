<?php
/******************************************************************************
 *
 * This is the class that handles the pagination. It returns the first, next,
 * and last page URL for the entire dataset requested.
 * 
 * Class and Function List:
 * Function list:
 * - __construct()
 * - getPage()
 * - getPageFirst()
 * - getPageLast()
 * - getPageNext()
 * - getBaseUrl()
 * - setPageNext()
 * - setBaseUrl()
 * - setPageFirst()
 * - setPageLast()
 * - setPage()
 * Classes list:
 * - Pagination
******************************************************************************/

require_once('Parser.php');
require_once('Constants.php');

class Pagination
{

  private $page;
  private $pageFirst;
  private $pageLast;
  private $pageNext;
  private $pagePrevious;
  private $recordCount;
  private $parser;
  private $baseUrl;
  private $isGetSet;

  public function __construct(int $recordCount = 1) {
    $this->recordCount = $recordCount;
    $this->parser      = new Parser();

    // check if any url parameters are set
    if (count($_GET) == 0)
      $this->isGetSet = false;
    else
      $this->isGetSet = true;

    $this->setBaseUrl();
    $this->setPageFirst();
    $this->setPageLast();
    $this->setPage();
    $this->setPageNext();
    $this->setPagePrevious();
    
  }

  public function getPage() {
    return $this->page;
  }

  public function getPageFirst() {
    return $this->baseUrl . 'page=' . 1;
  }

  public function getPageLast() {
    return $this->baseUrl . 'page=' . $this->pageLast;
  }

  public function getPageNext() {
    $next = $this->baseUrl . 'page=' . $this->pageNext;
    return $next;
  }

  public function getBaseUrl() {
    return $this->baseUrl;
  }

  public function getPagePrevious() {
    if ($this->pagePrevious == null)
      return null;
    else
      return $this->baseUrl . 'page=' . $this->pagePrevious;
  }

  public function getPageCurrent() {
    return $this->baseUrl . 'page=' . $this->page;
  }

  public function getRecordCount() {
    return $this->recordCount;
  }

  private function setPageNext() {
    if ($this->page + 1 < $this->pageLast)
      $this->pageNext = $this->page + 1;
    else
      $this->pageNext = $this->pageLast;
  }

  private function setBaseUrl() {
    $link    = Constants::RootUrl . $_SERVER['PATH_INFO'] . '?';
    $getKeys = array_keys($_GET);
    $get     = array_values($_GET);
    $isFirst = true;

    for ($count = 0; $count < count($get); $count++) {
      $key = $getKeys[$count];
      
      // if the current key is page skip it going to place the page at the end
      if ($key == 'page')
        continue;

      // if there is more than 1 parm need to prefix the rest of them with an &
      if ($count != 0 && !$isFirst)
        $link .= '&';

      $link .= $key . '=' . $get[$count];
      $isFirst = false;
    } 

    // add possible & for appending page parm
    if (isset($_GET['page']) || count($_GET) >= 1)
      $link .= '&';

    $this->baseUrl = $link;
  }

  private function setPageFirst() {
    $this->pageFirst = 1;
  }

  private function setPageLast() {
    $this->pageLast  = ceil($this->recordCount / $this->parser->getPerPage());
  }

  private function setPage() {
    $page = $this->parser->getPage();

    if ($page > $this->pageLast) {
      ApiFunctions::returnRequestNotFound('This page does not exist');
    } else {
      $this->page = $page;
    }
  }

  private function setPagePrevious() {
    if ($this->page < 2)
      $this->pagePrevious = null;
    else
      $this->pagePrevious = $this->page - 1;
  }
}


?>