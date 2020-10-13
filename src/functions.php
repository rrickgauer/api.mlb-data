<?php


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
}

































?>