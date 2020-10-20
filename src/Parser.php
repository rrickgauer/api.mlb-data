<?php

include_once('functions.php');
include_once('constants.php');
include_once('api-functions.php');


class Parser {

    private $module;
    private $sorts;
    private $request;

    public function __construct() {

        if (!isset($_SERVER['PATH_INFO'])) {
            ApiFunctions::returnBadRequest('Module not specified.');
            exit;
        }

        $this->request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

        $this->setModule();
        $this->setSorts();
    }


    public function getModule() {
        return $this->module;
    }

    public function getSorts() {
        return $this->sorts;
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







}



?>