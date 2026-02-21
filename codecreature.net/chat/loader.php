<?php
// Initialize the session
session_start();

$user_IP = $_SERVER['REMOTE_ADDR'];
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "Anonymous";

// Include database connection file
require_once "connect.php";

$sql = "SELECT * FROM worm_chat ORDER BY id DESC LIMIT 50;";
$result = mysqli_query($chat_conn, $sql);

while ($row = mysqli_fetch_array($result))
	{
	?>
<div class="
		message
		<?php echo (
			($username == "Anonymous" && $row['username'] == "Anonymous" && $row['IP_address'] == $user_IP)
			|| $row['username'] == $username
		) ? 'self' : ''; ?>
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
	<?php
	}
?>
