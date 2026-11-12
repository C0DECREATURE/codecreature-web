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
		// load the worm data into $worm
		require_once "get-worm.php";
		?>
		
		<title><?php echo !empty($worm["name"]) ? $worm["name"] : "worm not found"; ?></title>
		<meta name="keywords" content="worm,worms">
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
		
		<!-- svg icons -->
		<link href="/graphix/svg-icons/svg-icons-new.css?fileversion=20260920" rel="stylesheet" type="text/css"></link>
		<!--full image view-->
		<script src="/codefiles/full-image.js"></script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--worms common stylesheet-->
		<link href="/games/worm-common/style.css?fileversion=20261011" rel="stylesheet" type="text/css" media="all">
		<!--worm race game stylesheet-->
		<link href="../style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--profile stylesheet-->
		<link href="gallery.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<link href="profile.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		
		<!-- worm race functions -->
		<script src="../wormFunctions.js?fileversion=20260920"></script>
	</head>
	<body>
		
		<!-- menu & navigation -->
		<?php include "../menu.php"; ?>
		
		<div id="content-wrapper">
			
			<main id="content">
				<!--main page header-->
				<?php include "../header.php"; ?>
				
				<!--worm details-->
				<div class="info-box profile" style="
					--color: <?php echo $worm["cssColor"] ?>;
					--text-color: <?php echo $worm["cssTextColor"] ?>;
				">
					<div class="top">
						<?php if (!empty($worm["icon"])) { ?>
							<img class="main-image" src="<?php echo $worm["icon"] ?>" alt="">
						<?php } ?>
						
						<header>
							<h2><?php echo !empty($worm["name"]) ? $worm["name"] : "Not Found"; ?></h2>
						</header>
						
					</div>
					
					<div class="main-container worm-main">
						<?php if (!empty($worm["id"])) { ?>
						<div class="details">
							<div>by <a href="/u/<?php echo $worm["ownerName"] ?>">@<?php echo $worm["ownerName"] ?></a></div>
							<?php echo !empty($worm["length"]) ? "<div><strong>length:</strong> ".$worm["length"]." inches</div>" : "" ?>
							<?php echo !empty($worm["likes"]) ? "<div><strong>likes:</strong> ".$worm["likes"]."</div>" : "" ?>
							<?php echo !empty($worm["website"]) ? "<div class='website'><a href='/url/?redirect=".urlencode($worm["website"])."'>personal page🡲</a></div>" : "" ?>
						</div>
						
						<div class="gallery">
							<?php for ($i = 0; $i < $gallery_limit; $i++) {
								if (!empty($worm["gallery"][$i])) {
									$img = $worm["gallery"][$i];?>
								<div class="wrapper">
									<img class="full-viewable" src="<?php echo $img["img"]; ?>"
										alt="<?php if (!empty($img["alt"])) echo $img["alt"]; ?>"
										style="
											<?php if (!empty($img["thumb"])) {
												$thumb = explode(",",$img["thumb"]);
												echo "left: $thumb[0]%; top: $thumb[1]%; width: $thumb[2]%;";
											} ?>
										"
										<?php
										$link = $label = "";
										if (!empty($img["uid"])) {
											$username = getUsername($img["uid"]);
											$link = "/u/$username";
											$label = "@$username";
										} else if (!empty($img["credit"])) {
											$link = $img["credit"];
											$label = !empty($img["creditLabel"]) ? $img["creditLabel"] : $img["credit"];
										}
										if (!empty($link)) echo "data-credit=\"$link\" data-credit-label=\"$label\"";
										?>
										data-credit-label="<?php if (!empty($img["artistLink"])) echo $img["artist"]; ?>"
									>
								</div>
								<?php
								}
							}?>
						</div>
						<?php } else { ?>
						<div class="not-found">Could not find worm<?php echo empty($_GET["id"]) ? " with id ".$_GET["id"] : ""; ?> in the system.</div>
						<?php } ?>
					</div>
					
					<footer>
						<div class="wrapper back-button-wrapper">
							<a href="/fan-worms">
								<i class="svg-icon i-caret-left"></i> <span>back</span>
							</a>
						</div>
						<?php if (!empty($worm["id"]) && $worm["canEdit"]) { ?>
						<div class="wrapper">
							<a href="/fan-worms/worm/<?php echo $worm["id"]; ?>/edit">
								<span>edit</span> <i class="svg-icon i-caret-right"></i>
							</a>
						</div>
						<?php } ?>
					</footer>
				</div>
			</main>
			
			<!--main page footer-->
			<?php include "../../worm-common/footer.php"; ?>
		</div>
		
		<!--worm race updates-->
		<?php include "../updates.php"; ?>
	</body>
</html>