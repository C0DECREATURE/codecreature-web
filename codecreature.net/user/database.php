<?php

// Include user database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/user/connect.php";

// returns an array of all user data that is safe to have 100% publicly accessible
// (e.g. no passwords, emails, etc)
function getPublicUserData($id) {
	global $users_conn;
	
	if (gettype($id) == "string") { $id = intval($id); }
	
	$user = [];
	
	if (empty($id)) {
		$user["username"] = "";
		$user["pronouns"] = "";
		$user["icon"] = getIconPath("");
	} else {
		// prepared statement to get icon for user
		$sql = "SELECT username, pronouns, icon FROM users WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = $id;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// bind result variables
				mysqli_stmt_bind_result($stmt, $username, $pronouns, $icon);
				// fetch values
				while (mysqli_stmt_fetch($stmt)) {
					$user["username"] = $username;
					$user["pronouns"] = $pronouns;
					$user["icon"] = getIconPath($icon);
				}
			} else{
				echo "Could not retrieve user data.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	return $user;
}

function getIdByUsername($username) {
	global $users_conn;
	
	// prepared statement to get icon for user
	$sql = "SELECT id FROM users WHERE username = ?";
	
	if($stmt = mysqli_prepare($users_conn, $sql)){
		// Bind variables to the prepared statement as parameters
		mysqli_stmt_bind_param($stmt, "s", $param_username);
		$param_username = $username;
		
		// Attempt to execute the prepared statement
		if(mysqli_stmt_execute($stmt)){
			// bind result variables
			mysqli_stmt_bind_result($stmt, $id);
			// fetch values
			while (mysqli_stmt_fetch($stmt)) {
				return $id;
			}
		} else{
			echo "Invalid username.";
		}
		
		// Close statement
		mysqli_stmt_close($stmt);
	}
}

function getUsername($id) {
	global $users_conn;
	
	if (gettype($id) == "string") { $id = intval($id); }
	
	if ($id == 0 || empty($id)) {
		return "Anonymous";
	} else {
		// prepared statement to get icon for user
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
					if (empty($username)) { $username = "Missing Username"; }
					return $username;
				}
			} else{
				echo "Could not retrieve username.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}

function getAuthorization($id) {
	global $users_conn;
	
	if (gettype($id) == "string") { $id = intval($id); }
	
	if ($id == 0 || empty($id)) {
		return "user";
	} else {
		// prepared statement to get icon for user
		$sql = "SELECT authorization FROM users WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = $id;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// bind result variables
				mysqli_stmt_bind_result($stmt, $auth);
				// fetch values
				while (mysqli_stmt_fetch($stmt)) {
					if (empty($auth)) { $auth = "user"; }
					return $auth;
				}
			} else{
				echo "Could not retrieve user authorization.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}

function getUserGamePrivacy($id) {
	global $users_conn;
	
	if (gettype($id) == "string") { $id = intval($id); }
	
	if ($id == 0 || empty($id)) {
		return "public";
	} else {
		// prepared statement to get game privacy setting for user
		$sql = "SELECT game_privacy FROM users WHERE id = ?";
		if($stmt = mysqli_prepare($users_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = $id;
			
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_bind_result($stmt, $privacy);
				while (mysqli_stmt_fetch($stmt)) {
					if (empty($privacy)) { $privacy = "public"; }
					return $privacy;
				}
			} else{
			}
			mysqli_stmt_close($stmt);
		}
	}
}

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
					return getIconPath($icon);
				}
			} else{
				echo "Could not retrieve icon.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}

function getIconPath($str) {
	if (empty($str)) { $str = "default"; }
	return "/user/icons/".$str.".png";
}

function getPronouns($id) {
	global $users_conn;
	
	if (gettype($id) == "string") { $id = intval($id); }
	
	if ($id == 0 || empty($id)) {
		return "";
	} else {
		// prepared statement to get icon for user
		$sql = "SELECT pronouns FROM users WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = $id;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// bind result variables
				mysqli_stmt_bind_result($stmt, $pronouns);
				// fetch values
				while (mysqli_stmt_fetch($stmt)) {
					return $pronouns;
				}
			} else{
				echo "Could not retrieve pronouns.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}

?>