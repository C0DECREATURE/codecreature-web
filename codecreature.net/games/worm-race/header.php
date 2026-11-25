<?php
	// check if it is currently a holiday event
	checkHolidays();
	
	$banner = "banner.svg";
	if (isset($holidays)) {
		if (array_key_exists($cur_holiday,$holidays) || $cur_holiday == "birthday") {
			echo "<script>document.body.classList.add('holiday','$cur_holiday');</script>";
			$hBanner = $cur_holiday."/".$banner;
			if (file_exists($_SERVER['DOCUMENT_ROOT'].$image_path.$hBanner)) $banner = $hBanner;
		}
	}
?>

<header id="header-banner" style="background-image: url('<?php echo $image_path.$banner ?>');">
	<a href="<?php echo $worm_race_path ?>" class="header-link">
		<h1 class="sr-only">Worm Race</h1>
		<h3 id="banner-subtitle">Feed a Worm</h3>
	</a>
</header>

<script>
	if (typeof headerCooldownInterval == "undefined") {
		function updateHeaderTime() {
			// get Unix timestamp when cooldown ends, in seconds
			let cooldownEnds = Number(sessionStorage.getItem("cooldownEnds"));
			// get current Unix timestamp, in seconds
			let now = Math.floor(Date.now() / 1000);
			
			// text to display in the header
			let displayText = "";
			
			// if the cooldown ended in the past, clear the stored cooldown
			if (cooldownEnds < now) {
				canFeed = true;
				updateFeedButtons();
				clearInterval(headerCooldownInterval);
				displayText = "Feed a Worm";
			// if the cooldown ends in the future
			} else {
				canFeed = false;
				// get the seconds until cooldown ends
				let cooldown = cooldownEnds - now;
				// convert into display text
				displayText += "Feed again in ";
				let minutes = Math.floor(cooldown / 60);
				let seconds = cooldown - (minutes * 60);
				if (seconds < 10) seconds = "0" + seconds;
				displayText += minutes + ":" + seconds;
			}
			// set the header text
			document.getElementById('banner-subtitle').innerHTML = displayText;
		}
		<?php
			// if there is a user logged in, check that user's recent feed logsc
			if (isset($_SESSION["id"])) userCanFeed($_SESSION["id"],"user_id");
			// pass any PHP cooldown info to javascript
			if ( isset($_SESSION["last_feed"]) && isset($_SESSION["last_cooldown"]) ) {
				$cooldown_end = $_SESSION["last_feed"] + $_SESSION["last_cooldown"];
				// if cooldown ends in the future
				if ($cooldown_end > time()) {
					echo "sessionStorage.setItem('cooldownEnds',$cooldown_end);";
				}
			}
		?>
		headerCooldownInterval = setInterval(updateHeaderTime, 1000);
		updateHeaderTime();
	};
</script>