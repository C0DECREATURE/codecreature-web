<?php
	// Initialize the session
	if(!isset($_SESSION)){session_start();}
	
	// Include database connection file
	require_once "connect.php";
	
	if (isset($_COOKIE['remember_token'])) {
		$token = $_COOKIE['remember_token'];
		$tokenHash = hash('sha256', $token);
		
		$stmt = $users_conn->prepare("DELETE FROM remember_tokens WHERE token_hash = ?");
		$stmt->execute([$tokenHash]);
		
		setcookie('remember_token', '', time() - 3600, '/', '', true, true);
	}
	 
	// Unset all of session variables
	$_SESSION = array();
	 
	// Destroy session
	session_destroy();
	 
	// Redirect to login page
	header("location: login/");
	exit;
?>