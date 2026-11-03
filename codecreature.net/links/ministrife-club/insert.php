<!--
insert this in body:
<div id="ministrife-wrapper"></div>

insert this in head:
		<!-- load jQuery --
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js?fileversion=20260410"></script>
		<!-- load ministrife club --
		<link href="/links/ministrife-club/style.css" rel="stylesheet" type="text/css" media="all">
		<script> $(function(){ $("#ministrife-wrapper").load("/links/ministrife-club/insert.php"); }); </script> 
-->
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
				<a href="<?php echo $spr["link"]; ?>"
					title="<?php echo $spr["name"]; ?>"
					<?php if (!str_starts_with($spr["link"],"/")) echo "target='_blank'"; ?>
				>
					<img src="<?php echo fullImg($spr["img"]); ?>" alt="<?php echo $spr["name"]; ?>">
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

