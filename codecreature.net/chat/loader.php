<?php
// Initialize the session
session_start();

$user_IP = $_SERVER['REMOTE_ADDR'];
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "Anonymous";

// Include database connection file
require_once "connect.php";

$sql = "SELECT * FROM worm_chat WHERE id > ". $_GET['from'] ." ORDER BY id DESC LIMIT 50;";
$result = mysqli_query($chat_conn, $sql);

// include function getIcon($id) to get icon path for given user id
require_once $_SERVER['DOCUMENT_ROOT'].'/user/icon-get.php';

while ($row = mysqli_fetch_array($result))
	{
	?>
<div class="message <?php echo (
			($username == "Anonymous" && $row['username'] == "Anonymous" && $row['IP_address'] == $user_IP)
			|| ($username != "Anonymous" && $row['username'] == $username)
		) ? 'self' : ''; ?> <?php echo $row['authorization'];
	// DEBUG: not working for anon messages, also want it to be based on user ID rather than username
	?>"
	id="message-<?php echo $row['id']; ?>">
	<img class="icon" src="<?php echo getIcon($row['user_id']); ?>" alt="">
	
	<div class="bubble">
		<header>
			<span class="username"><?php echo $row['username']; ?></span>
			<span class="date">
				<?php echo date('Y/m/d h:i', (int)$row['date'] - (int)$_GET['timezone-offset'] ); ?>
			</span>
		</header>
		<div class="content"><?php echo $row['message']; ?></div>
	</div>
</div>
	<?php
	}
?>
