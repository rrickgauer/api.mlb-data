<?php


include_once('functions.php');
include_once('api-functions.php');

header('Content-Type: application/json');


$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));


$query = $request[1]; // second parameter


$searchResults = searchPlayers($query)->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($searchResults, JSON_PRETTY_PRINT);



exit;




















































?>