<?php
require_once $_SERVER['DOCUMENT_ROOT']."/user/database.php";

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }

$param_username = urldecode($_GET['username']);
$id = getIdByUsername($param_username);
// get user's public data array
$user = getPublicUserData($id);
$username = $user['username'];
$pronouns = $user['pronouns'];
$icon = $user['icon'];

if (empty($id) || $id == 0) {
	header("location: /user/profile/not-found");
}

// get the user's profile details
$sql = "SELECT summary FROM profiles WHERE id = ?";
if($stmt = mysqli_prepare($users_conn, $sql)){
	mysqli_stmt_bind_param($stmt, "i", $id);
	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_bind_result($stmt, $summary);
		mysqli_stmt_fetch($stmt);
		$summary = urldecode($summary);
	} else{
		$summary = "";
	}
	// Close statement
	mysqli_stmt_close($stmt);
}

// Include chat bbcode settings file
require_once $_SERVER['DOCUMENT_ROOT']."/chat/bbcode.php";
?>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widateh=device-widateh, initial-scale=1.0">
    <title><?php echo $user["username"]; ?>'s profile</title>
		<meta name="description" content="<?php echo $user["username"]; ?>'s user profile.">
		<meta name="keywords" content="user,profile,userpage,<?php echo $user["username"]; ?>">
		<meta name="author" content="codecreature">
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="<?php echo $icon; ?>">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<script>fonts.load("Super Comic");</script>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260410"></script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260410" id="svg-icons-js"></script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--bbcode stylesheet-->
		<link href="/chat/bbcode.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="/user/profile/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
</head>
<body class="<?php echo $user['color']; ?>">
	<div class="main-container">
		<header class="username-header">
			<img id="icon" src="<?php echo $icon; ?>">
			<div class="text">
				<h1 id="username"><?php echo $username; ?></h1>
				<?php if (!empty($user["pronouns"])) {
					echo "<div id='pronouns'>$pronouns</div>";
				} ?>
			</div>
		</header>
		
		<section class="<?php echo empty($summary) ? "empty" : ""; ?>" id="summary" aria-label="user summary">
			<div class="text">
				<?php echo empty($summary) ? "This user hasn't written a summary!" : $bbcode->Parse($summary); ?>
			</div>
			<?php echo (!empty($_SESSION["id"]) && $id == $_SESSION["id"]) ? '<button id="edit-summary-button" onclick="toggleEdit();">✏️</button>' : ''; ?>
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
		
		<form id="edit-summary-form" class="hidden" action="/user/profile/update.php" method="POST">
			<input type="hidden" name="user_id" value="<?php echo $id; ?>"></input>
			<textarea id="edit-summary" name="new-summary" value="" maxlength="2000"><?php echo empty($summary) ? "This user hasn't written a summary!" : $summary; ?></textarea>
			<button type="button" class="btn btn-red" onclick="toggleEdit();">cancel</button>
			<button type="submit" class="btn btn-green">update</button>
		</form>
		
		<nav>
			<a class="btn btn-default" href="/">home</a>
		</nav>
	</div>
</body>
</html>