<?php

include_once('constants.php');

class Module 
{

    protected $filters;     // array of filters
    protected $sorts;       // array of sorts
    protected $sortType;    // ASC OR DESC
    protected $perPage;     // int - number of items in data set
    protected $page;        // int - offset
    protected $dataSet;

    public function __construct($newFilters, $newSorts, $newSortType, $newPerPage, $newPage) {
      $this->setFilters($newFilters);
      $this->setSorts($newSorts);
      $this->setSortType($newSortType);
      $this->setPerPage($newPerPage);
      $this->setPage($newPage);
      $this->dataSet = null;
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

    public function getSortType() {
      return $this->sortType;
    }

    public function setSortType($newSortType) {
      $newSortType = strtoupper($newSortType);

        // ensure that the sort type is either ASC or DESC
      if ($newSortType == 'ASC')
        $this->sortType = $newSortType;
      else
       $this->sortType = 'DESC'; 
   }

   public function getPerPage() {
    return $this->perPage;
  }

  public function setPerPage($newPerPage) {
    if ($newPerPage < 0)
      $newPerPage = Constants::Defaults['PerPage'];
    else if ($newPerPage > Constants::Limits['PerPage'])
      $newPerPage = Constants::Limits['PerPage'];
    else
      $this->perPage = $newPerPage;
  }

  public function getPage() {
    return $this->page;
  }

  public function setPage($newPage) {

    if ($newPage < 0)
      $newPage = Constants::Defaults['Page'];
    else
      $this->page = $newPage;
  }

  public function returnData() {
    ApiFunctions::printJson($this->dataSet);
  }
}


class Pitching extends Module
{
    public function __construct($newFilters, $newSorts, $newSortType, $newPerPage, $newPage) {
        parent::__construct($newFilters, $newSorts, $newSortType, $newPerPage, $newPage);
        $this->retrieveData();
    }

    private function retrieveData() {
        $this->dataSet = DB::getPitching($this->sorts, $this->sortType, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Batting extends Module
{
    public function __construct($newFilters, $newSorts, $newPerPage = Constants::Defaults['PerPage'], $newPage = Constants::Defaults['Page']) {
        parent::__construct($newFilters, $newSorts, $newPerPage = Constants::Defaults['PerPage'], $newPage = Constants::Defaults['Page']);
        $this->retrieveData();
    }

    private function retrieveData() {
        $this->dataSet = DB::getTopBattersSeason($this->sorts, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>