<?php

include_once('Constants.php');

class Module {

    protected $filters;     // array of filters
    protected $sorts;       // array of sorts
    protected $perPage;     // int - number of items in data set
    protected $page;        // int - offset
    protected $dataSet;
    protected $aggregate;

    public function __construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
        $this->setFilters($newFilters);
        $this->setSorts($newSorts);
        $this->setPerPage($newPerPage);
        $this->setPage($newPage);
        $this->dataSet = null;
        $this->setAggregate($newAggregate);
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


class People extends Module {
    public function __construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
        parent::__construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
        $this->dataSet = DB::getPeople($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Pitching extends Module {
    public function __construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
        parent::__construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
        $this->retrieveData();
    }

    private function retrieveData() {
        if ($this->aggregate == true)
            $this->dataSet = DB::getPitchingAggregate($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
        else 
            $this->dataSet = DB::getPitching($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
}





class Batting extends Module {
    public function __construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
        parent::__construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
        $this->retrieveData();
    }

    private function retrieveData() {
        if ($this->aggregate == true)
            $this->dataSet = DB::getBattingAggregate($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
        else 
            $this->dataSet = DB::getBatting($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
}


class Fielding extends Module {
    public function __construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
        parent::__construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
        $this->retrieveData();
    }

    private function retrieveData() {
        if ($this->aggregate == true)
            $this->dataSet = DB::getFieldingAggregate($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
        else 
            $this->dataSet = DB::getFielding($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
}

class FieldingOF extends Module {
    public function __construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
        parent::__construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
        $this->retrieveData();
    }

    private function retrieveData() {
        if ($this->aggregate == true)
            // $this->dataSet = DB::getFieldingAggregate($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
        else 
            $this->dataSet = DB::getFieldingOF($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
}

class FieldingOFSplit extends Module {
    public function __construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
        parent::__construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
        $this->retrieveData();
    }

    private function retrieveData() {
        if ($this->aggregate == true)
            // $this->dataSet = DB::getFieldingAggregate($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
        else 
            $this->dataSet = DB::getFieldingOFSplit($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Appearances extends Module {
    public function __construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
        parent::__construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
        $this->retrieveData();
    }

    private function retrieveData() {
        if ($this->aggregate == true)
            // $this->dataSet = DB::getFieldingAggregate($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
        else 
            $this->dataSet = DB::getAppearances($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Salaries extends Module {
    public function __construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate) {
        parent::__construct($newFilters, $newSorts, $newPerPage, $newPage, $newAggregate);
        $this->retrieveData();
    }

    private function retrieveData() {
        if ($this->aggregate == true)
            // $this->dataSet = DB::getFieldingAggregate($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
        else 
            $this->dataSet = DB::getSalaries($this->sorts, $this->filters, $this->perPage, $this->page)->fetchAll(PDO::FETCH_ASSOC);
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
        $this->dataSet = DB::getPeopleSearch($this->query, null, null, $this->perPage)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function returnData() {
        ApiFunctions::printJson($this->dataSet);
    }
}

?>