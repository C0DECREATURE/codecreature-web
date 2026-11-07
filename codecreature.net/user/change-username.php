<?php

// Include database connection file
require_once "connect.php";
// Include password functions file
require_once "password-functions.php";
// Include username functions file
require_once "username-functions.php";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["new_username"])) {
	// check if username is valid
	$new_username = !empty($_POST["new_username"]) ? trim($_POST["new_username"]) : "";
	$username_err = getUsernameErr($new_username);
	
	// check if password is valid
	$cur_password = !empty($_POST["cur_password"]) ? trim($_POST["cur_password"]) : "";
	$cur_password_err = getPasswordErr($cur_password);
	
	if (empty($username_err) && empty($cur_password_err)) {
		// Prepare an update statement
		$sql = "UPDATE users SET username = ? WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "si", $new_username, $param_id);
			// Set parameters
			$param_id = $_SESSION["id"];
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Username updated successfully. Destroy the session, and redirect to login page
				session_destroy();
				header("location: /login");
				exit();
			} else{
				echo "Error: Failed to execute prepared statement. Please try again later.";
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}
	} else {
		echo $cur_password_err."<br>".$username_err;
	}
}

?>