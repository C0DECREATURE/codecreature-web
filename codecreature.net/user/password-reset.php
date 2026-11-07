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

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["new_password"])) {
  // Validate new password
	$new_password_err = getPasswordErr(trim($_POST["new_password"]));
	if(empty($new_password_err)) { $new_password = trim($_POST["new_password"]); }
	
	// Check if current password is empty or incorrect
	$password = trim($_POST["password"]);
	$cur_password_err = isCorrectPassword($password);
	
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
	if(empty($cur_password_err) && empty($new_password_err) && empty($confirm_password_err)){
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
	} else { echo $cur_password_err." ".$new_password_err." ".$confirm_password_err; }
	
	// Close connection
	mysqli_close($users_conn);
}
?>