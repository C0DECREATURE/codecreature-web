<?php

// Initialize the session
if(!isset($_SESSION)){session_start();}
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: ../login/");
	exit;
}

// Include flag info file
require_once "../flags.php";

// Include user database functions file
require_once "../database.php";

// Include password functions file
require_once "../password-functions.php";
// Include username functions file
require_once "../username-functions.php";
// Include icon update functions file
require_once "../icon-update.php";
// Include display update functions file
require_once "../display-update.php";

$user = getPublicUserData($_SESSION['id'],true);

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>user settings</title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260930"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260930" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260930"></script>
		
		<!-- fonts -->
		<script>fonts.load('Comic Sans MS','Super Comic','Yet R');</script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260930" rel="stylesheet" type="text/css" media="all">
		
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260930"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260930" id="svg-icons-js"></script>
		
		<!--user common stylesheet-->
		<link href="../style.css?fileversion=20161121" rel="stylesheet" type="text/css" media="all">
		
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20161121" rel="stylesheet" type="text/css" media="all">
</head>
<body class="<?php echo $user["color"]; ?>">
		<nav>
			<a href="/" class="btn btn-green">Home</a>
		</nav>
		
		<header>
			<h1><span id="greeting">hello</span>, <strong><?php echo htmlspecialchars($user["username"]); ?></strong>!</h1>
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
			
			<p>user features are currently integrated into the <a href="/games/worm-race" target="_top">worm games</a> and <a href="/chat" target="_top">chat rooms</a>!</p>
			
			<section id="user-settings">
				
				<section class="settings-block" id="details">
					<header><h2>user details</h2></header>
					<div class="content-wrapper">
						<img class="user-icon" src="<?php echo $user['icon']; ?>" alt="">
						<div class="info">
							<div class="username">
								username:
								<span class="value"><?php echo htmlspecialchars($user["username"]); ?></span>
							</div>
							<div class="id">
								id:
								<span class="value">#<?php echo htmlspecialchars($user["id"]); ?></span>
							</div>
							<div class="pronouns">
								pronouns:
								<span class="value"><?php
									echo !empty(htmlspecialchars($user["pronouns"])) ? htmlspecialchars($user["pronouns"]) : "unspecified";
								?></span>
							</div>
							<div class="authorization">
								authorization level:
								<span class="value <?php echo htmlspecialchars($user["authorization"]); ?>"><?php echo htmlspecialchars($user["authorization"]); ?></span>
							</div>
							<div>
								<a href="/u/<?php echo htmlspecialchars($user["username"]); ?>" target="_top">view profile</a>
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
								<?php
								$iconOptions = [
									["name"=>"worm_apple","alt"=>"Golden apple"],
									["name"=>"worm_drink","alt"=>"Can of battery juice"],
									["name"=>"fish","alt"=>"Can of battery juice"],
									["name"=>"jeremy_head","alt"=>"Close-up Jeremy"],
									["name"=>"jeremy","alt"=>"Jeremy"],
									["name"=>"jeremy_halloween","alt"=>"Halloween costume Jeremy"],
									["name"=>"pretzel","alt"=>"Pretzel"],
									["name"=>"pretzel_halloween","alt"=>"Halloween costume Pretzel"],
									["name"=>"string_cheese_head","alt"=>"Close-up String Cheese"],
									["name"=>"string_cheese","alt"=>"String Cheese"],
									["name"=>"string_cheese_halloween","alt"=>"Halloween costume String Cheese"],
									["name"=>"matilda","alt"=>"Matilda"],
									["name"=>"matilda_halloween","alt"=>"Halloween costume Matilda"],
									["name"=>"pool_noodle","alt"=>"Pool Noodle"],
									["name"=>"pool_noodle_halloween","alt"=>"Halloween costume Pool Noodle"],
									["name"=>"microplastics_head","alt"=>"Close-up Microplastics"],
									["name"=>"microplastics","alt"=>"Microplastics"],
									["name"=>"microplastics_halloween","alt"=>"Halloween costume Microplastics"],
									["name"=>"ship_wall_nepeta","alt"=>"Scribble Nepeta"],
									["name"=>"tildeath","alt"=>"~ATH book cover"],
								];
								
								foreach ($iconOptions as $i) { ?>
									<div class="wrapper">
										<input type="radio" id="icon-<?php echo $i["name"]; ?>" value="<?php echo $i["name"]; ?>" name="new-icon">
										<label for="icon-<?php echo $i["name"]; ?>"><img class="icon-preview" src="/user/icons/<?php echo $i["name"]; ?>.png" alt="<?php echo $i["alt"]; ?>"></label>
									</div>
								<?php } ?>
							</div>
							<!--end of icon inputs-->
							<input type="submit" class="btn btn-green" value="update">
						</form>
					</div>
				</section>
				
				<section class="settings-block">
					<header><h2>display options</h2></header>
					<div class="content-wrapper">
						<form name="pronouns" action="../display-update.php" method="post">
							<!-- user game privacy -->
							<div class="form-section">
								<input type="checkbox" name="game-privacy" id="game-privacy" <?php echo getUserGamePrivacy($user["id"]) == "private" ? "checked" : ""; ?>></input>
								<label for="game-privacy">make gameplay activity private</label>
								<div class="info">hide your username from leaderboards, recent activity, etc.</div>
							</div>
							<!-- user display color -->
							<div id="color" class="form-section">
								<label for="color-select">color style:</label>
								<select name="color" id="color-select">
									 <option value="pink" <?php echo $user["color"] == "pink" ? "selected" : "" ?>>pink</option>
									 <option value="orange" <?php echo $user["color"] == "orange" ? "selected" : "" ?>>orange</option>
									 <option value="green" <?php echo $user["color"] == "green" ? "selected" : "" ?>>green</option>
									 <option value="blue" <?php echo $user["color"] == "blue" ? "selected" : "" ?>>blue</option>
									 <option value="purple" <?php echo $user["color"] == "purple" ? "selected" : "" ?>>purple</option>
								</select>
							</div>
							<!-- user pronouns -->
							<div id="pronouns" class="form-section">
								<label for="pronouns-input">pronouns:</label>
								<input type="text" id="pronouns-input" name="pronouns" maxlength="<?php echo $pronouns_length; ?>" value="<?php echo $user["pronouns"]; ?>"></input>
							</div>
							<!-- user pronouns -->
							<div id="flags" class="form-section flags">
								<?php
									// create checkbox for given flag
									// check the checkbox if flag in user's current flags
									function insertFlagCheckbox($f) {
										global $user;
										$flag = $f["flag"];
										$blankFlag = $f["blankFlag"];
										$name = $f["name"];
										$checked = !empty($user["flags"]) && in_array($name,$user["flags"]) ? " checked" : "";
										echo "
											<button class='option-wrapper' type='button'>
												<input type='checkbox' id='flags-$name' name='flags[]' value='$name'$checked></input>
												<label for='flags-$name' style=\"
													--flag:url('/graphix/flags/$flag');
													--blankFlag:url('/graphix/flags/$blankFlag');
												\">
													$name
												</label>
											</button>
										";
									}
								?>
								<fieldset>
									<legend>gender flags</legend>
									<?php
										// create gender flag checkboxes
										foreach($flagData as $f) { if ($f["type"] == "gender") insertFlagCheckbox($f); }
									?>
								</fieldset>
								<fieldset>
									<legend>other flags</legend>
									<?php
										// create other flag checkboxes
										foreach($flagData as $f) { if ($f["type"] == "other") insertFlagCheckbox($f); }
									?>
								</fieldset>  
							</div>
							<input type="submit" class="btn btn-green" value="update">
						</form>
					</div>
				</section>
				
				<section class="settings-block" id="actions">
					<header><h2>account actions</h2></header>
					
					
					<div class="content-wrapper">
						<!--change username form-->
						<section id="change-username" class="form-section">
							<form name="change-username" action="../change-username.php" method="POST">
								<input type="hidden" name="form" value="change-username"></input>
								<div class="form-group">
									<label for="new_username">new username: </label>
									<input
										id="new_username" name="new_username"
										required
										class="form-control <?php echo (!empty($username_err)) ? "is-invalid" : ""; ?>"
										>
									<span class="invalid-feedback"><?php echo (!empty($username_err)) ? $username_err : ""; ?></span>
								</div>
								<?php echo $username_err; ?>
								<div class="form-group">
									<label for="cur_password">current password: </label>
									<input
										type="password"
										id="cur_password" name="cur_password"
										required
										minlength="<?php echo $password_length; ?>"
										class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
										value="<?php echo $new_password; ?>">
									<span class="invalid-feedback"><?php echo $new_password_err; ?></span>
								</div>
								<div class="form-group">
									<div class="info"><strong>warning:</strong> your current username will become available to other users. you might not be able to get it back!</div>
									<input type="submit" class="btn btn-small" value="Change Username">
								</div>
							</form>
						</section>
						<!--reset password form-->
						<section id="reset-password" class="form-section">
							<form name="reset-password" action="../password-reset.php" method="POST">
								<input type="hidden" name="form" value="reset-password"></input>
								<div class="form-group">
									<label for="cur_password">current password: </label>
									<input
										type="password"
										id="cur_password" name="password"
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
									<div class="info">for security, use a password you don't use anywhere else!</div>
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