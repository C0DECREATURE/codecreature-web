<?php
	/* Database credentials */
	define('WORM_DB_SERVER', 'localhost');
	define('WORM_DB_USERNAME', 'prax_worms');
	define('WORM_DB_PASSWORD', 'ruyQ.CU6}?t$tbG');
	define('WORM_DB_NAME', 'prax_wormrace');
	 
	/* Attempt to connect to MySQL database */
	$worm_conn = mysqli_connect(WORM_DB_SERVER, WORM_DB_USERNAME, WORM_DB_PASSWORD, WORM_DB_NAME);
	 
	// Check connection
	if($worm_conn === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>