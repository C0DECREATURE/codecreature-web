<?php

// Initialize the session
if(!isset($_SESSION)){session_start();}

// Include database connection file
require_once "connect.php";

// error message to echo if something goes wrong
$error = "";

// Process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && (!empty($_POST["ban_user_id"]) || !empty($_POST["ban_IP_address"])) ) {
	// Get posted variables
	$ban_user_id = trim($_POST["ban_user_id"]);
	$ban_IP = trim($_POST["ban_IP_address"]);
	$ban_reason = trim($_POST["ban_reason"]);
	$duration = trim($_POST["ban_duration"]);
}

if (!empty($duration)) {
	$multiplier = 1;
	if (str_contains($duration,"h")) $multiplier = 3600;
	else if (str_contains($duration,"d")) $multiplier = 86400;
	// convert duration into seconds integer
	$duration =  intval(substr(trim($duration), 0, -1)) * $multiplier;
}

// Validate that user details have been provided
if (empty($ban_user_id) && empty($ban_IP)) {
	$error = "No user provided.";
} else if (empty($error)) {
	if (!empty($duration)) { $ban_expiration = time() + $duration; }
	
	// if IP address given
	if (!empty($ban_IP)) {
		// Insert user id into ban list
		$sql = "INSERT INTO ban_list ( IP_address, reason, expiration ) VALUES ( ? , ? , ? );";
		if($stmt = mysqli_prepare($users_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "ssi", $ban_IP, $ban_reason, $ban_expiration);
			if(!mysqli_stmt_execute($stmt)){ $error = "IP ban execution failed. Please try again later."; }
			mysqli_stmt_close($stmt);
		} else { $error = "IP ban statement preparation failed. Please try again later."; }
	}
	
	// if user id given
	if (!empty($ban_user_id)) {
		// Insert user id into ban list
		$sql = "INSERT INTO ban_list ( user_id, reason, expiration ) VALUES ( ? , ? , ? );";
		if($stmt = mysqli_prepare($users_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "isi", $ban_user_id, $ban_reason, $ban_expiration);
			if(!mysqli_stmt_execute($stmt)){ $error = "User ban execution failed. Please try again later."; }
			mysqli_stmt_close($stmt);
		} else { $error = "User ban statement preparation failed. Please try again later."; }
	}
	
	// Close connection
	mysqli_close($users_conn);
}

echo $error;
?>