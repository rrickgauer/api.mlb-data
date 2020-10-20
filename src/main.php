<?php

include_once('includes.php');
include_once('Modules.php'); // filters, sorts, sortType, perPage, page


$b1 = new Pitching('filter', 'GS', 'desc', 100, 0);

$b1->returnData();






exit;















?>