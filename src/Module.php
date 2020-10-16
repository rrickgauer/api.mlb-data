<?php

include_once('constants.php');

class Module 
{

    protected $filters;     // array of filters
    protected $sorts;       // array of sorts
    protected $perPage;     // int - number of items in data set
    protected $page;        // int - offset
    protected $dataSet;

    public function __construct($newFilters, $newSorts, $newPerPage = Constants::Defaults['PerPage'], $newPage = Constants::Defaults['Page']) {
        $this->filters = $newFilters;
        $this->sorts   = $newSorts;
        $this->perPage = $newPerPage;
        $this->page    = $newPage;
        
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

    public function getPerPage() {
        return $this->perPage;
    }

    public function setPerPage($newPerPage) {
        $this->perPage = $newPerPage;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($newPage) {
        $this->page = $newPage;
    }

    public function returnData() {
        ApiFunctions::printJson($this->dataSet);
    }
}

?>