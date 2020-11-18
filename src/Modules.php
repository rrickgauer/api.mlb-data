<?php
/******************************************************************************
 *
 * Here is where the base module class, and the module sub classes are 
 * contained. Based on the subclass, it gets its dataset from the corresponding
 * DB function
 *
 * 
 * Class and Function List:
 * Function list:
 * - __construct()
 * - getFilters()
 * - getSorts()
 * - getPerPage()
 * - getPage()
 * - getPlayerID()
 * - returnData()
 * - setDataSetSize()
 * - getPagination()
 * - setOffset()
 * - getOffset()
 * - retrieveData()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - __construct()
 * - getQuery()
 * - getPerPage()
 * - getPage()
 * - retrieveData()
 * - setDataSetSize()
 * - returnData()
 * - getPagination()
 * - setOffset()
 * - getOffset()
 * Classes list:
 * - Module
 * - People extends Module
 * - Pitching extends Module
 * - PitchingPost extends Module
 * - Batting extends Module
 * - BattingPost extends Module
 * - Fielding extends Module
 * - FieldingPost extends Module
 * - FieldingOF extends Module
 * - FieldingOFSplit extends Module
 * - Appearances extends Module
 * - Salaries extends Module
 * - Images extends Module
 * - Colleges extends Module
 * - Search
 * 
******************************************************************************/

include_once ('Constants.php');
require_once('Pagination.php');
require_once('API-Functions.php');
require_once('Parser.php');

class Module {

  protected $filters;   // array of filters
  protected $sorts;     // array of sorts
  protected $perPage;   // int - number of items in data set
  protected $page;      // int - offset
  protected $dataSet;
  protected $aggregate;
  protected $playerID;
  protected $offset;
  protected $dataSetSize;
  protected $parser;
  protected $db;

  public function __construct() {
    $this->parser         = new Parser();
    $this->filters        = $this->parser->getFilters();
    $this->sorts          = $this->parser->getSorts();
    $this->perPage        = $this->parser->getPerPage();
    $this->page           = $this->parser->getPage();
    $this->aggregate      = $this->parser->getAggregate();
    $this->playerID       = $this->parser->getPlayerID();
    $this->setOffset();

    $this->db          = new DB($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->offset);
    $this->dataSet     = null;
    $this->dataSetSize = 1;    // this will get changed later in each of the sub modules
  }

  public function getFilters() {
    return $this->filters;
  }

  public function getSorts() {
    return $this->sorts;
  }

  public function getPerPage() {
    return $this->perPage;
  }

  public function getPage() {
    return $this->page;
  }

  public function getPlayerID() {
    return $this->playerID;
  }

  public function returnData() {
    $data                 = [];
    $data['pagination']   = $this->getPagination(); 
    $data['resultsCount'] = $this->dataSetSize;   
    $data['results']      = $this->dataSet;
    ApiFunctions::printJson($data);
  }

  public function setDataSetSize($functionAggregate, $function) {
    if ($this->aggregate)
      $this->dataSetSize = call_user_func(array($this->db, $functionAggregate));
    else
      $this->dataSetSize = call_user_func(array($this->db, $function));
  }

  public function getPagination() {
    $pagination         = new Pagination($this->dataSetSize);
    $links              = [];
    $links['first']     = $pagination->getPageFirst();
    $links['current']   = $pagination->getPageCurrent();
    $links['next']      = $pagination->getPageNext();
    $links['previous']  = $pagination->getPagePrevious();
    $links['last']      = $pagination->getPageLast();
    return $links;
  }

  public function setOffset() {
    $this->offset = ($this->perPage) * ($this->page - 1);
  }

  public function getOffset() {
    return $this->offset;
  }

  protected function retrieveData($aggregateFunction, $function) {
    // determine if I should use aggregate function or not
    if ($this->aggregate == true)
      $dataset = call_user_func(array($this->db, $aggregateFunction));
    else 
      $dataset = call_user_func(array($this->db, $function));
    
    $parser = new Parser(); // need this to get the module

    // if there is only 1 row for the results, then just fetch the first row
    if ($this->playerID != null && ($this->aggregate || $parser->getModule() == Constants::Modules['People']))
      $this->dataSet = $dataset->fetch(PDO::FETCH_ASSOC);
    else 
      $this->dataSet = $dataset->fetchAll(PDO::FETCH_ASSOC);
  }
}

class People extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getPeople', 'getPeople');
    $this->setDataSetSize('getPeopleCount', 'getPeopleCount');

    // add additional info if playerID is specified
    if ($this->playerID != null) {
      // teams played for
      $teams = getTeamsPlayedFor($this->playerID)->fetchAll(PDO::FETCH_ASSOC);
      $this->dataSet['teamsPlayedFor'] = array_column($teams, 'name');

      // images
      $images = getImagesPlayer($this->playerID)->fetchAll(PDO::FETCH_ASSOC);
      $this->dataSet['images'] = array_column($images, 'source');
    }

  }
}

class Pitching extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getPitchingAggregate', 'getPitching');
    $this->setDataSetSize('getPitchingAggregateCount', 'getPitchingCount');
  }
}

class PitchingPost extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getPitchingPostAggregate', 'getPitchingPost');
    $this->setDataSetSize('getPitchingPostAggregateCount', 'getPitchingPostCount');
  }
}

class Batting extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getBattingAggregate', 'getBatting');
    $this->setDataSetSize('getBattingAggregateCount', 'getBattingCount');
  }
}

class BattingPost extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getBattingPostAggregate', 'getBattingPost');
    $this->setDataSetSize('getBattingPostAggregateCount', 'getBattingPostCount');
  }
}

class Fielding extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getFieldingAggregate', 'getFielding');
    $this->setDataSetSize('getFieldingAggregateCount', 'getFieldingCount');
  }
}

class FieldingPost extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getFieldingPostAggregate', 'getFieldingPost');
    $this->setDataSetSize('getFieldingPostAggregateCount', 'getFieldingPostCount');
  }
}

class FieldingOF extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getFieldingOFAggregate', 'getFieldingOF');
    $this->setDataSetSize('getFieldingOFAggregateCount', 'getFieldingOFCount');
  }
}

class FieldingOFSplit extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getFieldingOFSplitAggregate', 'getFieldingOFSplit');
    $this->setDataSetSize('getFieldingOFSplitAggregateCount', 'getFieldingOFSplitCount');
  }
}

class Appearances extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getAppearancesAggregate', 'getAppearances');
    $this->setDataSetSize('getAppearancesAggregateCount', 'getAppearancesCount');
  }
}

class Salaries extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getSalariesAggregate', 'getSalaries');
    $this->setDataSetSize('getSalariesAggregateCount', 'getSalariesCount');
  }
}

class Images extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getImages', 'getImages');
    $this->setDataSetSize('getImagesCount', 'getImagesCount');
  }
}

Class Colleges extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('getColleges', 'getColleges');
    $this->setDataSetSize('getCollegesCount', 'getCollegesCount');
  }
}


Class Teams extends Module {
  public function __construct() {
    parent::__construct();

    $parserTeams = new ParserTeams();

    // normal teams
    if ($parserTeams->getYear() == null) {
      $this->retrieveData('getTeamsAggregate', 'getTeams');
      $this->setDataSetSize('getTeamsAggregateCount', 'getTeamsCount');
    }

    // teams/year
    else if ($parserTeams->returnPlayers() == false) {
      $data = $this->db->getTeamYear($parserTeams->getYear());
      $this->dataSet = $data->fetch(PDO::FETCH_ASSOC);
      $this->dataSetSize = 1;
    }

    // teams/year/players
    else {
      $data = $this->db->getTeamYearPlayers($parserTeams->getYear());
      $this->dataSet = $data->fetchAll(PDO::FETCH_ASSOC);
      $this->dataSetSize = $this->db->getTeamYearPlayersCount($parserTeams->getYear());
    }

  }
}




class Search {
  private $query;
  private $perPage;
  private $dataSet;
  private $dataSetSize;
  private $page;
  private $offset;
  private $parser;
  private $db;

  public function __construct($newQuery) {
    $this->query = $newQuery;
    $this->parser = new Parser();
    $this->perPage = $this->parser->getPerPage();
    $this->page = $this->parser->getPage();
    $this->setOffset();

    $this->db = new DB(null, null, null, $this->perPage, $this->offset);
    $this->retrieveData();
    $this->setDataSetSize();
  }

  public function getQuery() {
    return $this->query;
  }

  public function getPerPage() {
    return $this->perPage;
  }

  public function getPage() {
    return $this->page;
  }

  private function retrieveData() {
    $data = $this->db->getPeopleSearch($this->query)->fetchAll(PDO::FETCH_ASSOC);

    // generate the player urls
    for ($count = 0; $count < count($data); $count++) {
      $data[$count]['urls'] = ApiFunctions::getPlayerModuleLinksArray($data[$count]['playerID']);
    }

    $this->dataSet = $data;
  }

  private function setDataSetSize() {
    $this->dataSetSize = $this->db->getPeopleSearchCount($this->query);
  }

  public function returnData() {
    $data = [];
    $data['pagination'] = $this->getPagination();
    $data['results'] = $this->dataSet;

    ApiFunctions::printJson($data);
  }

  public function getPagination() {
    $pagination         = new Pagination($this->dataSetSize);
    $links              = [];
    $links['first']     = $pagination->getPageFirst();
    $links['last']      = $pagination->getPageLast();
    $links['next']      = $pagination->getPageNext();

    return $links;
  }

  public function setOffset() {
    $this->offset = ($this->perPage) * ($this->page - 1);
  }

  public function getOffset() {
    return $this->offset;
  }
}

?>
