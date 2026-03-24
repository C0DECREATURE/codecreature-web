<?php

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// Include chat database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/connect.php";
// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/chat-functions.php";
// Include user database functions
require_once $_SERVER['DOCUMENT_ROOT']."/user/database.php";

$logged_in = false;
$user_id = '0';
$user_IP = $_SERVER['REMOTE_ADDR'];
$username = "Anonymous";
$user_icon = "";
// Check if the user is already logged in, if yes then redirect to user details page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	$logged_in = true;
	$user_id = $_SESSION["id"];
	$username = $_SESSION["username"];                       
	$user_icon = $_SESSION["user_icon"];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error_text = $message_id = $new_message = $table_name = "";

	// check for chat table name
	if (!isset($_REQUEST['chat-table']) || empty(trim($_REQUEST['chat-table']))) {
		$error_text = "Missing chat database table name.";
	} else $table_name = trim($_REQUEST['chat-table']);
	
	// check for new message text
	if (!isset($_REQUEST['message']) || empty(trim($_REQUEST['message']))) {
		// Escape user inputs for security
		$message = mysqli_real_escape_string(
			$chat_conn, cleanMessageText(trim($_REQUEST['message']))
		);
		if (empty($message)) $error_text = "Message body cannot be blank.";
	} else {
		// Escape user inputs for security
		$message = mysqli_real_escape_string(
			$chat_conn, cleanMessageText(trim($_REQUEST['message']))
		);
		if (empty($message)) $error_text = "Message body cannot be blank.";
	}
	
	date_default_timezone_set('America/New_York'); // EST
	$date = time();
	
	if (empty($error_text)) {
		// Attempt insert query execution
		$sql = "INSERT INTO $table_name (user_id, IP_address, message, date) 
								VALUES ('$user_id', '$user_IP', '$message', '$date')";
		if (!mysqli_query($chat_conn, $sql)) {
			$error_text = "Message not sent!";
		}
	}
	
	$response = [];
	$response["error"] = $error_text;
	echo json_encode($response);
}
?>