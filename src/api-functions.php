<?php

include_once('functions.php');

function returnPeople($pageNumber = 1) {
  header('Content-Type: application/json');

  $people = getAllPlayers()->fetchAll(PDO::FETCH_ASSOC);


  $MAX_PAGES = 19;

  // determine page number
  if (!isset($_GET['page']))
    $page = 1;
  else 
    $page = $_GET['page'];

  // check if page number exceeded the number of available pages
  if ($page > $MAX_PAGES) {
    http_response_code(400);
    exit;
  }


  if ($page == $MAX_PAGES)
    $peopleSub = array_slice($people, $page * 1000);
  else
    $peopleSub = array_slice($people, $page * 1000, 1000);


  echo json_encode($peopleSub, JSON_PRETTY_PRINT);

  
  exit;
}

function returnPerson($playerID) {
  $resultsPerson = getPlayer($playerID)->fetch(PDO::FETCH_ASSOC);
  $resultsBatting = getPlayerBatting($playerID)->fetchAll(PDO::FETCH_ASSOC);

  $results = [];
  $results['person_info'] = $resultsPerson;
  $results['batting'] = $resultsBatting;

  echo json_encode($results, JSON_PRETTY_PRINT);
  http_response_code(200);
  exit;
}


function returnPersonBatting($playerID) {
  $results = getPlayerBatting($playerID)->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($results, JSON_PRETTY_PRINT);
  http_response_code(200);
  exit;
}













?>