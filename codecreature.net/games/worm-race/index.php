<?php
	// include worm functions file
	require_once "worm-functions.php";

	// fetch worm data
	getAllData();
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>ultimate worm sport</title>
		<meta name="description" content="Feed a worm, race to victory.">
		<meta name="keywords" content="game,worms,worm,feed,worm game,worms game,worms race,worm race,worm racing,worm feeding">
		<meta name="author" content="codecreature">
		
		<!-- check url parameters and such -->
		<script>updateUrl();</script>
		
		<!-- prevent warnings popup on this page -->
		<script>var showWarnings = false;</script>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="favicon.ico">
		
		<!--fonts-->
		<script>fonts.load('YetR','Super Comic');</script>
		
		<!-- svg icons -->
		<link href="/graphix/svg-icons/svg-icons-new.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--worms common stylesheet-->
		<link href="/games/worm-common/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		
		<!-- worm race functions -->
		<script src="/games/worm-race/wormFunctions.js"></script>
	</head>
	<body>
		
		<!-- menu & navigation -->
		<?php include 'menu.php'; ?>
		
		<div id="content-wrapper">
			<!--main page header-->
			<?php include 'header.php'; ?>
			
			<main id="content">
				<!--worm details-->
				<?php include 'worms.php'; ?>
				
			</main>
			
			<!--main page footer-->
			<?php include '../worm-common/footer.php'; ?>
		</div>
		
		<!--worm race updates-->
		<?php include 'updates.php'; ?>
	</body>
</html>