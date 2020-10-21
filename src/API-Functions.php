<?php
/**
* Class and Function List:
* Function list:
* - printJson()
* - returnBadRequest()
* - returnPeople()
* - returnPerson()
* - returnPersonBatting()
* - returnPersonPitching()
* - returnPersonSalaries()
* - returnPersonAppearances()
* - returnPersonSchools()
* - getPaginationResults()
* - returnDefaultDisplay()
* - returnPersonPitchingTotals()
* - returnInvalidUrl()
* - returnPersonBattingTotals()
* - returnPersonAppearancesTotals()
* - returnPersonSalariesTotals()
* Classes list:
* - ApiFunctions
*/
include_once ('DB-Functions.php');

class ApiFunctions {

  const MAX_PAGE_ITEMS = 1000;

  public static function printJson($data) {
    // return response
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE + JSON_NUMERIC_CHECK);
    exit;
  }

  public static function returnBadRequest($message = 'Invalid URL') {
    http_response_code(400);
    echo $message;
    exit;
  }

  public static function returnPeople($currentPage) {
    $result = [];
    $peopleAll = DB::getAllPlayers()->fetchAll(PDO::FETCH_ASSOC);

    // get pagination
    $result['pagination'] = ApiFunctions::getPaginationResults($peopleAll, self::MAX_PAGE_ITEMS, $currentPage);

    $offset = $currentPage * self::MAX_PAGE_ITEMS;
    $people = DB::getPlayers(self::MAX_PAGE_ITEMS, $offset)->fetchAll(PDO::FETCH_ASSOC);
    $result['results'] = $people;

    // return response
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit;
  }

  public static function returnPerson($playerID) {
    header('Content-Type: application/json');
    $results = DB::getPlayer($playerID)->fetch(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function returnPersonBatting($playerID) {
    header('Content-Type: application/json');
    $results = DB::getPlayerBatting($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function returnPersonPitching($playerID) {
    header('Content-Type: application/json');
    $results = DB::getPlayerPitching($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function returnPersonSalaries($playerID) {
    header('Content-Type: application/json');
    $results = DB::getPersonSalaries($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function returnPersonAppearances($playerID) {
    header('Content-Type: application/json');
    $results = DB::getPersonAppearances($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function returnPersonSchools($playerID) {
    header('Content-Type: application/json');
    $results = DB::getPersonSchools($playerID)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results, JSON_PRETTY_PRINT);
    http_response_code(200);
    exit;
  }

  public static function getPaginationResults($dataSet, $numItemsPerPage, $currentPage = 1) {
    $numPages = floor(count($dataSet) / $numItemsPerPage);

    // ensure the current page does not exceed the last available page
    if ($currentPage > $numPages) {
      http_response_code(404);
      echo 'Page does not exist';
      exit;
    }

    $pages = [];
    $pages['first'] = 0;
    $pages['last'] = $numPages;

    // next page is null if user is on the last page
    $pages['next'] = null;
    if ($currentPage < $numPages) {
      $pages['next'] = $currentPage + 1;
    }

    return $pages;
  }

  public static function returnDefaultDisplay() {

    $projectInfo['author']         = 'Ryan Rickgauer';
    $projectInfo['authorWebsite']  = 'https://www.ryanrickgauer.com/resume/index.html';
    $projectInfo['projectWebsite'] = 'https://github.com/rrickgauer/mlb-api';
    $results['projectInfo']        = $projectInfo;

    $people['all']                 = '/people{?page}';
    $people['biography']           = '/people/{playerID}';
    $people['appearances']         = '/people/{playerID}/appearances{?total}';
    $people['batting']             = '/people/{playerID}/batting{?total}';
    $people['pitching']            = '/people/{playerID}/pitching{?total}';
    $people['salaries']            = '/people/{playerID}/salaries{?total}';
    $people['schools']             = '/people/{playerID}/schools';
    $results['modules']['/people'] = $people;

    $search['searchDatabase']      = '/search?q=';
    $results['modules']['/search'] = $search;

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode($results, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE + JSON_NUMERIC_CHECK);
    exit;
  }

  public static function returnPersonPitchingTotals($playerID) {
    $pitchingTotal = DB::getPersonPitchingTotals($playerID)->fetch(PDO::FETCH_ASSOC);
    ApiFunctions::printJson($pitchingTotal);
    exit;
  }

  public static function returnInvalidUrl($message = 'Unrecoginzed parameter in the URL') {
    http_response_code(400);
    echo $message;
    exit;
  }

  public static function returnPersonBattingTotals($playerID) {
    $battingTotal = DB::getPersonBattingTotals($playerID)->fetch(PDO::FETCH_ASSOC);
    ApiFunctions::printJson($battingTotal);
    exit;
  }

  public static function returnPersonAppearancesTotals($playerID) {
    $appearancesTotal = DB::getPersonAppearancesTotals($playerID)->fetch(PDO::FETCH_ASSOC);
    ApiFunctions::printJson($appearancesTotal);
    exit;
  }

  public static function returnPersonSalariesTotals($playerID) {
    $salariesTotal = DB::getPersonSalariesTotals($playerID)->fetch(PDO::FETCH_ASSOC);
    ApiFunctions::printJson($salariesTotal);
    exit;
  }
}

?>
