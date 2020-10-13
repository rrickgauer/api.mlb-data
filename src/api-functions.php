<?php

include_once('functions.php');


class ApiFunctions {

  public static function returnPeople($pageNumber = 1) {
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

  public static function returnPerson($playerID) {
    header('Content-Type: application/json');
    $results = getPlayer($playerID)->fetch(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }


  public static function returnPersonBatting($playerID) {
    header('Content-Type: application/json');
    $results = getPlayerBatting($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function returnPersonPitching($playerID) {
    header('Content-Type: application/json');
    $results = getPlayerPitching($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function returnPersonSalaries($playerID) {
    header('Content-Type: application/json');
    $results = getPersonSalaries($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function returnPersonAppearances($playerID) {
    header('Content-Type: application/json');
    $results = getPersonAppearances($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function returnPersonSchools($playerID) {
    header('Content-Type: application/json');
    $results = getPersonSchools($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function getPaginationResults($dataSet, $numItemsPerPage, $currentPage = 1) {
    $numPages =  floor(count($dataSet) / $numItemsPerPage);
    
    // ensure the current page does not exceed the last available page
    if ($currentPage > $numPages) {
      http_response_code(404);
      echo 'Page does not exist';
      exit;
    }

    $pages = [];
    $pages['first'] = 1;
    $pages['last'] = $numPages;

    // next page is null if user is on the last page
    $pages['next'] = null;
    if ($currentPage < $numPages)
      $pages['next'] = $currentPage + 1;
    
    return $pages;
  }
}









?>