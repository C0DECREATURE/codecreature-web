<?php
	if (!function_exists('stat_to_str')) {
		function stat_to_str($stat) {
			$str = "$stat";
			// 0 to 9,999 - add commas as needed
		  if ($stat < 10000) {
				return number_format($stat);
				
			// 10,000 to 99,999 - condense to XX.Xk
			} else if ($stat < 100000) {
				$round = floor((int)substr($str,-3) / 100);
				return substr($str,0,-3).".".$round."k";
				
			// 100,000 to 999,999 - condense to XXXk
			} else if ($stat < 1000000) {
				return floor((int)substr($str,0,-3))."k";
				
			// 1,000,000 to 9,999,999 - condense to X.XXm
			} else {
				$round = floor((int)substr($str,-6) / 10000);
				return substr($str,0,-6).".".$round."m";
			}
		}
	}
?>
<div id="worm-stats-<?php echo $cur_worm["id"] ?>" class="worm-stats"
style="--bg: var(--<?php echo $cur_worm["color_dark"] ?>);">
	<div class="title">
		<a href="<?php echo $worm_race_path ?>#<?php echo $cur_worm["color"]; ?>"><?php echo $cur_worm["name"] ?></a>
	</div>
	<div class="progress">
		<?php
		echo number_format($cur_worm["progress"]);
		?><img src="<?php echo $image_path; ?>icon-progress-1.png" alt="progress">
	</div>
	<div class="wrapper">
		<div class="item-stat">
			<img src="<?php echo $items["apple"]["icon"]; ?>" alt="<?php echo $items["apple"]["display_name"]; ?>">
			<br><?php echo stat_to_str($cur_worm["apple_count"]); ?>
		</div>
		<div class="item-stat">
			<img src="<?php echo $items["drink"]["icon"]; ?>" alt="<?php echo $items["drink"]["display_name"]; ?>">
			<br><?php echo stat_to_str($cur_worm["drink_count"]); ?>
		</div>
		<div class="item-stat">
			<img src="<?php echo $items["poison"]["icon"]; ?>" alt="<?php echo $items["poison"]["display_name"]; ?>">
			<br><?php echo stat_to_str($cur_worm["poison_count"]); ?>
		</div>
		<div class="item-stat">
			<img src="<?php echo $items["heal"]["icon"]; ?>" alt="<?php echo $items["heal"]["display_name"]; ?>">
			<br><?php echo stat_to_str($cur_worm["heal_count"]); ?>
		</div>
	</div>
</div>