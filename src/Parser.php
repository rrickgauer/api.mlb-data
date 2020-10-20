<?php

include_once('functions.php');
include_once('constants.php');
include_once('api-functions.php');


class Parser {

    private $module;
    private $sorts;
    private $request;
    private $filters;

    public function __construct() {

        if (!isset($_SERVER['PATH_INFO'])) {
            ApiFunctions::returnBadRequest('Module not specified.');
            exit;
        }

        $this->request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

        $this->setModule();
        $this->setSorts();
        $this->setFilters();
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

        if (isset($sorts[1]) && strtoupper($sorts[1]) == 'ASC')
            $this->sorts['type'] = 'ASC';
        else
            $this->sorts['type'] = 'DESC';
    }


    private function setFilters() {

        if (!isset($_GET['filter'])) {
            $this->filters = null;
            return;
        }

        // break up filters by comma
        $filters = explode(',', $_GET['filter']);

        $filterList = [];

        for ($count = 0; $count < count($filters); $count++) {
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

        // eventually, need to check if the column is in the constants
        $parsedFilter = [];
        $parsedFilter['column'] = $filter[0];
        $parsedFilter['conditional'] = $filter[1];
        $parsedFilter['qualifier'] = $filter[2];

        return $parsedFilter;
    }


}



?>