<?php
/******************************************************************************************
 * This class contains all the functions that interact with the database.
 *
 * All the functions are static.
 *
 * Eventually, I would like to turn it into a non-static class so I dont have to pass in
 * the same parms every time
 *
 * Function list:
 * - dbConnect()
 * - getSqlStmt()
 * - getSqlStmtNoLimit()
 * - getFilterStmt()
 * - getOrderStmt()
 * - doesPlayerExist()
 * - getBatting()
 * - getBattingCount()
 * - getBattingAggregate()
 * - getBattingAggregateCount()
 * - getBattingPost()
 * - getBattingPostCount()
 * - getBattingPostAggregate()
 * - getBattingPostAggregateCount()
 * - getPitching()
 * - getPitchingCount()
 * - getPitchingAggregate()
 * - getPitchingAggregateCount()
 * - getPitchingPost()
 * - getPitchingPostCount()
 * - getPitchingPostAggregate()
 * - getPitchingPostAggregateCount()
 * - getFielding()
 * - getFieldingCount()
 * - getFieldingAggregate()
 * - getFieldingAggregateCount()
 * - getFieldingPost()
 * - getFieldingPostCount()
 * - getFieldingPostAggregate()
 * - getFieldingPostAggregateCount()
 * - getAppearances()
 * - getAppearancesCount()
 * - getAppearancesAggregate()
 * - getAppearancesAggregateCount()
 * - getFieldingOF()
 * - getFieldingOFCount()
 * - getFieldingOFAggregate()
 * - getFieldingOFAggregateCount()
 * - getFieldingOFSplit()
 * - getFieldingOFSplitCount()
 * - getFieldingOFSplitAggregate()
 * - getFieldingOFSplitAggregateCount()
 * - getSalaries()
 * - getSalariesCount()
 * - getSalariesAggregate()
 * - getSalariesAggregateCount()
 * - getPeople()
 * - getPeopleCount()
 * - getPeopleSearch()
 * - getPeopleSearchCount()
 * - getTeamsPlayedFor()
 * - getImages()
 * - getImagesCount()
 * - getImagesPlayer()
 * - getColleges()
 * - getCollegesCount()
*******************************************************************************/
include_once('Common-Structures.php');
include_once ('Constants.php');

class DB {

  private $playerID;
  private $sort;
  private $filters;
  private $limit;
  private $offset;

  public function __construct(
    $playerID = Constants::Defaults['playerID'],
    $sort     = Constants::Defaults['sort'],
    $filters  = Constants::Defaults['filters'],
    $limit    = Constants::Defaults['perPage'],
    $offset   = Constants::Defaults['offset'])
  {
    $this->playerID = $playerID;
    $this->sort     = $sort;
    $this->filters  = $filters;
    $this->limit    = $limit;
    $this->offset   = $offset;
  }



  private function dbConnect() {
    include('db-info.php');

    try {
      // connect to database
      $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      return $pdo;

    }
    catch(PDOexception $e) {
      return 0;
    }
  }

  private function getSqlStmt($stmt, $table, $groupByColumn) {
    // playerID is included and only want data for that player
    if ($this->playerID != null)
      $stmt .= " WHERE $table.playerID = :playerID ";

    $stmt .= " GROUP  BY $table.$groupByColumn ";
    $stmt .= $this->getFilterStmt();
    $stmt .= $this->getOrderStmt();
    $stmt .= " LIMIT  :limit OFFSET :offset ";

    $sql = $this->dbConnect()->prepare($stmt);

    // filter/bind playerID if it is set
    if ($this->playerID != null) {
      $this->playerID = filter_var($this->playerID, FILTER_SANITIZE_STRING);
      $sql->bindParam(':playerID', $this->playerID, PDO::PARAM_STR);
    }

    // limit
    $this->limit = filter_var($this->limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $this->limit, PDO::PARAM_INT);

    // offset
    $this->offset = filter_var($this->offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $this->offset, PDO::PARAM_INT);

    return $sql;
  }

  private function getSqlStmtNoLimit($stmt, $table, $groupByColumn) {
    if ($this->playerID != null)
      $stmt .= " WHERE $table.playerID = :playerID ";

    $stmt .= " GROUP  BY $table.$groupByColumn ";
    $stmt .= $this->getFilterStmt();
    $stmt .= " ) table1 ";
    $sql  = $this->dbConnect()->prepare($stmt);

    // filter/bind playerID if it is set
    if ($this->playerID != null) {
      $this->playerID = filter_var($this->playerID, FILTER_SANITIZE_STRING);
      $sql->bindParam(':playerID', $this->playerID, PDO::PARAM_STR);
    }
    return $sql;
  }

  private function getFilterStmt($tableName = '') {
    //return empty string if null
    if ($this->filters == null) {
      return '';
    }

    $stmt = ' HAVING ';

    for ($count = 0; $count < count($this->filters); $count++) {
      $filter      = $this->filters[$count];
      $column      = $filter['column'];
      $conditional = $filter['conditional'];
      $qualifier   = $filter['qualifier'];

      // if there is more than 1 filter, add an AND
      if ($count > 0)
        $stmt .= ' AND';

      $stmt = $stmt . " $tableName$column $conditional $qualifier";
    }

    return $stmt;
  }

  private function getOrderStmt() {
    if ($this->sort == null)
      return '';

    // build order by statement
    $orderStmt  = '';
    $this->sortColumn = $this->sort['column'];

    // determine asc or desc
    $this->sortType = strtoupper($this->sort['type']);
    if ($this->sortType != 'ASC')
      $this->sortType = 'DESC';

    // clean it
    $this->sortType = filter_var($this->sortType, FILTER_SANITIZE_STRING);

    $orderStmt = " ORDER BY $this->sortColumn $this->sortType ";

    return $orderStmt;
  }


  public function doesPlayerExist() {
    $stmt = '
    SELECT playerID
    FROM   people
    WHERE  playerID = :playerID
    LIMIT  1';

    $sql = $this->dbConnect()->prepare($stmt);

    $playerID = filter_var($this->playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) == 1)
      return true;
    else
      return false;
  }

  public function getBatting() {
    $stmt = "
    SELECT    b.playerID  AS playerID,
              p.nameFirst AS nameFirst,
              p.nameLast  AS nameLast,
              b.yearID    AS year,
              t.name      AS teamName,
              t.teamID    AS teamID,
              b.stint     AS stint,
              b.lgID      AS lgID,
              b.G         AS G,
              b.AB        AS AB,
              b.R         AS R,
              b.H         AS H,
              b.2B        AS 2B,
              b.3B        AS 3B,
              b.HR        AS HR,
              b.RBI       AS RBI,
              b.SB        AS SB,
              b.CS        AS CS,
              b.BB        AS BB,
              b.SO        AS SO,
              b.IBB       AS IBB,
              b.HBP       AS HBP,
              b.SH        AS SH,
              b.SF        AS SF,
              b.GIDP      AS GIDP
    FROM      batting b
    LEFT JOIN people p
    ON        b.playerID = p.playerID
    LEFT JOIN teams t
    ON        b.team_ID = t.ID ";

    $sql = $this->getSqlStmt($stmt, 'b', 'ID');
    $sql->execute();
    return $sql;
  }


  public function getBattingCount() {
    $stmt = "
    SELECT COUNT(*) AS count
    FROM   (
             SELECT    b.playerID  AS playerID,
                       p.nameFirst AS nameFirst,
                       p.nameLast  AS nameLast,
                       b.yearID    AS year,
                       t.name      AS teamName,
                       t.teamID    AS teamID,
                       b.stint     AS stint,
                       b.lgID      AS lgID,
                       b.G         AS G,
                       b.AB        AS AB,
                       b.R         AS R,
                       b.H         AS H,
                       b.2B        AS 2B,
                       b.3B        AS 3B,
                       b.HR        AS HR,
                       b.RBI       AS RBI,
                       b.SB        AS SB,
                       b.CS        AS CS,
                       b.BB        AS BB,
                       b.SO        AS SO,
                       b.IBB       AS IBB,
                       b.HBP       AS HBP,
                       b.SH        AS SH,
                       b.SF        AS SF,
                       b.GIDP      AS GIDP
             FROM      batting b
             LEFT JOIN people p
             ON        b.playerID = p.playerID
             LEFT JOIN teams t
             ON        b.team_ID = t.ID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'b', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getBattingAggregate() {
    $stmt = "
    SELECT    b.playerID,
              p.nameFirst,
              p.nameLast,
              (
                     SELECT COUNT(DISTINCT yearID)
                     FROM   batting b2
                     WHERE  b2.playerID = b.playerID) AS years,
              SUM(b.G)                                AS G,
              SUM(b.AB)                               AS AB,
              SUM(b.R)                                AS R,
              SUM(b.H)                                AS H,
              SUM(b.2B)                               AS 2B,
              SUM(b.3B)                               AS 3B,
              SUM(b.HR)                               AS HR,
              SUM(b.RBI)                              AS RBI,
              SUM(b.SB)                               AS SB,
              SUM(b.CS)                               AS CS,
              SUM(b.BB)                               AS BB,
              SUM(b.SO)                               AS SO,
              SUM(b.IBB)                              AS IBB,
              SUM(b.HBP)                              AS HBP,
              SUM(b.SH)                               AS SH,
              SUM(b.SF)                               AS SF,
              SUM(b.GIDP)                             AS GIDP
    FROM      batting b
    LEFT JOIN people p
    ON        b.playerID = p.playerID";

    $sql = $this->getSqlStmt($stmt, 'b', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getBattingAggregateCount() {

    $stmt = "
    SELECT COUNT(*) AS count
    FROM   (
           SELECT    b.playerID,
                     p.nameFirst,
                     p.nameLast,
                     (
                            SELECT COUNT(DISTINCT yearID)
                            FROM   batting b2
                            WHERE  b2.playerID = b.playerID) AS years,
                     SUM(b.G)                                AS G,
                     SUM(b.AB)                               AS AB,
                     SUM(b.R)                                AS R,
                     SUM(b.H)                                AS H,
                     SUM(b.2B)                               AS 2B,
                     SUM(b.3B)                               AS 3B,
                     SUM(b.HR)                               AS HR,
                     SUM(b.RBI)                              AS RBI,
                     SUM(b.SB)                               AS SB,
                     SUM(b.CS)                               AS CS,
                     SUM(b.BB)                               AS BB,
                     SUM(b.SO)                               AS SO,
                     SUM(b.IBB)                              AS IBB,
                     SUM(b.HBP)                              AS HBP,
                     SUM(b.SH)                               AS SH,
                     SUM(b.SF)                               AS SF,
                     SUM(b.GIDP)                             AS GIDP
           FROM      batting b
           LEFT JOIN people p
           ON        b.playerID = p.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'b', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }


  public function getBattingPost() {
    $stmt = "
    SELECT    b.playerID  AS playerID,
              p.nameFirst AS nameFirst,
              p.nameLast  AS nameLast,
              b.yearID    AS year,
              t.name      AS teamName,
              t.teamID    AS teamID,
              b.round     AS ROUND,
              b.lgID      AS lgID,
              b.G         AS G,
              b.AB        AS AB,
              b.R         AS R,
              b.H         AS H,
              b.2B        AS 2B,
              b.3B        AS 3B,
              b.HR        AS HR,
              b.RBI       AS RBI,
              b.SB        AS SB,
              b.CS        AS CS,
              b.BB        AS BB,
              b.SO        AS SO,
              b.IBB       AS IBB,
              b.HBP       AS HBP,
              b.SH        AS SH,
              b.SF        AS SF,
              b.GIDP      AS GIDP
    FROM      battingpost b
    LEFT JOIN people p
    ON        b.playerID = p.playerID
    LEFT JOIN teams t
    ON        b.team_ID = t.ID ";

    $sql = $this->getSqlStmt($stmt, 'b', 'ID');
    $sql->execute();
    return $sql;
  }


  public function getBattingPostCount() {
    $stmt = "
    SELECT COUNT(*) AS count
    FROM   (
             SELECT    b.playerID  AS playerID,
                       p.nameFirst AS nameFirst,
                       p.nameLast  AS nameLast,
                       b.yearID    AS year,
                       t.name      AS teamName,
                       t.teamID    AS teamID,
                       b.round     AS ROUND,
                       b.lgID      AS lgID,
                       b.G         AS G,
                       b.AB        AS AB,
                       b.R         AS R,
                       b.H         AS H,
                       b.2B        AS 2B,
                       b.3B        AS 3B,
                       b.HR        AS HR,
                       b.RBI       AS RBI,
                       b.SB        AS SB,
                       b.CS        AS CS,
                       b.BB        AS BB,
                       b.SO        AS SO,
                       b.IBB       AS IBB,
                       b.HBP       AS HBP,
                       b.SH        AS SH,
                       b.SF        AS SF,
                       b.GIDP      AS GIDP
             FROM      battingpost b
             LEFT JOIN people p
             ON        b.playerID = p.playerID
             LEFT JOIN teams t
             ON        b.team_ID = t.ID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'b', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }


  public function getBattingPostAggregate() {
    $stmt = "
    SELECT    b.playerID  AS playerID,
              p.nameFirst AS nameFirst,
              p.nameLast  AS nameLast,
              (
                     SELECT COUNT(DISTINCT yearID)
                     FROM   batting b2
                     WHERE  b2.playerID = b.playerID) AS years,
              SUM(b.G)                                AS G,
              SUM(b.AB)                               AS AB,
              SUM(b.R)                                AS R,
              SUM(b.H)                                AS H,
              SUM(b.2B)                               AS 2B,
              SUM(b.3B)                               AS 3B,
              SUM(b.HR)                               AS HR,
              SUM(b.RBI)                              AS RBI,
              SUM(b.SB)                               AS SB,
              SUM(b.CS)                               AS CS,
              SUM(b.BB)                               AS BB,
              SUM(b.SO)                               AS SO,
              SUM(b.IBB)                              AS IBB,
              SUM(b.HBP)                              AS HBP,
              SUM(b.SH)                               AS SH,
              SUM(b.SF)                               AS SF,
              SUM(b.GIDP)                             AS GIDP
    FROM      battingpost b
    LEFT JOIN people p
    ON        b.playerID = p.playerID ";

    $sql = $this->getSqlStmt($stmt, 'b', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getBattingPostAggregateCount() {
    $stmt = "
    SELECT COUNT(*) AS count
    FROM   (
             SELECT    b.playerID  AS playerID,
                       p.nameFirst AS nameFirst,
                       p.nameLast  AS nameLast,
                       (
                              SELECT COUNT(DISTINCT yearID)
                              FROM   batting b2
                              WHERE  b2.playerID = b.playerID) AS years,
                       SUM(b.G)                                AS G,
                       SUM(b.AB)                               AS AB,
                       SUM(b.R)                                AS R,
                       SUM(b.H)                                AS H,
                       SUM(b.2B)                               AS 2B,
                       SUM(b.3B)                               AS 3B,
                       SUM(b.HR)                               AS HR,
                       SUM(b.RBI)                              AS RBI,
                       SUM(b.SB)                               AS SB,
                       SUM(b.CS)                               AS CS,
                       SUM(b.BB)                               AS BB,
                       SUM(b.SO)                               AS SO,
                       SUM(b.IBB)                              AS IBB,
                       SUM(b.HBP)                              AS HBP,
                       SUM(b.SH)                               AS SH,
                       SUM(b.SF)                               AS SF,
                       SUM(b.GIDP)                             AS GIDP
             FROM      battingpost b
             LEFT JOIN people p
             ON        b.playerID = p.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'b', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];

  }

  public function getPitching() {
    $stmt = "
    SELECT      p.playerID as playerID,
                people.nameFirst as nameFirst,
                people.nameLast as nameLast,
                p.yearID as year,
                p.stint as stint,
                t.name as teamName,
                p.lgID as lgID,
                p.W as W,
                p.L as L,
                p.G as G,
                p.GS as GS,
                p.CG as CG,
                p.SHO as SHO,
                p.SV as SV,
                p.IPouts as IPouts,
                p.H as H,
                p.ER as ER,
                p.HR as HR,
                p.BB as BB,
                p.SO as SO,
                p.BAOpp as BAOpp,
                p.ERA as ERA,
                p.IBB as IBB,
                p.WP as WP,
                p.HBP as HBP,
                p.BK as BK,
                p.BFP as BFP,
                p.GF as GF,
                p.R as R,
                p.SH as SH,
                p.SF as SF,
                p.GIDP as GIDP
    FROM        pitching p
    LEFT JOIN   people on p.playerID = people.playerID
    LEFT JOIN   teams t on p.team_ID = t.ID";

    $sql = $this->getSqlStmt($stmt, 'p', 'ID');
    $sql->execute();
    return $sql;
  }

  public function getPitchingCount() {
    $stmt = "SELECT COUNT(*) AS count FROM (
    SELECT      p.playerID as playerID,
                people.nameFirst as nameFirst,
                people.nameLast as nameLast,
                p.yearID as year,
                p.stint as stint,
                t.name as teamName,
                p.lgID as lgID,
                p.W as W,
                p.L as L,
                p.G as G,
                p.GS as GS,
                p.CG as CG,
                p.SHO as SHO,
                p.SV as SV,
                p.IPouts as IPouts,
                p.H as H,
                p.ER as ER,
                p.HR as HR,
                p.BB as 'BB',
                p.SO as SO,
                p.BAOpp as BAOpp,
                p.ERA as ERA,
                p.IBB as IBB,
                p.WP as WP,
                p.HBP as HBP,
                p.BK as BK,
                p.BFP as BFP,
                p.GF as GF,
                p.R as R,
                p.SH as SH,
                p.SF as SF,
                p.GIDP as GIDP
    FROM        pitching p
    LEFT JOIN   people on p.playerID = people.playerID
    LEFT JOIN   teams t on p.team_ID = t.ID";

    $sql = $this->getSqlStmtNoLimit($stmt, 'p', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getPitchingAggregate() {
    $stmt = "
    SELECT      p.playerID,
                people.nameFirst,
                people.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM pitching p2 where p2.playerID = p.playerID) as years,
                SUM(p.W) AS W,
                SUM(p.L) AS L,
                SUM(p.G) AS G,
                SUM(p.GS) AS GS,
                SUM(p.CG) AS CG,
                SUM(p.SHO) AS SHO,
                SUM(p.SV) AS SV,
                SUM(p.IPouts) AS IPouts,
                SUM(p.H) AS H,
                SUM(p.ER) AS ER,
                SUM(p.HR) AS HR,
                SUM(p.BB) AS BB,
                SUM(p.SO) AS SO,
                SUM(p.BAOpp) AS BAOpp,
                ((SUM(p.ER) * 9) / (SUM(p.IPouts) / 3)) as ERA,
                SUM(p.IBB) AS IBB,
                SUM(p.WP) AS WP,
                SUM(p.HBP) AS HBP,
                SUM(p.BK) AS BK,
                SUM(p.BFP) AS BFP,
                SUM(p.GF) AS GF,
                SUM(p.R) AS R,
                SUM(p.SH) AS SH,
                SUM(p.SF) AS SF,
                SUM(p.GIDP) AS GIDP
    FROM        pitching p
    LEFT JOIN   people on p.playerID = people.playerID ";

    $sql = $this->getSqlStmt($stmt, 'p', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getPitchingAggregateCount() {
    $stmt = "SELECT COUNT(*) AS count FROM (
    SELECT      p.playerID,
                people.nameFirst,
                people.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM pitching p2 where p2.playerID = p.playerID) as years,
                SUM(p.W) AS W,
                SUM(p.L) AS L,
                SUM(p.G) AS G,
                SUM(p.GS) AS GS,
                SUM(p.CG) AS CG,
                SUM(p.SHO) AS SHO,
                SUM(p.SV) AS SV,
                SUM(p.IPouts) AS IPouts,
                SUM(p.H) AS H,
                SUM(p.ER) AS ER,
                SUM(p.HR) AS HR,
                SUM(p.BB) AS BB,
                SUM(p.SO) AS SO,
                SUM(p.BAOpp) AS BAOpp,
                ((SUM(p.ER) * 9) / (SUM(p.IPouts) / 3)) as ERA,
                SUM(p.IBB) AS IBB,
                SUM(p.WP) AS WP,
                SUM(p.HBP) AS HBP,
                SUM(p.BK) AS BK,
                SUM(p.BFP) AS BFP,
                SUM(p.GF) AS GF,
                SUM(p.R) AS R,
                SUM(p.SH) AS SH,
                SUM(p.SF) AS SF,
                SUM(p.GIDP) AS GIDP
    FROM        pitching p
    LEFT JOIN   people on p.playerID = people.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'p', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }


  public function getPitchingPost() {
    $stmt = "
    SELECT      p.playerID as playerID,
                people.nameFirst as nameFirst,
                people.nameLast as nameLast,
                p.yearID as year,
                p.round as round,
                t.name as teamName,
                p.lgID as lgID,
                p.W as W,
                p.L as L,
                p.G as G,
                p.GS as GS,
                p.CG as CG,
                p.SHO as SHO,
                p.SV as SV,
                p.IPouts as IPouts,
                p.H as H,
                p.ER as ER,
                p.HR as HR,
                p.BB as BB,
                p.SO as SO,
                p.BAOpp as BAOpp,
                p.ERA as ERA,
                p.IBB as IBB,
                p.WP as WP,
                p.HBP as HBP,
                p.BK as BK,
                p.BFP as BFP,
                p.GF as GF,
                p.R as R,
                p.SH as SH,
                p.SF as SF,
                p.GIDP as GIDP
    FROM        pitchingpost p
    LEFT JOIN   people on p.playerID = people.playerID
    LEFT JOIN   teams t on p.team_ID = t.ID";

    $sql = $this->getSqlStmt($stmt, 'p', 'ID');
    $sql->execute();
    return $sql;
  }

  public function getPitchingPostCount() {
    $stmt = " SELECT COUNT(*) AS count from (
    SELECT      p.playerID as playerID,
                people.nameFirst as nameFirst,
                people.nameLast as nameLast,
                p.yearID as year,
                p.round as round,
                t.name as teamName,
                p.lgID as lgID,
                p.W as W,
                p.L as L,
                p.G as G,
                p.GS as GS,
                p.CG as CG,
                p.SHO as SHO,
                p.SV as SV,
                p.IPouts as IPouts,
                p.H as H,
                p.ER as ER,
                p.HR as HR,
                p.BB as BB,
                p.SO as SO,
                p.BAOpp as BAOpp,
                p.ERA as ERA,
                p.IBB as IBB,
                p.WP as WP,
                p.HBP as HBP,
                p.BK as BK,
                p.BFP as BFP,
                p.GF as GF,
                p.R as R,
                p.SH as SH,
                p.SF as SF,
                p.GIDP as GIDP
    FROM        pitchingpost p
    LEFT JOIN   people on p.playerID = people.playerID
    LEFT JOIN   teams t on p.team_ID = t.ID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'p', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getPitchingPostAggregate() {
    $stmt = "
    SELECT      p.playerID,
                people.nameFirst,
                people.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM pitching p2 where p2.playerID = p.playerID) as years,
                SUM(p.W) AS W,
                SUM(p.L) AS L,
                SUM(p.G) AS G,
                SUM(p.GS) AS GS,
                SUM(p.CG) AS CG,
                SUM(p.SHO) AS SHO,
                SUM(p.SV) AS SV,
                SUM(p.IPouts) AS IPouts,
                SUM(p.H) AS H,
                SUM(p.ER) AS ER,
                SUM(p.HR) AS HR,
                SUM(p.BB) AS BB,
                SUM(p.SO) AS SO,
                SUM(p.BAOpp) AS BAOpp,
                ((SUM(p.ER) * 9) / (SUM(p.IPouts) / 3)) as ERA,
                SUM(p.IBB) AS IBB,
                SUM(p.WP) AS WP,
                SUM(p.HBP) AS HBP,
                SUM(p.BK) AS BK,
                SUM(p.BFP) AS BFP,
                SUM(p.GF) AS GF,
                SUM(p.R) AS R,
                SUM(p.SH) AS SH,
                SUM(p.SF) AS SF,
                SUM(p.GIDP) AS GIDP
    FROM        pitchingpost p
    LEFT JOIN   people on p.playerID = people.playerID";

    $sql = $this->getSqlStmt($stmt, 'p', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getPitchingPostAggregateCount() {
    $stmt = " SELECT COUNT(*) AS count from (
    SELECT      p.playerID,
                people.nameFirst,
                people.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM pitching p2 where p2.playerID = p.playerID) as years,
                SUM(p.W) AS W,
                SUM(p.L) AS L,
                SUM(p.G) AS G,
                SUM(p.GS) AS GS,
                SUM(p.CG) AS CG,
                SUM(p.SHO) AS SHO,
                SUM(p.SV) AS SV,
                SUM(p.IPouts) AS IPouts,
                SUM(p.H) AS H,
                SUM(p.ER) AS ER,
                SUM(p.HR) AS HR,
                SUM(p.BB) AS BB,
                SUM(p.SO) AS SO,
                SUM(p.BAOpp) AS BAOpp,
                ((SUM(p.ER) * 9) / (SUM(p.IPouts) / 3)) as ERA,
                SUM(p.IBB) AS IBB,
                SUM(p.WP) AS WP,
                SUM(p.HBP) AS HBP,
                SUM(p.BK) AS BK,
                SUM(p.BFP) AS BFP,
                SUM(p.GF) AS GF,
                SUM(p.R) AS R,
                SUM(p.SH) AS SH,
                SUM(p.SF) AS SF,
                SUM(p.GIDP) AS GIDP
    FROM        pitchingpost p
    LEFT JOIN   people on p.playerID = people.playerID";

    $sql = $this->getSqlStmtNoLimit($stmt, 'p', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getFielding() {
    $stmt = "
    SELECT f.playerID,
           p.nameFirst,
           p.nameLast,
           f.yearID AS year,
           f.stint,
           t.name   AS teamName,
           f.lgID,
           f.POS,
           f.G,
           f.GS,
           f.InnOuts,
           f.PO,
           f.A,
           f.E,
           f.DP,
           f.PB,
           f.WP,
           f.SB,
           f.CS,
           f.ZR
    FROM   fielding f
           LEFT JOIN people p
                  ON f.playerID = p.playerID
           LEFT JOIN teams t
                  ON f.team_ID = t.ID ";

    $sql = $this->getSqlStmt($stmt, 'f', 'ID');

    $sql->execute();
    return $sql;
  }

  public function getFieldingCount() {
    $stmt = "
    SELECT COUNT(*) AS count
    FROM   (
             SELECT    f.playerID,
                       p.nameFirst,
                       p.nameLast,
                       f.yearID AS year,
                       f.stint,
                       t.name AS teamName,
                       f.lgID,
                       f.POS,
                       f.G,
                       f.GS,
                       f.InnOuts,
                       f.PO,
                       f.A,
                       f.E,
                       f.DP,
                       f.PB,
                       f.WP,
                       f.SB,
                       f.CS,
                       f.ZR
             FROM      fielding f
             LEFT JOIN people p
             ON        f.playerID = p.playerID
             LEFT JOIN teams t
             ON        f.team_ID = t.ID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'f', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getFieldingAggregate() {
    $stmt = "
    SELECT f.playerID                        AS playerID,
           p.nameFirst                       AS nameFirst,
           p.nameLast                        AS nameLast,
           (SELECT COUNT(DISTINCT yearID)
            FROM   fielding f2
            WHERE  f2.playerID = f.playerID) AS years,
           SUM(f.G)                          AS G,
           SUM(f.GS)                         AS GS,
           SUM(f.InnOuts)                    AS InnOuts,
           SUM(f.PO)                         AS PO,
           SUM(f.A)                          AS A,
           SUM(f.E)                          AS E,
           SUM(f.DP)                         AS DP,
           SUM(f.PB)                         AS PB,
           SUM(f.WP)                         AS WP,
           SUM(f.SB)                         AS SB,
           SUM(f.CS)                         AS CS,
           SUM(f.ZR)                         AS ZR
    FROM   fielding f
           LEFT JOIN people p
                  ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmt($stmt, 'f', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getFieldingAggregateCount() {

    $stmt = " SELECT COUNT(*) AS count FROM (
    SELECT f.playerID                        AS playerID,
           p.nameFirst                       AS nameFirst,
           p.nameLast                        AS nameLast,
           (SELECT COUNT(DISTINCT yearID)
            FROM   fielding f2
            WHERE  f2.playerID = f.playerID) AS years,
           SUM(f.G)                          AS G,
           SUM(f.GS)                         AS GS,
           SUM(f.InnOuts)                    AS InnOuts,
           SUM(f.PO)                         AS PO,
           SUM(f.A)                          AS A,
           SUM(f.E)                          AS E,
           SUM(f.DP)                         AS DP,
           SUM(f.PB)                         AS PB,
           SUM(f.WP)                         AS WP,
           SUM(f.SB)                         AS SB,
           SUM(f.CS)                         AS CS,
           SUM(f.ZR)                         AS ZR
    FROM   fielding f
           LEFT JOIN people p
                  ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'f', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];

  }

  public function getFieldingPost() {
    $stmt = "
    SELECT f.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           f.yearID    AS year,
           f.round     AS round,
           t.name      AS teamName,
           t.teamID    AS teamID,
           f.lgID      AS lgID,
           f.POS       AS POS,
           f.G         AS G,
           f.GS        AS GS,
           f.InnOuts   AS InnOuts,
           f.PO        AS PO,
           f.A         AS A,
           f.E         AS E,
           f.DP        AS DP,
           f.PB        AS PB,
           f.SB        AS SB,
           f.CS        AS CS
    FROM   fieldingpost f
           LEFT JOIN people p
                  ON f.playerID = p.playerID
           LEFT JOIN teams t
                  ON f.team_ID = t.ID ";

    $sql = $this->getSqlStmt($stmt, 'f', 'ID');
    $sql->execute();
    return $sql;
  }

  public function getFieldingPostCount() {
    $stmt = " SELECT COUNT(*) AS count FROM (
    SELECT f.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           f.yearID    AS year,
           f.round     AS round,
           t.name      AS teamName,
           t.teamID    AS teamID,
           f.lgID      AS lgID,
           f.POS       AS POS,
           f.G         AS G,
           f.GS        AS GS,
           f.InnOuts   AS InnOuts,
           f.PO        AS PO,
           f.A         AS A,
           f.E         AS E,
           f.DP        AS DP,
           f.PB        AS PB,
           f.SB        AS SB,
           f.CS        AS CS
    FROM   fieldingpost f
           LEFT JOIN people p
                  ON f.playerID = p.playerID
           LEFT JOIN teams t
                  ON f.team_ID = t.ID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'f', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getFieldingPostAggregate() {
    $stmt = "
    SELECT f.playerID                        AS playerID,
           p.nameFirst                       AS nameFirst,
           p.nameLast                        AS nameLast,
           (SELECT COUNT(DISTINCT yearID)
            FROM   fielding f2
            WHERE  f2.playerID = f.playerID) AS years,
           SUM(f.G)                          AS G,
           SUM(f.GS)                         AS GS,
           SUM(f.InnOuts)                    AS InnOuts,
           SUM(f.PO)                         AS PO,
           SUM(f.A)                          AS A,
           SUM(f.E)                          AS E,
           SUM(f.DP)                         AS DP,
           SUM(f.PB)                         AS PB,
           SUM(f.SB)                         AS SB,
           SUM(f.CS)                         AS CS
    FROM   fieldingpost f
           LEFT JOIN people p
                  ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmt($stmt, 'f', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getFieldingPostAggregateCount() {
    $stmt = " SELECT COUNT(*) AS count FROM (
    SELECT f.playerID                        AS playerID,
           p.nameFirst                       AS nameFirst,
           p.nameLast                        AS nameLast,
           (SELECT COUNT(DISTINCT yearID)
            FROM   fielding f2
            WHERE  f2.playerID = f.playerID) AS years,
           SUM(f.G)                          AS G,
           SUM(f.GS)                         AS GS,
           SUM(f.InnOuts)                    AS InnOuts,
           SUM(f.PO)                         AS PO,
           SUM(f.A)                          AS A,
           SUM(f.E)                          AS E,
           SUM(f.DP)                         AS DP,
           SUM(f.PB)                         AS PB,
           SUM(f.SB)                         AS SB,
           SUM(f.CS)                         AS CS
    FROM   fieldingpost f
           LEFT JOIN people p
                  ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'f', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }


  public function getAppearances() {
    $stmt = "
    SELECT a.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           a.yearID    AS year,
           t.name      AS teamName,
           t.teamID    AS teamID,
           a.lgID      AS lgID,
           a.G_all     AS G_all,
           a.GS        AS GS,
           a.G_batting AS G_batting,
           a.G_defense AS G_defense,
           a.G_p       AS G_p,
           a.G_c       AS G_c,
           a.G_1b      AS G_1b,
           a.G_2b      AS G_2b,
           a.G_3b      AS G_3b,
           a.G_ss      AS G_ss,
           a.G_lf      AS G_lf,
           a.G_cf      AS G_cf,
           a.G_rf      AS G_rf,
           a.G_of      AS G_of,
           a.G_dh      AS G_dh,
           a.G_ph      AS G_ph,
           a.G_pr      AS G_pr
    FROM   appearances a
           LEFT JOIN people p
                  ON a.playerID = p.playerID
           LEFT JOIN teams t
                  ON a.team_ID = t.ID ";

    $sql = $this->getSqlStmt($stmt, 'a', 'ID');
    $sql->execute();
    return $sql;
  }

  public function getAppearancesCount() {
    $stmt = " SELECT COUNT(*) AS count FROM (
    SELECT a.yearID AS year,
           t.name   AS teamName,
           t.teamID AS teamID,
           a.lgID as lgID,
           a.playerID as playerID,
           p.nameFirst as nameFirst,
           p.nameLast as nameLast,
           a.G_all as G_all,
           a.GS as GS,
           a.G_batting as G_batting,
           a.G_defense as G_defense,
           a.G_p as G_p,
           a.G_c as G_c,
           a.G_1b as G_1b,
           a.G_2b as G_2b,
           a.G_3b as G_3b,
           a.G_ss as G_ss,
           a.G_lf as G_lf,
           a.G_cf as G_cf,
           a.G_rf as G_rf,
           a.G_of as G_of,
           a.G_dh as G_dh,
           a.G_ph as G_ph,
           a.G_pr as G_pr
    FROM   appearances a
           LEFT JOIN people p
                  ON a.playerID = p.playerID
           LEFT JOIN teams t
                  ON a.team_ID = t.ID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'a', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getAppearancesAggregate() {
    $stmt = "
    SELECT a.playerID                        AS playerID,
           p.nameFirst                       AS nameFirst,
           p.nameLast                        AS nameLast,
           (SELECT COUNT(DISTINCT yearID)
            FROM   appearances a2
            WHERE  a2.playerID = a.playerID) AS years,
           SUM(a.G_all)                      AS G_all,
           SUM(a.GS)                         AS GS,
           SUM(a.G_batting)                  AS G_batting,
           SUM(a.G_defense)                  AS G_defense,
           SUM(a.G_p)                        AS G_p,
           SUM(a.G_c)                        AS G_c,
           SUM(a.G_1b)                       AS G_1b,
           SUM(a.G_2b)                       AS G_2b,
           SUM(a.G_3b)                       AS G_3b,
           SUM(a.G_ss)                       AS G_ss,
           SUM(a.G_lf)                       AS G_lf,
           SUM(a.G_cf)                       AS G_cf,
           SUM(a.G_rf)                       AS G_rf,
           SUM(a.G_of)                       AS G_of,
           SUM(a.G_dh)                       AS G_dh,
           SUM(a.G_ph)                       AS G_ph,
           SUM(a.G_pr)                       AS G_pr
    FROM   appearances a
           LEFT JOIN people p
                  ON a.playerID = p.playerID ";

    $sql = $this->getSqlStmt($stmt, 'a', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getAppearancesAggregateCount() {
    $stmt = " SELECT COUNT(*) AS count FROM (
    SELECT a.playerID                        AS playerID,
           p.nameFirst                       AS nameFirst,
           p.nameLast                        nameLast,
           (SELECT COUNT(DISTINCT yearID)
            FROM   appearances a2
            WHERE  a2.playerID = a.playerID) AS years,
           SUM(a.G_all)                      AS G_all,
           SUM(a.GS)                         AS GS,
           SUM(a.G_batting)                  AS G_batting,
           SUM(a.G_defense)                  AS G_defense,
           SUM(a.G_p)                        AS G_p,
           SUM(a.G_c)                        AS G_c,
           SUM(a.G_1b)                       AS G_1b,
           SUM(a.G_2b)                       AS G_2b,
           SUM(a.G_3b)                       AS G_3b,
           SUM(a.G_ss)                       AS G_ss,
           SUM(a.G_lf)                       AS G_lf,
           SUM(a.G_cf)                       AS G_cf,
           SUM(a.G_rf)                       AS G_rf,
           SUM(a.G_of)                       AS G_of,
           SUM(a.G_dh)                       AS G_dh,
           SUM(a.G_ph)                       AS G_ph,
           SUM(a.G_pr)                       AS G_pr
    FROM   appearances a
           LEFT JOIN people p
                  ON a.playerID = p.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'a', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getFieldingOF() {
    $stmt = "
    SELECT f.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           f.yearID    AS year,
           f.stint     AS stint,
           f.Glf       AS Glf,
           f.Gcf       AS Gcf,
           f.Grf       AS Grf
    FROM   fieldingof f
           LEFT JOIN people p
                  ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmt($stmt, 'f', 'ID');
    $sql->execute();
    return $sql;
  }

  public function getFieldingOFCount() {
    $stmt = " SELECT COUNT(*) AS count FROM (
    SELECT f.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           f.yearID    AS year,
           f.stint     AS stint,
           f.Glf       AS Glf,
           f.Gcf       AS Gcf,
           f.Grf       AS Grf
    FROM   fieldingof f
           LEFT JOIN people p
                  ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'f', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];

  }

  public function getFieldingOFAggregate() {
    $stmt = "
    SELECT f.playerID                        AS playerID,
           p.nameFirst                       AS nameFirst,
           p.nameLast                        AS nameLast,
           (SELECT COUNT(DISTINCT yearID)
            FROM   fieldingof f2
            WHERE  f2.playerID = f.playerID) AS years,
           SUM(f.Glf)                        AS Glf,
           SUM(f.Gcf)                        AS Gcf,
           SUM(f.Grf)                        AS Grf
    FROM   fieldingof f
           LEFT JOIN people p
                  ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmt($stmt, 'f', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getFieldingOFAggregateCount() {
    $stmt = "SELECT COUNT(*) AS count FROM (
    SELECT    f.playerID,
              p.nameFirst,
              p.nameLast,
              (SELECT COUNT(DISTINCT yearID) FROM fieldingof f2 where f2.playerID = f.playerID) as years,
              SUM(f.Glf) AS Glf,
              SUM(f.Gcf) AS Gcf,
              SUM(f.Grf) AS Grf
    FROM      fieldingof f
    LEFT JOIN people p ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'f', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getFieldingOFSplit() {
    $stmt = "
    SELECT f.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           f.yearID    AS year,
           f.stint     AS stint,
           t.name      AS teamName,
           t.teamID    AS teamID,
           f.lgID      AS lgID,
           f.POS       AS POS,
           f.G         AS G,
           f.GS        AS GS,
           f.InnOuts   AS InnOuts,
           f.PO        AS PO,
           f.A         AS A,
           f.E         AS E,
           f.DP        AS DP,
           f.PB        AS PB,
           f.WP        AS WP,
           f.SB        AS SB,
           f.CS        AS CS,
           f.ZR        AS ZR
    FROM   fieldingofsplit f
           LEFT JOIN people p
                  ON f.playerID = p.playerID
           LEFT JOIN teams t
                  ON f.team_ID = t.ID ";

    $sql = $this->getSqlStmt($stmt, 'f', 'ID');
    $sql->execute();
    return $sql;
  }

  public function getFieldingOFSplitCount() {
    $stmt = " SELECT COUNT(*) AS count FROM (
    SELECT f.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           f.yearID    AS year,
           f.stint     AS stint,
           t.name      AS teamName,
           t.teamID    AS teamID,
           f.lgID      AS lgID,
           f.POS       AS POS,
           f.G         AS G,
           f.GS        AS GS,
           f.InnOuts   AS InnOuts,
           f.PO        AS PO,
           f.A         AS A,
           f.E         AS E,
           f.DP        AS DP,
           f.PB        AS PB,
           f.WP        AS WP,
           f.SB        AS SB,
           f.CS        AS CS,
           f.ZR        AS ZR
    FROM   fieldingofsplit f
           LEFT JOIN people p
                  ON f.playerID = p.playerID
           LEFT JOIN teams t
                  ON f.team_ID = t.ID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'f', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];

  }

  public function getFieldingOFSplitAggregate() {
    $stmt = "
    SELECT f.playerID                        AS playerID,
           p.nameFirst                       AS nameFirst,
           p.nameLast                        AS nameLast,
           (SELECT COUNT(DISTINCT yearID)
            FROM   fieldingofsplit f2
            WHERE  f2.playerID = f.playerID) AS years,
           SUM(f.G)                          AS G,
           SUM(f.GS)                         AS GS,
           SUM(f.InnOuts)                    AS InnOuts,
           SUM(f.PO)                         AS PO,
           SUM(f.A)                          AS A,
           SUM(f.E)                          AS E,
           SUM(f.DP)                         AS DP,
           SUM(f.PB)                         AS PB,
           SUM(f.WP)                         AS WP,
           SUM(f.SB)                         AS SB,
           SUM(f.CS)                         AS CS,
           SUM(f.ZR)                         AS ZR
    FROM   fieldingofsplit f
           LEFT JOIN people p
                  ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmt($stmt, 'f', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getFieldingOFSplitAggregateCount() {
    $stmt = "SELECT COUNT(*) AS count FROM (
    SELECT f.playerID                        AS playerID,
           p.nameFirst                       AS nameFirst,
           p.nameLast                        AS nameLast,
           (SELECT COUNT(DISTINCT yearID)
            FROM   fieldingofsplit f2
            WHERE  f2.playerID = f.playerID) AS years,
           SUM(f.G)                          AS G,
           SUM(f.GS)                         AS GS,
           SUM(f.InnOuts)                    AS InnOuts,
           SUM(f.PO)                         AS PO,
           SUM(f.A)                          AS A,
           SUM(f.E)                          AS E,
           SUM(f.DP)                         AS DP,
           SUM(f.PB)                         AS PB,
           SUM(f.WP)                         AS WP,
           SUM(f.SB)                         AS SB,
           SUM(f.CS)                         AS CS,
           SUM(f.ZR)                         AS ZR
    FROM   fieldingofsplit f
           LEFT JOIN people p
                  ON f.playerID = p.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'f', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getSalaries() {
    $stmt = "
    SELECT s.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           s.yearID    AS year,
           t.name      AS teamName,
           t.teamID    AS teamID,
           s.lgID      AS lgID,
           s.salary    AS salary
    FROM   salaries s
           LEFT JOIN people p
                  ON s.playerID = p.playerID
           LEFT JOIN teams t
                  ON s.team_ID = t.ID ";

    $sql = $this->getSqlStmt($stmt, 's', 'ID');
    $sql->execute();
    return $sql;
  }

  public function getSalariesCount() {
    $stmt = "SELECT COUNT(*) AS count FROM (
    SELECT      s.playerID,
                p.nameFirst,
                p.nameLast,
                s.yearID as year,
                t.name as teamName,
                t.teamID    AS teamID,
                s.lgID,
                s.salary
    FROM        salaries s
    LEFT JOIN   people p ON s.playerID = p.playerID
    LEFT JOIN   teams t on s.team_ID = t.ID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 's', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getSalariesAggregate() {
    $stmt = "
    SELECT      s.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM salaries s2 where s2.playerID = s.playerID) as years,
                SUM(s.salary) AS salary
    FROM        salaries s
    LEFT JOIN   people p ON s.playerID = p.playerID ";

    $sql = $this->getSqlStmt($stmt, 's', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getSalariesAggregateCount() {
    $stmt = "SELECT COUNT(*) AS count FROM (
    SELECT      s.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM salaries s2 where s2.playerID = s.playerID) as years,
                SUM(s.salary) AS salary
    FROM        salaries s
    LEFT JOIN   people p ON s.playerID = p.playerID ";

    $sql = $this->getSqlStmtNoLimit($stmt, 's', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getPeople() {
    $stmt = "
    SELECT p.playerID                      AS playerID,
           p.nameFirst                     AS nameFirst,
           p.nameLast                      AS nameLast,
           p.nameGiven                     AS nameGiven,
           p.birthCountry                  AS birthCountry,
           p.birthState                    AS birthState,
           p.birthCity                     AS birthCity,
           p.deathCountry                  AS deathCountry,
           p.deathState                    AS deathState,
           p.deathCity                     AS deathCity,
           p.weight                        AS weight,
           p.height                        AS height,
           p.bats                          AS bats,
           p.throws                        AS throws,
           p.retroID                       AS retroID,
           CONCAT('https://www.baseball-reference.com/players/', SUBSTR(p.bbrefID, 1, 1), '/', p.bbrefID, '.shtml')                       AS bbrefLink,
           p.birth_date                    AS birthDate,
           p.debut_date                    AS debuteDate,
           p.finalgame_date                AS finalGameDate,
           p.death_date                    AS deathDate,
           (SELECT t.name
            FROM   appearances a
                   LEFT JOIN teams t
                          ON a.team_ID = t.ID
            WHERE  a.playerID = p.playerID
            GROUP  BY a.ID
            ORDER  BY a.yearID DESC
            LIMIT  1)                      AS team,
           (SELECT i.source
            FROM   images i
            WHERE  i.playerID = p.playerID
            LIMIT  1)                      AS image,
           IF ((SELECT h.inducted
                FROM   halloffame h
                WHERE  h.playerID = p.playerID
                LIMIT  1) = 'Y', 'y', 'n') AS hallOfFame
    FROM   people p ";

    $sql = $this->getSqlStmt($stmt, 'p', 'playerID');
    $sql->execute();
    return $sql;
  }

  public function getPeopleCount() {
    $stmt = "SELECT COUNT(*) AS count FROM (
    SELECT  p.playerID,
            p.nameFirst,
            p.nameLast,
            p.nameGiven,
            p.birthCountry,
            p.birthState,
            p.birthCity,
            p.deathCountry,
            p.deathState,
            p.deathCity,
            p.weight,
            p.height,
            p.bats,
            p.throws,
            p.retroID,
            CONCAT('https://www.baseball-reference.com/players/', SUBSTR(p.bbrefID, 1, 1), '/', p.bbrefID, '.shtml') as bbrefLink,
            p.birth_date as birthDate,
            p.debut_date as debuteDate,
            p.finalgame_date as finalGameDate,
            p.death_date as deathDate,
            (select t.name from appearances a left join teams t on a.team_ID = t.ID where a.playerID = p.playerID group by a.ID order by a.yearID desc limit 1) as team,
            (select i.source from images i where i.playerID = p.playerID limit 1) as image,
            if ((select h.inducted from halloffame h where h.playerID = p.playerID limit 1) = 'Y', 'y', 'n') as hallOfFame
    FROM    people p ";

    $sql = $this->getSqlStmtNoLimit($stmt, 'p', 'playerID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getPeopleSearch($query = '') {

    $stmt = "
    SELECT    MATCH(nameFirst, nameLast) against(:query IN boolean mode) as score,
              p.playerID as playerID,
              p.nameFirst as nameFirst,
              p.nameLast as nameLast,
              p.birth_date as birthDate,
              p.debut_date as debutDate,
              p.finalgame_date as finalGameDate,
              p.death_date as deathDate
    FROM      people p
    WHERE     MATCH(nameFirst, nameLast) against(:query IN boolean mode) > 0
    GROUP BY  playerID
    HAVING    score > 0
    ORDER BY  score DESC, playerID ASC
    LIMIT     :limit
    OFFSET    :offset";

    $sql = $this->dbConnect()->prepare($stmt);

    // filter and bind query
    $query = '(' . $query . '*)';
    $query = filter_var($query, FILTER_SANITIZE_STRING);
    $sql->bindParam(':query', $query, PDO::PARAM_STR);

    // limit
    $limit = filter_var($this->limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($this->offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();

    return $sql;
  }

  public function getPeopleSearchCount($query = '') {
    $stmt = "SELECT COUNT(*) AS count FROM (
    SELECT    p.playerID as playerID
    FROM      people p
    WHERE     MATCH(nameFirst, nameLast) against(:query IN boolean mode) > 0
    GROUP BY  playerID) table1";

    $sql = $this->dbConnect()->prepare($stmt);

    // filter and bind query
    $query = '(' . $query . '*)';
    $query = filter_var($query, FILTER_SANITIZE_STRING);
    $sql->bindParam(':query', $query, PDO::PARAM_STR);

    $sql->execute();
    $results = $sql->fetch(PDO::FETCH_ASSOC);
    return $results['count'];
  }

  public function getTeamsPlayedFor() {
    $stmt = 'SELECT distinct t.name from appearances a left join teams t on a.team_ID = t.ID where a.playerID = :playerID group by a.ID';
    $sql = $this->dbConnect()->prepare($stmt);

    $playerID = filter_var($this->playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();
    return $sql;
  }


  public function getImages() {

    $stmt = '
    SELECT      i.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                i.source as source
    FROM        images i
    LEFT JOIN   people p on i.playerID = p.playerID ';

    $sql = $this->getSqlStmt($stmt, 'i', 'ID');
    $sql->execute();
    return $sql;
  }

  public function getImagesCount() {
    $stmt = 'SELECT COUNT(*) AS count FROM (
    SELECT      i.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                i.source as source
    FROM        images i
    LEFT JOIN   people p on i.playerID = p.playerID ';

    $sql = $this->getSqlStmtNoLimit($stmt, 'i', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getImagesPlayer() {

    $stmt = '
    SELECT    i.source
    FROM      images i
    WHERE     i.playerID = :playerID
    GROUP BY  i.ID';

    $sql = $this->dbConnect()->prepare($stmt);

    // filter and bind player ID
    $playerID = filter_var($this->playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();
    return $sql;
  }


  public function getColleges() {
    $stmt = '
    SELECT      cp.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                cp.yearID as year,
                s.name_full as schoolName,
                s.city as schoolCity,
                s.state as schoolState,
                s.country as schoolCountry
    from        collegeplaying cp
    LEFT JOIN   people p on cp.playerID = p.playerID
    LEFT JOIN   schools s on cp.schoolID = s.schoolID';

    $sql = $this->getSqlStmt($stmt, 'cp', 'ID');
    $sql->execute();
    return $sql;
  }

  public function getCollegesCount() {
    $stmt = 'SELECT COUNT(*) AS count FROM (
    SELECT      cp.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                cp.yearID as year,
                s.name_full as schoolName,
                s.city as schoolCity,
                s.state as schoolState,
                s.country as schoolCountry
    from        collegeplaying cp
    LEFT JOIN   people p on cp.playerID = p.playerID
    LEFT JOIN   schools s on cp.schoolID = s.schoolID ';

    $sql = $this->getSqlStmtNoLimit($stmt, 'cp', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }

  public function getTeams() {

    $stmt = '
    SELECT t.teamID         AS teamID,
           t.name           AS teamName,
           t.yearID         AS year,
           t.lgID           AS lgID,
           t.franchID       AS franchID,
           t.divID          AS divID,
           t.div_ID         AS div_ID,
           t.teamRank       AS teamRank,
           t.G              AS G,
           t.Ghome          AS Ghome,
           t.W              AS W,
           t.L              AS L,
           t.DivWin         AS DivWin,
           t.WCWin          AS WCWin,
           t.LgWin          AS LgWin,
           t.WSWin          AS WSWin,
           t.R              AS R,
           t.AB             AS AB,
           t.H              AS H,
           t.2B             AS 2B,
           t.3B             AS 3B,
           t.HR             AS HR,
           t.BB             AS BB,
           t.SO             AS SO,
           t.SB             AS SB,
           t.CS             AS CS,
           t.HBP            AS HBP,
           t.SF             AS SF,
           t.RA             AS RA,
           t.ER             AS ER,
           t.ERA            AS ERA,
           t.CG             AS CG,
           t.SHO            AS SHO,
           t.SV             AS SV,
           t.IPouts         AS IPouts,
           t.HA             AS HA,
           t.HRA            AS HRA,
           t.BBA            AS BBA,
           t.SOA            AS SOA,
           t.E              AS E,
           t.DP             AS DP,
           t.FP             AS FP,
           t.park           AS park,
           t.attendance     AS attendance,
           t.BPF            AS BPF,
           t.PPF            AS PPF,
           t.teamIDBR       AS teamIDBR,
           i.source         as image,
           t.teamIDlahman45 AS teamIDlahman45,
           t.teamIDretro    AS teamIDretro
    FROM   teams t
    LEFT JOIN imagesteams i on t.teamID = i.teamID ';


    $sql = $this->getSqlStmtTeams($stmt, 't', 'ID');
    $sql->execute();

    return $sql;

  }


  public function getTeamsCount() {
    $stmt = 'SELECT COUNT(*) AS count FROM (
    SELECT t.name           AS teamName,
           t.yearID         AS year,
           t.lgID           AS lgID,
           t.teamID         AS teamID,
           t.franchID       AS franchID,
           t.divID          AS divID,
           t.div_ID         AS div_ID,
           t.teamRank       AS teamRank,
           t.G              AS G,
           t.Ghome          AS Ghome,
           t.W              AS W,
           t.L              AS L,
           t.DivWin         AS DivWin,
           t.WCWin          AS WCWin,
           t.LgWin          AS LgWin,
           t.WSWin          AS WSWin,
           t.R              AS R,
           t.AB             AS AB,
           t.H              AS H,
           t.2B             AS 2B,
           t.3B             AS 3B,
           t.HR             AS HR,
           t.BB             AS BB,
           t.SO             AS SO,
           t.SB             AS SB,
           t.CS             AS CS,
           t.HBP            AS HBP,
           t.SF             AS SF,
           t.RA             AS RA,
           t.ER             AS ER,
           t.ERA            AS ERA,
           t.CG             AS CG,
           t.SHO            AS SHO,
           t.SV             AS SV,
           t.IPouts         AS IPouts,
           t.HA             AS HA,
           t.HRA            AS HRA,
           t.BBA            AS BBA,
           t.SOA            AS SOA,
           t.E              AS E,
           t.DP             AS DP,
           t.FP             AS FP,
           t.park           AS park,
           t.attendance     AS attendance,
           t.BPF            AS BPF,
           t.PPF            AS PPF,
           t.teamIDBR       AS teamIDBR,
           t.teamIDlahman45 AS teamIDlahman45,
           t.teamIDretro    AS teamIDretro
    FROM   teams t ';

    $sql = $this->getSqlStmtNoLimitTeams($stmt, 't', 'ID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }


  public function getTeamsAggregate() {

    $stmt = '
    SELECT t.teamID              AS teamID,
    (SELECT name FROM teams t2 WHERE t2.teamID = t.teamID ORDER BY t2.yearID DESC LIMIT 1) as teamName,
    (SELECT COUNT(DISTINCT yearID) FROM teams t2 where t2.teamID = t.teamID) as years,
    SUM(t.G)              AS G,
    SUM(t.Ghome)          AS Ghome,
    SUM(t.W)              AS W,
    SUM(t.L)              AS L,
    (SELECT COUNT(ID) FROM teams t2 where t2.DivWin = "Y" and t2.teamID = t.teamID) AS DivWin,
    (SELECT COUNT(ID) FROM teams t2 where t2.WCWin =  "Y" and t2.teamID = t.teamID) AS WCWin,
    (SELECT COUNT(ID) FROM teams t2 where t2.LgWin =  "Y" and t2.teamID = t.teamID) AS LgWin,
    (SELECT COUNT(ID) FROM teams t2 where t2.WSWin =  "Y" and t2.teamID = t.teamID) AS WSWin,
    SUM(t.R)              AS R,
    SUM(t.AB)             AS AB,
    SUM(t.H)              AS H,
    SUM(t.2B)             AS 2B,
    SUM(t.3B)             AS 3B,
    SUM(t.HR)             AS HR,
    SUM(t.BB)             AS BB,
    SUM(t.SO)             AS SO,
    SUM(t.SB)             AS SB,
    SUM(t.CS)             AS CS,
    SUM(t.HBP)            AS HBP,
    SUM(t.SF)             AS SF,
    SUM(t.RA)             AS RA,
    SUM(t.ER)             AS ER,
    SUM(t.ERA)            AS ERA,
    SUM(t.CG)             AS CG,
    SUM(t.SHO)            AS SHO,
    SUM(t.SV)             AS SV,
    SUM(t.IPouts)         AS IPouts,
    SUM(t.HA)             AS HA,
    SUM(t.HRA)            AS HRA,
    SUM(t.BBA)            AS BBA,
    SUM(t.SOA)            AS SOA,
    SUM(t.E)              AS E,
    SUM(t.DP)             AS DP,
    SUM(t.FP)             AS FP,
    SUM(t.park)           AS park,
    SUM(t.attendance)     AS attendance,
    SUM(t.BPF)            AS BPF,
    SUM(t.PPF)            AS PPF,
    i.source              AS image
    FROM   teams t
    LEFT JOIN imagesteams i on t.teamID = i.teamID ';


    $sql = $this->getSqlStmtTeams($stmt, 't', 'teamID');
    $sql->execute();

    return $sql;

  }

  public function getTeamsAggregateCount() {
    $stmt = 'SELECT COUNT(*) AS count FROM (
    SELECT t.teamID       AS teamID,
    (SELECT name FROM teams t2 WHERE t2.teamID = t.teamID ORDER BY t2.yearID DESC LIMIT 1) as teamName,
    (SELECT COUNT(DISTINCT yearID) FROM teams t2 WHERE t2.teamID = t.teamID) as years,
    SUM(t.G)              AS G,
    SUM(t.Ghome)          AS Ghome,
    SUM(t.W)              AS W,
    SUM(t.L)              AS L,
    (SELECT COUNT(ID) FROM teams t2 WHERE t2.DivWin = "Y" and t2.teamID = t.teamID) AS DivWin,
    (SELECT COUNT(ID) FROM teams t2 WHERE t2.WCWin =  "Y" and t2.teamID = t.teamID) AS WCWin,
    (SELECT COUNT(ID) FROM teams t2 WHERE t2.LgWin =  "Y" and t2.teamID = t.teamID) AS LgWin,
    (SELECT COUNT(ID) FROM teams t2 WHERE t2.WSWin =  "Y" and t2.teamID = t.teamID) AS WSWin,
    SUM(t.R)              AS R,
    SUM(t.AB)             AS AB,
    SUM(t.H)              AS H,
    SUM(t.2B)             AS 2B,
    SUM(t.3B)             AS 3B,
    SUM(t.HR)             AS HR,
    SUM(t.BB)             AS BB,
    SUM(t.SO)             AS SO,
    SUM(t.SB)             AS SB,
    SUM(t.CS)             AS CS,
    SUM(t.HBP)            AS HBP,
    SUM(t.SF)             AS SF,
    SUM(t.RA)             AS RA,
    SUM(t.ER)             AS ER,
    SUM(t.ERA)            AS ERA,
    SUM(t.CG)             AS CG,
    SUM(t.SHO)            AS SHO,
    SUM(t.SV)             AS SV,
    SUM(t.IPouts)         AS IPouts,
    SUM(t.HA)             AS HA,
    SUM(t.HRA)            AS HRA,
    SUM(t.BBA)            AS BBA,
    SUM(t.SOA)            AS SOA,
    SUM(t.E)              AS E,
    SUM(t.DP)             AS DP,
    SUM(t.FP)             AS FP,
    SUM(t.park)           AS park,
    SUM(t.attendance)     AS attendance,
    SUM(t.BPF)            AS BPF,
    SUM(t.PPF)            AS PPF
    FROM   teams t ';

    $sql = $this->getSqlStmtNoLimitTeams($stmt, 't', 'teamID');
    $sql->execute();
    $results = $sql->fetch();
    return $results['count'];
  }


  private function getSqlStmtTeams($stmt, $table, $groupByColumn) {
    // playerID is included and only want data for that player
    if ($this->playerID != null)
      $stmt .= " WHERE $table.teamID = :playerID ";

    $stmt .= " GROUP  BY $table.$groupByColumn ";
    $stmt .= $this->getFilterStmt();
    $stmt .= $this->getOrderStmt();
    $stmt .= " LIMIT  :limit OFFSET :offset ";

    $sql = $this->dbConnect()->prepare($stmt);

    // filter/bind playerID if it is set
    if ($this->playerID != null) {
      $playerID = filter_var($this->playerID, FILTER_SANITIZE_STRING);
      $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);
    }

    // limit
    $limit = filter_var($this->limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($this->offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    return $sql;
  }

  private function getSqlStmtNoLimitTeams($stmt, $table, $groupByColumn) {
    if ($this->playerID != null)
      $stmt .= " WHERE $table.teamID = :playerID ";

    $stmt .= " GROUP  BY $table.$groupByColumn ";
    $stmt .= $this->getFilterStmt();
    $stmt .= " ) table1 ";
    $sql  = $this->dbConnect()->prepare($stmt);

    // filter/bind playerID if it is set
    if ($this->playerID != null) {
      $playerID = filter_var($this->playerID, FILTER_SANITIZE_STRING);
      $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);
    }
    return $sql;
  }


   public function getTeamYear($year) {

    $stmt = '
    SELECT t.teamID         AS teamID,
           t.name           AS teamName,
           t.yearID         AS year,
           t.lgID           AS lgID,
           t.franchID       AS franchID,
           t.divID          AS divID,
           t.div_ID         AS div_ID,
           t.teamRank       AS teamRank,
           t.G              AS G,
           t.Ghome          AS Ghome,
           t.W              AS W,
           t.L              AS L,
           t.DivWin         AS DivWin,
           t.WCWin          AS WCWin,
           t.LgWin          AS LgWin,
           t.WSWin          AS WSWin,
           t.R              AS R,
           t.AB             AS AB,
           t.H              AS H,
           t.2B             AS 2B,
           t.3B             AS 3B,
           t.HR             AS HR,
           t.BB             AS BB,
           t.SO             AS SO,
           t.SB             AS SB,
           t.CS             AS CS,
           t.HBP            AS HBP,
           t.SF             AS SF,
           t.RA             AS RA,
           t.ER             AS ER,
           t.ERA            AS ERA,
           t.CG             AS CG,
           t.SHO            AS SHO,
           t.SV             AS SV,
           t.IPouts         AS IPouts,
           t.HA             AS HA,
           t.HRA            AS HRA,
           t.BBA            AS BBA,
           t.SOA            AS SOA,
           t.E              AS E,
           t.DP             AS DP,
           t.FP             AS FP,
           t.park           AS park,
           t.attendance     AS attendance,
           t.BPF            AS BPF,
           t.PPF            AS PPF,
           t.teamIDBR       AS teamIDBR,
           t.teamIDlahman45 AS teamIDlahman45,
           t.teamIDretro    AS teamIDretro
    FROM   teams t
    WHERE t.teamID = :teamID
    AND   t.yearID = :yearID ';

    $sql = $this->dbConnect()->prepare($stmt);

    $teamID = filter_var($this->playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':teamID', $teamID, PDO::PARAM_STR);

    $year = filter_var($year, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':yearID', $year, PDO::PARAM_INT);

    $sql->execute();
    return $sql;
   }

  public function getTeamYearPlayers($year) {

    $stmt = "
    SELECT a.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           t.teamID    AS teamID,
           t.name      AS teamName,
           a.yearID    AS year,
           a.G_all     AS G_all,
           a.GS        AS GS,
           a.G_batting AS G_batting,
           a.G_defense AS G_defense,
           a.G_p       AS G_p,
           a.G_c       AS G_c,
           a.G_1b      AS G_1b,
           a.G_2b      AS G_2b,
           a.G_3b      AS G_3b,
           a.G_ss      AS G_ss,
           a.G_lf      AS G_lf,
           a.G_cf      AS G_cf,
           a.G_rf      AS G_rf,
           a.G_of      AS G_of,
           a.G_dh      AS G_dh,
           a.G_ph      AS G_ph,
           a.G_pr      AS G_pr
    FROM   appearances a
           LEFT JOIN people p
                  ON a.playerID = p.playerID
           LEFT JOIN teams t
                  ON a.team_ID = t.ID
    WHERE  team_ID IN (SELECT ID AS team_id
                       FROM   teams
                       WHERE  yearID = :yearID
                       AND    teamID = :teamID)
    GROUP  BY a.ID ";

    $stmt .= $this->getFilterStmt();
    $stmt .= $this->getOrderStmt();


    $sql = $this->dbConnect()->prepare($stmt);

    $teamID = $this->playerID;

    $teamID = filter_var($teamID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':teamID', $teamID, PDO::PARAM_STR);

    $year = filter_var($year, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':yearID', $year, PDO::PARAM_INT);

    $sql->execute();
    return $sql;
  }

  public function getTeamYearPlayersCount($year) {

    $stmt = "SELECT COUNT(*) AS count FROM (
    SELECT a.playerID  AS playerID,
           p.nameFirst AS nameFirst,
           p.nameLast  AS nameLast,
           a.G_all     AS G_all,
           a.GS        AS GS,
           a.G_batting AS G_batting,
           a.G_defense AS G_defense,
           a.G_p       AS G_p,
           a.G_c       AS G_c,
           a.G_1b      AS G_1b,
           a.G_2b      AS G_2b,
           a.G_3b      AS G_3b,
           a.G_ss      AS G_ss,
           a.G_lf      AS G_lf,
           a.G_cf      AS G_cf,
           a.G_rf      AS G_rf,
           a.G_of      AS G_of,
           a.G_dh      AS G_dh,
           a.G_ph      AS G_ph,
           a.G_pr      AS G_pr
    FROM   appearances a
           LEFT JOIN people p
                  ON a.playerID = p.playerID
    WHERE  team_ID IN (SELECT ID AS team_id
                       FROM   teams
                       WHERE  yearID = :yearID
                       AND    teamID = :teamID)
    GROUP  BY a.ID ";

    $stmt .= $this->getFilterStmt();
    $stmt .= $this->getOrderStmt();

    $stmt .= ") tbl2";

    $sql = $this->dbConnect()->prepare($stmt);

    $teamID = filter_var($this->playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':teamID', $teamID, PDO::PARAM_STR);

    $year = filter_var($year, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':yearID', $year, PDO::PARAM_INT);

    $sql->execute();

    $results = $sql->fetch(PDO::FETCH_ASSOC);

    return $results['count'];
  }


}

?>
