<?php

// Initialize the session
session_start();

// Include database connection file
require_once "../connect.php";
	
$logged_in = false;
$user_id = '0';
$user_IP = $_SERVER['REMOTE_ADDR'];
$username = "Anonymous";
$user_authorization = "user";
$user_icon = "";
// Check if the user is already logged in, if yes then redirect to user details page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	$logged_in = true;
	$user_id = $_SESSION["id"];
	$username = $_SESSION["username"];                    
	$user_authorization = $_SESSION["user_authorization"];                            
	$user_icon = $_SESSION["user_icon"];   
}

if (isset($_POST['submit'])){
	// if message text is not empty
	if (!empty(trim($_REQUEST['message']))) {
		// Escape user inputs for security
		$message = mysqli_real_escape_string(
			$chat_conn, $_REQUEST['message']
		);
		
		// strip HTML tags from message
		$message = strip_tags($message);
		
		date_default_timezone_set('America/New_York'); // EST
		$date = time();
		
		$chat_table = $_POST['chat-table'];
			
		// Attempt insert query execution
		$sql = "INSERT INTO $chat_table (user_id, username, IP_address, authorization, message, date) 
								VALUES ('$user_id', '$username', '$user_IP', '$user_authorization', '$message', '$date')";
		if (mysqli_query($chat_conn, $sql)) {
			;
		} else {
			echo "ERROR: Message not sent!!!";
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widateh=device-widateh, initial-scale=1.0">
    <title>worm chat</title>
		<meta name="description" content="Worm games chat room">
		<meta name="keywords" content="worm, game, chat, forum, discussion, message">
		<meta name="author" content="codecreature">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20251216"></script>
		
		<!-- fonts -->
		<script>fonts.load('Yet R','Super Comic')</script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20251216" id="svg-icons-js"></script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		
		<!--chat stylesheet-->
		<link href="/chat/chat.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- chat code -->
    <script src="/chat/liveChat.js"></script>
</head>
<body>
	<main class="chatbox">
		<header>
			<a href="/user"><?php echo $logged_in ? $username : 'log in'; ?></a>
			<button id="page-settings" class="open-page-settings" aria-label="page settings"
			onclick="togglePageSettings();" onfocusvisible="togglePageSettings();">
				<i class="svg-icon svg-icon-solid" data-icon="gear-solid" alt="">
					<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">
						<path style="stroke-linejoin:round;stroke-linecap:butt;" d="M 58.475469,8.2100704 V 25.772997 A 41.184249,41.184253 0 0 0 35.106834,39.084493 L 20.308319,30.540394 12.64347,43.816052 27.439039,52.358188 a 41.184249,41.184253 0 0 0 -2.48311,13.787695 41.184249,41.184253 0 0 0 2.392781,13.545669 l -14.70524,8.490098 7.155267,13.56973 15.138236,-8.739987 a 41.184249,41.184253 0 0 0 23.538496,13.507377 v 16.9748 l 15.329698,0.58813 V 106.51877 A 41.184249,41.184253 0 0 0 97.497322,92.806186 l 15.493668,8.945194 7.15527,-13.56973 -15.124,-8.732125 A 41.184249,41.184253 0 0 0 107.3247,66.145883 41.184249,41.184253 0 0 0 105.01048,52.554559 L 120.14626,43.816052 112.4819,30.540394 97.340717,39.282337 A 41.184249,41.184253 0 0 0 73.805167,25.688558 V 8.2100704 Z m 7.664849,31.9490626 a 25.987005,25.986999 0 0 1 25.98724,25.98675 25.987005,25.986999 0 0 1 -25.98724,25.987241 25.987005,25.986999 0 0 1 -25.98675,-25.987241 25.987005,25.986999 0 0 1 25.98675,-25.98675 z" />
					</svg>
				</i>
			</button>
			<div id="page-settings-contents" class="page-settings-contents hidden" ariaLabel="page settings">
				<!--page settings go here-->
				<span><a href="/chat/bbcode">BBCode Style Guide</a></span>
			</div>
		</header>
		
		<section class="messages" id="messages">
		</section>
		
		<form id="new-message" method="POST">
			<input type="hidden" name="chat-table" value="worm_chat"></input>
			<script>
				let localDate = new Date();
				document.getElementById('timezone-offset').value = localDate.getTimezoneOffset() * 60;
			</script>
			<input id="message-input" type="text" name="message" minlength="1" maxlength="400" autocomplete="off"></input>
			<button type="submit" name="submit">send</button>
		</form>
	</main>
		
</body></html>