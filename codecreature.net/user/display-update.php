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
	// if pronouns have been given, set them
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
}

function updateGamePrivacy($private) {
	global $users_conn;
	
	$privacy = (empty($private) || $private == "off") ? "public" : "private";
	
	// Prepare an update statement
	$sql = "UPDATE users SET game_privacy = ? WHERE id = ?";
	
	if($stmt = mysqli_prepare($users_conn, $sql)){
		mysqli_stmt_bind_param($stmt, "si", $param_privacy, $param_id);
		$param_privacy = $privacy;
		$param_id = $_SESSION["id"];
		
		// Attempt to execute the prepared statement
		if(mysqli_stmt_execute($stmt)){
		} else{
			echo "Oops! Something went wrong. Please try again later.";
		}
		
		// Close statement
		mysqli_stmt_close($stmt);
	}
}

function updateColor($color) {
	global $users_conn;
	
	// Prepare an update statement
	$sql = "UPDATE users SET color = ? WHERE id = ?";
	
	if($stmt = mysqli_prepare($users_conn, $sql)){
		mysqli_stmt_bind_param($stmt, "si", $param_color, $param_id);
		$param_color = $color;
		$param_id = $_SESSION["id"];
		
		// Attempt to execute the prepared statement
		if(mysqli_stmt_execute($stmt)){
		} else{
			echo "Oops! Something went wrong. Please try again later.";
		}
		
		// Close statement
		mysqli_stmt_close($stmt);
	}
}

// update icon when form posts to this page
if($_SERVER["REQUEST_METHOD"] == "POST") {
	updatePronouns($_POST["pronouns"]);
	
	$private = isset($_POST["game-privacy"]) ? $_POST["game-privacy"] : "off";
	updateGamePrivacy($private);
	
	updateColor($_POST["color"]);
	
	// redirect to user details page
	header("Location: /user/details");
}