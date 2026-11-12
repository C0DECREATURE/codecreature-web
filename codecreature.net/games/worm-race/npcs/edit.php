<?php
	$baseLink = "/games/worm-race/npcs/";
	
	// include worm functions file
	require_once $_SERVER['DOCUMENT_ROOT']."/games/worm-race/worm-functions.php";
	
	// include users connection data
	require_once $_SERVER['DOCUMENT_ROOT']."/games/worm-common/users.php";
	// include get username by id function
	require_once $_SERVER['DOCUMENT_ROOT']."/user/database.php";
	
	$image_formats = ["png","gif","jpg","webp"];
	$image_regex = "(.*)\.(".implode("|",$image_formats).")\/?$";
	
	// character limits
	$name_limit = 15;
	$link_limit = 150;
	$length_limit = 4;
	$likes_limit = 50;
	$color_limit = 25;
	// regex validation
	$name_regex = "[ 0-9A-Za-z\-]+";
	$length_regex = "[0-9\.]+";
	$color_regex = "#[0-9A-Za-z]{6}|#[0-9A-Za-z]{3}|rgba?\([0-9]+, ?[0-9]+, ?[0-9]+(, ?[0-9\.]+)?\)";
	$link_regex = "^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,63}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$";
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<base src="<?php echo $baseLink; ?>" href="<?php echo $baseLink; ?>">
		
		<?php
		$worm = [];
		// load the worm data into $worm
		include "get-worm.php";
	
		$wormLink = "/fan-worms/worm/".$worm["id"]."/";
		
		$icon_err = $name_err = $length_err = $likes_err = $color_err = $text_color_err = $website_err = "";
		// proces when form is submitted
		if($_SERVER["REQUEST_METHOD"] == "POST" && $worm["canEdit"]){
			// validate worm name
			if (empty($_POST["name"])) $name_err = "Your worm needs a name!";
			else {
				$name = trim($_POST["name"]);
				if (strlen($name) > $name_limit) $name_err = "Must be less than $name_limit characters long.";
				else if (!preg_match("/$name_regex/i",$name)) $name_err = "May only contain letters, numbers, hyphens, and spaces.";
				else $worm["name"] = htmlspecialchars($name);
			}
			// validate worm icon
			if (empty($_POST["icon"])) $icon_err = "Must submit an image link.";
			else {
				$icon = trim($_POST["icon"]);
				if (!str_starts_with($icon,"http")) $icon_err = "Must start with http:// or https://";
				else if (!preg_match("/$link_regex/",$icon)) $icon_err = "Invalid link url.";
				else if (!preg_match("/$image_regex/i",$icon)) $icon_err = "Image link must end with one of these: ".implode(", ",$image_formats);
				else if (strlen($icon) > $link_limit) $icon_err = "Must be under $link_limit characters long.";
				else $worm["icon"] = $icon;
			}
			// validate worm length
			if (!empty($_POST["length"])) {
				$length = trim($_POST["length"]);
				if (strlen($length) > $length_limit) $length_err = "Must be less than $name_limit characters.";
				else if (!preg_match("/$length_regex/",$length)) $length_err = "May only contain numbers and periods.";
				else $worm["length"] = $length;
			}
			// validate worm likes
			if (!empty($_POST["likes"])) {
				$likes = trim($_POST["likes"]);
				if (strlen($length) > $length_limit) $likeserr = "Must be under $name_limit numbers long.";
				else $worm["likes"] = htmlspecialchars($likes);
			}
			// validate main color
			if (!empty($_POST["color"])) {
				$color = trim($_POST["color"]);
				if (strlen($color) > $color_limit) $color_err = "Must be under $color_limit characters.";
				else if (!preg_match("/$color_regex/",$color)) $color_err = "Must be a valid rgb or hexadecimal color.";
				else $worm["color"] = $color;
			}
			// validate text color
			if (!empty($_POST["textColor"])) {
				$color = trim($_POST["textColor"]);
				if (strlen($color) > $color_limit) $text_color_err = "Must be under $color_limit characters.";
				else if (!preg_match("/$color_regex/",$color)) $text_color_err = "Must be a valid rgb or hexadecimal color.";
				else $worm["text_color"] = $color;
			}
			// validate worm site link
			if (!empty($_POST["website"])) {
				$website = trim($_POST["website"]);
				if (strlen($website) > $link_limit) $website_err = "Must be less than $name_limit characters long.";
				else if (!preg_match("/$link_regex/",$website)) {
					if (!str_starts_with($website,"http")) $website_err = "Must start with http:// or https://";
					else $website_err = "Invalid url link.";
				}
				else $worm["website"] = $website;
			}
			// if no errors, update worm
			if (empty($icon_err) && empty($name_err) && empty($length_err) && empty($likes_err) && empty($color_err) && empty($text_color_err)) {
				$sql = "INSERT INTO fan_worms (id, owner, name, icon, length, likes, color, text_color, website)
									VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? )
									ON DUPLICATE KEY UPDATE owner=VALUES(owner), name=VALUES(name), icon=VALUES(icon), length=VALUES(length), likes=VALUES(likes), color=VALUES(color), text_color=VALUES(text_color), website=VALUES(website);";
				if($stmt = mysqli_prepare($worm_conn, $sql)){
					mysqli_stmt_bind_param($stmt, "iisssssss", $worm["id"], $_SESSION["id"], $worm["name"], $worm["icon"], $worm["length"],
																						$worm["likes"], $worm["color"], $worm["text_color"], $worm["link"]);
					if(!mysqli_stmt_execute($stmt)) echo "Oops! Something went wrong. Please try again later.";
					mysqli_stmt_close($stmt);
				}
			}
			
			// if needed, reload the worm data into $worm
			if (empty($worm["id"]) && !empty($worm["name"])) {
				$sql = "SELECT id FROM fan_worms WHERE name = ? ;";
				if($stmt = mysqli_prepare($worm_conn, $sql)){
					mysqli_stmt_bind_param($stmt, "s", $worm["name"]);
					if(mysqli_stmt_execute($stmt)) {
						$result = mysqli_stmt_get_result($stmt);
						$row = mysqli_fetch_assoc($result);
						$_GET["id"] = $row["id"];
						include "get-worm.php";
					} else echo "Something went wrong. Please try again later.";
					mysqli_stmt_close($stmt);
				}
				//include "get-worm.php";
			}
		}
		?>
		
		<title><?php echo empty($worm["name"]) ? "post a worm" : "edit ".$worm["name"]; ?></title>
		<meta name="description" content="Feed a worm, race to victory.">
		<meta name="keywords" content="game,worms,worm,feed,worm game,worms game,worms race,worm race,worm racing,worm feeding">
		<meta name="author" content="codecreature">
		
		<!-- prevent warnings popup on this page -->
		<script>var showMainWarnings = false;</script>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260920"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260920" rel="stylesheet" type="text/css"></link>
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="../favicon.ico">
		
		<!--fonts-->
		<script>fonts.load('YetR','Super Comic');</script>
		
		<!--full image view-->
		<script src="/codefiles/full-image.js"></script>
		
		<!-- svg icons -->
		<link href="/graphix/svg-icons/svg-icons-new.css?fileversion=20260920" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--worms common stylesheet-->
		<link href="/games/worm-common/style.css?fileversion=20261011" rel="stylesheet" type="text/css" media="all">
		<!--worm race game stylesheet-->
		<link href="../style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--profile stylesheet-->
		<link href="gallery.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<link href="edit.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		
		<!-- worm race functions -->
		<script src="/games/worm-race/wormFunctions.js?fileversion=20260920"></script>
	</head>
	<body>
		
		<!-- menu & navigation -->
		<?php include '../menu.php'; ?>
		
		<div id="content-wrapper">
			
			<main id="content">
				<!--main page header-->
				<?php include '../header.php'; ?>
				
				<div class="info-box forms-wrapper" style="<?php echo !empty($worm["cssColor"]) ? "--color-dark:".$worm["cssColor"] : ""; ?>">
					<header>
						<h2><?php echo empty($worm["id"]) ? "New" : "Edit"; ?> Worm</h2>
					</header>
					<div class="main-container"><div class="details">
						<?php if ($worm["canEdit"]) { ?>
						<form id="info-form" method="POST">
							<h4>required</h4>
							<div class="form-section">
								<label for="input-name">name:</label>
								<input type="text" id="input-name" name="name" value="<?php echo $worm["name"]; ?>"
									maxlength="<?php echo $name_limit; ?>"
									pattern="<?php echo $name_regex; ?>"
									title="Only letters, numbers, spaces, and hyphens"
									required></input>
								<div class="error"><?php echo $name_err; ?></div>
							</div>
							
							<div class="form-section">
								<label for="input-icon">main image (square):</label>
								<input type="text" id="input-icon" name="icon" value="<?php echo $worm["icon"]; ?>"
									maxlength="<?php echo $link_limit; ?>"
									placeholder="link to a square image. transparent recommended!"
									required></input>
								<div class="error"><?php echo $icon_err; ?></div>
							</div>
							
							<h4>optional</h4>
							<div class="form-section">
								<label for="input-length">length (inches):</label>
								<input type="text" id="input-length" name="length" value="<?php echo $worm["length"]; ?>"
									maxlength="<?php echo $length_limit; ?>"
									pattern="<?php echo $length_regex; ?>"
									title="Only numbers and periods"
									placeholder="enter a number"></input>
								<div class="error"><?php echo $length_err; ?></div>
							</div>
							
							<div class="form-section">
								<label for="input-likes">likes:</label>
								<input type="text" id="input-likes" name="likes" value="<?php echo $worm["likes"]; ?>"
									maxlength="<?php echo $likes_limit; ?>"></input>
								<div class="error"><?php echo $likes_err; ?></div>
							</div>
							
							<div class="form-section">
								<label for="input-color">header color:</label>
								<input type="text" id="input-color" name="color" value="<?php echo $worm["color"]; ?>"
									maxlength="<?php echo $color_limit; ?>"
									pattern="<?php echo $color_regex; ?>"
									title="Hexadecimal or rgb format"
									placeholder="hexadecimal or rgb"></input>
								<div class="error"><?php echo $color_err; ?></div>
							</div>
							
							<div class="form-section">
								<label for="input-text-color">text color:</label>
								<input type="text" id="input-text-color" name="textColor" value="<?php echo $worm["text_color"]; ?>"
									maxlength="<?php echo $color_limit; ?>"
									pattern="<?php echo $color_regex; ?>"
									title="Hexadecimal or rgb format"
									placeholder="hexadecimal or rgb"></input>
								<div class="error"><?php echo $text_color_err; ?></div>
							</div>
							
							<div class="form-section">
								<label for="input-website">external webpage:</label>
								<input type="text" id="input-website" name="website" value="<?php echo $worm["website"]; ?>"
									maxlength="<?php echo $link_limit; ?>"
									placeholder="link to page showing more about this character"></input>
								<div class="error"><?php echo $website_err; ?></div>
							</div>
							
							<input type="hidden" name="id" value="<?php echo $worm["id"]; ?>"></input>
							
							<div class="form-section buttons">
								<a class="btn" type="button"
									href="<?php echo empty($worm["id"]) ? "/fan-worms" : "/fan-worms/worm/$worm_id"; ?>"
								>back</a>
								<button class="btn" type="submit"><?php echo empty($worm["id"]) ? "post" : "update"; ?></button>
							</div>
						</form>
						
						<?php if (!empty($worm["id"])) { ?>
						<section id="gallery" class="gallery-section">
							<h3>gallery</h3>
							<div class="gallery">
								<?php for ($i = 0; $i < $gallery_limit; $i++) {
									if (!empty($worm["gallery"][$i])) {
										$img = $worm["gallery"][$i];?>
									<div class='wrapper'>
										<img src="<?php echo $img["img"]; ?>"
											alt="gallery image <?php echo $i; ?>"
											style="
												<?php if (!empty($img["thumb"])) {
													$thumb = explode(",",$img["thumb"]);
													echo "left: $thumb[0]%; top: $thumb[1]%; width: $thumb[2]%;";
												} ?>
											"
										>
										<a class="edit button" type="button" href="<?php echo $wormLink; ?>image/<?php echo $i; ?>">edit</a>
										<button class="delete button" type="button">delete</button>
									</div>
									<?php
									} else { ?>
									<a class="empty wrapper" href="<?php echo $wormLink; ?>image/<?php echo $i; ?>">+</a>
									<?php
									}
								}?>
							</div>
						</section>
						<?php } ?>
						
						<?php } else { // if not canEdit ?>
						<div class="unauthorized">
							<p>You don't have permission to <?php echo empty($worm["id"]) ? "post a worm!" : "edit this worm!"; ?>
							<?php if (empty($_SESSION["id"])) { echo "<br><a href='/user'>Log in</a> and try again."; } ?>
							</p>
							<p><a class="btn" href="<?php echo !empty($worm["id"]) ? $wormLink : "/fan-worms"; ?>">back</a></p>
						</div>
						<?php } ?>
					</div>
				</div></div>
			</main>
			
			<!--main page footer-->
			<?php include '../../worm-common/footer.php'; ?>
		</div>
		
		<!--worm race updates-->
		<?php include '../updates.php'; ?>
	</body>
</html>