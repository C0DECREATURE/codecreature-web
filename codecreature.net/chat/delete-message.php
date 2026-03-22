<?php

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/chat-functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error_text = $message_id = $table_name = "";
	
	// check for chat table name
	if (!isset($_REQUEST['chat-table']) || empty(trim($_REQUEST['chat-table']))) {
		$error_text = "Missing chat database table name.";
	} else $table_name = trim($_REQUEST['chat-table']);
	
	// check for message id
	if (!isset($_REQUEST['message-id']) || empty(trim($_REQUEST['message-id']))) {
		$error_text = "Missing message ID.";
	} else { $message_id = intval(trim($_REQUEST['message-id'])); }
	
	// if still no errors...
	// make sure message exists and current user allowed to modify
	if (empty($error_text)) $error_text = getMessageModifyErr($message_id, $table_name);
	
	// if still no errors...
	// delete the message
	if (empty($error_text)) {
		$sql = "DELETE FROM $table_name WHERE id = ?";
		if($stmt = mysqli_prepare($chat_conn, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "i", $param_message_id);
			$param_message_id = $message_id;
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
			} else{
				$error_text = "Could not connect to database. Please try again later.";
			}
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	
	echo $error_text;
}
?>