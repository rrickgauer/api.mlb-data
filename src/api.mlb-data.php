<?php


include_once('functions.php');
include_once('api-functions.php');

// header('Content-Type: application/json');


$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));


$module = $request[0];
$playerID = $request[1];


// check if player exists
if (!doesPlayerExist($playerID)) {
  http_response_code(404);
  echo 'ID does not exist!';
  exit;
}


if ($module == 'people')
  returnPerson($playerID);
else if ($module == 'pitching')
  returnPersonPitching($playerID);
else if ($module == 'batting')
  returnPersonBatting($playerID);
else
  http_response_code(404);



exit;




















































?>