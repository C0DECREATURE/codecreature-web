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
	
	if (empty($message["error"])) {
		$ban_IP = $message["IP_address"];
		if (!empty($message["user_id"])) $ban_user_id = $message["user_id"];
		// add the banning file
		include $_SERVER['DOCUMENT_ROOT']."/user/ban.php";
	} else { echo $message["error"]; }
}
?>