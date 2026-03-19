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
$pronouns = $pronouns_err = $pronouns_success = "";

$pronouns_length = 20;

function updatePronouns($new_pronouns) {
	// empty variables for storing data
	global $users_conn, $pronouns, $pronouns_err, $pronouns_success, $pronouns_length;
	
	$pronouns = "";
	// if icon has been given, set it
	if (isset($new_pronouns)) $pronouns = trim($new_pronouns);
	
	if (strlen(trim($pronouns)) > $pronouns_length) {
		$pronouns_err = "Pronouns must not be longer than ".$pronouns_length;
	}
	
	// Check input errors before updating the database
	if(empty($pronouns_err)){
		// Prepare an update statement
		$sql = "UPDATE users SET pronouns = ? WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "si", $param_pronouns, $param_id);
			
			// Set parameters
			$param_pronouns = $pronouns;
			$param_id = $_SESSION["id"];
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){                            
				$_SESSION["user_pronouns"] = $pronouns;
				$icon_success = "Updated pronouns to ".$_SESSION["user_pronouns"]."!";
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
	updatePronouns($_POST["pronouns"]);
}