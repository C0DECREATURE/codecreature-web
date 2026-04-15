<?php

// Initialize the session
if(!isset($_SESSION)){session_start();}
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: ../login/");
	exit;
}

// Include user database functions file
require_once "../database.php";

// Include password functions file
require_once "../password-functions.php";
// Include icon update functions file
require_once "../icon-update.php";
// Include display update functions file
require_once "../display-update.php";

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>user <?php echo htmlspecialchars($_SESSION["username"]); ?></title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		
		<!-- fonts -->
		<script>fonts.load('ComicSansMS','SuperComic','Yet R');</script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260410"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260410" id="svg-icons-js"></script>
		
		<!--user common stylesheet-->
		<link href="../style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
</head>
<body>
		<nav>
			<a href="/" class="btn btn-green">Home</a>
		</nav>
		
		<header>
			<h1><span id="greeting">hello</span>, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>!</h1>
		</header>
		
		<main>
			<p id="welcome" class="hidden">thanks for signing up!</p>
			<script>
				(function(){
					let urlParams = new URL(window.location.toLocaleString()).searchParams; 
					if (urlParams.get('welcome')) {
						document.getElementById('greeting').innerHTML = 'welcome';
						document.getElementById('welcome').classList.remove('hidden');
					}
				})();
			</script>
			
			<p>user features are currently integrated into the <a href="/games/worm-race">worm games</a> and <a href="/chat">chat rooms</a>!</p>
			
			<section id="user-settings">
				
				<section class="settings-block" id="details">
					<header><h2>user details</h2></header>
					<div class="content-wrapper">
						<img class="user-icon" src="/user/icons/<?php echo $_SESSION['user_icon']; ?>.png" alt="">
						<div class="info">
							<div class="username">
								username:
								<span class="value"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
							</div>
							<div class="pronouns">
								pronouns:
								<span class="value"><?php
									echo !empty(htmlspecialchars($_SESSION["user_pronouns"])) ? htmlspecialchars($_SESSION["user_pronouns"]) : "unspecified";
								?></span>
							</div>
							<div class="authorization">
								authorization level:
								<span class="value <?php echo htmlspecialchars($_SESSION["user_authorization"]); ?>"><?php echo htmlspecialchars($_SESSION["user_authorization"]); ?></span>
							</div>
						</div>
					</div>
				</section>
				
				<section class="settings-block" id="icon">
					<header><h2>select icon</h2></header>
					<div class="content-wrapper">
						<form name="icon" action="../icon-update.php" method="post">
							<!--icon inputs-->
							<div class="icon-selections">
								<!--jeremy-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_pink" value="worm_pink" name="new-icon">
									<label for="icon-worm_pink"><img class="icon-preview" src="/user/icons/worm_pink.png" alt="pink worm"></label>
								</div>
								<!--pretzel-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_orange" value="worm_orange" name="new-icon">
									<label for="icon-worm_orange"><img class="icon-preview" src="/user/icons/worm_orange.png" alt="pink worm"></label>
								</div>
								<!--string cheese-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_yellow" value="worm_yellow" name="new-icon">
									<label for="icon-worm_yellow"><img class="icon-preview" src="/user/icons/worm_yellow.png" alt="yellow worm"></label>
								</div>
								<!--matilda-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_green" value="worm_green" name="new-icon">
									<label for="icon-worm_green"><img class="icon-preview" src="/user/icons/worm_green.png" alt="blue worm"></label>
								</div>
								<!--pool noodle-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_blue" value="worm_blue" name="new-icon">
									<label for="icon-worm_blue"><img class="icon-preview" src="/user/icons/worm_blue.png" alt="blue worm">
								</div>
								<!--microplastics-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_purple" value="worm_purple" name="new-icon">
									<label for="icon-worm_purple"><img class="icon-preview" src="/user/icons/worm_purple.png" alt="purple worm"></label>
								</div>
								<!--worm apple-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_apple" value="worm_apple" name="new-icon">
									<label for="icon-worm_apple"><img class="icon-preview" src="/user/icons/worm_apple.png" alt="golden apple"></label>
								</div>
								<!--worm energy drink-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_drink" value="worm_drink" name="new-icon">
									<label for="icon-worm_drink"><img class="icon-preview" src="/user/icons/worm_drink.png" alt="golden apple"></label>
								</div>
							</div>
							<!--end of icon inputs-->
							<input type="submit" class="btn btn-green" value="update">
						</form>
					</div>
				</section>
				
				<section class="settings-block" id="pronouns">
					<header><h2>update display info</h2></header>
					<div class="content-wrapper">
						<!-- user pronouns -->
						<form name="pronouns" action="../display-update.php" method="post">
							<div class="form-section">
								<input type="checkbox" name="game-privacy" id="game-privacy" <?php echo getUserGamePrivacy($_SESSION["id"]) == "private" ? "checked" : ""; ?>></input>
								<label for="game-privacy">make gameplay activity private</label>
								<div class="info">hide your username from leaderboards, recent activity, etc.</div>
							</div>
							<div class="form-section">
								<label for="pronouns-input">pronouns:</label>
								<input type="text" id="pronouns-input" name="pronouns" maxlength="<?php echo $pronouns_length; ?>" value="<?php echo $_SESSION["user_pronouns"]; ?>"></input>
							</div>
							<input type="submit" class="btn btn-green" value="update">
						</form>
					</div>
				</section>
				
				<section class="settings-block" id="actions">
					<header><h2>account actions</h2></header>
					
					
					<div class="content-wrapper">
						<!--reset password form-->
						<section id="reset-password" class="form-section">
							<form name="reset-password" action="../password-reset.php" method="POST">
								<input type="hidden" name="form" value="reset-password"></input>
								<div class="form-group">
									<label for="old_password">current password: </label>
									<input
										type="password"
										id="old_password" name="password"
										required
										class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
									<span class="invalid-feedback"><?php echo $password_err; ?></span>
								</div>
								<div class="form-group">
									<label for="new_password">new password: </label>
									<input
										type="password"
										id="new_password" name="new_password"
										required
										minlength="<?php echo $password_length; ?>"
										class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>"
										value="<?php echo $new_password; ?>">
									<span class="invalid-feedback"><?php echo $new_password_err; ?></span>
								</div>
								<div class="form-group">
									<label for="confirm_password">confirm new password: </label>
									<input
										type="password"
										id="confirm_password" name="confirm_password"
										required
										minlength="<?php echo $password_length; ?>"
										class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
									<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-small" value="Update Password">
								</div>
							</form>
						</section>
						<section id="logout" class="form-section">
							<!--logout button-->
							<a href="../logout.php" class="btn btn-danger form-section">Log Out</a>
						</section>
					</div>
				</section>
				
			</section>
		</main>
</body>
</html>