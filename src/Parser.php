<?php

///////////////////////////////
// Class and Function List:  //
//                           //
// Function list:            //
// - __construct()           //
// - getModule()             //
// - getSorts()              //
// - getFilters()            //
// - setModule()             //
// - setSorts()              //
// - setFilters()            //
// - parseFilter()           //
// - retrieveFilterColumns() //
// - setAggregate()          //
// - getAggregate()          //
//                           //
// Classes list:             //
// - Parser                  //
//                           //
///////////////////////////////

include_once ('DB-Functions.php');
include_once ('Constants.php');
include_once ('API-Functions.php');

class Parser {

  private $module;
  private $sorts;
  private $request;         // array(column, type)
  private $filters;         // list of arrays(column, conditional, qualifier)
  private $filterColumns;
  private $aggregate;
  private $playerID;

  public function __construct() {

    if (!isset($_SERVER['PATH_INFO'])) {
      ApiFunctions::returnBadRequest('Module not specified.');
      exit;
    }

    $this->request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

    $this->setModule();
    $this->retrieveFilterColumns();
    $this->setFilters();
    $this->setSorts();
    $this->setAggregate();
    $this->setPlayerID();
  }

  public function getModule() {
    return $this->module;
  }

  public function getSorts() {
    return $this->sorts;
  }

  public function getFilters() {
    return $this->filters;
  }

  private function setModule() {
    $this->module = $this->request[0];

    if (!in_array($this->module, Constants::Modules)) {
      ApiFunctions::returnBadRequest('Unrecognized module!');
      exit;
    }
  }

  private function setSorts() {
    // check if sort is set
    if (!isset($_GET['sort'])) {
      $this->sorts = null;
      return;
    }

    $sorts = $_GET['sort'];
    $sorts = explode(':', $sorts);

    $this->sorts['column'] = $sorts[0];

    // check if sort is in the constants array
    if (!in_array($sorts[0], $this->filterColumns)) {
      ApiFunctions::returnBadRequest('Error. Unrecognized sort column.');
      exit;
    }

    if (isset($sorts[1]) && strtoupper($sorts[1]) == 'ASC') {
      $this->sorts['type'] = 'ASC';
    } else {
      $this->sorts['type'] = 'DESC';
    }
  }

  private function setFilters() {

    if (!isset($_GET['filter'])) {
      $this->filters = null;
      return;
    }

    // break up filters by comma
    $filters = explode(',', $_GET['filter']);

    $filterList = [];

    for ($count = 0;$count < count($filters);$count++) {
      $newFilter = $this->parseFilter($filters[$count]);
      array_push($filterList, $newFilter);
    }

    $this->filters = $filterList;
  }

  // HR:>=:500
  // column_name:conditional:qualifier
  private function parseFilter($rawFilter) {
    $filter = explode(':', $rawFilter);

    // verify that the conditional is valid
    if (!in_array($filter[1], Constants::FilterConditionals)) {
      ApiFunctions::returnBadRequest('Unrecognized filter conditional');
      exit;
    }

    // verify that the column is valid
    if (!in_array($filter[0], $this->filterColumns)) {
      ApiFunctions::returnBadRequest('Error. Unrecognized filter column.');
      exit;
    }

    // eventually, need to check if the column is in the constants
    $parsedFilter = [];
    $parsedFilter['column'] = $filter[0];
    $parsedFilter['conditional'] = $filter[1];
    $parsedFilter['qualifier'] = $filter[2];

    return $parsedFilter;
  }

  // Determine the matching columns
  private function retrieveFilterColumns() {
    switch ($this->module) {
      case Constants::Modules['Batting']:
        $this->filterColumns = Constants::Batting; break;
      case Constants::Modules['Pitching']:
        $this->filterColumns = Constants::Pitching; break;
      case Constants::Modules['Appearances']:
        $this->filterColumns = Constants::Appearances; break;
      case Constants::Modules['Fielding']:
        $this->filterColumns = Constants::Fielding; break;
      case Constants::Modules['People']:
        $this->filterColumns = Constants::People; break;
      case Constants::Modules['FieldingOF']:
        $this->filterColumns = Constants::FieldingOF; break;
      case Constants::Modules['FieldingOFSplit']:
        $this->filterColumns = Constants::FieldingOFSplit; break;
      case Constants::Modules['Salaries']:
        $this->filterColumns = Constants::Salaries; break;
      default:
        $this->filterColumns = null; break;
    }
  }

  // the aggregate flag needs to be set to 'true' in order to do the aggregate
  private function setAggregate() {
    if (isset($_GET['aggregate']) && $_GET['aggregate'] == 'true') {
      $this->aggregate = true;
    } else {
      $this->aggregate = false;
    }
  }

  public function getAggregate() {
    return $this->aggregate;
  }


  private function setPlayerID() {
    // set playerID to null if not set in the url
    if (!isset($this->request[1])) {
      $this->playerID = null;
      return;
    }

    $playerID = $this->request[1];

    // check if playerID exists
    if (!DB::doesPlayerExist($playerID)) {
      ApiFunctions::returnBadRequest('Error. playerID does not exist!');
      return;
    }


    $this->playerID = $playerID;
  } 

  public function getPlayerID() {
    return $this->playerID;
  }

  public function isPlayerIDSet() {
    if ($this->playerID == null)
      return false;
    else
      return true;
  }
}

?>
