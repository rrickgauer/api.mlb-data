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
// $sort = $p1->getSorts();

// $results = new Fielding($p1->getFilters(), $p1->getSorts(), Constants::Defaults['PerPage'], 0, $p1->getAggregate());



// generate the results based on the specified module
switch ($p1->getModule()) {
  case Constants::Modules['Pitching']:
    $results = new Pitching($p1->getFilters(), $p1->getSorts(), Constants::Defaults['PerPage'], 0, $p1->getAggregate()); break;
  case Constants::Modules['Batting']:
    $results = new Batting($p1->getFilters(), $p1->getSorts(), Constants::Defaults['PerPage'], 0); break;
  case Constants::Modules['Fielding']:
    $results = new Fielding($p1->getFilters(), $p1->getSorts(), Constants::Defaults['PerPage'], 0, $p1->getAggregate()); break;
  case Constants::Modules['Appearances']:
    $results = new Appearances($p1->getFilters(), $p1->getSorts(), Constants::Defaults['PerPage'], 0); break;
  case Constants::Modules['FieldingOF']:
    $results = new FieldingOF($p1->getFilters(), $p1->getSorts(), Constants::Defaults['PerPage'], 0); break;
  case Constants::Modules['FieldingOFSplit']:
    $results = new FieldingOFSplit($p1->getFilters(), $p1->getSorts(), Constants::Defaults['PerPage'], 0); break;
  case Constants::Modules['Salaries']:
    $results = new Salaries($p1->getFilters(), $p1->getSorts(), Constants::Defaults['PerPage'], 0); break;
  case Constants::Modules['People']:
    $results = new People($p1->getFilters(), $p1->getSorts(), Constants::Defaults['PerPage'], 0); break;
  case Constants::Modules['Search']:
    // ensure the query paramter is set
    if (!isset($_GET['q'])) 
      ApiFunctions::returnBadRequest('You need to specify a search query!');
      
    $results = new Search($_GET['q'], Constants::Defaults['PerPage']); break;
  default:
    ApiFunctions::returnBadRequest('Module does not exist!');
    exit;
    break;
}

// return the results
$results->returnData();

exit;


?>