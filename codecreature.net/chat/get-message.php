<?php

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/chat-functions.php";
// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/bbcode.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
	$message_id = $table_name = "";
	
	$message_id = trim($_REQUEST['message-id']);
	$table_name = trim($_REQUEST['chat-table']);
	
	$message = getMessage($message_id, $table_name);
	
	if (empty($message["error"])) $message["message-HTML"] = $bbcode->Parse($message['message']);
	
	echo json_encode($message);
}
?>