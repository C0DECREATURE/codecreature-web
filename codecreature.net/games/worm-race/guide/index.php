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
		<meta name="description" content="Worm race play guide.">
		<meta name="keywords" content="how to play,guide,worms,worm,worm game,worms game">
		<meta name="author" content="codecreature">
		
		<!-- prevent warnings popup on this page -->
		<script>var showMainWarnings = false;</script>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="favicon.ico">
		
		<!--fonts-->
		<script>fonts.load('YetR','Super Comic');</script>
		
		<!-- svg icons -->
		<link href="/graphix/svg-icons/svg-icons-new.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--worms common stylesheet-->
		<link href="/games/worm-common/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--worm race game stylesheet-->
		<link href="../style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="guide.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		
		<!-- worm race functions -->
		<script src="/games/worm-race/wormFunctions.js"></script>
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
						
						<div class="subheader">
							<h3>Awards</h3>
						</div>
						
						<div class="details">
							<p>worms can earn special awards for their achievements! one-time awards, like Underdog, can only be held by one worm at a time, except in case of a tie.</p>
							<hr>
							<div id="awards">
								<div class="award">
									<img src="../images/award_most_kinnable.png" alt="">
									<div class="name">Most Kinnable</div>
									<div class="description">
										highest number of users with this worm as their icon
									</div>
								</div>
								
								<div class="award">
									<img src="../images/award_certified_organic.png" alt="">
									<div class="name">Certified Organic</div>
									<div class="description">
										highest number of apples relative to total items eaten
									</div>
								</div>
								
								<div class="award">
									<img src="../images/award_caffeine_addict.png" alt="">
									<div class="name">Caffeine Addict</div>
									<div class="description">
										highest number of drinks relative to total items eaten
									</div>
								</div>
								
								<div class="award">
									<img src="../images/award_most_despised.png" alt="">
									<div class="name">Most Despised</div>
									<div class="description">
										highest number of poisons relative to total items eaten
									</div>
								</div>
								
								<div class="award">
									<img src="../images/award_underdog.png" alt="">
									<div class="name">Underdog</div>
									<div class="description">
										win first place after coming in last the previous season
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
					<footer>
						<div class="wrapper">
							<a href="../">
								<i class="svg-icon i-caret-left"></i> back
							</a>
						</div>
					</footer>
				</section>
				
			</main>
			
			<!--main page footer-->
			<?php include '../../worm-common/footer.php'; ?>
		</div>
		
		<!--worm race updates-->
		<?php include '../updates.php'; ?>
	</body>
</html>