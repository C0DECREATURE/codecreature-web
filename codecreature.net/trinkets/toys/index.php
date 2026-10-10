<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>toy trinkets</title>
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="../favicon.ico">
		<link rel="icon" type="image/png" sizes="16x16" href="../favicon16.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../favicon32.png">
		<link rel="icon" type="image/png" sizes="48x48" href="../favicon48.png">
		<link rel="apple-touch-icon" sizes="180x180" href="../favicon_apple_touch.png">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20261010"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20261010" rel="stylesheet" type="text/css"></link>
		
		<script>fonts.load('Halogen');</script>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20261010"></script>
		
		<!--this page's stylesheets-->
		<link href="../trinkets-default.css?fileversion=20261010" rel="stylesheet" type="text/css" media="all">
		<link href="style.css?fileversion=20261010" rel="stylesheet" type="text/css" media="all">
		<link href="aquarium.css?fileversion=20261010" rel="stylesheet" type="text/css" media="all">
		<!-- this page's scripts -->
		<script src="../loading.js?fileversion=20261010"></script>
	</head>
	
	<!-----------BODY------------------->
	<body>
		<div class="effect-layers el-1"></div>
		
		<base target="_blank"><!-- open links in new tab unless otherwise specified -->
		
		<nav>
			<p class="sr-only">Sorry, this page is not screen reader friendly!</p>
			<a href="/" target="_self" class="navbutton home glow-focus">
				<div class="paper-popout"><span>Home</span></div>
				<img class="sticker" src="/graphix/stickers/birdhouse.png" alt="">
			</a>
			<div id="page-settings" class="page-settings">
				<button id="page-settings-button" class="navbutton open-page-settings glow-focus" aria-label="page settings">
					<div class="paper-popout left" style="right: calc(88% - 10px);"><span>Settings</span></div>
					<img src="images/gear.png" alt="settings">
				</button>
			</div>
		</nav>
			
		<div id="load-screen"><div class="wrapper">
			<img src="../images/waiting_room.png" alt="">
			<br>Loading...
		</div></div>
		
		<main><div id="drag-wrapper" class="hidden"> <!-- hidden until images load -->
			<img id="top-left-marker" class="corner" src="images/corner.png" alt="">
			<img id="top-right-marker" class="corner" src="images/corner.png" alt="">
			<img id="bottom-left-marker" class="corner" src="images/corner.png" alt="">
			<img id="bottom-right-marker" class="corner" src="images/corner.png" alt="">
			
			<!--section to move around when I need to make more space -->
			<div class="repositioner">
				
				
				<div id="intro">
					<img src="images/envelope.png" alt="" style="left: -269px; top: -147px; scale: .800;">
					<p style="left: 21px; top: 16px;">Click and drag to explore...</p>
				</div>
				
				<button id="credit-button" popovertarget="credits" class="sticker glow-focus link" style="top: 66px; left: 560px;">
					<div class="paper-popout"><span>Credits</span></div>
					<img src="/graphix/stickers/mrs-grossman-floppy-yellow.png">
				</button>
				<div popover="" id="credits"><div class="wrapper">
					<h2>Credits</h2>
					
					<h4>Backgrounds</h4>
					<ul>
						<li><a href="https://internetbee.neocities.org/graphics/patterns#beady-faces">Perler bead smiley faces</a> by internetbee</li>
					</ul>
					
					<h4>Misc</h4>
					<ul>
						<li><a href="https://www.tumblr.com/777polaris/804345126909509632?source=share">Alphabet beads</a> from 777polaris</li>
					</ul>
					
					<br><button class="close" popovertarget="credits">Close</button>
				</div></div>
				<!-- end credits -->
				
				<div class="container stack" style="left: 1455px; top: 25px; rotate: 5deg; scale: -0.7 0.7;">
					<img src="images/rainbow_cats_patch_tiling_top.png" alt="">
					<img src="images/rainbow_cats_patch_tiling.png" alt="">
					<img src="images/rainbow_cats_patch_tiling_middle.png" alt="">
					<img src="images/rainbow_cats_patch_tiling.png" alt="">
					<img src="images/rainbow_cats_patch_tiling_bottom.png" alt="">
				</div>
				
				<div id="fur-blob" class="blob" style="left: 943px; top: 330px;"></div>
				
				<img src="images/collage_stars.png" alt="" style="left: 770px; top: 499px; scale: 0.800; rotate: -23deg;">
				
				<div id="perler-blob" class="blob" style="rotate: 11deg; left: 731px; top: -85px;"></div>
				
				<div id="water-blob" class="blob parallax parallax-reverse" data-parallax-scale="-.25" style="rotate: 11deg; left: 38px; top: 226px; background-position: 0px 0px, 122px 0px, 61px 0px;"></div>
				
				<img src="images/squares_rug.png" alt="" style="left: -60px; top: 783px; rotate: -11deg; scale: 0.800;">
				
				<img src="images/strawberry_granny_square.png" alt="" style="left: 474px; top: 43px; scale: 0.800;">
				
				<img src="images/denim_star.png" alt="" style="left: 646px; top: 306px; rotate: -23deg; scale: 0.800">
				<img src="images/trout.png" alt="" style="left: 355px; top: 279px; rotate: -25deg; scale: 0.800">
				<img class="sticker" src="/graphix/stickers/sandylion_ocean_coral.png" alt="" style="left: 148px; top: 238px; scale: 0.800;">
				<img class="sticker" src="/graphix/stickers/sandylion_ocean_shark_2.png" alt="" style="left: -47px; top: 160px; scale: .5;">
				<img src="images/star_fruit.png" alt="" style="left: 796px; top: -8px; rotate: -10deg; scale: 0.800;">
				<img class="sticker" src="/graphix/stickers/sandylion_ocean_shark_1.png" alt="" style="left: 688px; top: -5px; scale: .5;">
				<img src="images/cloud_cube.png" alt="" style="left: 2px; top: 360px; scale: 0.800;">
				<img src="images/agate_goo.png" alt="" style="left: 13px; top: 672px; scale: 0.800;">
				<img src="images/mantis_goggles.png" alt="" style="left: 195px; top: 514px;">
				<img src="images/inflatable_chair.png" alt="" style="left: 533px; top: 509px; scale: 0.800;">
				<img src="images/whale_shark.png" alt="" style="left: 625px; top: 611px; rotate: -9deg; scale: 0.800">
				<img class="sticker" src="/graphix/stickers/sandylion-fuzzy-hat-1.png" alt="" style="left: 595px; top: 568px; scale: -.6 .6; rotate: -36deg;">
				
				<img src="images/hungry_caterpillar.png" alt="" style="left: 710px; top: 882px; scale: 0.800">
				
				<img src="images/orange_peel_dog.png" alt="" style="left: 1349px; top: 28px; scale: 0.800;">
				<img src="images/occlupanid.png" alt="" style="left: 972px; top: 454px; rotate: 36deg; scale: 0.800;">
				<img class="sticker" src="/graphix/stickers/dbgci_cat_butterfly.png" alt="" style="left: 1295px; top: 187px; rotate: 9deg; scale: -1 1;">
				<img src="images/citrus_kitty.png" alt="" style="left: 1114px; top: 224px;">
				<img src="images/beads_meow.png" alt="" style="left: 1140px; top: 123px; rotate: 20deg;">
				<a id="garfield" href="/shrines/garfield/merch" class="container glow-focus" style="left: 1285px; top: 407px;">
					<div class="paper-popout left" style="right: calc(92% - 10px);"><span>Garfield</span></div>
					<img src="/shrines/garfield/images/merch/vinyl_smile.png" alt="" style="width:160px;">
				</a>
				<img class="sticker" src="/graphix/stickers/sandylion-fuzzy-hat-3.png" alt="" style="left: 1374px; top: -22px; scale: .5;">
				
				<img class="sticker" src="/graphix/stickers/sandylion-clown-2.png" alt="" style="left: 991px; top: 681px; scale: 0.800;">
				<img src="images/block_tower.png" alt="" style="left: 1386px; top: 407px; scale: 0.800;">
				<img class="sticker" src="/graphix/stickers/sandylion-bubble-bunny-1.png" alt="" style="left: 1316px; top: 781px; scale: 0.800;">
				
				<?php $aquariumCount = 20; ?>
				<div id="aquarium" class="aquarium" style="left: 538px; top: 1073px;">
					<div class="back"></div>
					<div class="carousel">
						<div class="layer">
							<?php $i = 0; while ($i < $aquariumCount) { $i += 1; ?>
							<div class="section" style="
								background-position: <?php echo (100 / $aquariumCount) * $i; ?>% 0;
								animation-delay: -<?php echo (20 / $aquariumCount) * $i; ?>s;"></div>
							<?php } ?>
						</div>
						<div class="layer">
							<?php $i = 0; while ($i < $aquariumCount) { $i += 1; ?>
							<div class="section" style="
								background-position: <?php echo (100 / $aquariumCount) * $i; ?>% 0;
								animation-delay: -<?php echo (15 / $aquariumCount) * $i; ?>s;"></div>
							<?php } ?>
						</div>
						<div class="overlay"></div>
						<div class="glow"></div>
					</div>
					<div class="front"></div>
					<button class="switch" data-on="true"><img src="images/aquarium/switch_on.png"></button>
					<script>
						(()=>{
							let aquarium = document.getElementById('aquarium');
							let btn = aquarium.querySelector('.switch');
							btn.addEventListener('click',()=>{
								aquarium.classList.toggle("off");
								switchOn = aquarium.classList.contains("off");
								btn.querySelector('img').src = "images/aquarium/switch_" + (aquarium.classList.contains("off") ? "off" : "on") + ".png";
							});
						})();
					</script>
				</div>
				<img src="images/sea_angel_globe.png" alt="" style="left: 405px; top: 1184px; scale: 0.800;">
			</div>
		</div></main>
	</body>
	<!--------------END BODY------------->
	
	<!-- script to enable the dragging movement -->
	<script src="../trinkets-draggable.js?fileversion=20261010"></script>
</html>