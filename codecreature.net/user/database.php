<?php

// Include user database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/user/connect.php";

// returns an array of all user data that is safe to have 100% publicly accessible
// (e.g. no passwords, emails, etc)
// DEBUG: $getProfile should default to false, but it's not registering the optional parameter for some reason..???
function getPublicUserData($id,$getProfile=true) {
	global $users_conn;
	
	if (gettype($id) == "string") { $id = intval($id); }
	
	$user = [];
	
	$user["id"] = $id;
	
	if (empty($id)) {
		$user["username"] = "Anonymous";
		$user["pronouns"] = "";
		$user["icon"] = getIconPath("");
		$user["authorization"] = "user";
	} else {
		// prepared statement to get icon for user
		$sql = "SELECT username, pronouns, icon, authorization, color FROM users WHERE id = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = $id;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// bind result variables
				mysqli_stmt_bind_result($stmt, $username, $pronouns, $icon, $authorization, $color);
				// fetch values
				while (mysqli_stmt_fetch($stmt)) {
					$user["username"] = $username;
					$user["pronouns"] = $pronouns;
					$user["icon"] = getIconPath($icon);
					$user["authorization"] = getModifiedAuthorization($authorization);
					$user["color"] = $color;
				}
			} else{
				echo "Could not retrieve user data.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	
	if ($getProfile) {
		$sql = "SELECT summary, flags FROM profiles WHERE id = ?";
		if($stmt = mysqli_prepare($users_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "i", $id);
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_bind_result($stmt, $summary, $flags);
				mysqli_stmt_fetch($stmt);
				$user["summary"] = htmlspecialchars_decode(urldecode($summary));
				$user["flags"] = json_decode($flags,true);
			} else{
				$user["summary"] = "";
				$user["flags"] = [];
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
					return getModifiedAuthorization($auth);
				}
			} else{
				echo "Could not retrieve user authorization.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}
function getModifiedAuthorization($auth) {
	if (empty($auth)) { $auth = "user"; }
	return $auth;
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

function isBannedIP($IP) {
	global $users_conn;
	
	$del_sql = "DELETE FROM ban_list WHERE expiration <= ". time() .";";
	if (mysqli_query($users_conn, $del_sql)) {}
	
	$isBanned = false;
	$IP = trim($IP);
	// get expiration date of any ban list rows for given IP address
	$sql = "SELECT id, expiration FROM ban_list WHERE IP_address = ? ;";
	if($stmt = mysqli_prepare($users_conn, $sql)){
		mysqli_stmt_bind_param($stmt, "s", $IP);
		
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_bind_result($stmt, $id, $expiration);
			while (mysqli_stmt_fetch($stmt)) {
				// if ban expires in the future or has no expiration, this IP is banned
				if (empty($expiration) || $expiration > time()) { $isBanned = true; }
			}
		}
		mysqli_stmt_close($stmt);
	}
	
	return $isBanned;
}
function isBannedUser($id) {
	global $users_conn;
	
	$del_sql = "DELETE FROM ban_list WHERE expiration <= ". time() .";";
	if (mysqli_query($users_conn, $del_sql)) {}
	
	$isBanned = false;
	// get expiration date of any ban list rows for given user ID
	$sql = "SELECT id, expiration FROM ban_list WHERE user_id = ? ;";
	if($stmt = mysqli_prepare($users_conn, $sql)){
		mysqli_stmt_bind_param($stmt, "i", $id);
		
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_bind_result($stmt, $id, $expiration);
			while (mysqli_stmt_fetch($stmt)) {
				// if ban expires in the future or has no expiration, this IP is banned
				if (empty($expiration) || $expiration > time()) { $isBanned = true; }
			}
		}
		mysqli_stmt_close($stmt);
	}
	
	return $isBanned;
}

function getBanInfo($type, $value) {
	global $users_conn;
	
	// delete expired bans from the table
	$del_sql = "DELETE FROM ban_list WHERE expiration <= ". time() .";";
	if (mysqli_query($users_conn, $del_sql)) {}
	
	$banInfo = $highest_expiration = $highest_reason = "";
	
	// get expiration date of any ban list rows for given user ID
	$sql = "SELECT expiration, reason FROM ban_list WHERE $type = ? ;";
	if($stmt = mysqli_prepare($users_conn, $sql)){
		$param_type = $type == "user_id" ? "i" : "s";
		mysqli_stmt_bind_param($stmt, $param_type, $value);
		
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_bind_result($stmt, $expiration, $reason);
			while (mysqli_stmt_fetch($stmt)) {
				// if ban expires in the future or has no expiration, this IP is banned
				if (empty($expiration)) {
					$highest_expiration = "forever";
					$highest_reason = $reason;
					break;
				} else if ($expiration > time() && $expiration > $highest_expiration) {
					$highest_expiration = $expiration;
					$highest_reason = $reason;
				}
			}
		}
		mysqli_stmt_close($stmt);
	}
	if (!empty($highest_expiration)) {
		$banInfo = [];
		$banInfo["type_text"] = $type == "user_id" ? "account" : "IP address";
		$banInfo["reason"] = $highest_reason;
		// get text describing ban duration
		if ($highest_expiration == "forever") { $banInfo["expire_text"] = "forever";
		} else {
			$time = $highest_expiration - time();
			$time_unit = "second";
			if ($time > 86400) { $time = $time / 86400; $time_unit = "day"; }
			else if ($time > 3600) { $time = $time / 3600; $time_unit = "hour"; }
			else if ($time > 60) { $time = $time / 60; $time_unit = "minute"; }
			$time = floor($time);
			if ($time > 1) $time_unit = $time_unit . "s";
			$banInfo["expire_text"] = "$time $time_unit";
		}
	}
	return $banInfo;
	
}

?>