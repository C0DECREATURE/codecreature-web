<?php

// Include database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/user/connect.php";

// Include user data storage file
require_once $_SERVER['DOCUMENT_ROOT']."/user/login/store-user.php";

// attempt to remember user based on token in cookies
function attemptRememberLogin() {
	global $users_conn;
	
	if (
		(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
		&& isset($_COOKIE['remember_token'])
	) {
		$token = $_COOKIE['remember_token'];
		$token_hash = hash('sha256', $token);
		
		$sql = "SELECT user_id FROM remember_tokens WHERE token_hash = ? AND expires_at > NOW()";
		if($stmt = mysqli_prepare($users_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $token_hash);
			if(mysqli_stmt_execute($stmt)){
				$result = $stmt->get_result();
				$row = mysqli_fetch_assoc($result);
				$user_id = $row['user_id'];
				
				$sql = "SELECT username, authorization, pronouns, icon FROM users WHERE id = ?";
				if($stmt = mysqli_prepare($users_conn, $sql)){
					mysqli_stmt_bind_param($stmt, "i", $user_id);
					if(mysqli_stmt_execute($stmt)){
						$result = $stmt->get_result();
						$row = mysqli_fetch_assoc($result);
						storeUser($user_id, $row['username'], $row['authorization'], $row['pronouns'], $row['icon']);
						return true;
					} else{
					}
					mysqli_stmt_close($stmt);
				}
				
			} else{
			}
			mysqli_stmt_close($stmt);
		}
	}
	
	return false;
}

?>