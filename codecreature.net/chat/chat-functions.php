<?php

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// Include chat database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/connect.php";
// Include user database functions
require_once $_SERVER['DOCUMENT_ROOT']."/user/database.php";

$logged_in = false;
$user_id = '0';
$user_authorization = "";
$user_IP = $_SERVER['REMOTE_ADDR'];
// Check if the user is already logged in, if yes then redirect to user details page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	$logged_in = true;
	$user_id = $_SESSION["id"];
	$user_auth = getAuthorization($user_id);
}

function isValidChatTable($table_name) {
	global $chat_conn;
	$chat_tables = array_column($chat_conn->query('SHOW TABLES')->fetch_all(),0);
	return in_array($table_name,$chat_tables);
}

// check for errors in current user attempting to modify a message
// make sure message exists, no duplicate message id, user has permission to modify
function getMessageModifyErr($message_id) {
	global $chat_conn; global $user_id; global $user_auth; global $logged_in;
	
	$error_text = "Something went wrong. Please try again later.";
	
	// if the current user is logged out, no modify permissions
	if (!$logged_in) {
		$error_text = "Logged out users can't modify messages, sorry!";
	// if the current user is logged in
	} else {
		$sql = "SELECT user_id FROM $table_name WHERE id = ?";
		if($stmt = mysqli_prepare($chat_conn, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "i", $param_message_id);
			$param_message_id = $message_id;
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
				// store result
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) == 1) {
					if ($user_auth != "moderator" && $user_auth != "admin") {
						// bind result variables
						mysqli_stmt_bind_result($stmt, $message_user_id);
						if (mysqli_stmt_fetch($stmt) && intval($message_user_id) != intval($user_id)) {
							$error_text = "You don't have permission to modify that message.";
						}
					}
				} else { $error_text = "Duplicate message ID found in database."; }
				
			} else{
				$error_text = "Could not connect to database. Please try again later.";
			}
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	
	return $error_text;
}

// get message data
function getMessage($message_id, $table_name) {
	global $chat_conn;
	
	$msg = [];
	
	$msg["error"] = isValidChatTable($table_name) ? "" : "Invalid chat table name.";
	
	if (empty($msg["error"])) {
		$sql = "SELECT * FROM $table_name WHERE id = ?";
		if($stmt = mysqli_prepare($chat_conn, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "i", $param_message_id);
			$param_message_id = $message_id;
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
				$result = mysqli_stmt_get_result($stmt);
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					$msg = $row;
				}
			} else {
				$msg["error"] = "Could not connect to database. Please try again later.";
			}
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	
	return $msg;
}

?>