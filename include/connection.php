<?php

	define("HOSTNAME","localhost");
	define("USERNAME","root");
	define("PASSWORD","");
	define("DBNAME","storeit_wms");
	$conn = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DBNAME) or die("cannot connect to database");

?>
