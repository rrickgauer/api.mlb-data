<?php


include_once('functions.php');
include_once('api-functions.php');

// header('Content-Type: application/json');


// check if user specified a path in the url
if (!isset($_SERVER['PATH_INFO'])) {
  echo http_response_code(404);
  exit;
}


$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));


$module = $request[0];

// ensure that a player id was provided in the url
if (!isset($request[1])) {
  http_response_code(404);
  echo 'Please provide a player ID';
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