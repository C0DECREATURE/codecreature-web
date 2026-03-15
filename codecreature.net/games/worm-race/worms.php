<section id="worms" class="tab show">
	<button onclick="openDetailBox('pink')">
		<img class="worm" src="<?php echo $image_path ?>pink.png">
	</button>
	<button onclick="openDetailBox('orange')">
		<img class="worm" src="<?php echo $image_path ?>orange.png">
	</button>
	<button onclick="openDetailBox('yellow')">
		<img class="worm" src="<?php echo $image_path ?>yellow.png">
	</button>
	<button onclick="openDetailBox('green')">
		<img class="worm" src="<?php echo $image_path ?>green.png">
	</button>
	<button onclick="openDetailBox('blue')">
		<img class="worm" src="<?php echo $image_path ?>blue.png">
	</button>
	<button onclick="openDetailBox('purple')">
		<img class="worm" src="<?php echo $image_path ?>purple.png">
	</button>
</section>

<?php
	for ($i = 0; $i < count($worms); $i++) {
		$cur_worm = $worms[$i];
		
		$prev = $i - 1;
		if ($prev < 0) { $prev = count($worms) - 1; }
		$prev_worm = $worms[$prev];
		
		$next = $i + 1;
		if ($next >= count($worms)) { $next = 0; }
		$next_worm = $worms[$next];
		
		include 'worm-detail-box.php';
	}
?>