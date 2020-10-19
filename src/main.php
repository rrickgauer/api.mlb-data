<?php

include_once('includes.php');
include_once('Module.php');   // filters, sorts, sortType, perPage, page
include_once('Batting.php');
include_once('Pitching.php');


$b1 = new Pitching('filter', 'GS', 'desc', 100, 0);

$b1->returnData();




// $b1->returnData();
exit;















?>