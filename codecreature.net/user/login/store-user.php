<?php

// Include database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/user/connect.php";

// attempt to remember user based on token in cookies
function storeUser($id, $username, $authorization, $pronouns, $icon) {
	if(!isset($_SESSION)){session_start();}

	// Store data in session variables
	$_SESSION["loggedin"] = true;
	$_SESSION["id"] = $id;
	$_SESSION["username"] = $username;
	$_SESSION["user_authorization"] = $authorization;                         
	$_SESSION["user_pronouns"] = $pronouns;
	$_SESSION["user_icon"] = $icon;
}

?>