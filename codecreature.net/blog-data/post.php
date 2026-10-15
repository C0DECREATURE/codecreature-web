<?php require_once "text-processing.php"; ?>

<div id="post-<?php echo $id; ?>" class="post">
	<div class="date">
		<?php if (!$fullPost) { ?>
		<a href="<?php echo $basePath; ?>/post/<?php echo $id; ?>/"><?php echo $date; ?></a>
		<?php } else echo $date; ?>
		<?php if (isset($userAuthorized) && $userAuthorized) { ?>
			<a class="edit" href="<?php echo $basePath; ?>/edit/<?php echo $id; ?>">(edit post)</a>
		<?php }?>
	</div>
	<div class="summary"><?php echo parsePostText($post["summary"]); ?></div>
	<?php
	// content to display only if full post should be loaded
	if ($fullPost) {
		$tags = json_decode($post["tags"],false);
		$details = parsePostText($post["details"]);
		?>
		<div class="tags">
			<?php foreach ($tags as $t) { ?>
			<a href="<?php echo $basePath; ?>?includeTags=<?php echo $t; ?>">#<?php echo $t; ?></a>
			<?php } ?>
		</div>
		<div class="details"><?php echo $details; ?></div>
	<?php } // end full post exclusive content ?>
	<script>
		(()=>{
			<?php echo "let id = $id;"; ?>
			let images = document.getElementById("post-"+id).querySelector(".details").getElementsByTagName("img");
			for (let i = 0; i < images.length; i++) {
				if (!images[i].classList.contains('no-full-view') && !images[i].classList.contains('mini') && !images[i].classList.contains('bbcode_smiley')) images[i].classList.add('full-viewable');
			}
		})();
	</script>
</div>