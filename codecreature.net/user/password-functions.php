<?php

// empty shared variables for storing data if needed
$password = $new_password = $confirm_password = "";
$password_err = $cur_password_err = $new_password_err = $confirm_password_err = "";

// required password length
$password_length = 8;

// gets the password error for the given password
// if password passes validation, return empty string
function getPasswordErr($p) {
	global $password_length;
	// Error to display if password validation fails
	$password_err = "";
	// Validate password
	if ( empty(trim($p)) ) {
		$password_err = "Please enter a password.";     
	} elseif (strlen(trim($p)) < $password_length) {
		$password_err = "Password must have at least ".$password_length." characters.";
	} elseif ( !preg_match('/(?=.*[0-9]).+/', trim($p)) ) {
		$password_err = "Password must contain at least one number.";
	} elseif ( !preg_match('/(?=.*[a-zA-Z]).+/', trim($p)) ) {
		$password_err = "Password must contain at least one letter.";
	} elseif(preg_match('/(.)\1{3}/', trim($p))){
		$password_err = "Password may not have more than 3 repeating characters.";
	} elseif ( preg_match('/(?=.*(?=(\w+)\1{2}|p[a@*][s\$][s\$]|w[o0*]rd|user|login|access|qwerty|q2w3e|uiop|asdf|monkey|letmein|dragon|hello|batman|shadow|loveme|lovely|mynoob|donald|charlie|ashley|hottie|flower|abc|xyz|012|123|345|456|567|678|789|890|1122|2233|4455|5566|6677|8899|9900)).+/i', trim($p)) ) {
		$password_err = "Please choose a less common password.";
	}
	return $password_err;
}

// Check if given password is empty or incorrect
function isCorrectPassword($p) {
	global $users_conn;
	
	if(empty($p)){
		$cur_password_err = "Please enter your current password.";
	} else {
		// prepare statement to get current hashed password
		$sql = "SELECT password FROM users WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = intval($_SESSION["id"]);
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
				// store result
				mysqli_stmt_store_result($stmt);
				// verify user exists, if yes then verify password
				if(mysqli_stmt_num_rows($stmt) == 1){                    
					// bind result variables
					mysqli_stmt_bind_result($stmt, $hashed_password);
					if(mysqli_stmt_fetch($stmt)){
						if(!password_verify($p, $hashed_password)){
							$cur_password_err = "Incorrect current password.";
						}
					}
				} else { $cur_password_err = "Error: Failed to locate user entry. Please try again later."; }
			} else{
				$cur_password_err = "Error: Failed to execute prepared statement. Please try again later.";
			}
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}

?>