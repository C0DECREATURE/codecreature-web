<?php
	// include worm functions file
	require_once "../worm-functions.php";

	// fetch worm data
	getAllData();
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>worm racetrack</title>
		
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
		<!--worm race game stylesheet-->
		<link href="../style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>
		<!-- menu & navigation -->
		<?php include '../menu.php'; ?>
		
		
		<main id="content-wrapper">
			<!--main page header-->
			<?php include '../header.php'; ?>
			
			<!-- contains all worm content -->
			<div id="content">
				<!-- worm race section -->
				<section id="race">
					<!-- screen reader navigation -->
					<div class="sr-only">
						<a href="#race-tracks">jump to race tracks</a>
						<a href="#worm-stats">jump to worm stats</a>
						<a href="#bottom-text">jump to bottom text</a>
					</div>
					
					<div class="race-content">
						<!-- worm race tracks inserted here -->
						<div id="race-tracks">
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
						<!-- worm stats inserted here -->
						<div id="worm-stats">
							<?php
								for ($i = 0; $i < count($worms); $i++) {
									$cur_worm = $worms[$i];
									include 'stat-block.php';
								}
							?>
						</div>
					</div>
					
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
						<span class="wrapper">
							<?php echo '
								<span class="wrapper"><span class="name text-outline-2px">'.$cur_winner["name"].'</span></span>
								'.$cur_winner["win_text"].'!'
							;?>
						</span>
					</section>
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
			<?php include '../footer.php'; ?>
		</main>
		
		<!--worm race updates-->
		<?php include '../updates.php'; ?>
		
		<script>
			// put the correct svg in each .svg-icon element
			defaultSvgIcons.load();
		</script>
	</body>
</html>