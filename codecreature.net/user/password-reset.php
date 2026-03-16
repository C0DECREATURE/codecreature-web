<?php
// Initialize the session
if(!isset($_SESSION)){session_start();}
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: /login");
	exit;
}

// Include database connection file
require_once "connect.php";
// Include password validator file
require_once "password-functions.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$old_password_err = $new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate new password
	$new_password_err = getPasswordErr(trim($_POST["new_password"]));
	if(empty($new_password_err)) { $new_password = trim($_POST["new_password"]); }
	
	// Check if current password is empty or incorrect
	$password = trim($_POST["password"]);
	if(empty($password)){
		$old_password_err = "Please enter your current password.";
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
						if(!password_verify($password, $hashed_password)){
							$old_password_err = "Incorrect current password.";
						}
					}
				} else { $old_password_err = "Error: Failed to locate user entry. Please try again later."; }
			} else{
				$old_password_err = "Error: Failed to execute prepared statement. Please try again later.";
			}
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	
	// Validate confirm password
	if(empty(trim($_POST["confirm_password"]))){
			$confirm_password_err = "Please confirm the password.";
	} else{
			$confirm_password = trim($_POST["confirm_password"]);
			if(empty($new_password_err) && ($new_password != $confirm_password)){
					$confirm_password_err = "Password did not match.";
			}
	}
			
	// Check input errors before updating the database
	if(empty($old_password_err) && empty($new_password_err) && empty($confirm_password_err)){
		// Prepare an update statement
		$sql = "UPDATE users SET password = ? WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
			
			// Set parameters
			$param_password = password_hash($new_password, PASSWORD_DEFAULT);
			$param_id = $_SESSION["id"];
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Password updated successfully. Destroy the session, and redirect to login page
				session_destroy();
				header("location: /login");
				exit();
			} else{
				echo "Error: Failed to execute prepared statement. Please try again later.";
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}
	} else { echo $old_password_err." ".$new_password_err." ".$confirm_password_err; }
	
	// Close connection
	mysqli_close($users_conn);
}
?>