<?php


include_once('functions.php');
require_once('api-functions.php');

$MAX_PAGE_ITEMS = 1000;


// check if user specified a path in the url
if (!isset($_SERVER['PATH_INFO'])) {
  http_response_code(404);
  exit;
}


$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$module = $request[0];


// return all people
if (!isset($request[1])) {
  $result = [];
  $peopleAll = DB::getAllPlayers()->fetchAll(PDO::FETCH_ASSOC);

  // determine current page
  $currentPage = 0;
  if (isset($_GET['page']))
    $currentPage = $_GET['page'];

  // get pagination
  $result['pagination'] = ApiFunctions::getPaginationResults($peopleAll, $MAX_PAGE_ITEMS, $currentPage);


  $offset = $currentPage * $MAX_PAGE_ITEMS;
  $people = DB::getPlayers($MAX_PAGE_ITEMS, $offset)->fetchAll(PDO::FETCH_ASSOC);
  $result['results'] = $people;

  // return response
  header('Content-Type: application/json');
  echo json_encode($result, JSON_PRETTY_PRINT);
  exit;

} else {
  $playerID = $request[1];
}


// check if player exists
if (!DB::doesPlayerExist($playerID)) {
  http_response_code(404);
  echo 'ID does not exist!';
  exit;
}


// determine which person submodule to return
if (isset($request[2])) {
  $module = $request[2];

  switch ($module) {
    case 'salaries':
      ApiFunctions::returnPersonSalaries($playerID);
      break;
    case 'batting':
      ApiFunctions::returnPersonBatting($playerID);
      break;
    case 'pitching':
      ApiFunctions::returnPersonPitching($playerID);
      break;
    case 'appearances':
      ApiFunctions::returnPersonAppearances($playerID);
      break;
    case 'schools':
      ApiFunctions::returnPersonSchools($playerID);
      break;
    default:
      echo 'invalid module.';
      http_response_code(400);
      exit;
  }
} else {
  // biographical
  ApiFunctions::returnPerson($playerID);
}


exit;







?>