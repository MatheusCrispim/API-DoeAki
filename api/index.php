<?php

	require_once (__DIR__)."/routes/Routes.php";
	header('Content-Type: application/json');
	
	$routes=new Routes();
	$routes->execute();
	
	?>
