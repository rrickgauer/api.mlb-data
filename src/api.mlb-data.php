<?php


include_once('functions.php');
include_once('api-functions.php');

header('Content-Type: application/json');


$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));


if ($request[0] == 'people') {

  $playerID = $request[1];
  returnPerson($playerID);
  // returnPersonBatting($playerID);
}







exit;




















































?>