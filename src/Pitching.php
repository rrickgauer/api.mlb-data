<?php

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

?>