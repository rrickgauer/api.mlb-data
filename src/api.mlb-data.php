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



// determine which module to return
// people/playerID - biographical
// people/playerID/salaries - salary info
// people/playerID/batting - batting stats
// people/playerID/pitching - pitching stats
// people/playerID/appearances - appearances
// people/playerID/schools - schools attended

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
      echo "Your favorite color is green!";
      break;
    case 'schools':
      echo "Your favorite color is green!";
      break;
    default:
      echo "Your favorite color is neither red, blue, nor green!";
  }
} else {
  // biographical
  returnPerson($playerID);
}


exit;




















































?>