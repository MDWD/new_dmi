<?php 

	$dbhost  = 'localhost';			 	// Unlikely to require changing
	$dbname  = 'scriptskole';			// Modify these...
	$dbuser  = 'root';					// ...variables according
	$dbpass  = 'root';					// ...to your installation

	$db_server=mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());

	if (!db_server) {
		die("Unable to connect to database: " . mysql_error());
	}else{
		//echo 'connection established';
	}
	mysql_select_db($dbname)
	or die("Unable to select databse: ") . mysql_error());

 ?>