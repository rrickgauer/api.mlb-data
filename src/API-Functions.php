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


  // use when the resource could not be found (like playerID DNE)
  public static function returnRequestNotFound($message = 'Resource not found!') {
    header('Content-Type: text/html; charset=UTF-8');
    http_response_code(404);
    echo $message;
    exit;
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

    ApiFunctions::printJson($results);
  }


  public static function returnInvalidUrl($message = 'Unrecoginzed parameter in the URL') {
    http_response_code(400);
    echo $message;
    exit;
  }

  public static function getPlayerModuleLinksArray($playerID) {
    $urls = [];
    $urls['Appearances']     = Constants::InternalUrls['Appearances'] . '/' . $playerID;
    $urls['Batting']         = Constants::InternalUrls['Batting'] . '/' . $playerID;
    $urls['Fielding']        = Constants::InternalUrls['Fielding'] . '/' . $playerID;
    $urls['FieldingOF']      = Constants::InternalUrls['FieldingOF'] . '/' . $playerID;
    $urls['FieldingOFSplit'] = Constants::InternalUrls['FieldingOFSplit'] . '/' . $playerID;
    $urls['People']          = Constants::InternalUrls['People'] . '/' . $playerID;
    $urls['Pitching']        = Constants::InternalUrls['Pitching'] . '/' . $playerID;
    $urls['Salaries']        = Constants::InternalUrls['Salaries'] . '/' . $playerID;

    return $urls;
  }

}

?>
