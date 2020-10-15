<?php


include_once('functions.php');
require_once('api-functions.php');


// check if user specified a path in the url
if (!isset($_SERVER['PATH_INFO'])) {
  ApiFunctions::returnDefaultDisplay();
}


$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$module = $request[0];

///////////////////
// search module //
///////////////////
if ($module == 'search') {

  // ensure the q parameter is set
  if (!isset($_GET['q'])) {
    http_response_code(400);
    echo 'please enter a query';
    exit;
  }


  $query = $_GET['q'];
  $results = DB::getPeopleSearch($query)->fetchAll(PDO::FETCH_ASSOC);
  ApiFunctions::printJson($results);

  exit;
}

///////////////////
// people module //
///////////////////
else {
  // return all people
  if (!isset($request[1])) {
    $currentPage = 0;
    if (isset($_GET['page']))
      $currentPage = $_GET['page'];

    ApiFunctions::returnPeople($currentPage);

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
        // if total is set but not true or false, error
        if (isset($_GET['total']) && !in_array($_GET['total'], ['true', 'false'])) {
          ApiFunctions::returnInvalidUrl('Total must be "true" or "false"');
          exit;
        }

        // return pitching
        if (isset($_GET['total']) && $_GET['total'] == 'true')
          ApiFunctions::returnPersonPitchingTotals($playerID);
        else
          ApiFunctions::returnPersonPitching($playerID);
        exit;
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
}




exit;







?>