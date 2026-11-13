<?php

// empty shared variables for storing data if needed
$password = $new_password = $confirm_password = "";
$password_err = $cur_password_err = $new_password_err = $confirm_password_err = "";

// required password length
$password_length = 8;

// gets the password error for the given password
// if password passes validation, return empty string
function getPasswordErr($p,$username="",$email="") {
	global $password_length;
	// Error to display if password validation fails
	$password_err = "";
	// get just the first part of email
	$email = substr($email,0,strpos($email,"@"));
	// Validate password
	if ( empty(trim($p)) ) {
		$password_err = "Please enter a password.";     
	} elseif (strlen(trim($p)) < $password_length) {
		$password_err = "Password must have at least ".$password_length." characters.";
	} elseif ( !preg_match('/(?=.*[0-9]).+/', trim($p)) ) {
		$password_err = "Password must contain at least one number.";
	} elseif ( !preg_match('/(?=.*[a-zA-Z]).+/', trim($p)) ) {
		$password_err = "Password must contain at least one letter.";
	} elseif ( !empty($username) && str_contains(trim($p),$username) ) {
		$password_err = "Password may not contain your username.";
	} elseif ( !empty($email) && str_contains(trim($p),$email) ) {
		$password_err = "Password may not contain your email.";
	} elseif(preg_match('/(.)\1{3}/', trim($p))){
		$password_err = "Password may not have more than 3 repeating characters in a row.";
	} elseif ( preg_match('/123qwe|qwerty|uiop|asdf|zxcv|!@#$%^|abc123|123abc|abc|wxyz|123|2345|3456|4567|5678|6789|7890|112233|223344|445566|556677|667788|778899|qazwsx|zaq1zaq1|1qaz2wsx|3rjs1la|18atcskd/i', trim($p)) ) {
		$password_err = "Password may not contain patterns like 123, abc, or qwerty";
	} elseif ( preg_match('/p[a@*][s\$][s\$]|^.?.?.?.?(pass@123|q2w3e|iloveyou|loveme|access|hello|login|letmein|princess|mynoob|monkey|shadow|charlie|football|starwars|trustno1|superman|welcome|sunshine|freedom|whatever|baseball|mustang|michael|ashley|bailey|master|c[o0*]d[e3]cr[e3][a4]tur[e3]|w[o0]rmr[a4]c[e3]|microplastics|matilda|jeremy|pretzel|poolnoodle|stringcheese).?.?.?.?$/i', trim($p)) ) {
		$password_err = "Contains a <a href='https://en.wikipedia.org/wiki/List_of_the_most_common_passwords' target='_blank'>common</a> or easily guessed word. Please choose something else.";
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