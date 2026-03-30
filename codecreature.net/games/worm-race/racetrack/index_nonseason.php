<?php
	// include worm functions file
	require_once "../worm-functions.php";
	
	// include worm season file
	require_once "../season.php";

	// fetch worm data
	getAllData();
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>worm racetrack</title>
		
		<!-- prevent warnings popup on this page -->
		<script>var showWarnings = false;</script>
		
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
			<div id="content">
				<!--main page header-->
				<?php include '../header.php'; ?>
				
				<!-- worm race section -->
				<section id="race">
					<!-- screen reader navigation -->
					<div class="sr-only">
						<a href="#race-tracks">jump to race tracks</a>
						<a href="#worm-stats">jump to worm stats</a>
						<a href="#bottom-text">jump to bottom text</a>
					</div>
									
					
					<div class="race-content">
						
						<div class="wrapper">
							<header>
								<!-- spacer -->
								<span class="header-side">
									<?php echo $cur_season["name"] ?>
								</span>
								
								<div class="title">
									<select id="season-select">
										<option value="current">season</option>
										<option value="all-time">all time</option>
									</select>
								</div>
								
								<span class="header-side">
									<svg xmlns="http://www.w3.org/2000/svg" style="display:inline-block;" width="1em" fill="currentColor" class="bi bi-hourglass" viewBox="0 0 16 16">
										<path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702c0 .7-.478 1.235-1.011 1.491A3.5 3.5 0 0 0 4.5 13v1h7v-1a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351v-.702c0-.7.478-1.235 1.011-1.491A3.5 3.5 0 0 0 11.5 3V2z"/>
									</svg>
									<span id="season-countdown"></span>
									<script>countdownToNextSeason();</script>
								</span>
							</header>
							<div id="race-tracks">
								<!-- worm race tracks inserted here -->
								<?php
									$percent_max = 0;
									for ($i = 0; $i < count($worms); $i++) {
										$percent_max = max((int)$worms[$i]["progress"], $percent_max);
									}
									for ($i = 0; $i < count($worms); $i++) {
										$cur_worm = $worms[$i];
										$winner = (int)$cur_worm["progress"] == $percent_max ? " winner" : "";
										$percent = (int)$cur_worm["progress"] / $percent_max;
										$css_percent = ($percent*100)-25;
										$css_time = $percent * 3;
										$css_bounce = 1-(.8*$percent);
										echo '
											<div id="'.$cur_worm["color"].'-racer" class="race-row'.$winner.'"
											style="--percent:'.$css_percent.'%; --time:'.$css_time.'s;--bounce:'.$css_bounce.'s;">
												<div class="dots" style="border-color: var(--'.$cur_worm["color"].');"></div>
												<div class="wrapper">
													<img src="'.$image_path.$cur_worm["color"].'_racer.png" alt="">
												</div>
											</div>
										';
									}
								?>
							</div>
						</div>
						
						<div id="worm-stats">
							<!-- worm stats inserted here -->
							<?php
								for ($i = 0; $i < count($worms); $i++) {
									$cur_worm = $worms[$i];
									include 'stat-block.php';
								}
							?>
						</div>
						
						<!-- CURRENT WINNING WORM BANNER -->
						<?php
							$cur_winner = $worms[0];
							for ($i = 1; $i < count($worms); $i++) {
								if ( (int)$worms[$i]["progress"] > (int)$cur_winner["progress"] ) {
									$cur_winner = $worms[$i];
								}
							}
						?>
						<section id="win-text" style="
							--color: var(--<?php echo $cur_winner["color_dark"] ?>);
							--color-light: var(--<?php echo $cur_winner["color_light"] ?>);
						">
							<?php echo '
								<span class="wrapper"><span class="name text-outline-2px">'.$cur_winner["name"].'</span></span>
								<span>'.$cur_winner["win_text"].'!</span>'
							;?>
						</section>
					</div>
					
				</section>
				
				<section id="feed-log" class="info-box">
					<header><h3>Recent</h3></header>
					<div class="main-container">
						<div class="details">
							<?php echo getFeedLogDisplay(); ?>
						</div>
					</div>
				</section>
			</div>
			
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