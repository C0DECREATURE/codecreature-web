<!-- loading status inserted here -->
<section class="load-area <?php echo (!empty($loading)) ? '' : ''; ?>">
	<div class="marquee">
		<div class="marquee-content mc1"><?php fillLoadingMarquee(); fillLoadingMarquee(); ?></div>
		<div class="marquee-content mc2"><?php fillLoadingMarquee(); fillLoadingMarquee(); ?></div>
	</div>
	<div id="load-status" class="<?php echo (empty($load_err)&empty($feed_err)) ? '' : 'hidden'; ?>">
		Loading...
	</div>
	<div class="subtitle <?php echo (!empty($load_err)|!empty($feed_err)) ? '' : 'hidden'; ?>">
		<?php echo $feed_err ?>
		<?php echo $load_err ?>
	</div>
	<div class="marquee">
		<div class="marquee-content mc1"><?php fillLoadingMarquee(); fillLoadingMarquee(); ?></div>
		<div class="marquee-content mc2"><?php fillLoadingMarquee(); fillLoadingMarquee(); ?></div>
	</div>
</section>

<?php
	function fillLoadingMarquee() {
		global $worms; global $image_path;
		for ( $w = count($worms) - 1; $w >= 0; $w-- ) {
			global $worms; global $image_path;
			$worm_img = '<img src="'.$image_path.$worms[$w]["color"].'_racer.png" alt="">';
			echo $worm_img;
		}
	};
?>