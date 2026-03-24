<?php

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// Include chat database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/connect.php";
// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/chat-functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
	$error_text = $message_id = $new_message = $table_name = "";
	
	// check for chat table name
	if (!isset($_REQUEST['chat-table']) || empty(trim($_REQUEST['chat-table']))) {
		$error_text = "Missing chat database table name.";
	} else $table_name = trim($_REQUEST['chat-table']);
	
	// check for message id
	if (!isset($_REQUEST['message-id']) || empty(trim($_REQUEST['message-id']))) {
		$error_text = "Missing message ID.";
	} else { $message_id = intval(trim($_REQUEST['message-id'])); }
	
	// check for new message text
	if (!isset($_REQUEST['new-message']) || empty(trim($_REQUEST['new-message']))) {
		$error_text = "New message body cannot be blank.";
	} else { $new_message = cleanMessageText($_REQUEST['new-message']); }
	
	// if still no errors...
	// make sure message exists and current user allowed to modify
	if (empty($error_text)) $error_text = getMessageModifyErr($message_id, $table_name);
	
	$message_changed = true;
	// if still no errors...
	// make sure message text is actually being changed
	if (empty($error_text)) {
		$data = getMessage($message_id,$table_name);
		if (empty($data["error"])) {
			$cur_message = $data["message"];
			if (!empty($cur_message) && $new_message == $cur_message) $message_changed = false;
		} else { $error_text = $data["error"]; }
	}
	
	// if still no errors...
	// delete the message
	if (empty($error_text) && $message_changed) {
		$sql = "UPDATE $table_name SET message = ?, edited = ? WHERE id = ?";
		if($stmt = mysqli_prepare($chat_conn, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "sii", $param_message_contents, $param_time, $param_message_id);
			$param_message_contents = $new_message;
			$param_message_id = $message_id;
			// time of edit
			$param_time = time();
			
			// attempt to execute
			if (mysqli_stmt_execute($stmt)) {
			} else{
				$error_text = "Could not connect to database. Please try again later.";
			}
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	
	$response = [];
	$response["error"] = $error_text;
	$response["new_message"] = $new_message;
	echo json_encode($response);
}
?>