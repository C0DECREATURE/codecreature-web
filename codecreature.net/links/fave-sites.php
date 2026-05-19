<!-- FAVE SITES -->
<section>
	<header><h3>fave indie sites</h3></header>
	<p class="body">
		fellow <u class="tq" data-a="personal">purrsonal</u> pages from around the web, mostly hosted on neocities! presented in <u class="tq" data-a="programatically">purrogramatically</u> random order
	</p>
	<?php
		function addDetailedSiteButton($site) {
			$name = $site["name"];
			$url = $site["url"];
			$button = $site["button"];
			$description = $site["description"];
			echo "<!-- $name -->
						<div class='site'>
							<a href='$url' class='button' target='_blank'>
								<img src='/graphix/site-buttons/$button' alt='$name'></a>
							<div class='description'><span>$description</span></div>
						</div>";
		}
		
		$faves = [
			[ // oliveen
				"name" => "oliveen",
				"url" => "https://olliveen.neocities.org/",
				"button" => "oliveen.gif",
				"description" => "gorgeous site with lots of interesting things to explore! <u class='tq'>ive</u> spent a LOT of time on here its <u class='tq' data='great'>gr8</u>",
			],
			[ // Umaneko Toon Lab
				"name" => "Umaneko Toon Lab",
				"url" => "https://drumanekotoonlab.monster/",
				"button" => "drumanekotoonlab.png",
				"description" => "tech themed cat laboratory! very graphic art style. available in <u class='tq' data-a='English'>english</u> and <u class='tq' data-a='Japanese'>japanese</u>",
			],
			[ // antiamorous
				"name" => "antiamorous",
				"url" => "https://antiamorous.neocities.org",
				"button" => "antiamorous.gif",
				"description" => 'colorful art site with custom assets on every page and a sorta grungy-grimy feel',
			],
			[ // cheepfish
				"name" => "cheep fish",
				"url" => "https://cheepfish.neocities.org",
				"button" => "cheepfish.gif",
				"description" => 'fish theme with lots of art and fun page designs',
			],
			[ // roguepebble
				"name" => "rogue pebble",
				"url" => "https://roguepebble.neocities.org",
				"button" => "roguepebble.gif",
				"description" => 'goth art site with a slick black and red theme and interactive elements',
			],
			[ // sinproexe
				"name" => "SPE web",
				"url" => "https://sinproexe.net/",
				"button" => "sinproexe.gif",
				"description" => 'bright colors, cool css effects, tons of art, and <a href="https://mindscape.zip/" class="inline">games</a>!',
			],
			[ // itpuddle
				"name" => "it puddle",
				"url" => "https://itpuddle.neocities.org/",
				"button" => "itpuddle.png",
				"description" => 'interactive art site with a huge variety of content, including art, games, comics, and more!',
			],
			[ // kyrn0v
				"name" => "kyrn0v",
				"url" => "https://kyrn0v.neocities.org/",
				"button" => "kyrn0v.gif",
				"description" => 'cool pink site with interactive elements (check out their <a class="inline" href="https://kyrn0v.neocities.org/ktoybox">toybox</a>!)',
			],
			[ // antikrist
				"name" => "antikrist",
				"url" => "https://antikrist.lol/",
				"button" => "antikrist.png",
				"description" => 'variety of content including marine biology, cooking, and pixel art',
			],
			[ // gnomes
				"name" => "gnomes",
				"url" => "https://gnomes.neocities.org/",
				"button" => "gnomes.gif",
				"description" => 'gnomes all the way down baby',
			],
			[ // moonkitty
				"name" => "moonkitty",
				"url" => "https://moonkitty.neocities.org/",
				"button" => "moonkitty.jpg",
				"description" => '3D modeled navigation rooms and hidden pages to explore in a dark industrial style',
			],
			[ // moonkitty
				"name" => "moonkitty",
				"url" => "https://ninacti0n.neocities.org/",
				"button" => "moonkitty.jpg",
				"description" => 'art site packed with color, custom assets, dithering effects, and lots of cool little side pages',
			],
			[ // yapi
				"name" => "yapi",
				"url" => "https://yapi.lol/",
				"button" => "yapilol.gif",
				"description" => 'alien-themed vaporwave style, includes a page of custom art freebies',
			],
			[ // alienheadshitkid
				"name" => "alien head shit kid",
				"url" => "https://alienheadshitkid.neocities.org/",
				"button" => "alienheadshitkid.png",
				"description" => 'low-poly 3D-modeled pages with a fun mascot!',
			],
			[ // goblincat
				"name" => "goblin cat",
				"url" => "https://goblincat.neocities.org/",
				"button" => "goblincat.png",
				"description" => 'gothic curiosities, pixel art theme, tons of excellent comics and games',
			],
			[ // kiophen
				"name" => "kiophen",
				"url" => "https://mileshouse.neocities.org/",
				"button" => "kiophen.gif",
				"description" => 'bubbly Y2K theme, incredible pixel animations, coding resources, and pokemon',
			],
			[ // espy.world
				"name" => "espy.world",
				"url" => "https://espy.world/",
				"button" => "espyworld.gif",
				"description" => 'alien tech style, lots of dithering, excellent art',
			],
			[ // syntheticfruits
				"name" => "synthetic fruits",
				"url" => "https://syntheticfruits.neocities.org/",
				"button" => "syntheticfruits.gif",
				"description" => 'pastel retro anime theme, very well executed',
			],
			[ // kittymanya
				"name" => "kitty manya",
				"url" => "https://kittymanya.neocities.org/",
				"button" => "kittymanya.gif",
				"description" => 'eye strain neon furry site, busy in a good way',
			],
			[ // ghostofsnails
				"name" => "ghost of snails",
				"url" => "https://ghostofsnails.neocities.org/",
				"button" => "ghostofsnails.png",
				"description" => 'spooky ghost castle! new-ish site but <u class="tq">i</u> love the vibes',
			],
		];
		
		// randomize order
		shuffle($faves);
		// add the site pages
		foreach($faves as $site) { addDetailedSiteButton($site); }
	?>
</section>
<!-- DEAD SITES -->
<section>
	<header><h3>graveyard</h3></header>
	<p class="body">these sites no longer exist, but can be viewed on the internet archive's wayback machine!</p>
	<?php
		
		$dead = [
			[ // sugarforbrains
				"name" => "sugar for brains",
				"url" => "https://web.archive.org/web/20250203042242/https://sugarforbrains.neocities.org/",
				"button" => "sugarforbrains.gif",
				"description" => 'super fun, colorful site with games and art! this was one of my biggest <u class="tq" data-a="inspirations">inspurrations</u> <u class="tq">4</u> starting this website',
			],
		];
		
		// randomize order
		shuffle($dead);
		// add the site pages
		foreach($dead as $site) { addDetailedSiteButton($site); }
	?>
</section>