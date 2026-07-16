<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>garf games</title>
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="../favicon.gif">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260707"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260707" rel="stylesheet" type="text/css"></link>
		
		<script>fonts.load('Garfield','Ad Lib')</script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260707" id="svg-icons-js"></script>
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260707"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260707"></script>
		
		<!-- load jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js?fileversion=20260707"></script>
		<!-- load navigation -->
		<script> $(function(){ $("#nav-wrapper").load("../nav.txt"); }); </script> 
		<!-- load right bar -->
		<script> $(function(){ $("#right-bar-wrapper").load("/shrines/garfield/right.txt"); }); </script> 
		
		<!--this page's stylesheet-->
		<link href="../style.css?fileversion=20260707" rel="stylesheet" type="text/css" media="all">
		<link href="games.css?fileversion=20260707" rel="stylesheet" type="text/css" media="all">
	</head>
	
	<!-----------BODY------------------->
	<body>
		<a class="skip-to-content" href="#content">skip to content</a>
		
		<main>
			<div id="nav-wrapper" class="left">
			</div>
			
			<div class="center">
				<header>
					<h1><a href="/shrines/garfield"><img id="logo" src="../images/logo.png" alt="Garfield"><img id="hopping-garf" src="/graphix/deco/garf_hop.png" alt=""></a></h1>
				</header>
				
				<div class="container">
					
					<?php
					
					$games = [
						[
							"title" => "Comic Creator",
							"year" => 2003,
							"description" => "",
							"src" => "https://archive.org/details/comiccreator",
							"preview" => "../images/games/comic_creator_2003.png",
						],
						[
							"title" => "Comic Creator (New)",
							"description" => "",
							"src" => "https://archive.org/details/comiccreator_swf",
							"preview" => "https://archive.org/serve/comiccreator_swf/comiccreator_swf_screenshot.gif",
						],
						[
							"title" => "Scary Scavenger Hunt",
							"year" => 2002,
							"description" => "A Halloween classic! Played with your keyboard. Pretty long.",
							"src" => "https://www.friv.com/z/games/scaryscavengerhunt/game.html",
							"preview" => "../images/games/scary_scavenger_hunt.png",
						],
						[
							"title" => "Amazing Garfield",
							"description" => "Garfield performs an impressive card trick!",
							"src" => "https://archive.org/details/amazinggarfield_swf",
							"preview" => "../images/games/amazing_garfield.png",
						],
						[
							"title" => "Dream Racers",
							"description" => "Mouse-based racing game. The graphics are terrible.",
							"src" => "https://flashmuseum.org/garfields-dream-racers/",
							"preview" => "https://flashmuseum.org/wp-content/uploads/2023/05/Garfields-Dream-Racers_Gameplay.png",
						],
						[
							"title" => "Beat the Cheese",
							"year" => 2004,
							"description" => "Whack-a-mole with mice.",
							"src" => "https://classicgamesfree.com/flash/beat-the-cheese",
							"preview" => "../images/games/beat_the_cheese.png",
						],
						[
							"title" => "Lasagna from Heaven",
							"year" => 2004,
							"description" => "Remake of an earlier game from 1996. It's difficult.",
							"src" => "https://archive.org/details/lasagna_game_swf",
							"preview" => "https://archive.org/serve/lasagna_game_swf/lasagna_game_swf_screenshot.gif",
						],
						[
							"title" => "Bean Me",
							"year" => 2000,
							"description" => "More of an interactive video. Referenced in the comic <a href='http://localhost/shrines/garfield/comics/?year=2000&num=250'>here</a>.",
							"src" => "https://flashmuseum.org/bean-me/",
							"preview" => "../images/games/bean_me.png",
						],
						[
							"title" => "Mix and Match",
							"description" => "A simple point-and-click memory game.",
							"year" => 2004,
							"src" => "https://archive.org/details/mixmatch_kitchen_flash",
							"preview" => "https://archive.org/serve/mixmatch_kitchen_flash/mixmatch_kitchen_flash_screenshot.gif",
						]
					];
					
					for ($i = 0; $i < count($games); $i++) {
						$g = $games[$i];
						?>
						<div class="game">
							<header><h2><?php echo $g["title"]; ?><?php if (!empty($g["year"])) echo " (".$g["year"].")"; ?></h2></header>
							<?php if (!empty($g["description"])) { ?>
								<div class="description"><span><?php echo $g["description"]; ?></span></div>
							<?php } ?>
							<a class="preview" href="<?php echo $g["src"]; ?>" target="_blank">
								<img src="<?php echo $g["preview"]; ?>" alt="Play <?php echo $g["title"]; ?>">
							</a>
						</div>
						<?php
					} ?>
				</div>
			</div>
			
			<div id="right-bar-wrapper" class="right">
			</div>
		</main>
		
	</body>
	<!--------------END BODY------------->
</html>
