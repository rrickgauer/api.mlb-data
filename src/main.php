<?php

include_once('includes.php');
include_once('Modules.php'); // filters, sorts, sortType, perPage, page
include_once('Parser.php');

// display default return if no module is specified
if (!isset($_SERVER['PATH_INFO'])) {
  ApiFunctions::returnDefaultDisplay();
  exit;
}

$p1 = new Parser();

header('Access-Control-Allow-Origin: *');

// generate the results based on the specified module
switch ($p1->getModule()) {
  case Constants::Modules['Pitching']:
    $results = new Pitching(); break;
  case Constants::Modules['Batting']:
    $results = new Batting(); break;
  case Constants::Modules['Fielding']:
    $results = new Fielding(); break;
  case Constants::Modules['Appearances']:
    $results = new Appearances(); break;
  case Constants::Modules['FieldingOF']:
    $results = new FieldingOF(); break;
  case Constants::Modules['FieldingOFSplit']:
    $results = new FieldingOFSplit(); break;
  case Constants::Modules['Salaries']:
    $results = new Salaries(); break;
  case Constants::Modules['People']:
    $results = new People(); break;
  case Constants::Modules['Images']:
    $results = new Images(); break;
  case Constants::Modules['BattingPost']:
    $results = new BattingPost(); break;
  case Constants::Modules['PitchingPost']:
    $results = new PitchingPost(); break;
  case Constants::Modules['FieldingPost']:
    $results = new FieldingPost(); break;
  case Constants::Modules['Colleges']:
    $results = new Colleges(); break;
  case Constants::Modules['Search']:
    // ensure the query paramter is set
    if (!isset($_GET['q'])) 
      ApiFunctions::returnBadRequest('You need to specify a search query!');
      
    $results = new Search($_GET['q']); break;
  default:
    ApiFunctions::returnBadRequest('Module does not exist!');
    exit;
    break;
}

// return the results
$results->returnData();

exit;


?>
