<?php

// Initialize the session
if(!isset($_SESSION)){session_start();}

// Include database connection file
require_once "connect.php";

// Include database functions
require_once "database.php";

// error message to echo if something goes wrong
$error = "";

// final message to output if successful
$message = "";

// verify that the current user is authorized to ban others
if (!empty($_SESSION["id"])) {
	$auth = getAuthorization($_SESSION["id"]);
	if ($auth != "admin" && $auth != "moderator") { $error = "Your account is not authorized to ban other users."; }
} else {
	$error = "Logged out users are not authorized to ban other users.";
}

if (empty($error)) {
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

	if (empty($ban_reason)) { $ban_reason = "None given."; }

	// Ensure user details have been provided
	if (empty($ban_user_id) && empty($ban_IP)) { $error = "No user provided."; }
	// Don't allow admins to be banned
	if (!empty($ban_user_id) && getAuthorization($ban_user_id) == "admin") { $error = "Admins cannot be banned."; }
	// Only admins can ban mods
	if (!empty($ban_user_id) && getAuthorization($ban_user_id) == "moderator" && $auth != "admin") {
		$error = "You are not authorized to ban moderators.";
	}
	
	if (empty($error)) {
		if (!empty($duration)) { $ban_expiration = time() + $duration; }
		
		// if IP address given
		if (!empty($ban_IP)) {
			// Insert user id into ban list
			$sql = "INSERT INTO ban_list ( IP_address, reason, expiration ) VALUES ( ? , ? , ? );";
			if($stmt = mysqli_prepare($users_conn, $sql)){
				mysqli_stmt_bind_param($stmt, "ssi", $ban_IP, $ban_reason, $ban_expiration);
				if(!mysqli_stmt_execute($stmt)){ $error = "IP ban execution failed. Please try again later."; }
				mysqli_stmt_close($stmt);
				$message = $message . "Banned IP address " . $ban_IP;
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
				if (!empty($message)) $message = $message . "\n";
				$message = $message . "Banned user ID #" . $ban_user_id;
			} else { $error = "User ban statement preparation failed. Please try again later."; }
		}
		
		// Close connection
		mysqli_close($users_conn);
	}
}

echo empty($error) ? $message : $error;
?>