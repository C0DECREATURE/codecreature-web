<?php

// run self-executing function to insert ministrife club
(function() {
	$ministrifeClubSprites = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT']."/links/ministrife-club/ministrife-club.json"),true);;
	function fullImg($filename) {
		if (!str_starts_with($filename,"/")) $filename = "/graphix/clubs/ministrife/".$filename;
		return $filename;
	}	
	?>
	<div id="ministrife-wrapper"><div id="ministrife-club">
		<div class="sprites">
			<?php
			foreach ($ministrifeClubSprites as $spr) {?>
				<a href="<?php echo (!str_starts_with($spr["link"],"http") ? "https://" : "").$spr["link"]; ?>"
					title="<?php echo $spr["name"]; ?>"
					<?php if (!str_starts_with($spr["link"],"/")) echo "target='_blank'"; ?>
				>
					<img src="<?php echo fullImg($spr["img"]); ?>" alt="<?php echo $spr["name"]; ?>">
					<div class="tooltip" aria-hidden="true"><?php echo $spr["name"]; ?></div>
				</a>
			<?php
			}
			?>
		</div>
		<a class="ministrife-button" href="https://honeyedcharlatan.neocities.org/ministrife" target="_blank"><img src="/graphix/clubs/ministrife/button.png" alt="ministrife pixel club"></a>
	</div></div>
	<?php
})();
?>

