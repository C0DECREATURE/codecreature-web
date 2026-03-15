<?php

// Include database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/user/connect.php";

function getUsernameById($id) {
	global $users_conn;
	
	if (gettype($id) == "string") { $id = intval($id); }
	
	if ($id == 0 || empty($id)) {
		return "Anonymous";
	} else {
		// prepared statement to get username for user
		$sql = "SELECT username FROM users WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = $id;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// bind result variables
				mysqli_stmt_bind_result($stmt, $username);
				// fetch values
				while (mysqli_stmt_fetch($stmt)) {
					return $username;
				}
			} else{
				echo "No username for id #".$id;
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}