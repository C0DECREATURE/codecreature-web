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
		
		// Escape user inputs for security
		$message = mysqli_real_escape_string(
			$chat_conn, $_REQUEST['message']
		);
		
		date_default_timezone_set('America/New_York'); // EST
		$date = date('y/m/d h:ia');
			
		// Attempt insert query execution
		$sql = "INSERT INTO worm_chat (user_id, username, authorization, message, date) 
								VALUES ('$user_id', '$username', '$user_authorization', '$message', '$date')";
		if (mysqli_query($chat_conn, $sql)) {
			;
		} else {
			echo "ERROR: Message not sent!!!";
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
		<script>fonts.load('Comic Sans MS','Super Comic')</script>
		
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
		<header><a href="/user"><?php echo $logged_in ? $username : 'log in'; ?></a></header>
		
		<section class="messages" id="messages">
			<div class="hidden" id="latest-message-id">0</div>
	<?php 
	$query = "SELECT * FROM worm_chat";
	$run = $chat_conn->query($query); 
	$i=0;

	while($row = $run->fetch_array()) :
		$last_id = $row['id'];
?>
<div class="
		message
		<?php echo ($row['username'] == "Anonymous" && $row['IP_address'] == $user_IP) || $row['username'] == $username ? ' self' : '' ?>
		<?php echo $row['authorization']; ?>
	" id="message-<?php echo $row['id']; ?>">
	<img class="icon" src="/user/icons/worm_blue.png" alt="">
	<div class="bubble">
		<header>
			<span class="username"><?php echo $row['username']; ?></span>
			<span class="date"><?php echo $row['date']; ?></span>
		</header>
		<div class="content"><?php echo $row['message']; ?></div>
	</div>
</div>
<?php endwhile; ?>
		</section>
		
		<form id="new-message" method="POST">
			<input id="message-input" type="text" name="message" autocomplete="off"></input>
			<button type="submit" name="submit">send</button>
		</form>
	</main>
		
</body></html>