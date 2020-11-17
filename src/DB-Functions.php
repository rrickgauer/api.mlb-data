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
include_once ('Constants.php');

class DB {

  public static function dbConnect() {
    include ('db-info.php');

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

  public static function getSqlStmt($stmt, $table, $groupByColumn, $playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {


    // playerID is included and only want data for that player
    if ($playerID != null) 
      $stmt .= " WHERE $table.playerID = :playerID ";

    $stmt .= " GROUP  BY $table.$groupByColumn ";
    $stmt .= DB::getFilterStmt($filters);
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit OFFSET :offset ";

    $sql = DB::dbConnect()->prepare($stmt);

    // filter/bind playerID if it is set
    if ($playerID != null) {
      $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
      $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);
    }

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    return $sql;
  }

  public static function getSqlStmtNoLimit($stmt, $table, $groupByColumn, $playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    if ($playerID != null) 
      $stmt .= " WHERE $table.playerID = :playerID ";

    $stmt .= " GROUP  BY $table.$groupByColumn ";
    $stmt .= DB::getFilterStmt($filters);
    $stmt .= " ) table1 ";
    $sql  = DB::dbConnect()->prepare($stmt);

    // filter/bind playerID if it is set
    if ($playerID != null) {
      $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
      $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);
    }
    return $sql;
  }

  public static function getFilterStmt($filters, $tableName = '') {
    //return empty string if null
    if ($filters == null) {
      return '';
    }

    $stmt = ' HAVING ';

    for ($count = 0; $count < count($filters); $count++) {
      $filter      = $filters[$count];
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

  public static function getOrderStmt($sort) {
    if ($sort == null) return '';

    // build order by statement
    $orderStmt  = '';
    // $sortColumn = filter_var($sort['column'], FILTER_SANITIZE_STRING);
    $sortColumn = $sort['column'];

    // determine asc or desc
    $sortType = strtoupper($sort['type']);
    if ($sortType != 'ASC') 
      $sortType = 'DESC';

    // clean it
    $sortType = filter_var($sortType, FILTER_SANITIZE_STRING);

    $orderStmt = " ORDER BY $sortColumn $sortType ";

    return $orderStmt;
  }


  public static function doesPlayerExist($playerID) {
    $stmt = '
    SELECT playerID
    FROM   people
    WHERE  playerID = :playerID
    LIMIT  1';

    $sql = DB::dbConnect()->prepare($stmt);

    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) == 1) return true;
    else return false;
  }

  public static function getBatting($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      b.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                b.yearID as year,
                t.name as teamName,
                b.stint as stint,
                b.lgID as lgID,
                b.G as G,
                b.AB as AB,
                b.R as R,
                b.H as H,
                b.2B as 2B,
                b.3B as 3B,
                b.HR as HR,
                b.RBI as RBI,
                b.SB as SB,
                b.CS as CS,
                b.BB as BB,
                b.SO as SO,
                b.IBB as IBB,
                b.HBP as HBP,
                b.SH as SH,
                b.SF as SF,
                b.GIDP as GIDP
    FROM        batting b
    LEFT JOIN   people p ON b.playerID = p.playerID
    LEFT JOIN   teams t on b.team_ID = t.ID";

    $sql = DB::getSqlStmt($stmt, 'b', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }


  public static function getBattingCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "
    SELECT count(*) as count FROM (
      SELECT      b.playerID as playerID,
                  p.nameFirst as nameFirst,
                  p.nameLast as nameLast,
                  b.yearID as year,
                  t.name as teamName,
                  b.stint as stint,
                  b.lgID as lgID,
                  b.G as G,
                  b.AB as AB,
                  b.R as R,
                  b.H as H,
                  b.2B as 2B,
                  b.3B as 3B,
                  b.HR as HR,
                  b.RBI as RBI,
                  b.SB as SB,
                  b.CS as CS,
                  b.BB as BB,
                  b.SO as SO,
                  b.IBB as IBB,
                  b.HBP as HBP,
                  b.SH as SH,
                  b.SF as SF,
                  b.GIDP as GIDP
      FROM        batting b
      LEFT JOIN   people p ON b.playerID = p.playerID
      LEFT JOIN   teams t on b.team_ID = t.ID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'b', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getBattingAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      b.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM batting b2 where b2.playerID = b.playerID) as years,
                SUM(b.G) AS G,
                SUM(b.AB) AS AB,
                SUM(b.R) AS R,
                SUM(b.H) AS H,
                SUM(b.2B) AS 2B,
                SUM(b.3B) AS 3B,
                SUM(b.HR) AS HR,
                SUM(b.RBI) AS RBI,
                SUM(b.SB) AS SB,
                SUM(b.CS) AS CS,
                SUM(b.BB) AS BB,
                SUM(b.SO) AS SO,
                SUM(b.IBB) AS IBB,
                SUM(b.HBP) AS HBP,
                SUM(b.SH) AS SH,
                SUM(b.SF) AS SF,
                SUM(b.GIDP) AS GIDP
    FROM        batting b
    LEFT JOIN   people p
    ON          b.playerID = p.playerID";

    $sql = DB::getSqlStmt($stmt, 'b', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getBattingAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {

    $stmt = " SELECT COUNT(*) AS count FROM (
    SELECT      b.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM batting b2 where b2.playerID = b.playerID) as years,
                SUM(b.G) AS G,
                SUM(b.AB) AS AB,
                SUM(b.R) AS R,
                SUM(b.H) AS H,
                SUM(b.2B) AS 2B,
                SUM(b.3B) AS 3B,
                SUM(b.HR) AS HR,
                SUM(b.RBI) AS RBI,
                SUM(b.SB) AS SB,
                SUM(b.CS) AS CS,
                SUM(b.BB) AS BB,
                SUM(b.SO) AS SO,
                SUM(b.IBB) AS IBB,
                SUM(b.HBP) AS HBP,
                SUM(b.SH) AS SH,
                SUM(b.SF) AS SF,
                SUM(b.GIDP) AS GIDP
    FROM        batting b
    LEFT JOIN   people p
    ON          b.playerID = p.playerID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'b', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }


  public function getBattingPost($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      b.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                b.yearID as year,
                t.name as teamName,
                b.round as round,
                b.lgID as lgID,
                b.G as G,
                b.AB as AB,
                b.R as R,
                b.H as H,
                b.2B as 2B,
                b.3B as 3B,
                b.HR as HR,
                b.RBI as RBI,
                b.SB as SB,
                b.CS as CS,
                b.BB as BB,
                b.SO as SO,
                b.IBB as IBB,
                b.HBP as HBP,
                b.SH as SH,
                b.SF as SF,
                b.GIDP as GIDP
    FROM        battingpost b
    LEFT JOIN   people p ON b.playerID = p.playerID
    LEFT JOIN   teams t on b.team_ID = t.ID";

    $sql = DB::getSqlStmt($stmt, 'b', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }


  public static function getBattingPostCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "SELECT COUNT(*) as count FROM (
    SELECT      b.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                b.yearID as year,
                t.name as teamName,
                b.round as round,
                b.lgID as lgID,
                b.G as G,
                b.AB as AB,
                b.R as R,
                b.H as H,
                b.2B as 2B,
                b.3B as 3B,
                b.HR as HR,
                b.RBI as RBI,
                b.SB as SB,
                b.CS as CS,
                b.BB as BB,
                b.SO as SO,
                b.IBB as IBB,
                b.HBP as HBP,
                b.SH as SH,
                b.SF as SF,
                b.GIDP as GIDP
    FROM        battingpost b
    LEFT JOIN   people p ON b.playerID = p.playerID
    LEFT JOIN   teams t on b.team_ID = t.ID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'b', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }


  public static function getBattingPostAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      b.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM batting b2 where b2.playerID = b.playerID) as years,
                SUM(b.G) AS G,
                SUM(b.AB) AS AB,
                SUM(b.R) AS R,
                SUM(b.H) AS H,
                SUM(b.2B) AS 2B,
                SUM(b.3B) AS 3B,
                SUM(b.HR) AS HR,
                SUM(b.RBI) AS RBI,
                SUM(b.SB) AS SB,
                SUM(b.CS) AS CS,
                SUM(b.BB) AS BB,
                SUM(b.SO) AS SO,
                SUM(b.IBB) AS IBB,
                SUM(b.HBP) AS HBP,
                SUM(b.SH) AS SH,
                SUM(b.SF) AS SF,
                SUM(b.GIDP) AS GIDP
    FROM        battingpost b
    LEFT JOIN   people p
    ON          b.playerID = p.playerID";

    $sql = DB::getSqlStmt($stmt, 'b', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getBattingPostAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "SELECT COUNT(*) as count FROM (
    SELECT      b.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM batting b2 where b2.playerID = b.playerID) as years,
                SUM(b.G) AS G,
                SUM(b.AB) AS AB,
                SUM(b.R) AS R,
                SUM(b.H) AS H,
                SUM(b.2B) AS 2B,
                SUM(b.3B) AS 3B,
                SUM(b.HR) AS HR,
                SUM(b.RBI) AS RBI,
                SUM(b.SB) AS SB,
                SUM(b.CS) AS CS,
                SUM(b.BB) AS BB,
                SUM(b.SO) AS SO,
                SUM(b.IBB) AS IBB,
                SUM(b.HBP) AS HBP,
                SUM(b.SH) AS SH,
                SUM(b.SF) AS SF,
                SUM(b.GIDP) AS GIDP
    FROM        battingpost b
    LEFT JOIN   people p
    ON          b.playerID = p.playerID";

    $sql = DB::getSqlStmtNoLimit($stmt, 'b', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];

  }

  public static function getPitching($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
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

    $sql = DB::getSqlStmt($stmt, 'p', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getPitchingCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "SELECT COUNT(*) as count FROM (
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

    $sql = DB::getSqlStmtNoLimit($stmt, 'p', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getPitchingAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
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

    $sql = DB::getSqlStmt($stmt, 'p', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getPitchingAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "SELECT COUNT(*) as count FROM (
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

    $sql = DB::getSqlStmtNoLimit($stmt, 'p', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }


  public static function getPitchingPost($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
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

    $sql = DB::getSqlStmt($stmt, 'p', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getPitchingPostCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = " SELECT count(*) as count from (
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

    $sql = DB::getSqlStmtNoLimit($stmt, 'p', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getPitchingPostAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
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

    $sql = DB::getSqlStmt($stmt, 'p', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getPitchingPostAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = " SELECT count(*) as count from (
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

    $sql = DB::getSqlStmtNoLimit($stmt, 'p', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getFielding($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      f.playerID,
                p.nameFirst,
                p.nameLast,
                f.yearID as year,
                f.stint,
                t.name as teamName,
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
    FROM        fielding f 
    LEFT JOIN   people p ON f.playerID = p.playerID
    LEFT JOIN   teams t on f.team_ID = t.ID ";

    $sql = DB::getSqlStmt($stmt, 'f', 'ID', $playerID, $sort, $filters, $limit, $offset);

    $sql->execute();
    return $sql;
  }

  public static function getFieldingCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = " SELECT count(*) as count from (
    SELECT      f.playerID,
                p.nameFirst,
                p.nameLast,
                f.yearID as year,
                f.stint,
                t.name as teamName,
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
    FROM        fielding f 
    LEFT JOIN   people p ON f.playerID = p.playerID
    LEFT JOIN   teams t on f.team_ID = t.ID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'f', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getFieldingAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      f.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM fielding f2 where f2.playerID = f.playerID) as years,
                SUM(f.G) as G,
                SUM(f.GS) as GS,
                SUM(f.InnOuts) as InnOuts,
                SUM(f.PO) as PO,
                SUM(f.A) as A,
                SUM(f.E) as E,
                SUM(f.DP) as DP,
                SUM(f.PB) as PB,
                SUM(f.WP) as WP,
                SUM(f.SB) as SB,
                SUM(f.CS) as CS,
                SUM(f.ZR) as ZR
    FROM        fielding f 
    LEFT JOIN   people p ON f.playerID = p.playerID";

    $sql = DB::getSqlStmt($stmt, 'f', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getFieldingAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {

    $stmt = " SELECT COUNT(*) as count FROM (
    SELECT      f.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM fielding f2 where f2.playerID = f.playerID) as years,
                SUM(f.G) as G,
                SUM(f.GS) as GS,
                SUM(f.InnOuts) as InnOuts,
                SUM(f.PO) as PO,
                SUM(f.A) as A,
                SUM(f.E) as E,
                SUM(f.DP) as DP,
                SUM(f.PB) as PB,
                SUM(f.WP) as WP,
                SUM(f.SB) as SB,
                SUM(f.CS) as CS,
                SUM(f.ZR) as ZR
    FROM        fielding f 
    LEFT JOIN   people p ON f.playerID = p.playerID";

    $sql = DB::getSqlStmtNoLimit($stmt, 'f', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];

  }

  public static function getFieldingPost($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      f.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                f.yearID as year,
                f.round as round,
                t.name as teamName,
                f.lgID as lgID,
                f.POS as POS,
                f.G as G,
                f.GS as GS,
                f.InnOuts as InnOuts,
                f.PO as PO,
                f.A as A,
                f.E as E,
                f.DP as DP,
                f.PB as PB,
                f.SB as SB,
                f.CS as CS
    FROM        fieldingpost f 
    LEFT JOIN   people p ON f.playerID = p.playerID
    LEFT JOIN   teams t on f.team_ID = t.ID ";

    $sql = DB::getSqlStmt($stmt, 'f', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getFieldingPostCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = " SELECT COUNT(*) as count FROM (
    SELECT      f.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                f.yearID as year,
                f.round as round,
                t.name as teamName,
                f.lgID as lgID,
                f.POS as POS,
                f.G as G,
                f.GS as GS,
                f.InnOuts as InnOuts,
                f.PO as PO,
                f.A as A,
                f.E as E,
                f.DP as DP,
                f.PB as PB,
                f.SB as SB,
                f.CS as CS
    FROM        fieldingpost f 
    LEFT JOIN   people p ON f.playerID = p.playerID
    LEFT JOIN   teams t on f.team_ID = t.ID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'f', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getFieldingPostAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      f.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM fielding f2 where f2.playerID = f.playerID) as years,
                SUM(f.G) as G,
                SUM(f.GS) as GS,
                SUM(f.InnOuts) as InnOuts,
                SUM(f.PO) as PO,
                SUM(f.A) as A,
                SUM(f.E) as E,
                SUM(f.DP) as DP,
                SUM(f.PB) as PB,
                SUM(f.SB) as SB,
                SUM(f.CS) as CS
    FROM        fieldingpost f 
    LEFT JOIN   people p ON f.playerID = p.playerID";

    $sql = DB::getSqlStmt($stmt, 'f', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getFieldingPostAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = " SELECT COUNT(*) as count FROM (
    SELECT      f.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM fielding f2 where f2.playerID = f.playerID) as years,
                SUM(f.G) as G,
                SUM(f.GS) as GS,
                SUM(f.InnOuts) as InnOuts,
                SUM(f.PO) as PO,
                SUM(f.A) as A,
                SUM(f.E) as E,
                SUM(f.DP) as DP,
                SUM(f.PB) as PB,
                SUM(f.SB) as SB,
                SUM(f.CS) as CS
    FROM        fieldingpost f 
    LEFT JOIN   people p ON f.playerID = p.playerID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'f', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }


  public static function getAppearances($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      a.yearID as year,
                t.name as teamName,
                a.lgID,
                a.playerID,
                p.nameFirst,
                p.nameLast,
                a.G_all,
                a.GS,
                a.G_batting,
                a.G_defense,
                a.G_p,
                a.G_c,
                a.G_1b,
                a.G_2b,
                a.G_3b,
                a.G_ss,
                a.G_lf,
                a.G_cf,
                a.G_rf,
                a.G_of,
                a.G_dh,
                a.G_ph,
                a.G_pr
    FROM        appearances a 
    LEFT JOIN   people p ON a.playerID = p.playerID
    LEFT JOIN   teams t on a.team_ID = t.ID ";

    $sql = DB::getSqlStmt($stmt, 'a', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getAppearancesCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = " SELECT COUNT(*) as count FROM (
    SELECT      a.yearID as year,
                t.name as teamName,
                a.lgID,
                a.playerID,
                p.nameFirst,
                p.nameLast,
                a.G_all,
                a.GS,
                a.G_batting,
                a.G_defense,
                a.G_p,
                a.G_c,
                a.G_1b,
                a.G_2b,
                a.G_3b,
                a.G_ss,
                a.G_lf,
                a.G_cf,
                a.G_rf,
                a.G_of,
                a.G_dh,
                a.G_ph,
                a.G_pr
    FROM        appearances a 
    LEFT JOIN   people p ON a.playerID = p.playerID
    LEFT JOIN   teams t on a.team_ID = t.ID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'a', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getAppearancesAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      a.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM appearances a2 where a2.playerID = a.playerID) as years,
                SUM(a.G_all) AS G_all,
                SUM(a.GS) AS GS,
                SUM(a.G_batting) AS G_batting,
                SUM(a.G_defense) AS G_defense,
                SUM(a.G_p) AS G_p,
                SUM(a.G_c) AS G_c,
                SUM(a.G_1b) AS G_1b,
                SUM(a.G_2b) AS G_2b,
                SUM(a.G_3b) AS G_3b,
                SUM(a.G_ss) AS G_ss,
                SUM(a.G_lf) AS G_lf,
                SUM(a.G_cf) AS G_cf,
                SUM(a.G_rf) AS G_rf,
                SUM(a.G_of) AS G_of,
                SUM(a.G_dh) AS G_dh,
                SUM(a.G_ph) AS G_ph,
                SUM(a.G_pr) AS G_pr
    FROM        appearances a 
    LEFT JOIN   people p ON a.playerID = p.playerID ";

    $sql = DB::getSqlStmt($stmt, 'a', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getAppearancesAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = " SELECT COUNT(*) as count FROM (
    SELECT      a.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM appearances a2 where a2.playerID = a.playerID) as years,
                SUM(a.G_all) AS G_all,
                SUM(a.GS) AS GS,
                SUM(a.G_batting) AS G_batting,
                SUM(a.G_defense) AS G_defense,
                SUM(a.G_p) AS G_p,
                SUM(a.G_c) AS G_c,
                SUM(a.G_1b) AS G_1b,
                SUM(a.G_2b) AS G_2b,
                SUM(a.G_3b) AS G_3b,
                SUM(a.G_ss) AS G_ss,
                SUM(a.G_lf) AS G_lf,
                SUM(a.G_cf) AS G_cf,
                SUM(a.G_rf) AS G_rf,
                SUM(a.G_of) AS G_of,
                SUM(a.G_dh) AS G_dh,
                SUM(a.G_ph) AS G_ph,
                SUM(a.G_pr) AS G_pr
    FROM        appearances a 
    LEFT JOIN   people p ON a.playerID = p.playerID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'a', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getFieldingOF($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      f.playerID,
                p.nameFirst,
                p.nameLast,
                f.yearID as year,
                f.stint,
                f.Glf,
                f.Gcf,
                f.Grf
    FROM        fieldingof f 
    LEFT JOIN   people p ON f.playerID = p.playerID ";

    $sql = DB::getSqlStmt($stmt, 'f', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getFieldingOFCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = " SELECT COUNT(*) as count FROM (
    SELECT      f.playerID,
                p.nameFirst,
                p.nameLast,
                f.yearID as year,
                f.stint,
                f.Glf,
                f.Gcf,
                f.Grf
    FROM        fieldingof f 
    LEFT JOIN   people p ON f.playerID = p.playerID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'f', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];

  }

  public static function getFieldingOFAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT    f.playerID,
              p.nameFirst,
              p.nameLast,
              (SELECT COUNT(DISTINCT yearID) FROM fieldingof f2 where f2.playerID = f.playerID) as years,
              SUM(f.Glf) AS Glf,
              SUM(f.Gcf) AS Gcf,
              SUM(f.Grf) AS Grf
    FROM      fieldingof f 
    LEFT JOIN people p ON f.playerID = p.playerID ";

    $sql = DB::getSqlStmt($stmt, 'f', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getFieldingOFAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "SELECT COUNT(*) as count FROM (
    SELECT    f.playerID,
              p.nameFirst,
              p.nameLast,
              (SELECT COUNT(DISTINCT yearID) FROM fieldingof f2 where f2.playerID = f.playerID) as years,
              SUM(f.Glf) AS Glf,
              SUM(f.Gcf) AS Gcf,
              SUM(f.Grf) AS Grf
    FROM      fieldingof f 
    LEFT JOIN people p ON f.playerID = p.playerID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'f', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getFieldingOFSplit($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      f.playerID,
                p.nameFirst,
                p.nameLast,
                f.yearID as year,
                f.stint,
                t.name as teamName,
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
    FROM        fieldingofsplit f 
    LEFT JOIN   people p ON f.playerID = p.playerID
    LEFT JOIN   teams t on f.team_ID = t.ID ";

    $sql = DB::getSqlStmt($stmt, 'f', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getFieldingOFSplitCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = " SELECT COUNT(*) as count FROM (
    SELECT      f.playerID,
                p.nameFirst,
                p.nameLast,
                f.yearID as year,
                f.stint,
                t.name as teamName,
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
    FROM        fieldingofsplit f 
    LEFT JOIN   people p ON f.playerID = p.playerID
    LEFT JOIN   teams t on f.team_ID = t.ID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'f', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];

  }

  public static function getFieldingOFSplitAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      f.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM fieldingofsplit f2 where f2.playerID = f.playerID) as years,
                SUM(f.G) AS G,
                SUM(f.GS) AS GS,
                SUM(f.InnOuts) AS InnOuts,
                SUM(f.PO) AS PO,
                SUM(f.A) AS A,
                SUM(f.E) AS E,
                SUM(f.DP) AS DP,
                SUM(f.PB) AS PB,
                SUM(f.WP) AS WP,
                SUM(f.SB) AS SB,
                SUM(f.CS) AS CS,
                SUM(f.ZR) AS ZR
    FROM        fieldingofsplit f 
    LEFT JOIN   people p ON f.playerID = p.playerID ";

    $sql = DB::getSqlStmt($stmt, 'f', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getFieldingOFSplitAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "SELECT COUNT(*) as count FROM (
    SELECT      f.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM fieldingofsplit f2 where f2.playerID = f.playerID) as years,
                SUM(f.G) AS G,
                SUM(f.GS) AS GS,
                SUM(f.InnOuts) AS InnOuts,
                SUM(f.PO) AS PO,
                SUM(f.A) AS A,
                SUM(f.E) AS E,
                SUM(f.DP) AS DP,
                SUM(f.PB) AS PB,
                SUM(f.WP) AS WP,
                SUM(f.SB) AS SB,
                SUM(f.CS) AS CS,
                SUM(f.ZR) AS ZR
    FROM        fieldingofsplit f 
    LEFT JOIN   people p ON f.playerID = p.playerID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 'f', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getSalaries($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      s.playerID,
                p.nameFirst,
                p.nameLast,
                s.yearID as year,
                t.name as teamName,
                s.lgID,
                s.salary
    FROM        salaries s 
    LEFT JOIN   people p ON s.playerID = p.playerID
    LEFT JOIN   teams t on s.team_ID = t.ID ";

    $sql = DB::getSqlStmt($stmt, 's', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getSalariesCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "SELECT COUNT(*) as count FROM (
    SELECT      s.playerID,
                p.nameFirst,
                p.nameLast,
                s.yearID as year,
                t.name as teamName,
                s.lgID,
                s.salary
    FROM        salaries s 
    LEFT JOIN   people p ON s.playerID = p.playerID
    LEFT JOIN   teams t on s.team_ID = t.ID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 's', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getSalariesAggregate($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
    SELECT      s.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM salaries s2 where s2.playerID = s.playerID) as years,
                SUM(s.salary) AS salary
    FROM        salaries s 
    LEFT JOIN   people p ON s.playerID = p.playerID ";

    $sql = DB::getSqlStmt($stmt, 's', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getSalariesAggregateCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "SELECT COUNT(*) as count FROM (
    SELECT      s.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM salaries s2 where s2.playerID = s.playerID) as years,
                SUM(s.salary) AS salary
    FROM        salaries s 
    LEFT JOIN   people p ON s.playerID = p.playerID ";

    $sql = DB::getSqlStmtNoLimit($stmt, 's', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getPeople($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
    $stmt = "
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

    $sql = DB::getSqlStmt($stmt, 'p', 'playerID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getPeopleCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = "SELECT COUNT(*) as count FROM (
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

    $sql = DB::getSqlStmtNoLimit($stmt, 'p', 'playerID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getPeopleSearch($query = '', $sort = null, $filters = null, $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {

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

    $sql = DB::dbConnect()->prepare($stmt);

    // filter and bind query
    $query = '(' . $query . '*)';
    $query = filter_var($query, FILTER_SANITIZE_STRING);
    $sql->bindParam(':query', $query, PDO::PARAM_STR);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();

    return $sql;
  }

  public static function getPeopleSearchCount($query = '') {
    $stmt = "SELECT COUNT(*) as count FROM (
    SELECT    p.playerID as playerID
    FROM      people p 
    WHERE     MATCH(nameFirst, nameLast) against(:query IN boolean mode) > 0
    GROUP BY  playerID) table1";

    $sql = DB::dbConnect()->prepare($stmt);

    // filter and bind query
    $query = '(' . $query . '*)';
    $query = filter_var($query, FILTER_SANITIZE_STRING);
    $sql->bindParam(':query', $query, PDO::PARAM_STR);

    $sql->execute();
    $results = $sql->fetch(PDO::FETCH_ASSOC);
    return $results['count'];
  }

  public static function getTeamsPlayedFor($playerID) {
    $stmt = 'SELECT distinct t.name from appearances a left join teams t on a.team_ID = t.ID where a.playerID = :playerID group by a.ID';
    $sql = DB::dbConnect()->prepare($stmt);

    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();
    return $sql;
  }


  public static function getImages($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {

    $stmt = '
    SELECT      i.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                i.source as source
    FROM        images i 
    LEFT JOIN   people p on i.playerID = p.playerID ';

    $sql = DB::getSqlStmt($stmt, 'i', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getImagesCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = 'SELECT COUNT(*) as count FROM (
    SELECT      i.playerID as playerID,
                p.nameFirst as nameFirst,
                p.nameLast as nameLast,
                i.source as source
    FROM        images i 
    LEFT JOIN   people p on i.playerID = p.playerID ';

    $sql = DB::getSqlStmtNoLimit($stmt, 'i', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getImagesPlayer($playerID) {

    $stmt = '
    SELECT    i.source 
    FROM      images i 
    WHERE     i.playerID = :playerID
    GROUP BY  i.ID';

    $sql = DB::dbConnect()->prepare($stmt);

    // filter and bind player ID
    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);
    
    $sql->execute();
    return $sql;
  }


  public static function getColleges($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters'], $limit = Constants::Defaults['perPage'], $offset = Constants::Defaults['offset']) {
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

    $sql = DB::getSqlStmt($stmt, 'cp', 'ID', $playerID, $sort, $filters, $limit, $offset);
    $sql->execute();
    return $sql;
  }

  public static function getCollegesCount($playerID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = 'SELECT COUNT(*) as count FROM (
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

    $sql = DB::getSqlStmtNoLimit($stmt, 'cp', 'ID', $playerID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }

  public static function getTeams(
    $teamID  = Constants::Defaults['playerID'], 
    $sort    = Constants::Defaults['sort'], 
    $filters = Constants::Defaults['filters'], 
    $limit   = Constants::Defaults['perPage'], 
    $offset  = Constants::Defaults['offset']) 
  {

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
    FROM   teams t ';


    $sql = DB::getSqlStmt($stmt, 't', 'ID', $teamID, $sort, $filters, $limit, $offset);
    $sql->execute();

    return $sql;

  }


  public static function getTeamsCount($teamID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = 'SELECT COUNT(*) as count FROM (
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

    $sql = DB::getSqlStmtNoLimit($stmt, 't', 'ID', $teamID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }


  public static function getTeamsAggregate(
    $teamID  = Constants::Defaults['playerID'], 
    $sort    = Constants::Defaults['sort'], 
    $filters = Constants::Defaults['filters'], 
    $limit   = Constants::Defaults['perPage'], 
    $offset  = Constants::Defaults['offset']) 
  { 

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
    SUM(t.PPF)            AS PPF 
    FROM   teams t ';


    $sql = DB::getSqlStmt($stmt, 't', 'teamID', $teamID, $sort, $filters, $limit, $offset);
    $sql->execute();

    return $sql;

  }

  public static function getTeamsAggregateCount($teamID = Constants::Defaults['playerID'], $sort = Constants::Defaults['sort'], $filters = Constants::Defaults['filters']) {
    $stmt = 'SELECT COUNT(*) as count FROM (
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

    $sql = DB::getSqlStmtNoLimit($stmt, 't', 'teamID', $teamID, $sort, $filters);
    $sql->execute();
    $results = $sql->fetch(); 
    return $results['count'];
  }


}

?>
