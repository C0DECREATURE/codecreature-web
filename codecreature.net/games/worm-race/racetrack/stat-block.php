<div id="worm-stats-<?php echo $cur_worm["id"] ?>" class="worm-stats"
style="--bg: var(--<?php echo $cur_worm["color_dark"] ?>);">
	<div class="title">
		<a href="<?php echo $worm_race_path ?>#<?php echo $cur_worm["color"]; ?>"><?php echo $cur_worm["name"] ?></a>
	</div>
	<div class="progress">
		<?php
		$p = strval($cur_worm["progress"]);
		echo $cur_worm["progress"] > 999 ? substr($p,0,-3).",".substr($p,-3) : $p;
		?><img src="<?php echo $image_path; ?>icon-progress-1.png" alt="progress">
	</div>
	<div class="wrapper">
		<div class="item-stat">
			<img src="<?php echo $items["apple"]["icon"]; ?>" alt="<?php echo $items["apple"]["display_name"]; ?>">
			<br><?php
				$c = strval($cur_worm["apple_count"]);
				echo $cur_worm["apple_count"] > 999 ? substr($c,0,-3).",".substr($c,-3) : $c;
			?>
		</div>
		<div class="item-stat">
			<img src="<?php echo $items["drink"]["icon"]; ?>" alt="<?php echo $items["drink"]["display_name"]; ?>">
			<br><?php
				$c = strval($cur_worm["drink_count"]);
				echo $cur_worm["drink_count"] > 999 ? substr($c,0,-3).",".substr($c,-3) : $c;
			?>
		</div>
		<div class="item-stat">
			<img src="<?php echo $items["poison"]["icon"]; ?>" alt="<?php echo $items["poison"]["display_name"]; ?>">
			<br><?php
				$c = strval($cur_worm["poison_count"]);
				echo $cur_worm["poison_count"] > 999 ? substr($c,0,-3).",".substr($c,-3) : $c;
			?>
		</div>
		<div class="item-stat">
			<img src="<?php echo $items["heal"]["icon"]; ?>" alt="<?php echo $items["heal"]["display_name"]; ?>">
			<br><?php
				$c = strval($cur_worm["heal_count"]);
				echo $cur_worm["heal_count"] > 999 ? substr($c,0,-3).",".substr($c,-3) : $c;
			?>
		</div>
	</div>
</div>