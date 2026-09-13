<section id="worms" class="tab show">
	<?php
		for ($i = 0; $i < count($worms); $i++) {
			?>
			<button onclick="openDetailBox('<?php echo $worms[$i]["color"]; ?>')">
				<img class="worm" src="<?php echo $worms[$i]["image"] ?>">
			</button>
			<?php
		}
	?>
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