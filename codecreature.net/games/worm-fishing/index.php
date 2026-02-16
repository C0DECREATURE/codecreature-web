<?php

// include users connection data
require_once "../worm-common/users.php";

?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>ultimate worm sport</title>
		
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
	</head>
	<body>
		<!--main page footer-->
		<?php include 'menu.php'; ?>
		
		<!-- menu & navigation -->
		<div id="content-wrapper">
			
			<main id="content">
				<iframe src="window"></iframe>
			</main>
			
			<!--main page footer-->
			<?php include $_SERVER['DOCUMENT_ROOT'].'/games/worm-common/footer.php'; ?>
		</div>
	</body>
</html>