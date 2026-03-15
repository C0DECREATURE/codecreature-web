<?php
// Initialize the session
session_start();

$user_IP = $_SERVER['REMOTE_ADDR'];
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "Anonymous";

// Include database connection file
require_once "connect.php";


/*************************************/
/* BBCODE PARSER */
require_once $_SERVER['DOCUMENT_ROOT'].'/codefiles/nbbc-3.0.0/Loader.php';
use Nbbc\BBCode;
$bbcode = new BBCode;

// set the directory to find smileys
$bbcode->ClearSmileys();
$bbcode->SetSmileyDir("/graphix/emojis"); /* DEBUG it's looking for them locally still..?? */
$bbcode->AddSmiley(":heart:","heart.png");
$bbcode->AddSmiley(":brokenheart:","broken_heart.png");
$bbcode->AddSmiley(":right:","arrow_right.png");
$bbcode->AddSmiley(":left:","arrow_left.png");
$bbcode->AddSmiley(":up:","arrow_up.png");
$bbcode->AddSmiley(":down:","arrow_down.png");

// automatically detect and style links
$bbcode->SetDetectURLs(true);
$bbcode->SetURLPattern('<a href="/url?redirect={$url/h}">{$text/h}</a>');

// remove default rules I don't want included in chat messages
$bbcode->AddRule('alt',[
		'mode' => BBCode::BBCODE_MODE_ENHANCED,
		'template' => '<span class="tq" data-a="{$_default}">{$_content}</span>',
		'class' => 'inline',
		'content' => 'BBCODE_REQUIRED',
		'allow_in' => ['listitem', 'block', 'columns', 'inline', 'link']
]);
$bbcode->AddRule('e',[
		'mode' => BBCode::BBCODE_MODE_ENHANCED,
		'template' => '<span class="tq-e" data-a="{$_default}">{$_content}</span>',
		'class' => 'inline',
		'content' => 'BBCODE_REQUIRED',
		'allow_in' => ['listitem', 'block', 'columns', 'inline', 'link']
]);

// remove default rules I don't want included in chat messages
$bbcode->RemoveRule('acronym');
$bbcode->RemoveRule('font');
$bbcode->RemoveRule('code');
$bbcode->RemoveRule('email');
$bbcode->RemoveRule('wiki');
$bbcode->RemoveRule('columns');

/*************************************/

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
		<div class="content"><?php
			echo $bbcode->Parse($row['message']);
		?></div>
	</div>
</div>
<script>
	// assign text and alt text for all typing quirk elements in the message that was just loaded
	(()=>{
		<?php echo "let tqParentElement = document.getElementById('message-".$row['id']."');"; ?>
		tqAlts(tqParentElement);
	})();
</script>
	<?php
	}
?>
