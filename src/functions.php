<?php


function dbConnect() {
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
function getPlayer($playerID) {
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

  $sql = dbConnect()->prepare($stmt);

  $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
  $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);


  $sql->execute();
  return $sql;
}


function getAllPlayers() {
  $stmt = 'SELECT * from people order by nameLast, nameFirst, playerID';
  $sql = dbConnect()->prepare($stmt);
  $sql->execute();
  return $sql;
}


function searchPlayers($query = '') {

  // Projects.name like :name
  // $name = "%$query%";

  $stmt = 'SELECT p.playerID, p.nameFirst, p.nameLast from people p where p.nameFirst like :nameFirst or p.nameLast like :nameLast limit 100';

  $sql = dbConnect()->prepare($stmt);

  $nameFirst = "%$query%";
  $nameFirst = filter_var($nameFirst, FILTER_SANITIZE_STRING);
  $sql->bindParam(':nameFirst', $nameFirst, PDO::PARAM_STR);

  $nameLast = "%$query%";
  $nameLast = filter_var($nameLast, FILTER_SANITIZE_STRING);
  $sql->bindParam(':nameLast', $nameLast, PDO::PARAM_STR);

  $sql->execute();
  return $sql;

}


function getPlayerBatting($playerID) {
  $stmt = 'SELECT * from batting where playerID = :playerID order by yearID asc';
  $sql = dbConnect()->prepare($stmt);

  $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
  $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);


  $sql->execute();
  return $sql;
}


function getPlayerPitching($playerID) {
  $stmt = 'SELECT * from pitching where playerID = :playerID order by yearID asc';
  $sql = dbConnect()->prepare($stmt);

  $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
  $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);


  $sql->execute();
  return $sql;
}


function doesPlayerExist($playerID) {
  $stmt = 'SELECT playerID from people where playerID = :playerID limit 1';

  $sql = dbConnect()->prepare($stmt);
  
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
function getPersonSalaries($playerID) {
  $stmt = '
  SELECT   s.yearid AS year,
           s.salary
  from     salaries s
  WHERE    s.playerid = :playerID
  ORDER BY year ASC';

  $sql = dbConnect()->prepare($stmt);
  
  // filter and bind playerID
  $playerID = filter_var($playerID, FILTER_SANITIZE_STRING);
  $sql->bindParam(':playerID', $playerID, PDO::PARAM_STR);

  $sql->execute();

  return $sql;
}































?>