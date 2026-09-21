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
						
						<div class="subheader" id="awards">
							<h3>Awards</h3>
						</div>
						
						<div class="details">
							<p>worms can earn special awards for their achievements! awards can only be held by one worm at a time, except in case of a tie.</p>
							<hr>
							<div class="awards">
								
								<div class="award">
									<img src="../images/awards/award_certified_organic.png" alt="">
									<div class="name">Certified Organic</div>
									<div class="description">
										most apples relative to race progress
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_caffeine_addict.png" alt="">
									<div class="name">Caffeine Addict</div>
									<div class="description">
										most drinks relative to race progress
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_private_insurance.png" alt="">
									<div class="name">Private Insurance</div>
									<div class="description">
										most health potions relative to race progress
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_most_despised.png" alt="">
									<div class="name">Most Despised</div>
									<div class="description">
										most poisons relative to race progress
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_sprint_master.png" alt="">
									<div class="name">Sprint Master</div>
									<div class="description">
										most progress gained in a single day
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_reigning_champion.png" alt="">
									<div class="name">Reigning Champion</div>
									<div class="description">
										winner of the previous season
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_underdog.png" alt="">
									<div class="name">Underdog</div>
									<div class="description">
										loser of the previous season
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_most_kinnable.png" alt="">
									<div class="name">Most Kinnable</div>
									<div class="description">
										most users with this worm as their icon
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_creature's_pet.png" alt="">
									<div class="name">Creature's Pet</div>
									<div class="description">
										admins' favorite worm
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="subheader" id="holidays">
							<h3>Holidays</h3>
						</div>
						<div class="details" id="holiday-details">
							<p>worm <b>birthdays</b> are celebrated for 3 days, starting the day before and ending the day after! the birthday worm can't be <span class="item poison">poisoned</span> during their party.</p>
							<p class="matilda"><span class="name">matilda:</span> february 29th <a class="info" href="https://en.wikipedia.org/wiki/February_29" target="_blank"></a></p>
							<p class="jeremy"><span class="name">jeremy:</span> april 15th <a class="info" href="https://en.wikipedia.org/wiki/Tax_Day" target="_blank"></a></p>
							<p class="stringcheese"><span class="name">string cheese:</span> may 13th</p>
							<p class="poolnoodle"><span class="name">pool noodle:</span> july 2nd <a class="info" href="https://nationaltoday.com/special-recreation-for-the-disabled-day/" target="_blank"></a></p>
							<p class="pretzel"><span class="name">pretzel:</span> september 8th</p>
							<p class="microplastics"><span class="name">microplastics:</span> november 22nd</p>
							<hr>
							<p>other worm holidays are celebrated throughout the year, with special treats and outfits! an award is given to the worm who travels the furthest during the holiday.</p>
							
							<div class="awards">
								
								<div class="award">
									<img src="../images/awards/award_sexiest_worm_alive.png" alt="">
									<div class="name jeremy">Valentine's Day</div>
									<div class="description">
										february 1st - 14th
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_silliest_worm.png" alt="">
									<div class="name matilda">April Fool's</div>
									<div class="description">
										april 1st - 3rd
									</div>
								</div>
								<!--
								<div class="award">
									<img src="../images/awards/award_summer.png" alt="">
									<div class="name stringcheese">Summer Solstice</div>
									<div class="description">
										june 16th - 22nd
									</div>
								</div>
								
								<div class="award">
									<img src="../images/awards/award_stargazer.png" alt="">
									<div class="name microplastics">Meteor Shower</div>
									<div class="description">
										august 10th - 16th
									</div>
								</div>
								-->
								<div class="award">
									<img src="../images/awards/award_pumpkin_king.png" alt="">
									<div class="name pretzel">Halloween</div>
									<div class="description">
										october 25th - 31st
									</div>
								</div>
								<!--
								<div class="award">
									<img src="../images/awards/award_ice_queen.png" alt="">
									<div class="name poolnoodle">Winter Solstice</div>
									<div class="description">
										december 16th - 22nd
									</div>
								</div>
								-->
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