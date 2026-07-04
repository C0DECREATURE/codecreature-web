<?php
	/* Database credentials */
	define('POLL_DB_SERVER', 'localhost');
	define('POLL_DB_USERNAME', 'prax_polls');
	define('POLL_DB_PASSWORD', 'QKTm7Gi8');
	define('POLL_DB_NAME', 'prax_polls');
	 
	/* Attempt to connect to MySQL database */
	$poll_conn = mysqli_connect(POLL_DB_SERVER, POLL_DB_USERNAME, POLL_DB_PASSWORD, POLL_DB_NAME);
	 
	// Check connection
	if($poll_conn === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>