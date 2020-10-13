<?php


include_once('functions.php');
include_once('api-functions.php');

$MAX_PAGE_ITEMS = 1000;

// header('Content-Type: application/json');


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



  $people = getAllPlayers()->fetchAll(PDO::FETCH_ASSOC);
  $numPages =  floor(count($people) / $MAX_PAGE_ITEMS);

  // set the current page
  // default is 1 if it is not specified
  $currentPage = 1;
  if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
  }

  // ensure the current page does not exceed the last available page
  if ($currentPage > $numPages) {
    http_response_code(404);
    echo 'Page does not exist';
    exit;
  }


  $pages = [];
  $pages['first'] = 'people?page=1';
  $pages['last'] = 'people?page=' . $numPages;

  // next page is null if user is on the last page
  $pages['next'] = null;
  if ($currentPage < $numPages) {
    $nextPage = $currentPage + 1;
    $pages['next'] = 'people?page=' . $nextPage;
  }


  $result['pagination'] = $pages;


  header('Content-Type: application/json');
  echo json_encode($result, JSON_PRETTY_PRINT);



  exit;





} else {
  $playerID = $request[1];
}



// check if player exists
if (!doesPlayerExist($playerID)) {
  http_response_code(404);
  echo 'ID does not exist!';
  exit;
}




// determine which person submodule to return
if (isset($request[2])) {
  $module = $request[2];

  switch ($module) {
    case 'salaries':
      returnPersonSalaries($playerID);
      break;
    case 'batting':
      returnPersonBatting($playerID);
      break;
    case 'pitching':
      returnPersonPitching($playerID);
      break;
    case 'appearances':
      returnPersonAppearances($playerID);
      break;
    case 'schools':
      returnPersonSchools($playerID);
      break;
    default:
      echo 'invalid module.';
      http_response_code(400);
      exit;
  }
} else {
  // biographical
  returnPerson($playerID);
}


exit;




















































?>