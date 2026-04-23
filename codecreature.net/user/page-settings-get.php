<script>
<?php
// Initialize the session
if(!isset($_SESSION)){session_start();}

$settings = [];

// If a user is logged in, get their settings
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
	// user database connection file
	require_once "connect.php";
	// get the user's saved settings
	$stmt = $users_conn->prepare("SELECT * FROM settings WHERE id = ?");
	$stmt->bind_param("i", $_SESSION["id"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$settings = $result->fetch_assoc();
	// remove the primary key row
	unset($settings['id']);
	
	// clean output
	foreach($settings as $key => $value) {
		// if a value is empty, clear it from the array
		if (trim($value) == "") unset($settings[$key]);
		// convert integer booleans to true/false
		else if ($value == 1) $settings[$key] = "true";
		else if ($value == 0) $settings[$key] = "false";
	}
	
	// set each of the settings in localStorage
	foreach($settings as $key => $value) {
		// set localStorage item with javascript
		echo "localStorage.setItem('$key', '$value');";
	}
}

$redirect_path = empty($_GET['redirect']) ? '/user/details' : $_GET['redirect'];
echo "window.location = '$redirect_path';";
?>
</script>