<?php
	// Initialize the session
	session_start();
	 
	// Check if the user is logged in, if not then redirect to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
			header("location: ../login/");
			exit;
	}
	
	// Include password functions file
	require_once "../password-functions.php";
	// Include icon functions file
	require_once "../icon-functions.php";
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>user <?php echo htmlspecialchars($_SESSION["username"]); ?></title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20251216"></script>
		
		<!-- fonts -->
		<script>fonts.load('ComicSansMS','SuperComic','Yet R');</script>
		
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
						<img class="user-icon" src="/user/icons/<?php echo $_SESSION['user_icon']; ?>.png" alt="">
						<div class="info">
							<div>
								username:
								<span class="value"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
							</div>
							<div>
								access level:
								<span class="value <?php echo htmlspecialchars($_SESSION["user_access"]); ?>"><?php echo htmlspecialchars($_SESSION["user_access"]); ?></span>
							</div>
						</div>
					</div>
				</section>
				
				<section class="settings-block" id="icon">
					<header><h2>select icon</h2></header>
					<div class="content-wrapper">
						<form name="icon" action="../icon-functions.php" method="post">
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
							</div>
							<!--end of icon inputs-->
							<input type="submit" class="btn btn-green" value="update">
						</form>
						<script>
							 (function () {
								 let icon = '<?php echo $_SESSION['user_icon']; ?>';
								 console.log(icon);
							 })();
						</script>
					</div>
				</section>
				
				<section class="settings-block" id="actions">
					<header><h2>account actions</h2></header>
					
					
					<div class="content-wrapper">
						<!--reset password form-->
						<section id="reset-password">
							<form name="reset-password" action="../password-reset.php" method="post"> 
								<div class="form-group">
									<label for="new_password">new password: </label>
									<input
										type="password"
										id="new_password" name="new_password"
										maxlength="<?php echo $password_length; ?>"
										class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>"
										value="<?php echo $new_password; ?>">
									<span class="invalid-feedback"><?php echo $new_password_err; ?></span>
								</div>
								<div class="form-group">
									<label for="confirm_password">confirm new password: </label>
									<input
										type="password"
										id="confirm_password" name="confirm_password"
										maxlength="<?php echo $password_length; ?>"
										class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
									<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-small" value="Update Password">
								</div>
							</form>
						</section>  
						<!--logout button-->
						<a href="../logout.php" class="btn btn-danger">Log Out</a>
					</div>
				</section>
				
			</section>
		</main>
</body>
</html>