<div id="worm-stats-<?php echo $cur_worm["id"] ?>" class="worm-stats"
style="--bg: var(--<?php echo $cur_worm["color_dark"] ?>);">
	<div class="title">
		<a href="<?php echo $worm_race_path ?>#<?php echo $cur_worm["color"]; ?>"><?php echo $cur_worm["name"] ?></a>
	</div>
	<div class="progress">
		<?php echo $cur_worm["progress"]; ?><img src="<?php echo $image_path; ?>icon-progress-1.png" alt="progress">
	</div>
	<div class="wrapper">
		<div class="item-stat">
			<img src="<?php echo $items["apple"]["icon"]; ?>" alt="<?php echo $items["apple"]["display_name"]; ?>">
			<br><?php echo $cur_worm["apple_count"]; ?>
		</div>
		<div class="item-stat">
			<img src="<?php echo $items["drink"]["icon"]; ?>" alt="<?php echo $items["drink"]["display_name"]; ?>">
			<br><?php echo $cur_worm["drink_count"]; ?>
		</div>
		<div class="item-stat">
			<img src="<?php echo $items["poison"]["icon"]; ?>" alt="<?php echo $items["poison"]["display_name"]; ?>">
			<br><?php echo $cur_worm["poison_count"]; ?>
		</div>
		<div class="item-stat">
			<img src="<?php echo $items["heal"]["icon"]; ?>" alt="<?php echo $items["heal"]["display_name"]; ?>">
			<br><?php echo $cur_worm["heal_count"]; ?>
		</div>
	</div>
</div>