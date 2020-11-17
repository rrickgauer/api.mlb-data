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

    $this->db = new DB($this->playerID, $this->sorts, $this->filters, $this->perPage, $this->offset);

    $this->dataSet        = null;
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
      $this->dataSetSize = call_user_func($functionAggregate, $this->playerID, $this->sorts, $this->filters);
    else
      $this->dataSetSize = call_user_func($function, $this->playerID, $this->sorts, $this->filters);
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
    // if ($this->aggregate == true)
    //   $dataset = call_user_func($aggregateFunction, $this->playerID, $this->sorts, $this->filters, $this->perPage, $this->offset);
    // else 
    //   $dataset = call_user_func($function, $this->playerID, $this->sorts, $this->filters, $this->perPage, $this->offset);

    if ($this->aggregate == true)
      $dataset = call_user_func($aggregateFunction);
    else 
      $dataset = call_user_func($function);
    
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
    $this->retrieveData('$this->db->getPeople', '$this->db->getPeople');
    $this->setDataSetSize('$this->db->getPeopleCount', '$this->db->getPeopleCount');

    // add additional info if playerID is specified
    if ($this->playerID != null) {
      // teams played for
      $teams = $this->db->getTeamsPlayedFor($this->playerID)->fetchAll(PDO::FETCH_ASSOC);
      $this->dataSet['teamsPlayedFor'] = array_column($teams, 'name');

      // images
      $images = $this->db->getImagesPlayer($this->playerID)->fetchAll(PDO::FETCH_ASSOC);
      $this->dataSet['images'] = array_column($images, 'source');
    }

  }
}

class Pitching extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getPitchingAggregate', '$this->db->getPitching');
    $this->setDataSetSize('$this->db->getPitchingAggregateCount', '$this->db->getPitchingCount');
  }
}

class PitchingPost extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getPitchingPostAggregate', '$this->db->getPitchingPost');
    $this->setDataSetSize('$this->db->getPitchingPostAggregateCount', '$this->db->getPitchingPostCount');
  }
}

class Batting extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getBattingAggregate', '$this->db->getBatting');
    $this->setDataSetSize('$this->db->getBattingAggregateCount', '$this->db->getBattingCount');
  }
}

class BattingPost extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getBattingPostAggregate', '$this->db->getBattingPost');
    $this->setDataSetSize('$this->db->getBattingPostAggregateCount', '$this->db->getBattingPostCount');
  }
}

class Fielding extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getFieldingAggregate', '$this->db->getFielding');
    $this->setDataSetSize('$this->db->getFieldingAggregateCount', '$this->db->getFieldingCount');
  }
}

class FieldingPost extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getFieldingPostAggregate', '$this->db->getFieldingPost');
    $this->setDataSetSize('$this->db->getFieldingPostAggregateCount', '$this->db->getFieldingPostCount');
  }
}

class FieldingOF extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getFieldingOFAggregate', '$this->db->getFieldingOF');
    $this->setDataSetSize('$this->db->getFieldingOFAggregateCount', '$this->db->getFieldingOFCount');
  }
}

class FieldingOFSplit extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getFieldingOFSplitAggregate', '$this->db->getFieldingOFSplit');
    $this->setDataSetSize('$this->db->getFieldingOFSplitAggregateCount', '$this->db->getFieldingOFSplitCount');
  }
}

class Appearances extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getAppearancesAggregate', '$this->db->getAppearances');
    $this->setDataSetSize('$this->db->getAppearancesAggregateCount', '$this->db->getAppearancesCount');
  }
}

class Salaries extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getSalariesAggregate', '$this->db->getSalaries');
    $this->setDataSetSize('$this->db->getSalariesAggregateCount', '$this->db->getSalariesCount');
  }
}

class Images extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getImages', '$this->db->getImages');
    $this->setDataSetSize('$this->db->getImagesCount', '$this->db->getImagesCount');
  }
}

Class Colleges extends Module {
  public function __construct() {
    parent::__construct();
    $this->retrieveData('$this->db->getColleges', '$this->db->getColleges');
    $this->setDataSetSize('$this->db->getCollegesCount', '$this->db->getCollegesCount');
  }
}


Class Teams extends Module {
  public function __construct() {
    parent::__construct();

    $parserTeams = new ParserTeams();

    // normal teams
    if ($parserTeams->getYear() == null) {
      $this->retrieveData('$this->db->getTeamsAggregate', '$this->db->getTeams');
      $this->setDataSetSize('$this->db->getTeamsAggregateCount', '$this->db->getTeamsCount');
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
