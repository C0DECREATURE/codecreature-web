<?php
// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /login");
    exit;
}
 
// Include database connection file
require_once "../connect.php";

function updateSummary($summary) {
	// empty variables for storing data
	global $users_conn;
	
	// if icon has been given, set it
	if (!empty(trim($summary))) {
		$summary = mb_substr($summary, 0 , 1000);
		$summary = urlencode(htmlspecialchars($summary));
	} else {
		$summary = "";
	}
			
	// Check input errors before updating the database
	if(empty($summary_err)){
		// Prepare an update statement
		$id = $_POST["user_id"];
		$sql = "INSERT INTO profiles (id, summary) VALUES (?, ?)
				ON DUPLICATE KEY UPDATE summary = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "iss", $param_id, $param_summary, $param_summary);
			
			// Set parameters
			$param_summary = $summary;
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
	
	// Close connection
	mysqli_close($users_conn);
}

// update icon when form posts to this page
if($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION["id"] == $_POST["user_id"]) {
		updateSummary($_POST["new-summary"]);
	}
	
	// redirect to user details page
	header("Location: /u/".$_SESSION["username"]);
}