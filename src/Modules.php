<?php

//////////////////////////////////////
// Class and Function List:         //
//                                  //
// Function list:                   //
// - __construct()                  //
// - getFilters()                   //
// - setFilters()                   //
// - getSorts()                     //
// - setSorts()                     //
// - setAggregate()                 //
// - getPerPage()                   //
// - setPerPage()                   //
// - getPage()                      //
// - setPage()                      //
// - returnData()                   //
// - __construct()                  //
// - __construct()                  //
// - retrieveData()                 //
// - __construct()                  //
// - retrieveData()                 //
// - __construct()                  //
// - retrieveData()                 //
// - __construct()                  //
// - retrieveData()                 //
// - __construct()                  //
// - retrieveData()                 //
// - __construct()                  //
// - retrieveData()                 //
// - __construct()                  //
// - retrieveData()                 //
// - __construct()                  //
// - getQuery()                     //
// - getPerPage()                   //
// - setQuery()                     //
// - setPerPage()                   //
// - retrieveData()                 //
// - returnData()                   //
//                                  //
// Classes list:                    //
// - Module                         //
// - People extends Module          //
// - Pitching extends Module        //
// - Batting extends Module         //
// - Fielding extends Module        //
// - FieldingOF extends Module      //
// - FieldingOFSplit extends Module //
// - Appearances extends Module     //
// - Salaries extends Module        //
// - Search                         //
//                                  //
//////////////////////////////////////

include_once ('Constants.php');
require_once('Pagination.php');

class Module {

  protected $filters;   // array of filters
  protected $sorts;     // array of sorts
  protected $perPage;   // int - number of items in data set
  protected $page;      // int - offset
  protected $dataSet;
  protected $aggregate;
  protected $playerID;
  protected $offset;
  protected $dataSetSize;

  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    $this->setFilters($newFilters);
    $this->setSorts($newSorts);
    $this->setPerPage($newPerPage);
    $this->setPage($newPage);
    $this->dataSet = null;
    $this->setAggregate($newAggregate);
    $this->setPlayerID($newPlayerID);
    $this->setOffset();
    $this->setDataSetSize = 1;    // this will get changed later in each of the sub modules
  }

  public function getFilters() {
    return $this->filters;
  }

  public function setFilters($newFilters) {
    $this->filters = $newFilters;
  }

  public function getSorts() {
    return $this->sorts;
  }

  public function setSorts($newSorts) {
    $this->sorts = $newSorts;
  }

  public function setAggregate($newAggregate) {
    if ($newAggregate == 'true') 
      $this->aggregate = true;
    else 
      $this->aggregate = false;
  }

  public function getPerPage() {
    return $this->perPage;
  }

  public function setPerPage($newPerPage) {
    if ($newPerPage < 0) {
      $newPerPage = Constants::Defaults['PerPage'];
    } else if ($newPerPage > Constants::Limits['PerPage']) {
      $newPerPage = Constants::Limits['PerPage'];
    } else {
      $this->perPage = $newPerPage;
    }
  }

  public function getPage() {
    return $this->page;
  }

  public function setPage($newPage) {
    if ($newPage > 0) {
      $this->page = $newPage;
    } else {
      $this->page = Constants::Defaults['Page'];
    }
  }

  public function setPlayerID($newPlayerID) {
    $this->playerID = $newPlayerID;
  }

  public function getPlayerID() {
    return $this->playerID;
  }

  public function returnData() {
    $data = [];
    $data['pagination'] = $this->getPagination();    
    $data['results'] = $this->dataSet;
    ApiFunctions::printJson($data);
  }

  public function setDataSetSize($function) {
    $this->dataSetSize = call_user_func($function, $this->playerID, $this->filters, $this->sorts);
  }

  public function getPagination() {
    $pagination         = new Pagination($this->dataSetSize);
    $links              = [];
    $links['first']     = $pagination->getPageFirst();
    $links['last']      = $pagination->getPageLast();
    $links['next']      = $pagination->getPageNext();

    return $links;
  }

  public function setOffset() {
    $this->offset = ($this->perPage) * ($this->page - 1);
  }

  public function getOffset() {
    return $this->offset;
  }
}

class People extends Module {
  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    parent::__construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
    $this->retrieveData();
    $this->setDataSetSize('DB::getPeopleCount');
  }

  private function retrieveData() {
    if ($this->playerID == null) {
      $results = DB::getPeople($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->offset)->fetchAll(PDO::FETCH_ASSOC);
    } else {
      $results = DB::getPeople($this->playerID, $this->sorts, $this->filters, $this->perPage, 0)->fetch(PDO::FETCH_ASSOC);
      $teams = DB::getTeamsPlayedFor($this->playerID)->fetchAll(PDO::FETCH_ASSOC);
      $results['teamsPlayedFor'] = array_column($teams, 'name');
    }

    $this->dataSet = $results;
  }
}

class Pitching extends Module {
  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    parent::__construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
    $this->retrieveData();
  }

  private function retrieveData() {
    if ($this->aggregate == true) {
      $this->dataSet = DB::getPitchingAggregate($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetch(PDO::FETCH_ASSOC);
    } else {
      $this->dataSet = DB::getPitching($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
}

class Batting extends Module {
  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    parent::__construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
    $this->retrieveData();
  }

  private function retrieveData() {
    if ($this->aggregate == true) {
      $this->dataSet = DB::getBattingAggregate($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetch(PDO::FETCH_ASSOC);
    } else {
      $this->dataSet = DB::getBatting($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
}

class Fielding extends Module {
  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    parent::__construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
    $this->retrieveData();
  }

  private function retrieveData() {
    if ($this->aggregate == true) {
      $this->dataSet = DB::getFieldingAggregate($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetch(PDO::FETCH_ASSOC);
    } else {
      $this->dataSet = DB::getFielding($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
}

class FieldingOF extends Module {
  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    parent::__construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
    $this->retrieveData();
  }

  private function retrieveData() {
    if ($this->aggregate == true) {
      $this->dataSet = DB::getFieldingOFAggregate($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetch(PDO::FETCH_ASSOC);
    } else {
      $this->dataSet = DB::getFieldingOF($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
}

class FieldingOFSplit extends Module {
  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    parent::__construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
    $this->retrieveData();
  }

  private function retrieveData() {
    if ($this->aggregate == true) {
      $this->dataSet = DB::getFieldingOFSplitAggregate($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetch(PDO::FETCH_ASSOC);
    } else {
      $this->dataSet = DB::getFieldingOFSplit($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
}

class Appearances extends Module {
  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    parent::__construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
    $this->retrieveData();
  }

  private function retrieveData() {
    if ($this->aggregate == true) {
      $this->dataSet = DB::getAppearancesAggregate($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetch(PDO::FETCH_ASSOC);
    } else {
      $this->dataSet = DB::getAppearances($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
}

class Salaries extends Module {
  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    parent::__construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
    $this->retrieveData();
  }

  private function retrieveData() {
    if ($this->aggregate == true) {
      $this->dataSet = DB::getSalariesAggregate($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetch(PDO::FETCH_ASSOC);
    } else {
      $this->dataSet = DB::getSalaries($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
}

class Search {
  private $query;
  private $perPage;
  private $dataSet;

  public function __construct($newQuery, $newPerPage) {
    $this->setQuery($newQuery);
    $this->setPerPage($newPerPage);
    $this->retrieveData();
  }

  public function getQuery() {
    return $this->query;
  }

  public function getPerPage() {
    return $this->perPage;
  }

  public function setQuery($newQuery) {
    $this->query = $newQuery;
  }

  public function setPerPage($newPerPage) {
    $this->perPage = $newPerPage;
  }

  private function retrieveData() {
    $data = DB::getPeopleSearch($this->query, null, null, $this->perPage)->fetchAll(PDO::FETCH_ASSOC);

    // generate the player urls
    for ($count = 0; $count < count($data); $count++) {
      $data[$count]['urls'] = ApiFunctions::getPlayerModuleLinksArray($data[$count]['playerID']);
    }

    $this->dataSet = $data;
  }

  public function returnData() {
    ApiFunctions::printJson($this->dataSet);
  }
}

?>
