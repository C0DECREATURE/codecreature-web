<?php
// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

$user_IP = $_SERVER['REMOTE_ADDR'];
$user_id = isset($_SESSION["id"]) ? $_SESSION["id"] : "0";

// Include chat database connection file
require_once "connect.php";
// Include chat functions file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/chat-functions.php";

// include user database file (functions to access user info based on user id)
// getIcon(), getUsername()
require_once $_SERVER['DOCUMENT_ROOT'].'/user/database.php';

// Include chat bbcode settings file
require_once "bbcode.php";

/*************************************/
/* SETTINGS */
$load_limit = 25; // maximum number of messages to load at once

$chat_table = $_GET['chat_table'];
if (!isValidChatTable($chat_table)) throw new Exception('Invalid chatroom name "'.$chat_table.'"');

$sql = "";

// if a single message id was specified, only load that one
if (isset($_GET['message_id'])) {
	$message_id = intval($_GET['message_id']);
	// statement to get message
	$sql = "SELECT * FROM ".$chat_table." WHERE id = ".$message_id.";";
// if no single message id was specified, load a range of messages
} else {
	// only loads messages with id newer than $_GET['from']
	// if $_GET['from'] not set, loads any messages
	$from = isset($_GET['from']) ? intval($_GET['from']) : 0;
	// if $_GET['to'] parameter given, only loads messages older than $_GET['to']
	$sql_to = isset($_GET['to']) ? " AND id < ". intval($_GET['to']) : "";
	// statement to get messages
	$sql = "SELECT * FROM ".$chat_table." WHERE id > ".$from.$sql_to." ORDER BY id DESC LIMIT ".$load_limit.";";
}

$result = mysqli_query($chat_conn, $sql);

while ($message = mysqli_fetch_array($result)) {
	if (empty($message['error'])) {
		// determine whether the current user sent this message
		$own_message = (
			($user_id == "0" && $message['user_id'] == "0" && $message['IP_address'] == $user_IP)
			|| ($user_id != "0" && $message['user_id'] == $_SESSION["id"])
		) ? true : false;
	?>
	<div class="message <?php echo $own_message ? 'self' : ''; ?> <?php echo getAuthorization($message['user_id']);
		?>"
		id="message-<?php echo $message['id']; ?>"
		data-raw-bbcode="<?php echo htmlspecialchars_decode($message['message']); ?>">
		<img class="icon" src="<?php echo getIcon($message['user_id']); ?>" alt="">
		
		<div class="bubble">
			<header>
				<span class="username"><?php echo getUsername($message['user_id']); ?></span>
				<span class="pronouns" title="pronouns"><?php
					$pronouns = getPronouns($message['user_id']);
					echo !empty($pronouns) ? "(".$pronouns.")" : "";
				?></span>
				<span class="date">
					<span class="edited <?php echo empty($message['edited']) ? "hidden" : ""; ?>">(edited) </span>
					<span class="date-text"></span>
				</span>
			</header>
			<div class="content"><?php
				echo htmlspecialchars_decode($bbcode->Parse($message['message']));
			?></div>
		</div>
	</div>
	<script>
		(()=>{
			<?php echo "let message = document.getElementById('message-".$message['id']."');"; ?>
			// assign display date
			<?php
				$date = $message['date'];
				echo "message.querySelector('.date-text').innerHTML = formatMessageDisplayDate($date)";
			?>
			// assign text and alt text for all typing quirk elements in the message that was just loaded
			tqAlts(message);
			// open special message right click menu on right clicking message
			message.addEventListener("contextmenu",(e)=>{
				<?php
					$own_message_txt = $own_message ? 'true' : 'false';
					echo "messageRightClick(e, ".$message['id'].", ". $own_message_txt .");";
				?>
			});
		})();
	</script>
		<?php
	} else echo $message["error"];
}


?>
