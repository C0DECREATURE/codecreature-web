<?php
	/* Database credentials */
	define('USERS_DB_SERVER', 'localhost');
	define('USERS_DB_USERNAME', 'prax_users');
	define('USERS_DB_PASSWORD', 'xeLXzdEmg9i75c!^');
	define('USERS_DB_NAME', 'prax_users');
	 
	/* Attempt to connect to MySQL database */
	$users_conn = mysqli_connect(USERS_DB_SERVER, USERS_DB_USERNAME, USERS_DB_PASSWORD, USERS_DB_NAME);
	 
	// Check connection
	if($users_conn === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>