<?php
require_once $_SERVER['DOCUMENT_ROOT']."/user/database.php";
require_once $_SERVER['DOCUMENT_ROOT']."/user/flags.php";

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

// get user parameters from url
if (isset($_GET['username'])) $id = getIdByUsername(urldecode($_GET['username']),true);
if (!isset($id) && isset($_GET['id'])) $id = (int)$_GET['id'];
// get user's public data array
if (!empty($id)) {
	$user = getPublicUserData($id);
	$auth = $user['authorization'];
	$username = $user['username'];
	$pronouns = $user['pronouns'];
	$icon = $user['icon'];
	$summary = $user['summary'];
}

// Include chat bbcode settings file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/bbcode.php";
?>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widateh=device-widateh, initial-scale=1.0">
    <title><?php echo empty($id) ? "user not found" : $username."'s profile"; ?></title>
		<meta name="description" content="<?php echo $username; ?>'s user profile.">
		<meta name="keywords" content="user,profile,userpage,<?php echo $username; ?>">
		<meta name="author" content="codecreature">
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="<?php echo $icon; ?>">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260930"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260930" rel="stylesheet" type="text/css"></link>
		
		<script>fonts.load("Super Comic","Yet R");</script>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260930"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260930"></script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260930" id="svg-icons-js"></script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260930" rel="stylesheet" type="text/css" media="all">
		<!--bbcode stylesheet-->
		<link href="/chat/bbcode.css?fileversion=20260930" rel="stylesheet" type="text/css" media="all">
		<!--identity ribbons stylesheet-->
		<link href="/user/profile/ribbons.css?fileversion=20260930" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="/user/profile/style.css?fileversion=20261107" rel="stylesheet" type="text/css" media="all">
</head>
<body class="<?php echo $user['color']; ?>">
	<div class="main-container">
		<header>
			<div class="username-header">
				<?php if (empty($id)) { ?>
				<div class="text">
					<h1 id="username">user not found</h1>
				</div>
				<?php } else { ?>
				<img id="icon" src="<?php echo $icon; ?>">
				<div class="text">
					<h1 id="username"><?php echo $username; ?></h1>
					<?php if (!empty($pronouns)) { ?>
						<div id="pronouns" class="pronouns"><?php echo $pronouns; ?></div>
					<?php } ?>
					<div class="uid"><?php echo ($auth != "user" ? "$auth, " : "")."user #".$id; ?></div>
				</div>
				<?php } ?>
			</div>
		</header>
		
		<?php
			if (!empty($user) && !empty($user["flags"])) {
				// get flag data and sort by category
				$genderFlags = [];
				$otherFlags = [];
				foreach($user["flags"] as $name) {
					// if flag recognized
					if (array_key_exists($name,$flagData)) {
						$f = $flagData[$name];
						if (!empty($f["type"]) && $f["type"] == "gender") $genderFlags[] = $f;
						else $otherFlags[] = $f;
					}
				}
			?>
			<section id="ribbons" aria-label="identity ribbons">
				<section id="ribbons-left" class="ribbons left" aria-label="gender identities">
					<?php
						foreach($genderFlags as $f) {
							$flag = $f["flag"];
							$name = $f["name"];
							echo "<button class='ribbon left $flag' style=background-image:url('/graphix/flags/$flag');><div class='wrapper'><span>$name</span></div></button>";
						}
					?>
				</section>
				<section id="ribbons-right" class="ribbons right" aria-label="other identities">
					<?php
						foreach($otherFlags as $f) {
							$flag = $f["flag"];
							$name = $f["name"];
							echo "<button class='ribbon right $flag' style=background-image:url('/graphix/flags/$flag');><div class='wrapper'><span>$name</span></div></button>";
						}
					?>
				</section>
			</section>
			<?php
			}
		?>
		
		
		<section class="<?php echo empty($summary) ? "empty" : ""; ?>" id="summary" aria-label="user summary">
			<?php echo (!empty($_SESSION["id"]) && $id == $_SESSION["id"]) ? '<button id="edit-summary-button" onclick="toggleEdit();" tabindex="1">✏️</button>' : ''; ?>
			<div class="text">
				<?php echo empty($id) ? "Did you make a typo? Check the url!" : (empty($summary) ? "This user hasn't written a summary!" : getPolishedBbcode(htmlspecialchars($summary))); ?>
			</div>
			<script>
				function toggleEdit() {
					document.getElementById('summary').classList.toggle('hidden');
					let editForm = document.getElementById('edit-summary-form');
					editForm.classList.toggle('hidden');
					if (!editForm.classList.contains('hidden')) {
						editForm.querySelector('textarea').focus();
					}
				}
			</script>
		</section>
		
		<?php if(!empty($id) && isset($_SESSION["id"]) && $_SESSION["id"] == $user["id"]) { ?>
		<form id="edit-summary-form" class="hidden" action="/user/profile/update.php" method="POST">
			<input type="hidden" name="user_id" value="<?php echo $id; ?>"></input>
			<textarea id="edit-summary" name="new-summary" value="" maxlength="2500"><?php echo htmlspecialchars_decode($summary); ?></textarea>
			<div class="links">
				<a href="/chat/bbcode">BBCode Guide</a>
				| <a href="/user/details">User Settings</a>
			</div>
			<div class="buttons">
				<button type="button" class="btn btn-red" onclick="toggleEdit();">cancel</button>
				<button type="submit" class="btn btn-green">update</button>
			</div>
		</form>
		<?php } ?>
		
		<nav>
			<a class="btn btn-default" href="/">home</a>
		</nav>
	</div>
</body>
</html>