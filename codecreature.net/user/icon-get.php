<?php

// Include database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/user/connect.php";

function getIcon($id) {
	global $users_conn;
	
	if (gettype($id) == "string") { $id = intval($id); }
	
	if ($id == 0 || empty($id)) {
		return "/user/icons/default.png";
	} else {
		// prepared statement to get icon for user
		$sql = "SELECT icon FROM users WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = $id;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// bind result variables
				mysqli_stmt_bind_result($stmt, $icon);
				// fetch values
				while (mysqli_stmt_fetch($stmt)) {
					if (empty($icon)) { $icon = "default"; }
					return "/user/icons/".$icon.".png";
				}
			} else{
				echo "Could not retrieve icon.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}