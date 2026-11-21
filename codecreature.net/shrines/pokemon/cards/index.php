<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>pokémon tcg collection</title>
		
		<base href="/shrines/pokemon/cards/" src="/shrines/pokemon/cards/">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260410" id="svg-icons-js"></script>
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		
		<!-- fonts -->
		<script>fonts.load('Pokemon Classic');</script>
		
		<!--full image view-->
		<script src="/codefiles/full-image.js"></script>
		
		<!--this page's stylesheet-->
		<link href="../style.css" rel="stylesheet" type="text/css" media="all">
		<link href="style.css?fileversion=20261118" rel="stylesheet" type="text/css" media="all">
	</head>
	
<body><div class="main-container">
	<nav>
		<a href="/pokemon">pokémon</a>
		<img src="../images/sprites/sm/pokeball_crop.webp" alt="">
		<a href="/">home</a>
	</nav>
	
	<main class="content">
		<header>
			<h1>my runts</h1>
		</header>
		
		<p>
			this is every snorunt card ever printed!
			<br>i still need physical copies of the faded cards
		</p>
		
		<div class="cardset">
			<?php
			
			$cards = [
				[
					"img"=>"arceus.webp",
					"num"=>"Platinum Arceus 75/99",
					"owned"=>true,
					"alt"=>"Card with a small clay Snorunt sitting on pebbles in front of a waterfall, facing the viewer.",
					"flavor"=>"It is said that several Snorunt gather under giant leaves and live together in harmony.",
				],
				[
					"img"=>"generations.webp",
					"num"=>"Generations RC7/RC32",
					"owned"=>true,
					"alt"=>"Card with a pair of grinning snorunts building a snow Pikachu together while a Pikachu watches from behind an igloo.",
					"flavor"=>"What a delicious-looking snowman! I think I'll sneak a bite. It's OK... no one's looking, right?",
				],
				[
					"img"=>"unified_minds.webp",
					"num"=>"Unified Minds 37/236",
					"owned"=>true,
					"alt"=>"Card with a Snorunt skipping through a field of dry grass, smiling up at the sky.",
					"flavor"=>"It feeds mainly on ice and snow. It's only able to survive in a limited number of places in the warm Alola region.",
				],
				[
					"img"=>"paradox_rift_illustration.webp",
					"num"=>"Paradox Rift188/182 Illustrated",
					"owned"=>false,
					"alt"=>"Full art card with a Snorunt happily rolling through the snow in a forest. There is a triangular Snorunt-shaped depression in the snow nearby and several pinecones scattered around its footsteps.",
					"flavor"=>"It is said that several Snorunt gather under giant leaves and live together in harmony.",
				],
				[
					"img"=>"mysterious_treasures.webp",
					"num"=>"Mysterious Treasures 100/123",
					"owned"=>true,
					"alt"=>"Card with a Snorunt holding the edges of its &quot;coat&quot; in the snow, looking up at a cloudy purple sky as snowflakes blow in the wind.",
					"flavor"=>"In the snow country, certain folklore says a house will prosper if a Snorunt lives there.",
				],
				[
					"img"=>"guardians_rising.webp",
					"num"=>"Guardians Rising 31/145",
					"owned"=>true,
					"alt"=>"Card with a Snorunt jumping cheerfully out of a refrigerator in a beach house with palm trees visible outside. Below, the top of another Snorunt peeks out of the ice cube bin, while a third Snorunt naps on top of the fridge.",
					"flavor"=>"Their numbers seem to have rapidly increased in Alola. Custom has it that houses where Snorunt live will be prosperous for generations to come.",
				],
				[
					"img"=>"brilliant_stars.webp",
					"num"=>"Brilliant Stars 034/172",
					"owned"=>true,
					"alt"=>"Card with a Snorunt walking through a snowy forest, breathing out a cloud of condensation. It is illustrated in a lineless style.",
					"flavor"=>"It can only survive in cold areas. It bounces happily around, even in environments as cold as −150 degrees Fahrenheit.",
				],
				[
					"img"=>"chilling_reign.webp",
					"num"=>"Chilling Reign 035/198",
					"owned"=>true,
					"alt"=>"Card with a Snorunt standing firm in front of a temple, looking determined. Wind whips over the icy mountains behind it.",
					"flavor"=>"It can only survive in cold areas. It bounces happily around, even in environments as cold as −150 degrees Fahrenheit.",
				],
				[
					"img"=>"silver_tempest.webp",
					"num"=>"Silver Tempest 041/195",
					"owned"=>false,
					"alt"=>"Card with a Snorunt standing on a snowy hill, looking out past the viewer.",
					"flavor"=>"It's said that if they are seen at midnight, they'll cause heavy snow. They eat snow and ice to survive.",
				],
				[
					"img"=>"paradox_rift.webp",
					"num"=>"Paradox Rift 037/182",
					"owned"=>false,
					"alt"=>"Card with a Snorunt resting in front of a pool of sparkling still water in an icy cave. The lineless illustration features pastel pinks, oranges, and teals, with rich purple shadows.",
					"flavor"=>"It is said that several Snorunt gather under giant leaves and live together in harmony.",
				],
				[
					"img"=>"paradox_rift_holo.webp",
					"num"=>"Paradox Rift 037/182 (Holiday Calendar)",
					"owned"=>false,
					"alt"=>"Reverse holographic card with snowflake stamp in the corner, featuring a Snorunt resting in front of a pool of sparkling still water in an icy cave. The lineless illustration features pastel pinks, oranges, and teals, with rich purple shadows.",
					"flavor"=>"It is said that several Snorunt gather under giant leaves and live together in harmony.",
				],
				[
					"img"=>"cosmic_eclipse.webp",
					"num"=>"Cosmic Eclipse 47/236",
					"owned"=>true,
					"alt"=>"Card with a Snorunt outdoors in a nighttime snowstorm. It is standing at the stairs of a porch, highlighted by the warm light from inside. One post of the stairs has a small snow Pikachu on it.",
					"flavor"=>"It feeds mainly on ice and snow. It's only able to survive in a limited number of places in the warm Alola region.",
				],
				[
					"img"=>"ascended_heroes.webp",
					"num"=>"Ascended Heroes 046/217",
					"owned"=>false,
					"alt"=>"Card with a Snorunt gazing up at a cool-toned aurora in the night sky, the blue glow highlighting its face. It is standing on a snow-covered rocky ledge.",
					"flavor"=>"In some snowy lands, certain folklore says a house will prosper if a Snorunt lives there.",
				],
				[
					"img"=>"ex_emerald.webp",
					"num"=>"EX Emerald 64/106",
					"owned"=>true,
					"alt"=>"Card with a close-up Snorunt on a clear, snowy day in a forest. The illustration style and colors are soft and warm.",
				],
				[
					"img"=>"hidden_legends.webp",
					"num"=>"EX Hidden Legends 73/101",
					"owned"=>true,
					"alt"=>"Card with a Snorunt huddled in front of a mirror-like wall of ice.",
				],
				[
					"img"=>"ascended_heroes_illustration.webp",
					"num"=>"Ascended Heroes 227/217 Illustrated",
					"owned"=>false,
					"alt"=>"Full art card with a Snorunt standing on a tree stump breaking through the snow in a pine forest field. It is reaching towards a small icicle-covered branch. The colors are pale and cool-toned.",
					"flavor"=>"In some snowy lands, certain folklore says a house will prosper if a Snorunt lives there.",
				],
				[
					"img"=>"plasma_blast.webp",
					"num"=>"Plasma Blast 21/101",
					"owned"=>true,
					"alt"=>"Card with a close-up Snorunt jumping up from the bottom corner of the frame. It is in a rocky cave with large ice crystals, vines, and flowering moss. The art is lined with minimal shading.",
					"flavor"=>"It is said that several Snorunt gather under giant leaves and live together in harmony.",
				],
				[
					"img"=>"crown_zenith.webp",
					"num"=>"Crown Zenith 034/159",
					"owned"=>false,
					"alt"=>"A card with a Snorunt standing intensely in center frame, surrounded by shards of swirling ice. The horizon line is dramatically tilted, with vivid colors and intense lighting.",
					"flavor"=>"It can only survive in cold areas. It bounces happily around, even in environments as cold as −150 degrees Fahrenheit.",
				],
				[
					"img"=>"twilight_masquerade.webp",
					"num"=>"Twilight Masquerade 051/167",
					"owned"=>false,
					"alt"=>"Card with a tiny Snorunt smiling with closed eyes in a snow igloo surrounded by gray, leafless trees. The art is cartoonish with minimal shading.",
					"flavor"=>"It is said that a home visited by a Snorunt will prosper. It can withstand cold of −150 degrees Fahrenheit.",
				],
				[
					"img"=>"power_keepers.webp",
					"num"=>"EX Power Keepers 64/108",
					"owned"=>false,
					"alt"=>"Card with a Snorunt hovering just above the ground in a snowy forest, a faint glow around its body. The Snorunt is drawn in the traditional Pokemon style atop a photo background.",
				],
				[
					"img"=>"ex_dragon.webp",
					"num"=>"EX Dragon 44/97",
					"owned"=>true,
					"alt"=>"Card with a Snorunt peeking up from behind a pile of ice boulders surrounded by blue and purple glacial ice. The foreground is drawn in thick, pencil-textured lines while the background is lineless and unshaded.",
				],
				/*
				[
					"img"=>"",
					"num"=>"",
					"owned"=>false,
					"alt"=>"",
					"flavor"=>"",
				],
				*/
			];
			
			foreach ($cards as $c) { ?>
				<div class="card <?php echo $c["owned"] ? "owned" : ""; ?>">
					<img src="../images/cards/snorunt/<?php echo $c["img"]; ?>" alt="<?php echo $c["alt"]; ?>"
						data-caption="<?php
							echo $c["num"];
							if (!empty($c["flavor"])) echo "<hr>&quot;".$c["flavor"]."&quot;";
						?>">
				</div>
			<?php } ?>
		
		</div>
		
		<script>
			let cards = document.getElementsByClassName('card');
			for (let i = 0; i < cards.length; i++) { cards[i].querySelector('img').classList.add('full-viewable'); }
		</script>
	</main>
</div></body>

</html>
