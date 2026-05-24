<?php

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/chat-functions.php";
// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/bbcode.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = "";
	
	$since = intval($_REQUEST['since']);
	$table_name = $_REQUEST['chat-table'];
	$error = isValidChatTable($table_name) ? "" : "Invalid chat table name.";
	
	if (empty($error)) {
		// get message IDs of messages edited since given time
		$ids = [];
		
		$sql = "SELECT id FROM $table_name WHERE edited > ?";
		if($stmt = mysqli_prepare($chat_conn, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "i", $since);
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
				$result = mysqli_stmt_get_result($stmt);
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { $ids[] = $row['id']; }
				}
			} else {
				$error = "Could not connect to database. Please try again later.";
			}
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
		if ($error) echo $error;
		else echo json_encode($ids);
	}
}
?>