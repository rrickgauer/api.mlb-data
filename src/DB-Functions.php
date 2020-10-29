<?php

///////////////////////////////////////////////////////////////////////////////////////
// Class and Function List:                                                          //
//                                                                                   //
// Function list:                  Description:                                      //
// - dbConnect()                   return a connection to the db                     //
// - doesPlayerExist()             returns if a player exists in the database        //
// - getBatting()                  seasonal batting stats                            //
// - getBattingAggregate()         aggregate batting stats                           //
// - getPitching()                 seasonal pitching stats                           //
// - getPitchingAggregate()        aggregate pitching stats                          //
// - getFielding()                 seasonal fielding stats                           //
// - getFieldingAggregate()        aggregate fielding stats                          //
// - getAppearances()              seasonal appearances stats                        //
// - getAppearancesAggregate()     aggregate appearances stats                       //
// - getFieldingOF()               seasonal fieldingOF stats                         //
// - getFieldingOFAggregate()      aggregate fieldingOF stats                        //
// - getFieldingOFSplit()          seasonal fieldingOFSplit stats                    //
// - getFieldingOFSplitAggregate() aggregate fieldingOFSplit stats                   //
// - getSalaries()                 seasonal salary stats                             //
// - getSalariesAggregate()        aggregate salary stats                            //
// - getPeople()                   player bio info                                   //
// - getPeopleSearch()             results for database player search query          //
// - getFilterStmt()               creates the filter statement for queries          //
// - getOrderStmt()                creates the order by statement for queries        //
//                                                                                   //
// Classes list:                                                                     //
// - DB                                                                              //
//                                                                                   //
///////////////////////////////////////////////////////////////////////////////////////

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

  public static function getBatting($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT      b.playerID,
                p.nameFirst,
                p.nameLast,
                b.yearID as year,
                t.name as teamName,
                b.stint,
                b.lgID,
                b.G,
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
    LEFT JOIN   people p ON b.playerID = p.playerID
    LEFT JOIN   teams t on b.team_ID = t.ID";

    $stmt .= DB::getFilterStmt($filters, '');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE b.playerID = :playerID ';
      } else {
        $stmt .= ' AND b.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY b.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getBattingAggregate($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, '');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE b.playerID = :playerID ';
      } else {
        $stmt .= ' AND b.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY b.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getPitching($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT      p.playerID,
                people.nameFirst,
                people.nameLast,
                p.yearID as year,
                p.stint,
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
    FROM        pitching p
    LEFT JOIN   people on p.playerID = people.playerID
    LEFT JOIN   teams t on p.team_ID = t.ID";

    // add filter options
    if ($filters != null) {
      $filterStmt = DB::getFilterStmt($filters, 'p.');
      $stmt .= $filterStmt;
    }

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE p.playerID = :playerID ';
      } else {
        $stmt .= ' AND p.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY p.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getPitchingAggregate($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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
    LEFT JOIN   people on p.playerID = people.playerID";

    // add filter options
    if ($filters != null) {
      $filterStmt = DB::getFilterStmt($filters, 'p.');
      $stmt .= $filterStmt;
    }

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE p.playerID = :playerID ';
      } else {
        $stmt .= ' AND p.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY p.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getFielding($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, 'f.');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE f.playerID = :playerID ';
      } else {
        $stmt .= ' AND f.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY f.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getFieldingAggregate($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, 'f.');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE f.playerID = :playerID ';
      } else {
        $stmt .= ' AND f.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY f.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getAppearances($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, 'a.');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE a.playerID = :playerID ';
      } else {
        $stmt .= ' AND a.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY a.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getAppearancesAggregate($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, 'a.');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE a.playerID = :playerID ';
      } else {
        $stmt .= ' AND a.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY a.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getFieldingOF($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, 'f.');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE f.playerID = :playerID ';
      } else {
        $stmt .= ' AND f.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY f.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getFieldingOFAggregate($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, 'f.');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE f.playerID = :playerID ';
      } else {
        $stmt .= ' AND f.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY f.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getFieldingOFSplit($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, 'f.');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE f.playerID = :playerID ';
      } else {
        $stmt .= ' AND f.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY f.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getFieldingOFSplitAggregate($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, '');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE f.playerID = :playerID ';
      } else {
        $stmt .= ' AND f.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY f.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();
    return $sql;
  }

  public static function getSalaries($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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

    $stmt .= DB::getFilterStmt($filters, 's.');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE s.playerID = :playerID ';
      } else {
        $stmt .= ' AND s.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY s.ID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();

    return $sql;
  }

  public static function getSalariesAggregate($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
    $stmt = "
    SELECT      s.playerID,
                p.nameFirst,
                p.nameLast,
                (SELECT COUNT(DISTINCT yearID) FROM salaries s2 where s2.playerID = s.playerID) as years,
                SUM(s.salary) AS salary
    FROM        salaries s 
    LEFT JOIN   people p ON s.playerID = p.playerID ";

    $stmt .= DB::getFilterStmt($filters, 's.');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE s.playerID = :playerID ';
      } else {
        $stmt .= ' AND s.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY s.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();

    return $sql;
  }

  public static function getPeople($playerID = null, $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {
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
            CONCAT('https://www.baseball-reference.com/players/', SUBSTR(p.bbrefID, 1, 1), '/', p.bbrefID, '.shtml') as bbrefLink,
            p.birth_date as birthDate,
            p.debut_date as debuteDate,
            p.finalgame_date as finalGameDate,
            p.death_date as deathDate,
            (select t.name from appearances a left join teams t on a.team_ID = t.ID where a.playerID = p.playerID group by a.ID order by a.yearID desc limit 1) as team
    FROM    people p ";

    $stmt .= DB::getFilterStmt($filters, '');

    // playerID is included and only want data for that player
    if ($playerID != null) {
      if ($filters == null) {
        $stmt .= ' WHERE p.playerID = :playerID ';
      } else {
        $stmt .= ' AND p.playerID = :playerID ';
      }
    }

    $stmt .= " GROUP  BY p.playerID ";
    $stmt .= DB::getOrderStmt($sort);
    $stmt .= " LIMIT  :limit offset :offset";

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

    $sql->execute();

    return $sql;
  }

  public static function getPeopleSearch($query = '', $sort = null, $filters = null, $limit = Constants::Defaults['PerPage'], $offset = 0) {

    $stmt = "
    SELECT    p.playerID as playerID,
              p.nameFirst as nameFirst,
              p.nameLast as nameLast,
              p.birth_date as birthDate,
              p.debut_date as debutDate,
              p.finalgame_date as finalGameDate,
              p.death_date as deathDate
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

  public static function getTeamsPlayedFor($playerID) {
    $stmt = 'SELECT distinct t.name from appearances a left join teams t on a.team_ID = t.ID where a.playerID = :playerID group by a.ID';
    $sql = DB::dbConnect()->prepare($stmt);

    $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
    $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

    $sql->execute();
    return $sql;
  }

  public static function getFilterStmt($filters, $tableName) {
    
    //return empty string if null
    if ($filters == null) {
      return '';
    }

    $stmt = ' WHERE ';

    for ($count = 0; $count < count($filters); $count++) {
      $filter      = $filters[$count];
      $column      = $filter['column'];
      $conditional = $filter['conditional'];
      $qualifier   = $filter['qualifier'];

      if ($count > 0) 
        $stmt .= ' AND';
      else
        $stmt = $stmt . " $tableName$column $conditional $qualifier";
    }

    return $stmt;
  }

  public static function getOrderStmt($sort) {
    if ($sort == null) return '';

    // build order by statement
    $orderStmt  = '';
    $sortColumn = filter_var($sort['column'], FILTER_SANITIZE_STRING);

    // determine asc or desc
    $sortType = strtoupper($sort['type']);
    if ($sortType != 'ASC') 
      $sortType = 'DESC';

    // clean it
    $sortType = filter_var($sortType, FILTER_SANITIZE_STRING);

    $orderStmt = " ORDER BY $sortColumn $sortType ";

    return $orderStmt;
  }

}

?>
