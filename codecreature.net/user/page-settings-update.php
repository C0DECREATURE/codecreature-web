<?php
// Initialize the session
if(!isset($_SESSION)){session_start();}

// Check if a user is logged in, otherwise do nothing
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
	// user database connection file
	require_once "connect.php";

	// update warnings options if specified
	if(!empty($_POST["updateType"]) && trim($_POST["updateType"]) == "warnings") {
		// get the settings variables
		$seenWarnings = filter_var($_POST["seenWarnings"], FILTER_VALIDATE_BOOLEAN);
		$acceptedWarningsTime = intval(trim($_POST["acceptedWarningsTime"]));
		$showSpecificWarnings = trim($_POST["showSpecificWarnings"]);
		
		// Check input errors before updating the database
		if(!empty($seenWarnings)){
			// Prepare an update statement
			$sql = "INSERT INTO settings (id, seenWarnings, acceptedWarningsTime, showSpecificWarnings) VALUES (?, ?, ?, ?)
					ON DUPLICATE KEY UPDATE seenWarnings = ? , acceptedWarningsTime = ?, showSpecificWarnings = ?";
			
			if($stmt = mysqli_prepare($users_conn, $sql)){
				mysqli_stmt_bind_param($stmt, "isissis", $param_id, $seenWarnings, $acceptedWarningsTime, $showSpecificWarnings, $seenWarnings, $acceptedWarningsTime, $showSpecificWarnings);
				$param_id = $_SESSION["id"];
				
				// Attempt to execute the prepared statement
				if(!mysqli_stmt_execute($stmt)){
					echo "Error: Failed to save settings to user's account. Please try again later.";
				}

				// Close statement
				mysqli_stmt_close($stmt);
			}
		} else { }
	}
	
	// update custom cursor page settings if specified
	if(!empty($_POST["customCursorOn"])) {
		$customCursorOn = filter_var($_POST["customCursorOn"], FILTER_VALIDATE_BOOLEAN);
		
		// Prepare an update statement
		$sql = "INSERT INTO settings (id, customCursorOn) VALUES (?, ?)
				ON DUPLICATE KEY UPDATE customCursorOn = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "iii", $param_id, $customCursorOn, $customCursorOn);
			$param_id = $_SESSION["id"];
			
			// Attempt to execute the prepared statement
			if(!mysqli_stmt_execute($stmt)){
				echo "Error: Failed to save settings to user's account. Please try again later.";
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	
	// update custom scrollbar page settings if specified
	if(!empty($_POST["customScrollbarsOn"])) {
		$customScrollbarsOn = filter_var($_POST["customScrollbarsOn"], FILTER_VALIDATE_BOOLEAN);
		
		// Prepare an update statement
		$sql = "INSERT INTO settings (id, customScrollbarsOn) VALUES (?, ?)
				ON DUPLICATE KEY UPDATE customScrollbarsOn = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "iii", $param_id, $customScrollbarsOn, $customScrollbarsOn);
			$param_id = $_SESSION["id"];
			
			// Attempt to execute the prepared statement
			if(!mysqli_stmt_execute($stmt)){
				echo "Error: Failed to save settings to user's account. Please try again later.";
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	
	// update typing quirk settings if specified
	if(!empty($_POST["tqOn"])) {
		$tqOn = filter_var($_POST["tqOn"], FILTER_VALIDATE_BOOLEAN);
		
		// Prepare an update statement
		$sql = "INSERT INTO settings (id, tqOn) VALUES (?, ?)
				ON DUPLICATE KEY UPDATE tqOn = ?";
		
		if($stmt = mysqli_prepare($users_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "iii", $param_id, $tqOn, $tqOn);
			$param_id = $_SESSION["id"];
			
			// Attempt to execute the prepared statement
			if(!mysqli_stmt_execute($stmt)){
				echo "Error: Failed to save settings to user's account. Please try again later.";
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}
?>