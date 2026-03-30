<?php

// include worm functions file
require_once "../worm-functions.php";

// if season name was specified, use that instead of the default current season
if (!empty($_GET['season'])) {
	$active_season = getSeason(trim($_GET['season']));
}

// load all data for selected $active_season
getAllData();
?>

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
						
		
		<div id="race-content" class="race-content">		
			<div class="wrapper">
				<header>
					<!-- spacer -->
					<span class="header-side"><?php
						if ($active_season["name"] == $cur_season["name"]) { echo $active_season["display_name"]; }
					?></span>
					
					<div class="title">
						<select id="season-select" onchange="loadSeasonRacetrack(this.value);">
							<?php
								echo '<option value="'.$cur_season["name"].'">Current</option>';
								echo '<option value="all_time">All Time</option>';
								foreach ($seasons_list as $s) {
									if ($s["name"] != $cur_season["name"] && $s["name"] != "all_time") {
										echo '<option value="'.$s["name"].'">'.$s["display_name"].'</option>';
									}
								}
							?>
						</select>
						<script><?php echo "document.getElementById('season-select').value = '".$active_season["name"]."';"; ?></script>
					</div>
					
					<span class="header-side">
						<?php if (!empty($active_season["end_time"])) { echo 
						`<svg xmlns="http://www.w3.org/2000/svg" style="display:inline-block;" width="1em" fill="currentColor" class="bi bi-hourglass" viewBox="0 0 16 16">
							<path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702c0 .7-.478 1.235-1.011 1.491A3.5 3.5 0 0 0 4.5 13v1h7v-1a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351v-.702c0-.7.478-1.235 1.011-1.491A3.5 3.5 0 0 0 11.5 3V2z"/>
						</svg>`;
						} ?>
						<span id="season-countdown"></span>
						<script>
							<?php
								if (!empty($active_season["end_time"])) {
									echo 'startSeasonCountdown('.getSeasonTimeRemaining($active_season).');';
								} else { echo 'clearSeasonCountdown();'; }
							?>
						</script>
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
							$percent = $percent_max == 0 ? 0 : (int)$cur_worm["progress"] / $percent_max;
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
				$cur_winners = [];
				$max_progress = 0;
				foreach ($worms as $w) {
					if ((int)$w["progress"] > $max_progress) $max_progress = $w["progress"];
				}
				foreach ($worms as $w) { if ($w["progress"] == $max_progress) $cur_winners[] = $w; }
			?>
			<section id="win-text">
				<?php
				$count = count($cur_winners); 
				if ($count > 1) {
					for ($i = 0; $i < $count; $i++) {
						echo '<span class="wrapper" style="
									--color: var(--'.$cur_winners[$i]["color_dark"].');
									--color-light: var(--'.$cur_winners[$i]["color_light"].');">
										<span class="name text-outline-2px">'.$cur_winners[$i]["name"].'</span>
									</span>';
						if ($i == $count - 2) { echo " and "; }
					}
					if ($active_season["ongoing"] == "true") {
						echo '<span> are neck and neck!</span>';
					} else { echo '<span> finished in a tie!</span>'; }
				} else {
					$cur_winner = $cur_winners[0];
					$win_text = $active_season["ongoing"] == "true" ? $cur_winner["win_text"] : $cur_winner["win_text_past"];
					echo '
						<span class="wrapper" style="
						--color: var(--'.$cur_winner["color_dark"].');
						--color-light: var(--'.$cur_winner["color_light"].');">
							<span class="name text-outline-2px">'.$cur_winner["name"].'</span>
						</span>
						<span>'.$win_text.'!</span>'
					;
				}
				
				?>
			</section>
		</div>
		
	</section>
	
	<div id="activity">
		<section id="feed-log" class="info-box">
			<header><h3>Recent</h3></header>
			<div class="main-container">
				<div class="details">
					<?php echo getFeedLogDisplay(); ?>
				</div>
			</div>
		</section>
		
		<section id="leaderboard" class="info-box">
			<header><h3>Season Fans</h3></header>
			<div class="main-container">
				<div class="details">
					<?php echo getSeasonFansDisplay($active_season); ?>
				</div>
			</div>
		</section>
	</div>
</div>