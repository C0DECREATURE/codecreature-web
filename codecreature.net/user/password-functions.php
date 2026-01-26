<?php

// empty shared variables for storing data if needed
$password = $new_password = $confirm_password = "";
$password_err = $new_password_err = $confirm_password_err = "";

// required password length
$password_length = 6;

// gets the password error for the given password
// if password passes validation, return empty string
function getPasswordErr($p) {
	global $password_length;
	// Error to display if password validation fails
	$password_err = "";
	// Validate password
	if ( empty(trim($p)) ) {
		$password_err = "Please enter a password.";     
	} elseif (strlen(trim($p)) != $password_length) {
		$password_err = "Password must have ".$password_length." characters.";
	} elseif ( !preg_match('/(?=.*[0-9]).+/', trim($p)) ) {
		$password_err = "Password must contain at least one number";
	} elseif ( !preg_match('/(?=.*[a-zA-Z]).+/', trim($p)) ) {
		$password_err = "Password must contain at least one letter";
	} elseif(preg_match('/(.)\1{3}/', trim($p))){
		$password_err = "Password may not have more than 3 repeating characters";
	} elseif ( preg_match('/(?=.*(?=(\w+)\1{2}|p[a@*][s\$][s\$]|w[o0*]rd|user|login|access|qwerty|q2w3e|uiop|asdf|monkey|letmein|dragon|hello|batman|shadow|loveme|lovely|mynoob|donald|charlie|ashley|hottie|flower|abc|xyz|012|123|345|456|567|678|789|890|1122|2233|4455|5566|6677|8899|9900)).+/i', trim($p)) ) {
		$password_err = "Please choose a less common password";
	}
	return $password_err;
}

?>