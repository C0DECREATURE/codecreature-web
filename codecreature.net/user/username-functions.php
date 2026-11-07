<?php

// Include database connection file
require_once "connect.php";
// Include password functions file
require_once "password-functions.php";

// empty shared variables for storing data if needed
$new_username = "";
$username_err = "";

// maximum username length
$username_length = 16;

// gets the username error for the given username
// if username passes validation, return empty string
function getUsernameErr($u) {
	global $username_length;
	// Error to display if username validation fails
	$username_err = "";
	// Validate username
	if(empty($u)){
		$username_err = "Please enter a username.";
	} elseif(!preg_match('/^[a-zA-Z0-9_]+$/', $u)){
		$username_err = "Username can only contain letters, numbers, and underscores.";
	} elseif(preg_match('/.*c.*[o0*].*d.*[e3].*c.*r.*[e3].*[a@].*t.*u.*r.*[e3].*|.*[a@]dm[i1l]n.*|.*m[o0]d[e3]r[a@]t[o0]r.*|.*w.*[e3].*b.*m.*[a@].*s.*t.*[e3].*r.*|anonymous|someone/i', $u)){
		$username_err = "Please choose a different username.";
	} elseif (strlen($u) > $username_length) {
		$username_err = "Username must have less than ".$username_length." characters.";
	}
	return $username_err;
}

?>