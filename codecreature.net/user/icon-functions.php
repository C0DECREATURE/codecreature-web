<?php
// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /login");
    exit;
}
 
// Include database connection file
require_once "connect.php";

// empty variables for storing data
$icon = $icon_err = $icon_success = "";

function updateIcon($new_icon) {
	// empty variables for storing data
	global $users_conn, $icon, $icon_err, $icon_success;
	
	// if icon has been given, set it
	if(!empty(trim($new_icon))){
		$icon = trim($new_icon);
	} else {
		$icon_err = "No icon selected.";
	}
			
	// Check input errors before updating the database
	if(empty($icon_err)){
		// Prepare an update statement
		$sql = "UPDATE users SET icon = ? WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "si", $param_icon, $param_id);
			
			// Set parameters
			$param_icon = $icon;
			$param_id = $_SESSION["id"];
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){                            
				$_SESSION["user_icon"] = $icon;
				$icon_success = "Updated icon to ".$_SESSION["user_icon"]."!";
			} else{
				echo "Oops! Something went wrong. Please try again later.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	
	// Close connection
	mysqli_close($users_conn);
	
	// redirect to user details page
	header("Location: /user/details");
}

// update icon when form posts to this page
if($_SERVER["REQUEST_METHOD"] == "POST") {
	updateIcon($_POST["new-icon"]);
}