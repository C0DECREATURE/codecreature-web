<?php

// include user database connection file
include $_SERVER['DOCUMENT_ROOT']."/user/database.php";

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }
// Store whether a user is logged in
$logged_in = false;
if ( isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true ) {
	$logged_in = true;
}

?>