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

  /******************************************************************************
   *  Returns people row
   *
   *  playerID
   *  birthCountry
   *  birthState
   *  birthCity
   *  deathState
   *  deathCity
   *  nameFirst
   *  nameLast
   *  nameGiven
   *  weight
   *  height
   *  bats
   *  throws
   *  retroID
   *  bbrefID
   *  birthDate
   *  debutDate
   *  finalGameDate
   *  deathDate
  ******************************************************************************/
  public static function getPlayer($playerID) {
    $stmt = '
    SELECT playerID,
    birthCountry,
    birthState,
    birthCity,
    deathState,
    deathCity,
    nameFirst,
    nameLast,
    nameGiven,
    weight,
    height,
    bats,
    throws,
    retroID,
    bbrefID,
    birth_date     AS birthDate,
    debut_date     AS debutDate,
    finalgame_date AS finalGameDate,
    death_date     AS deathDate
    FROM   people
    WHERE  playerID = :playerID
    LIMIT  1';

    $sql = DB::dbConnect()->prepare($stmt);

    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);


    $sql->execute();
    return $sql;
  }


  public static function getAllPlayers() {
    $stmt = '
    SELECT *
    FROM   people
    ORDER  BY nameLast,
    nameFirst,
    playerID';

    $sql = DB::dbConnect()->prepare($stmt);
    $sql->execute();
    return $sql;
  }

  public static function getPlayers($limit, $offset) {
    $stmt = '
    SELECT *
    FROM   people
    ORDER  BY nameLast,
    nameFirst,
    playerID
    LIMIT  :limit OFFSET :offset';


    $sql = DB::dbConnect()->prepare($stmt);

    $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);

    $offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
    
    $sql->execute();
    return $sql;
  }


  public static function searchPlayers($query = '') {
    $stmt = '
    SELECT p.playerID,
    p.nameFirst,
    p.nameLast
    FROM   people p
    WHERE  p.nameFirst LIKE :nameFirst
    OR p.nameLast LIKE :nameLast
    LIMIT  100';

    $sql = DB::dbConnect()->prepare($stmt);

    $nameFirst = "%$query%";
    $nameFirst = filter_var($nameFirst, FILTER_SANITIZE_STRING);
    $sql->bindParam(':nameFirst', $nameFirst, PDO::PARAM_STR);

    $nameLast = "%$query%";
    $nameLast = filter_var($nameLast, FILTER_SANITIZE_STRING);
    $sql->bindParam(':nameLast', $nameLast, PDO::PARAM_STR);

    $sql->execute();
    return $sql;

  }


  public static function getPlayerBatting($playerID) {
    $stmt = '
    SELECT *
    FROM   batting
    WHERE  playerID = :playerID
    ORDER  BY yearID ASC';

    $sql = DB::dbConnect()->prepare($stmt);

    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);


    $sql->execute();
    return $sql;
  }


  public static function getPlayerPitching($playerID) {
    $stmt = '
    SELECT *
    FROM   pitching
    WHERE  playerID = :playerID
    ORDER  BY yearID ASC';

    $sql = DB::dbConnect()->prepare($stmt);

    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);


    $sql->execute();
    return $sql;
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

  /******************************************************************************
   *  Returns persons salaries
   *
   *  year
   *  salary
  ******************************************************************************/
  public static function getPersonSalaries($playerID) {
    $stmt = '
    SELECT   s.yearid AS year,
    s.salary
    from     salaries s
    WHERE    s.playerid = :playerID
    ORDER BY year ASC';

    $sql = DB::dbConnect()->prepare($stmt);
    
    // filter and bind playerID
    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();

    return $sql;
  }

  public static function getPersonAppearances($playerID) {
    $stmt = '
    SELECT *
    FROM   appearances
    WHERE  playerID = :playerID
    ORDER  BY yearID DESC';

    $sql = DB::dbConnect()->prepare($stmt);
    
    // filter and bind playerID
    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();

    return $sql;
  }

  public static function getPersonSchools($playerID) {
    $stmt = '
    SELECT c.ID        AS id,
    c.yearID    AS year,
    s.name_full AS schoolName,
    s.city,
    s.state,
    s.country
    FROM   collegeplaying c
    LEFT JOIN schools s
    ON c.schoolID = s.schoolID
    WHERE c.playerID = :playerID
    GROUP  BY id
    ORDER  BY year ASC';

    $sql = DB::dbConnect()->prepare($stmt);
    
    // filter and bind playerID
    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();

    return $sql;
  }

  public static function getPeopleSearch($query) {
    $stmt = '
    SELECT   playerid,
    namefirst,
    namelast,
    namegiven,
    weight,
    height,
    bats,
    throws,
    debut_date,
    finalgame_date,
    birth_date,
    death_date,
    birthcountry,
    birthstate,
    birthcity
    FROM     people
    WHERE    MATCH(namefirst, namelast) against(:query IN boolean mode) > 0
    ORDER BY namelast ASC,
    namefirst ASC
    LIMIT    30';

    $sql = DB::dbConnect()->prepare($stmt);
    
    // filter and bind query
    $query = '(' . $query . '*)';
    $query = filter_var($query, FILTER_SANITIZE_STRING);
    $sql->bindParam(':query', $query, PDO::PARAM_STR);

    $sql->execute();
    return $sql;
  }


  public static function getPersonPitchingTotals($playerID) {
    $stmt = '
    SELECT (SELECT COUNT(playerID)
    FROM   pitching
    WHERE  playerID = :playerID2) AS yearsTotal,
    SUM(W)                         AS W,
    SUM(L)                         AS L,
    SUM(G)                         AS G,
    SUM(GS)                        AS GS,
    SUM(CG)                        AS CG,
    SUM(SHO)                       AS SHO,
    SUM(SV)                        AS SV,
    SUM(IPouts)                    AS IPouts,
    SUM(H)                         AS H,
    SUM(ER)                        AS ER,
    SUM(HR)                        AS HR,
    SUM(BB)                        AS BB,
    SUM(SO)                        AS SO,
    SUM(BAOpp)                     AS BAOpp,
    SUM(ERA)                       AS ERA,
    SUM(IBB)                       AS IBB,
    SUM(WP)                        AS WP,
    SUM(HBP)                       AS HBP,
    SUM(BK)                        AS BK,
    SUM(BFP)                       AS BFP,
    SUM(GF)                        AS GF,
    SUM(R)                         AS R,
    SUM(SH)                        AS SH,
    SUM(SF)                        AS SF,
    SUM(GIDP)                      AS GIDP
    FROM   pitching
    WHERE  playerID = :playerID
    LIMIT  1';

    $sql = DB::dbConnect()->prepare($stmt);

    // filter and bind playerID/playerID2
    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID2', $playerID, PDO::PARAM_STR);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();
    return $sql;
  }


  public static function getPersonBattingTotals($playerID) {
    $stmt = '
    SELECT (SELECT COUNT(playerID)
    FROM   batting
    WHERE  playerID = :playerID2) AS yearsTotal,
    SUM(G)                        AS G,
    SUM(G_batting)                AS G_batting,
    SUM(AB)                       AS AB,
    SUM(R)                        AS R,
    SUM(H)                        AS H,
    SUM(2B)                       AS "2B",
    SUM(3B)                       AS "3B",
    SUM(HR)                       AS HR,
    SUM(RBI)                      AS RBI,
    SUM(SB)                       AS SB,
    SUM(CS)                       AS CS,
    SUM(BB)                       AS BB,
    SUM(SO)                       AS SO,
    SUM(IBB)                      AS IBB,
    SUM(HBP)                      AS HBP,
    SUM(SH)                       AS SH,
    SUM(SF)                       AS SF,
    SUM(GIDP)                     AS GIDP
    FROM   batting
    WHERE  playerID = :playerID
    LIMIT  1';

    $sql = DB::dbConnect()->prepare($stmt);

    // filter and bind playerID/playerID2
    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID2', $playerID, PDO::PARAM_STR);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();
    return $sql;
  }

  public static function getPersonAppearancesTotals($playerID) {
    $stmt = '
    SELECT (SELECT COUNT(playerID)
    FROM   appearances
    WHERE  playerID = :playerID2) AS yearsTotal,
    SUM(G_all)                    AS G_all,
    SUM(GS)                       AS GS,
    SUM(G_batting)                AS G_batting,
    SUM(G_defense)                AS G_defense,
    SUM(G_p)                      AS G_p,
    SUM(G_c)                      AS G_c,
    SUM(G_1b)                     AS G_1b,
    SUM(G_2b)                     AS G_2b,
    SUM(G_3b)                     AS G_3b,
    SUM(G_ss)                     AS G_ss,
    SUM(G_lf)                     AS G_lf,
    SUM(G_cf)                     AS G_cf,
    SUM(G_rf)                     AS G_rf,
    SUM(G_of)                     AS G_of,
    SUM(G_dh)                     AS G_dh,
    SUM(G_ph)                     AS G_ph,
    SUM(G_pr)                     AS G_pr
    FROM   appearances
    WHERE  playerID = :playerID
    LIMIT  1';

    $sql = DB::dbConnect()->prepare($stmt);

    // filter and bind playerID/playerID2
    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID2', $playerID, PDO::PARAM_STR);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();
    return $sql;
  }

  public static function getPersonSalariesTotals($playerID) {
    $stmt = '
    SELECT (SELECT COUNT(playerID)
    FROM   salaries
    WHERE  playerID = :playerID2) AS yearsTotal,
    SUM(salary)                   as salary
    FROM   salaries
    WHERE  playerID = :playerID
    LIMIT  1';

    $sql = DB::dbConnect()->prepare($stmt);

    // filter and bind playerID/playerID2
    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID2', $playerID, PDO::PARAM_STR);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();
    return $sql;
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
  public static function getBatting($sort = 'playerID', $limit = 100, $offset = 0) {
    $sort = filter_var($sort, FILTER_SANITIZE_STRING);

    $stmt = "
    SELECT    b.playerID,
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
    FROM      batting b
    LEFT JOIN people p
    ON        b.playerID = p.playerID
    GROUP BY  b.id
    ORDER BY  $sort desc limit :limit offset :offset";

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
    SELECT p.playerID,
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
      $filterStmt = DB::getFilterStmt($filters, 'p');
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

    $stmt .= DB::getFilterStmt($filters, '.f');
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

    $stmt .= DB::getFilterStmt($filters, '.a');
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

    $stmt .= DB::getFilterStmt($filters, '.f');
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

    $stmt .= DB::getFilterStmt($filters, '.f');
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

    $stmt .= DB::getFilterStmt($filters, '.s');
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
      $stmt = $stmt . " $tableName.$column $conditional $qualifier";

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