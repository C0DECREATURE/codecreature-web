<?php

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// Include chat database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/connect.php";
// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/chat-functions.php";
// Include user database functions
require_once $_SERVER['DOCUMENT_ROOT']."/user/database.php";

$logged_in = false;
$user_id = '0';
$user_IP = $_SERVER['REMOTE_ADDR'];
$username = "Anonymous";
$user_icon = "";
// Check if the user is already logged in, if yes then redirect to user details page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	$logged_in = true;
	$user_id = $_SESSION["id"];
	$username = $_SESSION["username"];                       
	$user_icon = $_SESSION["user_icon"];
}

?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widateh=device-widateh, initial-scale=1.0">
    <title><?php echo $chatroom_name; ?> chat</title>
		<meta name="description" content=
			"<?php echo empty($meta_description) ? "Chat room on codecreature.net." : $meta_description; ?>">
		<meta name="keywords" content=
			"<?php echo empty($meta_keywords) ? "" : $meta_keywords.", "; ?>chat, forum, discussion, message">
		<meta name="author" content="codecreature">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20251216"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20251216"></script>
		
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
		<script>
			<?php
				echo 'const chatTableName = "'.$chat_table.'";';
				echo 'const userAuth = "'. getAuthorization($user_id) .'";';
				echo 'const oldestMessageId = '. getOldestMessageId($chat_table) .';';
			?>
		</script>
    <script src="/chat/liveChat.js"></script>
    <script src="/chat/chatFunctions.js"></script>
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
				<span><a href="/chat/rules">Chatroom Rules</a></span>
				<span><a href="/chat/bbcode">BBCode Style Guide</a></span>
			</div>
		</header>
		<section class="messages" id="messages">
			<!--load older messages button-->
			<button id="load-older" class="hidden" onclick="loadOlderChat();">load older messages</button>
			
			<!--right click message edit menu-->
			<div id="right-click-menu" class="right-click-menu hidden">
				<button id="right-click-report" class="txt-red" onclick="reportMessage(this.parentNode.dataset.messageId);">Report</button>
				<!--edit-->
				<button id="right-click-edit" 
				onclick="openMessageEditor(this.parentNode.dataset.messageId);">
					Edit
				</button>
				<!--delete-->
				<button id="right-click-delete" onclick="deleteMessage(this.parentNode.dataset.messageId);">Delete</button>
			</div>
			<script>document.addEventListener("click",hideRightClickMenus);</script>
			
			<!--message edit popup-->
			<form popover id="edit-message">
				<header><h3>Edit Message</h3></header>
				<div class="content">
					<textarea id="edit-message-new-text" name="new-message" maxlength="<?php echo $max_message_length; ?>" autocomplete="off"></textarea>
					<div class="bottom-buttons">
						<button class="cancel" onclick="this.closest('form').hidePopover();">cancel</button>
						<button class="submit" id="edit-message-submit" type="submit">update</button>
					</div>
				</div>
			</form>
			<script>
				function openMessageEditor(messageId) {
					let msgEl = document.getElementById('message-' + messageId);
					let form = document.getElementById('edit-message');
					let textArea = document.getElementById('edit-message-new-text');
					
					form.showPopover();
					form.dataset.messageId = messageId;
					
					// put message contents in editor text area
					textArea.value = "";
					const xhr = new XMLHttpRequest();
					xhr.open("POST", "/chat/get-message.php", true);
					xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					// do stuff when request finishes
					xhr.onreadystatechange = () => {
						if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
							if (xhr.responseText != '') {
								let msg = JSON.parse(xhr.responseText)["message"];
								msg = msg.replaceAll("[br]","\n");
								textArea.value = msg;
							} else {
								alert("Something went wrong! Try again later.");
							}
						}
					};
					// send the variables
					xhr.send(`message-id=${messageId}&chat-table=${chatTableName}`);
					
					textArea.focus();
				}
				
				(()=>{
					let form = document.getElementById('edit-message');
					
					document.getElementById("edit-message-new-text").addEventListener("keypress", (e)=>{
						if (e.key === "Enter" && !e.shiftKey) {
							e.preventDefault();
							document.getElementById("edit-message-submit").click();
						}
					});
					
					form.addEventListener("submit", function(event){
						event.preventDefault();
						let formProps = Object.fromEntries(new FormData(form));
						editMessage(form.dataset.messageId,formProps['new-message']);
						form.hidePopover();
					});
				})();
			</script>
			
		</section>
		
		<form id="new-message" method="POST" action="/chat/send-message.php">
			<input type="hidden" name="chat-table" value="<?php echo $chat_table; ?>"></input>
			<input id="message-input" type="text" name="message" minlength="1" maxlength="<?php echo $max_message_length; ?>" autocomplete="off"></input>
			<button type="submit" name="submit">send</button>
		</form>
		<script>
				(()=>{
					let form = document.getElementById('new-message');
					
					form.addEventListener("submit", function(event){
						event.preventDefault();
						let formProps = Object.fromEntries(new FormData(form));
						sendMessage(formProps['message']);
					});
				})();
			</script>
	</main>
		
</body></html>