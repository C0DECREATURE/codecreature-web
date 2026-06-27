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

$prev_deleted = 0;

while ($message = mysqli_fetch_array($result)) {
	$message_user = getPublicUserData($message['user_id']);
	
	if (empty($message['error'])) {
		// determine whether the current user sent this message
		$own_message = (
			($user_id == "0" && $message_user['id'] == "0" && $message['IP_address'] == $user_IP)
			|| ($user_id != "0" && $message_user['id'] == $_SESSION["id"])
		) ? true : false;
		
		$html_id = "message-".$message['id'];
		$html_own = $own_message ? ' self' : '';
		
		if (intval($message['deleted']) == 1) {
			$str = "(message deleted)";
			if ($prev_deleted > 0) {
				$del_str = $prev_deleted + 1;
				$str = "(" . $del_str . " messages deleted)"
							. "<script>document.getElementById('$html_id').previousSibling.style.display = 'none';</script>";
			}
			echo "<div id='$html_id' class='message deleted $html_own'>$str</div>";
			$prev_deleted += 1;
			continue;
		} else {
			$prev_deleted = 0;
?>
	<div class="message<?php
			echo $own_message ? ' self' : '';
			echo !empty($message_user['color']) ? " ".$message_user['color'] : "";
			echo " ".$message_user['authorization'];
		?>"
		id="message-<?php echo $message['id']; ?>"
		data-uid="<?php echo $message['user_id']; ?>"
		data-timestamp="<?php echo $message['date']; ?>"
		data-raw-bbcode="<?php echo htmlspecialchars_decode($message['message']); ?>">
		<a class="icon" <?php if($message['user_id'] != "0") { echo "href='/u/".$message_user['username']."'"; } ?> target="_top">
			<img src="<?php echo $message_user['icon']; ?>" alt="">
		</a>
		
		<div class="bubble">
			<header>
				<a class="username" <?php if($message['user_id'] != "0") { echo "href='/u/".$message_user['username']."'"; } ?>
					target="_top"><?php echo $message_user['username']; ?></a>
				<?php
				$pronouns = $message_user["pronouns"];
				if (!empty($pronouns)) { ?>
					<span class="pronouns" title="pronouns"><?php
					$pronouns = $message_user['pronouns'];
					echo !empty($pronouns) ? "(".$pronouns.")" : ""; ?>
						</span>
					
				<?php } ?>
				
				<span class="date">
					<span class="edited <?php echo empty($message['edited']) ? "hidden" : ""; ?>">(edited) </span>
					<span class="date-text"></span>
				</span>
			</header>
			<div class="content"><?php
				echo htmlspecialchars_decode($bbcode->Parse(replaceEmojis($message['message'])));
			?></div>
		</div>
		<script>
			(()=>{
				<?php
					$own_message_txt = $own_message ? 'true' : 'false';
					echo "messageSetup(".$message['id'].")";
				?>
			})();
		</script>
	</div>
<?php
		}
	} else echo $message["error"];
}


?>
