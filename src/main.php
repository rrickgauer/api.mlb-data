<?php

include_once('includes.php');
include_once('Modules.php'); // filters, sorts, sortType, perPage, page
include_once('Parser.php');


// if (!$_SERVER['PATH_INFO'])
//   throw new Exception('No path set');
// else
//   echo $_SERVER['PATH_INFO'];


$p1 = new Parser();

$sort = $p1->getSorts();

$pitch = new Pitching($p1->getFilters(), $p1->getSorts(), 100, 0);

$pitch->returnData();




exit;





?>