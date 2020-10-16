<?php

class Batting extends Module
{
    public function __construct($newFilters, $newSorts, $newPerPage = Constants::Defaults['PerPage'], $newPage = Constants::Defaults['Page']) {
        parent::__construct($newFilters, $newSorts, $newPerPage = Constants::Defaults['PerPage'], $newPage = Constants::Defaults['Page']);
        $this->retrieveData();
    }

    private function retrieveData() {
        $this->dataSet = DB::getTopBattersSeason('HR', 50)->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>