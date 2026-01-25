<?php
	/* Database credentials */
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'user_login');
	define('DB_PASSWORD', 'xeLXzdEmg9i75c!^');
	define('DB_NAME', 'prax_users');
	 
	/* Attempt to connect to MySQL database */
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 
	// Check connection
	if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>