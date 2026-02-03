<header style="background-image: url('<?php echo $image_path ?>banner.svg');">
	<a href="<?php echo $worm_race_path ?>" class="header-link">
		<h1 class="sr-only">Worm Race</h1>
		<h3 id="banner-subtitle">Feed a Worm</h3>
	</a>
</header>

<script>
	(()=>{
		function updateTime() {
			let cooldown = Number(sessionStorage.getItem("cooldown")) - 1;
			sessionStorage.setItem("cooldown", cooldown);
			
			let displayText = "";
			if (cooldown <= 0) {
				canFeed = true;
				updateFeedButtons();
				clearInterval(cooldownInterval);
				displayText = "Feed a Worm";
			} else {
				canFeed = false;
				displayText += "Feed again in ";
				let minutes = Math.floor(cooldown / 60);
				let seconds = cooldown - (minutes * 60);
				if (seconds < 10) seconds = "0" + seconds;
				displayText += minutes + ":" + seconds;
			}
			document.getElementById('banner-subtitle').innerHTML = displayText;
		}
		<?php
			if ( isset($_SESSION["last_feed"]) && isset($_SESSION["last_cooldown"]) ) {
				echo '
					sessionStorage.setItem("cooldown",'.
						max($_SESSION["last_feed"] + $_SESSION["last_cooldown"] - time(), 0)
					.');
					let cooldownInterval = setInterval(updateTime, 1000);
					updateTime();
				';
			}
		?>
	})();
</script>