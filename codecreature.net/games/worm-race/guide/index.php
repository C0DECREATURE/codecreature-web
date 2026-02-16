<?php
	// include worm functions file
	require_once "../worm-functions.php";
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>how to worm</title>
		
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
		<!--worm race game stylesheet-->
		<link href="../style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="guide.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>
		<!-- menu & navigation -->
		<?php include '../menu.php'; ?>
		
		<div id="content-wrapper">
			<!--main page header-->
			<?php include '../header.php'; ?>
			
			<main id="content">
				
				<section id="guide" class="tab info-box popup show">
					<header>
						<h2>How to Play</h2>
					</header>
					<div class="main-container">
						<div class="details">
							<p>each worm has two stats: <span class="health caps">health</span> and <span class="movement caps">race progress</span>.</p>
							<hr>
							<p><span class="item apple">apples</span> increase <span class="movement">race progress</span> a little.</p>
							<p><span class="item battery">battery juice</span> increases <span class="movement">race progress</span> a lot, but damages <span class="health">health</span>.</p>
							<p><span class="item heart">heart potions</span> increase <span class="health">health</span>.</p>
							<p><span class="item poison">poison</span> decreases <span class="health">health</span> and <span class="movement">race progress</span>. if the worm is already at 0 health, it decreases progress a <b>lot</b>.</p>
							<hr>
							<p>low <span class="health caps">health</span> makes apples and battery juice <b>weaker</b>, and makes poison <b>stronger</b>. when you click an item, it shows the effects based on the selected worm's current health.</p>
						</div>
					</div>
					
					<footer>
						<a href="../">
							<i class="svg-icon i-caret-left"></i> back
						</a>
					</footer>
				</section>
				
			</main>
			
			<!--main page footer-->
			<?php include '../footer.php'; ?>
		</div>
		
		<!--worm race updates-->
		<?php include '../updates.php'; ?>
	</body>
</html>