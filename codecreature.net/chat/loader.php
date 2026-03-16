<?php
// Initialize the session
session_start();

$user_IP = $_SERVER['REMOTE_ADDR'];
$user_id = isset($_SESSION["id"]) ? $_SESSION["id"] : "0";

// Include chat database connection file
require_once "connect.php";

// include user database file (functions to access user info based on user id)
// getIcon(), getUsername()
require_once $_SERVER['DOCUMENT_ROOT'].'/user/database.php';

/*************************************/
/* SETTINGS */
$load_limit = 50; // maximum number of messages to load at once


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

$chat_table = $_GET['chat_table'];

// only loads messages with id newer than $_GET['from']
// if $_GET['from'] not set, loads any messages
$from = isset($_GET['from']) ? $_GET['from'] : "0";
// if $_GET['to'] parameter given, only loads messages older than $_GET['to']
$sql_to = isset($_GET['to']) ? " AND id < ".$_GET['to'] : "";
// statement to get messages
$sql = "SELECT * FROM ".$chat_table." WHERE id > ".$from.$sql_to." ORDER BY id DESC LIMIT ".$load_limit.";";
$result = mysqli_query($chat_conn, $sql);

if ($result = mysqli_query($chat_conn, $sql)) {
	while ($row = mysqli_fetch_array($result))
		{
		?>
	<div class="message <?php echo (
				($user_id == "0" && $row['user_id'] == "0" && $row['IP_address'] == $user_IP)
				|| ($user_id != "0" && $row['user_id'] == $_SESSION["id"])
			) ? 'self' : ''; ?> <?php echo $row['authorization'];
		?>"
		id="message-<?php echo $row['id']; ?>">
		<img class="icon" src="<?php echo getIcon($row['user_id']); ?>" alt="">
		
		<div class="bubble">
			<header>
				<span class="username"><?php echo getUsername($row['user_id']); ?></span>
				<span class="date">
					<?php echo date('y/m/d h:i', (int)$row['date'] - (int)$_GET['timezone-offset'] ); ?>
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
}
?>
