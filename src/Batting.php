<?php

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