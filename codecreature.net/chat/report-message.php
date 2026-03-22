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
	
	// if still no errors...
	// make sure chat table name is valid
	if (empty($error_text) && !isValidChatTable($table_name)) $error_text = 'Invalid chat database table "'.$table_name.'"';
	
	// check for message id
	if (!isset($_REQUEST['message-id']) || empty(trim($_REQUEST['message-id']))) {
		$error_text = "Missing message ID.";
	} else { $message_id = intval(trim($_REQUEST['message-id'])); }
	
	// if still no errors...
	// get message details
	if (!$error_text) {
		$sql = "SELECT * FROM $table_name WHERE id = ?";
		if($stmt = mysqli_prepare($chat_conn, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "i", $param_message_id);
			$param_message_id = $message_id;
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
				// store result
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) == 1) {
					$message = getMessage($message_id,$table_name);
					if (isset($message["error"]) && !empty($message["error"])) {
						$error_text = $message["error"];
					} else {
						// report the message
						$message_user_id = $message['user_id'];
						$message_contents = $message['message'];
						$sql = "INSERT INTO reports
										(chat_table, user_id, message_id, message, reporter_id, reporter_IP)
										VALUES
										('".$table_name."', $message_user_id, $message_id, '".$message_contents."', $user_id, '".$user_IP."')";
						if ($stmt = mysqli_prepare($chat_conn, $sql)) {
							if(!mysqli_stmt_execute($stmt)) { $error_text = "Could not connect to database. Please try again later."; }
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
	
	echo empty($error_text) ? "Report submitted." : "Error: ".$error_text;
}
?>