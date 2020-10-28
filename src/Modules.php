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

class Module {

  protected $filters; // array of filters
  protected $sorts; // array of sorts
  protected $perPage; // int - number of items in data set
  protected $page; // int - offset
  protected $dataSet;
  protected $aggregate;
  protected $playerID;

  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    $this->setFilters($newFilters);
    $this->setSorts($newSorts);
    $this->setPerPage($newPerPage);
    $this->setPage($newPage);
    $this->dataSet = null;
    $this->setAggregate($newAggregate);
    $this->setPlayerID($newPlayerID);
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
    if ($newPage < 0) {
      $newPage = Constants::Defaults['Page'];
    } else {
      $this->page = $newPage;
    }
  }

  public function setPlayerID($newPlayerID) {
    $this->playerID = $newPlayerID;
  }

  public function getPlayerID() {
    return $this->playerID;
  }

  public function returnData() {
    ApiFunctions::printJson($this->dataSet);
  }
}

class People extends Module {
  public function __construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
    parent::__construct($newPlayerID, $newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
    $this->retrieveData();
  }

  private function retrieveData() {
    $this->dataSet = DB::getPeople($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->page)->fetch(PDO::FETCH_ASSOC);
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
