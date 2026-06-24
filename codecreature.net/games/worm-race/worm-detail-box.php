<form id="<?php echo $cur_worm["color"] ?>" class="tab info-box popup worm-details" action="feed.php" method="POST" style="
	--color: var(--<?php echo $cur_worm["color_medium"] ?>);
	--color-dark: var(--<?php echo $cur_worm["color_dark"] ?>);
">
	<input id="worm-input" type="hidden" name="worm-id" value="<?php echo $cur_worm["id"] ?>">
	
	<div>
		<div class="main-image main-worm-tab tab">
			<button type="button" onclick="openDetailBox('<?php echo $prev_worm["color"] ?>')">
				<i class="svg-icon i-caret-left"></i>
			</button>
			
			<img src="<?php echo $image_path.$cur_worm["color"].".png" ?>" alt="">
			
			<button type="button" onclick="openDetailBox('<?php echo $next_worm["color"] ?>')">
				<i class="svg-icon i-caret-right"></i>
			</button>
		</div>
		
		<header>
			<h2><?php echo $cur_worm["name"] ?></h2>
		</header>
		
		<section class="health-section main-worm-tab tab">
			<div class="wrapper">
				<div class="health-bar health-<?php echo $cur_worm["health"] ?>">
					<div class="unit"></div><div class="unit"></div><div class="unit"></div><div class="unit"></div>
				</div>
				<div class="health-icon"><span class="sr-only">current health: <?php echo $cur_worm["health"] ?></span></div>
			</div>
		</section>
	</div>
	
	<div class="main-container worm-main">
		
		<div class="details main-worm-tab tab" style="--color: <?php echo $cur_worm["color"] ?>">
			<div><strong>color:</strong> <?php echo $cur_worm["color"] ?></div>
			<div><strong>length:</strong> <?php echo $cur_worm["length"] ?> inches</div>
			<div><strong>likes:</strong> <?php echo $cur_worm["likes"] ?></div>
		</div>
		
		<div class="items main-worm-tab tab">
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
		
		<div class="tab leaderboard hidden">
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
		
		<div class="tab trophies hidden">
			<div class="top">
				<?php
					$trophy_nums = ["1st","2nd","3rd","4th","5th","6th"];
					$win_history = json_decode($cur_worm["win_counts"],false);
					$highest = array_search(max($win_history),$win_history) + 1;
					
					$type = $highest < 4 ? "trophy" : "ribbon";
					
					echo "<div class='average-trophy'>"
								. "<img src='images/" . $type . "_base_" . $highest . ".png' "
								. "alt='" . $trophy_nums[$highest - 1] . " place" . "'>"
								. "<img src='images/trophy_base_" . $cur_worm["color"] . ".png' alt=''>"
								. "</div>";
				?>
				<div class="wrapper">
					<?php
						$trophy_nums = ["1st","2nd","3rd","4th","5th","6th"];
						$win_history = json_decode($cur_worm["win_counts"],false);
						for ($w = 0; $w < count($win_history); $w++) {
							$num = $w + 1;
							echo "<div class='trophy'>"
										. "<img src='images/trophy_" . $num . ".png' alt='"
										. $trophy_nums[$w] . " place" . "'>"
										. $win_history[$w] . "</div>";
						};
						
					?>
				</div>
			</div>
			<div class="awards">
				<?php
					$awards = $cur_worm["awards"];
					
					if (count($awards) == 0) {
						echo "<div class='text'>No special awards!</div>";
					} else {
						for ($a = 0; $a < count($awards); $a++) {
							echo "<a href='guide#awards' class='award tooltip'>
											<img src=images/award_" . str_replace(" ","_",strtolower($awards[$a])) . ".png
												alt='" . $awards[$a] . "'>
											<span class='tooltip-text'>" . $awards[$a] . "</span>
										</a>";
						};
					}
				?>
			</div>
		</div>
	</div>
	
	<footer>
		<div class="wrapper back-button-wrapper">
			<button type="button" onclick="openDetailBox('worms')">
				<i class="svg-icon i-caret-left"></i> <span>back</span>
			</button>
		</div>
		<button type="button" class="main-worm-tab-button" onclick="showWormTab('<?php echo $cur_worm["color"] ?>','main-worm-tab');" aria-label="main <?php echo $cur_worm["color"] ?> worm tab">
			<svg xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1.15em" fill="currentColor" class="bi bi-fork-knife" viewBox="0 0 16 16">
				<path d="M13 .5c0-.276-.226-.506-.498-.465-1.703.257-2.94 2.012-3 8.462a.5.5 0 0 0 .498.5c.56.01 1 .13 1 1.003v5.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5zM4.25 0a.25.25 0 0 1 .25.25v5.122a.128.128 0 0 0 .256.006l.233-5.14A.25.25 0 0 1 5.24 0h.522a.25.25 0 0 1 .25.238l.233 5.14a.128.128 0 0 0 .256-.006V.25A.25.25 0 0 1 6.75 0h.29a.5.5 0 0 1 .498.458l.423 5.07a1.69 1.69 0 0 1-1.059 1.711l-.053.022a.92.92 0 0 0-.58.884L6.47 15a.971.971 0 1 1-1.942 0l.202-6.855a.92.92 0 0 0-.58-.884l-.053-.022a1.69 1.69 0 0 1-1.059-1.712L3.462.458A.5.5 0 0 1 3.96 0z"/>
			</svg>
		</button>
		<button type="button" class="leaderboard-button" onclick="showWormTab('<?php echo $cur_worm["color"] ?>','leaderboard');" aria-label="leaderboard">
			<svg xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1.15em" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
				<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
			</svg>
		</button>
		<button type="button" class="trophies-button" onclick="showWormTab('<?php echo $cur_worm["color"] ?>','trophies');" aria-label="trophies">
			<svg xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1.15em" fill="currentColor" class="bi bi-trophy-fill" viewBox="0 0 16 16">
				<path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5q0 .807-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33 33 0 0 1 2.5.5m.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935m10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935"/>
			</svg>
		</button>
		<div class="wrapper feed-button-wrapper">
			<button type="submit" class="feed-button tooltip">
				<span class="text">feed <i class="svg-icon i-caret-right"></i></span>
				<span class="tooltip-text">select an item!</span>
			</button>
		</div>
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