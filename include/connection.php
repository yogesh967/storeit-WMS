<?php

	define("HOSTNAME","localhost");
	define("USERNAME","root");
	define("PASSWORD","");
	define("DBNAME","storeit_wms");
	$conn = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DBNAME) or die("cannot connect to database");
	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
?>
