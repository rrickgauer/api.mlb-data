<?php

include_once('includes.php');
include_once('Modules.php'); // filters, sorts, sortType, perPage, page
include_once('Parser.php');



// if (!$_SERVER['PATH_INFO'])
//   throw new Exception('No path set');
// else
//   echo $_SERVER['PATH_INFO'];


$p1 = new Parser();

echo var_dump($p1->getSorts());

































exit;





?>