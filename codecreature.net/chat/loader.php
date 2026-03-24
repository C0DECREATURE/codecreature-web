<?php
// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

$user_IP = $_SERVER['REMOTE_ADDR'];
$user_id = isset($_SESSION["id"]) ? $_SESSION["id"] : "0";

// Include chat database connection file
require_once "connect.php";
// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/chat-functions.php";

// include user database file (functions to access user info based on user id)
// getIcon(), getUsername()
require_once $_SERVER['DOCUMENT_ROOT'].'/user/database.php';

// Include chat bbcode settings file
require_once "bbcode.php";

/*************************************/
/* SETTINGS */
$load_limit = 50; // maximum number of messages to load at once

$chat_table = $_GET['chat_table'];
if (!isValidChatTable($chat_table)) throw new Exception('Invalid chatroom name "'.$chat_table.'"');

// if a single message id was specified, only load that one
if (isset($_GET['message_id'])) {
	$message_id = intval($_GET['message_id']);
	$message = getMessage($message_id,$chat_table);
	include "load-message.php";
// if no single message id was specified, load a range of messages
} else {
	// id of oldest message in the table
	$oldest_message = getOldestMessageId($chat_table);
	// only loads messages with id newer than $_GET['from']
	// if $_GET['from'] not set, loads any messages
	$from = isset($_GET['from']) ? $_GET['from'] : 0;
	// if $_GET['to'] parameter given, only loads messages older than $_GET['to']
	$sql_to = isset($_GET['to']) ? " AND id < ".$_GET['to'] : "";
	// statement to get messages
	$sql = "SELECT * FROM ".$chat_table." WHERE id > ".$from.$sql_to." ORDER BY id DESC LIMIT ".$load_limit.";";
	$result = mysqli_query($chat_conn, $sql);

	while ($message = mysqli_fetch_array($result)) {
		include "load-message.php";
	}
}
?>
