<?php

include_once('includes.php');
include_once('Modules.php'); // filters, sorts, sortType, perPage, page
include_once('Parser.php');
require_once('Pagination.php');

// // display default return if no module is specified
// if (!isset($_SERVER['PATH_INFO'])) {
//   ApiFunctions::returnDefaultDisplay();
//   exit;
// }

// $p1 = new Parser();


$results = new Teams();

$teamParser = new ParserTeams();




// return the results
$results->returnData();

exit;


?>