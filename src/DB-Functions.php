<?php

include_once('Constants.php');

class DB {


  public static function dbConnect() {
    include('db-info.php');

    try {
      // connect to database
      $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      return $pdo;

    } catch(PDOexception $e) {
      return 0;
    }
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

    if (count($result) == 1)
      return true;
    else
      return false;
  }

  /****************************************************************************
   * Returns people batting
   * 
   * Sort is the column to sort with
   * limit is the number of rows to return
   * offset is the offset
   * 
   * returns
   * playerID
   * nameFist
   * yearID,
   * stint,
   * teamID,
   * team_ID,
   * lgID,
   * G,
   * G_batting,
   * AB,
   * R,
   * H,
   * 2B,
   * 3B,
   * HR,
   * RBI,
   * SB,
   * CS,
   * BB,
   * SO,
   * IBB,
   * HBP,
   * SH,
   * SF,
   * GIDP
   ***************************************************************************/
  public static function getBatting($sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT      b.playerID,
    p.nameFirst,
    p.nameLast,
    b.yearID,
    b.stint,
    b.teamID,
    b.team_ID,
    b.lgID,
    b.G,
    b.G_batting,
    b.AB,
    b.R,
    b.H,
    b.2B,
    b.3B,
    b.HR,
    b.RBI,
    b.SB,
    b.CS,
    b.BB,
    b.SO,
    b.IBB,
    b.HBP,
    b.SH,
    b.SF,
    b.GIDP
    FROM        batting b
    LEFT JOIN   people p
    ON          b.playerID = p.playerID";

    $stmt .= DB::getFilterStmt($filters, '');
    $stmt .= " GROUP  BY b.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();
    return $sql;
  }


  public static function getBattingAggregate($sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT      b.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM batting b2 where b2.playerID = b.playerID) as years,
                SUM(b.G) AS G,
                SUM(b.G_batting) AS G_batting,
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

    $stmt .= DB::getFilterStmt($filters, '');
    $stmt .= " GROUP  BY b.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();
    return $sql;
  }


  public static function getPitching($sort, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT  p.playerID,
    people.nameFirst,
    people.nameLast,
    p.yearID as year,
    p.stint,
    p.team_ID,
    t.name as teamName,
    p.lgID,
    p.W,
    p.L,
    p.G,
    p.GS,
    p.CG,
    p.SHO,
    p.SV,
    p.IPouts,
    p.H,
    p.ER,
    p.HR,
    p.BB,
    p.SO,
    p.BAOpp,
    p.ERA,
    p.IBB,
    p.WP,
    p.HBP,
    p.BK,
    p.BFP,
    p.GF,
    p.R,
    p.SH,
    p.SF,
    p.GIDP
    FROM   pitching p
    LEFT   JOIN people on p.playerID = people.playerID
    LEFT   JOIN teams t on p.team_ID = t.ID";


    // add filter options
    if ($filters != null) {
      $filterStmt = DB::getFilterStmt($filters, 'p.');
      $stmt .= $filterStmt;
    }

    $stmt .= " GROUP  BY p.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";


    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);


    $sql->execute();
    return $sql;
  }

  public static function getPitchingAggregate($sort, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {

    $stmt = "
    SELECT  p.playerID,
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
            SUM(p.ERA) AS ERA,
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
    FROM    pitching p
    LEFT    JOIN people on p.playerID = people.playerID";


    // add filter options
    if ($filters != null) {
      $filterStmt = DB::getFilterStmt($filters, 'p.');
      $stmt .= $filterStmt;
    }

    $stmt .= " GROUP  BY p.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);


    $sql->execute();
    return $sql;
  }


  public static function getFielding($sort, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {

    $stmt = "
    SELECT  f.playerID,
    p.nameFirst,
    p.nameLast,
    f.yearID,
    f.stint,
    f.teamID,
    f.team_ID,
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
    FROM    fielding f 
    LEFT JOIN people p ON f.playerID = p.playerID
    LEFT JOIN teams t on f.team_ID = t.ID ";

    $stmt .= DB::getFilterStmt($filters, 'f.');
    $stmt .= " GROUP  BY f.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();
    return $sql;
  }

  public static function getFieldingAggregate($sort, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT  f.playerID as playerID,
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
    FROM    fielding f 
    LEFT JOIN people p ON f.playerID = p.playerID";

    $stmt .= DB::getFilterStmt($filters, 'f.');
    $stmt .= " GROUP  BY f.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();
    return $sql;
  }




  public static function getAppearances($sort, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT  a.yearID,
    a.teamID,
    a.team_ID,
    t.name,
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
    FROM appearances a 
    LEFT JOIN people p ON a.playerID = p.playerID
    LEFT JOIN teams t on a.team_ID = t.ID ";

    $stmt .= DB::getFilterStmt($filters, 'a.');
    $stmt .= " GROUP  BY a.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();
    return $sql;
  }


  public static function getFieldingOF($sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT  f.playerID,
    p.nameFirst,
    p.nameLast,
    f.yearID,
    f.stint,
    f.Glf,
    f.Gcf,
    f.Grf
    FROM    fieldingof f 
    LEFT JOIN people p ON f.playerID = p.playerID ";

    $stmt .= DB::getFilterStmt($filters, 'f.');
    $stmt .= " GROUP  BY f.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();
    return $sql;
  }

  public static function getFieldingOFSplit($sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT  f.playerID,
    p.nameFirst,
    p.nameLast,
    f.yearID,
    f.stint,
    f.teamID,
    f.team_ID,
    t.name,
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
    FROM    fieldingofsplit f 
    LEFT JOIN people p ON f.playerID = p.playerID
    LEFT JOIN teams t on f.team_ID = t.ID ";

    $stmt .= DB::getFilterStmt($filters, 'f.');
    $stmt .= " GROUP  BY f.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();
    return $sql;
  }


  public static function getSalaries($sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT  s.playerID,
    p.nameFirst,
    p.nameLast,
    s.yearID,
    s.teamID,
    s.team_ID,
    t.name as teamName,
    s.lgID,
    s.salary
    FROM    salaries s 
    LEFT JOIN people p ON s.playerID = p.playerID
    LEFT JOIN teams t on s.team_ID = t.ID ";

    $stmt .= DB::getFilterStmt($filters, 's.');
    $stmt .= " GROUP  BY s.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);

    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();

    return $sql;
  }


  public static function getPeople($sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT  p.playerID,
    p.birthCountry,
    p.birthState,
    p.birthCity,
    p.deathCountry,
    p.deathState,
    p.deathCity,
    p.nameFirst,
    p.nameLast,
    p.nameGiven,
    p.weight,
    p.height,
    p.bats,
    p.throws,
    p.retroID,
    p.bbrefID,
    p.birth_date as birthDate,
    p.debut_date as debuteDate,
    p.finalgame_date as finalGameDate,
    p.death_date as deathDate
    FROM    people p ";

    $stmt .= DB::getFilterStmt($filters, '');
    $stmt .= " GROUP  BY p.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

    $sql = DB::dbConnect()->prepare($stmt);
    
    // limit
    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    // offset
    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);

    $sql->execute();

    return $sql;
  }



  public static function getPeopleSearch($query = '', $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {

    // create the module link variables
    $moduleBatting         = sprintf("CONCAT('/%s/', playerID)", Constants::Modules['Batting']);
    $modulePitching        = sprintf("CONCAT('/%s/', playerID)", Constants::Modules['Pitching']);
    $moduleAppearances     = sprintf("CONCAT('/%s/', playerID)", Constants::Modules['Appearances']);
    $moduleFielding        = sprintf("CONCAT('/%s/', playerID)", Constants::Modules['Fielding']);
    $modulePeople          = sprintf("CONCAT('/%s/', playerID)", Constants::Modules['People']);
    $moduleFieldingOF      = sprintf("CONCAT('/%s/', playerID)", Constants::Modules['FieldingOF']);
    $moduleFieldingOFSplit = sprintf("CONCAT('/%s/', playerID)", Constants::Modules['FieldingOFSplit']);
    $moduleSalaries        = sprintf("CONCAT('/%s/', playerID)", Constants::Modules['Salaries']);

    $stmt = "
    SELECT    p.playerID as playerID,
    p.nameFirst as nameFirst,
    p.nameLast as nameLast,
    p.birth_date as birthDate,
    p.debut_date as debutDate,
    p.finalgame_date as finalGameDate,
    p.death_date as deathDate,
    $moduleBatting as moduleBatting,
    $modulePitching as modulePitching,
    $moduleAppearances as moduleAppearances,
    $moduleFielding as moduleFielding,
    $modulePeople as modulePeople,
    $moduleFieldingOF as moduleFieldingOF,
    $moduleFieldingOFSplit as moduleFieldingOFSplit,
    $moduleSalaries as moduleSalaries
    FROM      people p 
    WHERE     MATCH(namefirst, namelast) against(:query IN boolean mode) > 0
    GROUP BY  playerID
    ORDER BY  nameLast ASC, nameFirst ASC, playerID ASC, birthDate ASC
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


  public static function getFilterStmt($filters, $tableName) {

    if ($filters == null)
      return '';

    $stmt = ' WHERE ';

    for ($count = 0; $count < count($filters); $count++) {
      $filter      = $filters[$count];
      $column      = $filter['column'];
      $conditional = $filter['conditional'];
      $qualifier   = $filter['qualifier'];

      if ($count > 0)
        $stmt .= ' AND';
      $stmt = $stmt . " $tableName$column $conditional $qualifier";

    }


    return $stmt;
  }

  public static function getOrderStmt($sort) {
    if ($sort == null)
      return '';

      // build order by statement
    $orderStmt = '';
    $sortColumn = filter_var($sort['column'], FILTER_SANITIZE_STRING);

    $sortType = strtoupper($sort['type']);
    if ($sortType != 'ASC')
      $sortType = 'DESC';
    $sortType = filter_var($sortType, FILTER_SANITIZE_STRING);

    $orderStmt = " ORDER BY $sortColumn $sortType ";

    return $orderStmt;
  }

}


?>