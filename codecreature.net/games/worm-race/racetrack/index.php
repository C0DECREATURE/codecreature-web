<?php
	// include worm functions file
	require_once "../worm-functions.php";
	
	// include worm season file
	require_once "../season.php";
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>worm racetrack</title>
		<meta name="description" content="The latest results of the worm race.">
		<meta name="keywords" content="game,race,results,worms,worm,worm race,worm racing,worm racetrack,worm race results">
		<meta name="author" content="codecreature">
		
		<!-- prevent warnings popup on this page -->
		<script>var showMainWarnings = false;</script>
		
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="../favicon.ico">
		
		<!--fonts-->
		<script>fonts.load('YetR','Super Comic');</script>
		
		<!-- svg icons -->
		<link href="/graphix/svg-icons/svg-icons-new.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--worms common stylesheet-->
		<link href="/games/worm-common/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--worm race game stylesheet-->
		<link href="../style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="racetrack.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		
		<!-- worm race functions -->
		<script src="/games/worm-race/wormFunctions.js"></script>
	</head>
	<body>
		<!-- menu & navigation -->
		<?php include '../menu.php'; ?>
		
		<main id="content-wrapper">
			
			<!-- contains all worm content -->
			<?php include "load_season.php"; ?>
			
			<script>
				function loadSeasonRacetrack(season) {
					console.log('Loading racetrack for season "'+season+'"');
					var content;
					$.get("load_season.php?season=" + season, function(data){
							content = data;
							$('#content').replaceWith(content);
					});
				}
			</script>
			
			<!--main page footer-->
			<?php include '../../worm-common/footer.php'; ?>
		</main>
		
		<!--worm race updates-->
		<?php include '../updates.php'; ?>
		
		<script>
			// put the correct svg in each .svg-icon element
			defaultSvgIcons.load();
		</script>
	</body>
</html>