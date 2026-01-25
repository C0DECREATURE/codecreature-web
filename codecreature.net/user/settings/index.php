<?php
	// Initialize the session
	session_start();
	 
	// Check if the user is logged in, if not then redirect to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
			header("location: ../login/");
			exit;
	}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>user settings</title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20251216"></script>
		
		<!-- fonts -->
		<script>fonts.load('ComicSansMS','SuperComic');</script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20251216"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20251216" id="svg-icons-js"></script>
		
		<!--user common stylesheet-->
		<link href="../style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
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
			
			<p>user features have not been integrated anywhere else in the site yet! come back later</p>
			
			<section id="user-settings">
				
				<section class="settings-block" id="details">
					<header><h2>user details</h2></header>
					<div class="content-wrapper">
						<div class="info">
							username:
							<span class="value"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
						</div>
						<div class="info">
							access level:
							<span class="value"><?php echo htmlspecialchars($_SESSION["user_access"]); ?></span>
						</div>
						<div class="info hidden">
							current icon:
							<span class="value"><?php echo htmlspecialchars($_SESSION["user_icon"]); ?></span>
						</div>
					</div>
				</section>
				
				<section class="settings-block hidden" id="icon">
					<header><h2>icon</h2></header>
					<div class="content-wrapper">
						<form name="icon">
							<!--icon inputs-->
							<div class="icon-selections">
								<!--jeremy-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_pink" name="icon-selection">
									<label for="icon-worm_pink"><img class="icon-preview" src="/user/icons/worm_pink.png"></label>
								</div>
								<!--pretzel-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_orange" name="icon-selection">
									<label for="icon-worm_orange"><img class="icon-preview" src="/user/icons/worm_orange.png"></label>
								</div>
								<!--string cheese-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_yellow" name="icon-selection">
									<label for="icon-worm_yellow"><img class="icon-preview" src="/user/icons/worm_yellow.png"></label>
								</div>
								<!--matilda-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_green" name="icon-selection">
									<label for="icon-worm_green"><img class="icon-preview" src="/user/icons/worm_green.png"></label>
								</div>
								<!--pool noodle-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_blue" name="icon-selection">
									<label for="icon-worm_blue"><img class="icon-preview" src="/user/icons/worm_blue.png">
								</div>
								<!--microplastics-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_purple" name="icon-selection">
									<label for="icon-worm_purple"><img class="icon-preview" src="/user/icons/worm_purple.png"></label>
								</div>
								<!--worm apple-->
								<div class="wrapper">
									<input type="radio" id="icon-worm_apple" name="icon-selection">
									<label for="icon-worm_apple"><img class="icon-preview" src="/user/icons/worm_apple.png"></label>
								</div>
							</div>
							<!--end of icon inputs-->
							<input type="submit" class="btn btn-green" value="update">
						</form>
					</div>
				</section>
				
				<section class="settings-block" id="actions">
					<header><h2>account actions</h2></header>
					<div class="content-wrapper">
						<a href="../reset-password.php" class="hidden btn btn-warning">Reset Password</a>
						<a href="../logout.php" class="btn btn-danger">Sign Out</a>
					</div>
				</section>
				
			</section>
		</main>
</body>
</html>