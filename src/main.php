<?php

include_once('includes.php');
include_once('Module.php');
include_once('Batting.php');


$b1 = new Batting('filter', 'sort');


// echo Constants::Batting['HR'];

$b1->returnData();
exit;















?>