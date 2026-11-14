<?php
	$baseLink = "/games/worm-race/npcs/";
	
	// include worm functions file
	require_once $_SERVER['DOCUMENT_ROOT']."/games/worm-race/worm-functions.php";
	
	// include users connection data
	require_once $_SERVER['DOCUMENT_ROOT']."/games/worm-common/users.php";
	// include get username by id function
	require_once $_SERVER['DOCUMENT_ROOT']."/user/database.php";
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<base src="<?php echo $baseLink; ?>" href="<?php echo $baseLink; ?>">
		
<?php
// include string validation limits and regex
require_once "regex.php";

// load the worm data into $worm
require_once "get-worm.php";

$link_err = $username_err = "";
$artist_id = "";
// proces when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && $worm["canEdit"]){
	// check for image link errors
	if (empty($_POST["imageLink"])) $link_err = "Must submit an image link.";
	else if (!preg_match("/$link_protocol_regex/",$_POST["imageLink"])) $link_err = "Link must start with http:// or https://";
	else if (!preg_match("/$link_regex/",$_POST["imageLink"])) $link_err = "Invalid link url.";
	else if (!preg_match("/$image_regex/i",$_POST["imageLink"])) {
		$link_err = "Image link must end with one of the following: ".implode(", ",$image_formats);
	}
	// check for username errors
	if (!empty($_POST["username"])) {
		$artist_id = getIdByUsername($_POST["username"]);
		if (gettype($artist_id) == "NULL") $username_err = "User not found!";
	}
	// if no errors, update the image
	if (empty($link_err) && empty($username_err)) {
		$new_image = ["img"=>$_POST["imageLink"],"uid"=>$artist_id,"thumb"=>$_POST["thumb"]];
		$worm["gallery"][$_GET["imageId"]] = $new_image;
		$json = json_encode($worm["gallery"]);
		
		$sql = "UPDATE fan_worms SET gallery = ? WHERE id = ? ;";
		if($stmt = mysqli_prepare($worm_conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "si", $json, $worm["id"]);
			
			// Attempt to execute the prepared statement
			if(!mysqli_stmt_execute($stmt)) echo "Oops! Something went wrong. Please try again later.";
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}

$image = "";
if (empty($worm["gallery"])) $worm["gallery"] = [];
else if (!empty($worm["gallery"][$_GET["imageId"]])) {
	$image = $worm["gallery"][$_GET["imageId"]];
	$image["thumbBox"] = explode(",",$image["thumb"]);
	if (count($image["thumbBox"]) == 3) {
		$image["thumbBox"][2] = 10000 / $image["thumbBox"][2];
		$image["thumbBox"][0] = ($image["thumbBox"][0] * $image["thumbBox"][2]) / -100;
		$image["thumbBox"][1] = ($image["thumbBox"][1] * $image["thumbBox"][2]) / -100;
	}
}

// load the image deletion function
require_once "delete-image.php";
?>
		
		<title>ultimate worm sport</title>
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
		<link href="edit.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<link href="edit-image.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		
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
				
				<?php if ($worm["canEdit"]) { ?>
				<div class="info-box forms-wrapper" style="<?php echo !empty($worm["cssColor"]) ? "--color-dark:".$worm["cssColor"] : ""; ?>">
					<header>
						<h2><?php echo !empty($image) ? "Edit" : "Add"; ?> Image</h2>
					</header>
					<div class="main-container">
						<div class="details">
							
							<section id="thumbnail">
								<h3>thumbnail</h3>
								<div class="thumbnail-wrapper"><div id="edit-thumbnail">
									<img id="thumbnail-image" src="<?php echo !empty($image) ? $image["img"] : ""; ?>" alt="">
									<div id="thumbnail-dragbox"
										<?php
										if (!empty($image) && count($image["thumbBox"]) == 3) {
											echo "data-left='".$image["thumbBox"][0]."'
														data-top='".$image["thumbBox"][1]."'
														data-width='".$image["thumbBox"][2]."'
														style='left:".$image["thumbBox"][0]."%;top:".$image["thumbBox"][1]."%;width:".$image["thumbBox"][2]."%;'";
										} ?>
									>
										<div class="dot right bottom" id="right-bottom"></div>
									</div>
									<script src="thumbnail-dragbox.js"></script>
								</div></div>
							</section>
							
							<form id="image-form" method="POST">
								<h4>required</h4>
								<div class="form-section">
									<label for="input-image-link">image link:</label>
									<input type="text" id="input-image-link" name="imageLink" value="<?php echo  !empty($_POST) && !empty($_POST["imageLink"]) ? $_POST["imageLink"] : (!empty($image) ? $image["img"] : ""); ?>" required></input>
									<div class="error"><?php echo $link_err; ?></div>
								</div>
								
								<h4>optional</h4>
								<div class="form-section">
									<label for="input-image-username">artist's username:</label>
									<input type="text" id="input-image-username" name="username" value="<?php echo !empty($_POST) && !empty($_POST["username"]) ? $_POST["username"] : (!empty($image) && !empty($image["uid"]) ? getUsername($image["uid"]) : ""); ?>"></input>
									<div class="error"><?php echo $username_err; ?></div>
								</div>
								
								<!-- hidden input for thumbnail values -->
								<input type="hidden" id="input-thumbnail" name="thumb" value="<?php echo !empty($image) && !empty($image["thumb"]) ? $image["thumb"] : ""; ?>"></input>
								
								<img id="full-size-image" src="<?php echo !empty($image) ? $image["img"] : ""; ?>" alt="">
								<script>
									(()=>{
										var input = document.getElementById("input-image-link");
										var preview = document.getElementById("thumbnail-image");
										var fullSize = document.getElementById("full-size-image");
										input.addEventListener("change",(e)=>{
											preview.src = fullSize.src = "";
											preview.src = fullSize.src = e.target.value;
											if (e.target.value != "") {
												thumbnail.reset();
												thumbnail.show();
											} else { thumbnail.hide(); }
										});
									})();
								</script>
								
								<button type="submit" class="btn">Update</button>
								<a href="delete-image.php?<?php echo "id=".$worm["id"]."&image=".$_GET["imageId"]; ?>"
									class="btn btn-red">Delete</a>
							</form>
							<?php } else { ?>
							<div class="unauthorized">You don't have permission to edit this image!</div>
							<?php } ?>
						</div>
					</div>
					<footer>
						<div class="wrapper back-button-wrapper">
							<a href="/fan-worms/worm/<?php echo $worm_id; ?>">
								<i class="svg-icon i-caret-left"></i> <span>back</span>
							</a>
						</div>
					</footer>
				</div>
			</main>
			
			<!--main page footer-->
			<?php include '../../worm-common/footer.php'; ?>
		</div>
		
		<!--worm race updates-->
		<?php include '../updates.php'; ?>
	</body>
</html>