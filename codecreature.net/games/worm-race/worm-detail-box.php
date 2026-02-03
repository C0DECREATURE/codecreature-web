<form id="<?php echo $cur_worm["color"] ?>" class="tab info-box popup worm-details" action="feed.php" method="POST" style="
	--color: var(--<?php echo $cur_worm["color_medium"] ?>);
	--color-dark: var(--<?php echo $cur_worm["color_dark"] ?>);
">
	<input id="worm-input" type="hidden" name="worm-id" value="<?php echo $cur_worm["id"] ?>">
	
	<div>
		<div class="main-image main-worm-tab">
			<img src="<?php echo $image_path.$cur_worm["color"].".png" ?>" alt="">
		</div>
		
		<header>
			<h2><?php echo $cur_worm["name"] ?></h2>
		</header>
		
		<section class="health-section main-worm-tab">
			<div class="wrapper">
				<div class="health-bar health-<?php echo $cur_worm["health"] ?>">
					<div class="unit"></div><div class="unit"></div><div class="unit"></div><div class="unit"></div>
				</div>
				<div class="health-icon"><span class="sr-only">current health: <?php echo $cur_worm["health"] ?></span></div>
			</div>
		</section>
	</div>
	
	<div class="main-container worm-main">
		
		<div class="details main-worm-tab" style="--color: <?php echo $cur_worm["color"] ?>">
			<div><strong>color:</strong> <?php echo $cur_worm["color"] ?></div>
			<div><strong>length:</strong> <?php echo $cur_worm["length"] ?> inches</div>
			<div><strong>likes:</strong> <?php echo $cur_worm["likes"] ?></div>
		</div>
		
		<div class="items main-worm-tab">
			<div class="buttons">
				<div class="item-wrapper"><div>
					<?php $cur_item = $items["apple"]; ?>
					<input type="radio" id="<?php echo $cur_item["name"]; ?>-input" class="item-input"
						name="item" value="<?php echo $cur_item["name"]; ?>" aria-label="<?php echo $cur_item["display_name"]; ?>"
						data-display-name="<?php echo $cur_item["display_name"]; ?>"
						data-cooldown="<?php echo $cur_item["cooldown"]; ?>"
						data-progress="<?php echo $cur_item["progress"] * $cur_item["progress_effect_".$cur_worm["health"]]; ?>"
						data-health="<?php echo $cur_item["health"] * $cur_item["health_effect_".$cur_worm["health"]]; ?>"
						data-flavor-text="<?php echo $cur_item["flavor_text"]; ?>"
						required>
					<label for="<?php echo $cur_item["name"]; ?>-input" class="item"></label>
				</div></div>
				<div class="item-wrapper"><div>
					<?php $cur_item = $items["drink"]; ?>
					<input type="radio" id="<?php echo $cur_item["name"]; ?>-input" class="item-input"
						name="item" value="<?php echo $cur_item["name"]; ?>" aria-label="<?php echo $cur_item["display_name"]; ?>"
						data-display-name="<?php echo $cur_item["display_name"]; ?>"
						data-cooldown="<?php echo $cur_item["cooldown"]; ?>"
						data-progress="<?php echo $cur_item["progress"] * $cur_item["progress_effect_".$cur_worm["health"]]; ?>"
						data-health="<?php echo $cur_item["health"] * $cur_item["health_effect_".$cur_worm["health"]]; ?>"
						data-flavor-text="<?php echo $cur_item["flavor_text"]; ?>"
						required>
					<label for="<?php echo $cur_item["name"]; ?>-input" class="item"></label>
				</div></div>
				<div class="item-wrapper"><div>
					<?php $cur_item = $items["poison"]; ?>
					<input type="radio" id="<?php echo $cur_item["name"]; ?>-input" class="item-input"
						name="item" value="<?php echo $cur_item["name"]; ?>" aria-label="<?php echo $cur_item["display_name"]; ?>"
						data-display-name="<?php echo $cur_item["display_name"]; ?>"
						data-cooldown="<?php echo $cur_item["cooldown"]; ?>"
						data-progress="<?php echo $cur_item["progress"] * $cur_item["progress_effect_".$cur_worm["health"]]; ?>"
						data-health="<?php echo $cur_item["health"] * $cur_item["health_effect_".$cur_worm["health"]]; ?>"
						data-flavor-text="<?php echo $cur_item["flavor_text"]; ?>"
						<?php echo $cur_worm["health"] == 0 && $cur_worm["progress"] == 0 ? 'disabled' : '' ?>
						required>
					<label for="<?php echo $cur_item["name"]; ?>-input" class="item"></label>
				</div></div>
				<div class="item-wrapper"><div>
					<?php $cur_item = $items["heal"]; ?>
					<input type="radio" id="<?php echo $cur_item["name"]; ?>-input" class="item-input"
						name="item" value="<?php echo $cur_item["name"]; ?>" aria-label="<?php echo $cur_item["display_name"]; ?>"
						data-display-name="<?php echo $cur_item["display_name"]; ?>"
						data-cooldown="<?php echo $cur_item["cooldown"]; ?>"
						data-progress="<?php echo $cur_item["progress"] * $cur_item["progress_effect_".$cur_worm["health"]]; ?>"
						data-health="<?php echo $cur_item["health"] * $cur_item["health_effect_".$cur_worm["health"]]; ?>"
						data-flavor-text="<?php echo $cur_item["flavor_text"]; ?>"
						<?php echo $cur_worm["health"] == 4 ? 'disabled' : '' ?>
						required>
					<label for="<?php echo $cur_item["name"]; ?>-input" class="item"></label>
				</div></div>
			</div>
			<div class="description empty">
				<div class="empty-text">Select an Item</div>
				<div class="info">
					<div class="name"></div>
					<div class="stats"></div>
					<div class="subtitle"></div>
				</div>
			</div>
		</div>
		
		<div id="<?php echo $cur_worm["color"] ?>-fans" class="leaderboard hidden">
			<div class="tables">
				<?php getWormLeaderboard($cur_worm["id"]); ?>
				<section class="box-wrapper">
					<header><h4>Fans</h4></header>
					<?php echo $helper_table ?>
				</section>
				
				<section class="box-wrapper">
					<header><h4>Haters</h4></header>
					<?php echo $hurter_table ?>
				</section>
			</div>
			
			<section class="user-data box-wrapper"><div class="wrapper">
				<header class="<?php $logged_in ? "" : "hidden" ?>">
					<h4><?php if($logged_in) { echo $_SESSION["username"]; } ?></h4>
				</header>
				<?php getUserWormLeaderboard($cur_worm["id"]); ?>
			</div></section>
		</div>
	</div>
	
	<footer>
		<button type="button" onclick="openDetailBox('worms')">
			<i class="svg-icon i-caret-left"></i> <span>back</span>
		</button>
		<button type="button" class="leaderboard-button" onclick="toggleFans('<?php echo $cur_worm["color"] ?>');">fans</button>
		<button type="submit" class="feed-button tooltip">
			<span class="text">feed <i class="svg-icon i-caret-right"></i></span>
			<span class="tooltip-text">select an item!</span>
		</button>
	</footer>
</form>

<script>
	(()=>{
		<?php echo 'let color = "'.$cur_worm["color"].'";'; ?>
		let hash = '#'+color;
		if (window.location.hash == hash) {
			openDetailBox(color);
		};
		updateFeedButton(color);
		let form = document.getElementById(color);
		let itemInputs = form.querySelectorAll('.item-input');
		for (let i = 0; i < itemInputs.length; i++) {
			itemInputs[i].addEventListener('change',()=>{
				updateFeedButton(color);
				
				if (itemInputs[i].checked) { form.querySelector(".description").classList.remove("empty");
				} else { form.querySelector(".description").classList.add("empty"); }
				
				form.querySelector(".info").querySelector(".name").innerHTML = itemInputs[i].dataset.displayName;
				
				// stats text
				<?php echo 'let imagePath = "'.$image_path.'";'; ?>
				let stats = "";				
				let cooldown = itemInputs[i].dataset.cooldown;
				stats += cooldown > 60 ? (cooldown/60)+" min cooldown" : cooldown+" sec cooldown";
				// progress
				let progress = Number(itemInputs[i].dataset.progress);
				if ( progress != 0 ) {
					if ( progress > 0 ) stats += " / +"+progress;
					else if ( progress < 0 ) stats += " / "+progress;
					stats += '<img src="'+imagePath+'icon-progress-1.png" alt="progress">';
				}
				// health
				let health = Number(itemInputs[i].dataset.health);
				if ( health > 0 ) stats += " / +"+health;
				else if ( health < 0 ) stats += " / "+health;
				stats += '<img src="'+imagePath+'icon-health-pos.png" alt="health">';
				// add the text
				form.querySelector(".info").querySelector(".stats").innerHTML = stats;
				
				form.querySelector(".info").querySelector(".subtitle").innerHTML = itemInputs[i].dataset.flavorText;
			});
		};
	})();
</script>