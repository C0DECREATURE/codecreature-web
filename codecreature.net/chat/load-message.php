<?php
// include user database file (functions to access user info based on user id)
// getIcon(), getUsername()
require_once $_SERVER['DOCUMENT_ROOT'].'/user/database.php';

// Include chat bbcode settings file
require_once "bbcode.php";

if (empty($message['error'])) {
	// determine whether the current user sent this message
	$own_message = (
		($user_id == "0" && $message['user_id'] == "0" && $message['IP_address'] == $user_IP)
		|| ($user_id != "0" && $message['user_id'] == $_SESSION["id"])
	) ? true : false;
?>
<div class="message <?php echo $own_message ? 'self' : ''; ?> <?php echo getAuthorization($message['user_id']);
	?>"
	id="message-<?php echo $message['id']; ?>">
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
?>
