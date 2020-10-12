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




function getPlayer($playerID) {

  $stmt = 'SELECT yearID, W, L, G, H, HR from pitching where playerID = :playerID';

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

































?>