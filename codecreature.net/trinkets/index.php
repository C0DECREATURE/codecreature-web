<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>trinkets</title>
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="favicon.ico">
		<link rel="icon" type="image/png" sizes="16x16" href="favicon16.png">
		<link rel="icon" type="image/png" sizes="32x32" href="favicon32.png">
		<link rel="icon" type="image/png" sizes="48x48" href="favicon48.png">
		<link rel="apple-touch-icon" sizes="180x180" href="favicon_apple_touch.png">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20261004"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20261004" rel="stylesheet" type="text/css"></link>
		
		<script>fonts.load('Victorian Parlor','Paint Hand');</script>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20261004"></script>
		
		<!--this page's stylesheets-->
		<link href="trinkets-default.css?fileversion=20261004" rel="stylesheet" type="text/css" media="all">
		<link href="my-stuff.css?fileversion=20261004" rel="stylesheet" type="text/css" media="all">
		<link href="book.css?fileversion=20261004" rel="stylesheet" type="text/css" media="all">
		<!-- this page's scripts -->
		<script src="magnifying-glass.js?fileversion=20261004"></script>
		<script src="loading.js?fileversion=20261004"></script>
	</head>
	
	<!-----------BODY------------------->
	<body>
		<div class="effect-layers el-1"></div> <div class="effect-layers el-2"></div> <div class="effect-layers el-3"></div>
		
		<base target="_blank"><!-- open links in new tab unless otherwise specified -->
		
		<nav>
			<p class="sr-only">Sorry, this page is not screen reader friendly!</p>
			<a href="/" target="_self" class="navbutton home glow-focus">
				<div class="paper-popout"><span>Home</span></div>
				<img src="images/house_charm.png">
			</a>
			<div id="page-settings" class="page-settings">
				<button id="page-settings-button" class="navbutton open-page-settings glow-focus" aria-label="page settings">
					<div class="paper-popout left"><span>Settings</span></div>
					<img src="images/gear.png" alt="settings">
				</button>
			</div>
		</nav>
			
		<div id="load-screen"><div class="wrapper">
			<img src="images/waiting_room.png" alt="">
			<br>Loading...
		</div></div>
		
		<div id="findables">
			<button class="navbutton" onclick="document.getElementById('findables').querySelector('.details').classList.toggle('closed');findables.startISpy();">
				<div class="paper-popout"><span>I Spy</span></div>
				<img class="icon" src="images/magnifying_glass_charm.png" alt="I Spy">
			</button>
			<div class="details closed"><div class="wrapper">
				Find and click these objects! Undiscovered objects will display a magnifier cursor when hovered.
				<ol id="findables-list"></ol>
			</div></div>
			<script>
				let findables = {
					iSpy: false, // whether I Spy mode has been started
					displayNames: {
						"bug": "Things with Bugs",
						"moon": "Crescent Moons",
						"key": "Keys",
						"humanimal": "Human-Faced Animals",
					},
					total: {},
					foundCount: {},
					found: (el)=>{
						if (el.dataset.found != "true") {
							let type = el.dataset.findableType;
							el.dataset.found = "true";
							findables.foundCount[type] += 1;
							document.getElementById('findable-'+type).querySelector('.count').innerHTML = findables.foundCount[type];
						}
					},
					startISpy: ()=>{
						document.body.classList.add("iSpy");
						findables.iSpy = true;
					},
					initElements: ()=>{
						let fEls = document.getElementsByClassName('findable');
						for (let i = 0; i < fEls.length; i++) {
							fEls[i].dataset.found = "false";
							fEls[i].addEventListener("click",(e)=>{
								if (findables.iSpy && fEls[i].dataset.found != "true") {
									e.preventDefault();
									findables.found(fEls[i]);
								}
							});
							let type = fEls[i].dataset.findableType;
							if (typeof(findables.total[type]) == "undefined") findables.total[type] = 1;
							else findables.total[type] += 1;
						};
						for (const [key, value] of Object.entries(findables.total)) {
							// set found count of findable to zero
							findables.foundCount[key] = 0;
							// create a counter display for the findable type
							let counterEl = document.createElement("li");
							counterEl.id = "findable-"+key;
							let name = typeof(findables.displayNames[key]) == "undefined" ? key : findables.displayNames[key];
							counterEl.innerHTML = `<span class="name">${name}:</span> <span class="count">0</span>/${value}`;
							document.getElementById("findables-list").appendChild(counterEl);
							// log type total count
							console.log(`total ${key} findables: ${value}`);
						}
					},
				};
			</script>
		</div>
		
		<?php include "credits.php"; ?>
		
		<main><div id="drag-wrapper" class="hidden"> <!-- hidden until images load -->
			<img id="top-left-marker" class="corner" src="images/corner.png" alt="">
			<img id="top-right-marker" class="corner" src="images/corner.png" alt="">
			<img id="bottom-left-marker" class="corner" src="images/corner.png" alt="">
			<img id="bottom-right-marker" class="corner" src="images/corner.png" alt="">
			
			<!--section to move around when I need to make more space -->
			<div class="repositioner">
				
				<div id="intro">
					<img src="images/envelope.png" alt="" style="left: -269px; top: -147px; scale: .800;">
					<img class="stamp" src="images/stamp_polska.png" alt="" style="rotate: 5deg; left: -116px; top: -101px;">
					<img class="stamp" src="images/stamp_felis_cattus.png" alt="" style="left: -182px; top: -89px;">
					<img class="stamp" src="images/stamp_mongolia_cat.png" alt="" style="rotate: 7deg; left: -181px; top: 97px;">
					<img class="stamp" src="images/stamp_denmark_cat.png" alt="" style="rotate:-3deg; left: -70px; top: -69px;">
					<img class="stamp" src="images/stamp_korean_tiger.png" alt="" style="left: 173px; top: 47px;">
					<p style="left: 21px; top: 16px;">Click and drag to explore...</p>
				</div>
				
				<button id="credit-button" popovertarget="credits" class="glow-focus link">
					<div class="paper-popout"><span>Credits</span></div>
					<img src="images/wax_c.png">
				</button>
				
				<button id="palette-button" popovertarget="palettes" class="container glow-focus link" style="left: 73px; top: 245px;">
					<div class="paper-popout"><span>Palettes</span></div>
					<img src="images/moon_inkpot.png" alt="" style="width:124px;">
					<div class="findable" data-findable-type="moon" style="width: 50px; height: 50px; left:36px; top: 82px;">
				</button>
				<div popover id="palettes"><div class="wrapper">
					<h2 class="sr-only">Palettes</h2>
					<div class="paint-palette" alt="">
						<img class="bg" src="images/paint_palette.png">
						<div class="options">
							<button class="palette-option" data-name="default">
								Default</button>
							<button class="palette-option" data-name="sepia">
								Sepia</button>
							<button class="palette-option" data-name="gray">
								Gray</button>
							<button class="palette-option" data-name="neon">
								Neon</button>
							<button class="palette-option" data-name="none">
								None</button>
							<button class="close" popovertarget="palettes">Close</button>
						</div>
					</div>
					<div class="preview">
						<div class="effect-layers el-1"></div> <div class="effect-layers el-2"></div> <div class="effect-layers el-3"></div>
						<img class="bg" src="images/leroy_cats.png" alt="">
					</div>
					<script>
						(()=>{
							curPalette = 'color-default';
							function setPagePalette(name) {
							}
							let buttons = document.getElementsByClassName('palette-option');
							for (let i = 0; i < buttons.length; i++) {
								buttons[i].addEventListener('click',()=>{
									document.body.classList.remove(curPalette);
									curPalette = 'color-' + buttons[i].dataset.name;
									document.body.classList.add(curPalette);
								});
							}
						})();
					</script>
				</div></div>
				
				<img src="images/louis_wain.png" alt="" style="left: 1923px; top: 300px; rotate: -60deg;">
				<img src="images/scenery_clouds.png" alt="" style="left: 1500px; top: 1642px;">
				
				<!-- BACK LAYER TAPESTRIES -->
				<img src="images/tapestry_floral_green.png" alt="" style="rotate: 5deg; left: 27px; top: 635px;">
				<img src="images/tapestry_floral_red.png" alt="" style="rotate: -4deg; left: 1393px; top: 580px;">
				<img src="images/tapestry_lady_unicorn.png" alt="" style="rotate: 24deg; left: -612px; top: 1417px;">
				<img src="images/crochet_star.png" alt="" style="rotate: -8deg; left: -700px; top: -290px;">
				
				<img src="images/beetle_cage.png" alt="" style="left: 786px; top: 1342px;">
				<img id="tarot-fool" class="interactive" src="images/tarot_fool.png" alt="" style="rotate: -38deg; left: 1017px; top: 1413px; width: 192px;">
				<img src="images/koi_charm.png" alt="" style="rotate: -10deg; left: 523px; top: 1470px;">
				
				<div id="shadow-box" class="img-magnifier-container">
					<img id="shadow-box-img" src="images/shadow_box.png" alt="" width="457" height="1041">
					<div class="findable" data-findable-type="moon" style="width: 50px; height: 50px; left: 125px; top: 30px;"></div>
				</div>
				
				<img src="images/coffin_doily.png" alt="" style="rotate: -11deg; left: 1534px; top: 645px; scale: .800;">
				<img src="images/black_wing.png" alt="" style="rotate: 13deg; left: 1310px; top: 953px; scale: .800;">
				
				<!-- GOLD SUN RAYS WINDOW -->
				<div class="wrapper" style="left: 1465px; top: 340px;"><div class="window window-20 window-round">
					<div class="window-scene"></div>
					<img src="images/sun_window.png" alt="">
				</div></div>
				
				<img id="bug-pearls" class="clipped container" src="images/bug_pearls.png" alt="" style="top: 594px; left: 461px;">
				
				<img src="images/fish_fossil.png" alt="" style="rotate: 18deg; left: 532px; top: -125px; scale: 0.800;">
				<img src="images/leg_plan_of_the_baby.png" alt="" style="rotate: -8deg; left: 327px; top: 338px;">
				<img src="images/ant_hill.png" alt="" style="rotate: 3deg; left: 1129px; top: 61px;">
				<img src="images/thorn_hand.png" class="passthrough" alt="" style="left: 817px; top: 149px;">
				<img src="images/toad_freak.png" class="findable" data-findable-type="humanimal" alt="" style="left: 855px; top: 539px;">
				<img src="images/bug_paper_dolls.png" alt="" style="left: 992px; top: 1900px;">
				<img src="images/kill_that_fly.png" alt="" style="left: 675px; top: 780px;">
				<img src="images/unicorn_shield.png" alt="" style="left: 648px; top: 149px;">
				<img src="images/medieval_harpy.png" class="findable" data-findable-type="humanimal" alt="" style="left: 1395px; top: 39px;">
				<img src="images/felt_cat.png" alt="" style="left: 1489px; top: 120px;">
				<img src="images/magnus_spider.png" alt="" style="left: 1638px; top: -98px; rotate: 16deg; scale: 0.800;">
				<img src="images/mirror_blue_star.png" alt="" style="top: 295px; left: 1272px;">
				<img src="images/stone_orb.png" alt="" style="left: 1382px; top: 279px;">
				<img src="images/thin_lamb.png" alt="" style="rotate: -5deg; left: 1092px; top: 367px;">
				<img src="images/bar_chain.png" alt="" style="left: 972px; top: -238px; scale: .800;">
				
				<img src="images/iron_owl.png" alt="" style="left: 1049px; top: 684px;">
				<img src="images/hands_pin.png" alt="" style="z-index: -1; rotate: 15deg; left: 1188px; top: 653px;">
				
				<a id="cut-worms" class="interactive container glow-focus" href="/games/worm-race/" style="left: 1271px; top: 730px;">
					<div class="paper-popout left"><span>WormRace</span></div>
					<img src="images/cut_worms.png" alt="">
				</a>
				
				<img src="images/night_photo.jpg" alt="" style="rotate: -12deg; left: 1925px; top: 1318px;">
				
				<div class="container" style="left: -278px; top: 491px; scale:.800;">
					<img src="images/nebra_disc.png" alt="">
					<div class="findable" data-findable-type="moon" style="width: 91px; height: 177px; left: 255px; top: 106px; rotate: 14deg;"></div>
				</div>
				<!-- SMILING FACE CERAMIC HAND -->
				<button id="hey-hand" class="clipped interactive container" style="left: 57px; top: 348px; scale: .800;">
					<img src="images/face_hand_smile.png" alt="">
					<img class="hover-hide" src="images/face_hand.png" alt="">
				</button>
				<img src="images/etoile.png" class="passthrough" alt="" style="left: 11px; top: 510px; rotate: -20deg; scale: .800;">
				<img class="findable" data-findable-type="key" src="images/key_bird.png" alt="" style="rotate: -78deg; left: -3px; top: 345px;">
				
				<img src="images/secret_teachings_of_all_ages.png" alt="" style="left: -128px; top: -274px; rotate: 11deg; scale: .800;">
				<div class="container" style="left: -381px; top: -163px; scale: .7;">
					<img src="images/wilhelm_pantomime.png" alt="" >
					<div class="findable" data-findable-type="moon" style="width: 100px; height: 108px; left: 237px; top: -8px;"></div>
				</div>
				<!-- CELESTIAL BOOK -->
				<button class="book interactive container" style="width: 220px; height: 310px; rotate: -11deg; left: -171px; top: 74px;">
					<div class="back"><img src="images/books/astronomy_observation.png" alt=""></div>
					<!-- inner pages here, in reverse order -->
					<div class="page pageInner"><img src="images/books/mallet_11.png" alt=""></div>
					<div class="page pageInner"><img src="images/books/mallet_02.png" alt=""></div>
					<div class="page pageInner"><img src="images/books/mallet_48.png" alt=""></div>
					<div class="page pageInner"><img src="images/books/mallet_34.png" alt=""></div>
					<div class="page pageInner"><img src="images/books/mallet_24.png" alt=""></div>
					<div class="page pageInner"><img src="images/books/mallet_23.png" alt=""></div>
					<div class="page pageInner"><img src="images/books/mallet_title.png" alt=""></div>
					<div class="page pageInner flip"><img src="images/books/mallet_cover.png" alt=""></div>
					<!-- end inner pages -->
					<div class="page page4"><img src="images/books/mallet_blank_5.png" alt=""></div><!--#5-->
					<div class="page page3"><img src="images/books/mallet_blank_2.png" alt=""></div><!--#2-->
					<div class="page page2"><img src="images/books/mallet_blank_1.png" alt=""></div><!--#6-->
					<div class="page page1"><img src="images/books/mallet_blank_1.png" alt=""></div><!--#1-->
					<div class="front"><img src="images/books/astronomy_observation.png" alt=""></div>
				</button>
				
				<!-- MORAVIAN STAR WINDOW -->
				<div class="wrapper" style="left: -395px; top: 362px;"><div class="window window-50 window-round">
					<div class="window-scene"></div>
					<img src="images/moravian_star_frame.png" alt="" style="width:272px;">
				</div></div>
				
				<img src="images/bead_red_swirl.png" alt="" style="left: 754px; top: 464px;">
				<img class="findable" data-findable-type="key" src="images/key_star.png" alt="" style="rotate: -50deg; left: 732px; top: 1337px; scale:.800;">
				
				<!----------------- LEFT SIDE ------------------>
				<img src="images/shark_egg.png" alt="" style="rotate: -24deg; left: -420px; top: 506px; scale: .800;">
				<img src="images/shell_charm.png" alt="" style="left: -398px; top: 1259px; scale: .800;">
				<a id="snailfish" class="interactive container glow-focus" href="/shrines/snailfish" style="rotate: -10deg; left: -393px; top: 983px;">
					<div class="paper-popout top"><span>Snailfish</span></div>
					<img src="images/snailfish_swirei.png" alt="">
				</a>
				<img src="images/greek_star_necklace.png" class="passthrough" alt="" style="rotate: -45deg; left: -513px; top: 929px; scale: .800;">
				<img src="images/cat_bite.jpg" alt="" style="rotate: 21deg; left: -180px; top: 835px; scale: .800;">
				<img src="images/kind_to_animals.png" alt="" style="left: -30px; top: 804px; scale: .800;">
				
				<!-- LOBSTER BOX -->
				<div id="lobster-box" style="left: -770px; top: 1083px; scale: .800;">
					<img src="images/lobster_box.png" alt="">
					<button class="top">
						<div class="interactive-area"></div>
						<img src="images/lobster_box_top.png" alt="">
					</button>
				</div>
				
				<!----------------- BOTTOM LEFT ------------------>
				<img src="images/star_goose.png" alt="" style="left: -63px; top: 1307px;">
				<img src="images/soprano_scream.png" alt="" style="rotate: 19deg; left: 82px; top: 1684px;">
				<img src="images/swan_bead.png" alt="" style="rotate: 20deg; left: 213px; top: 1645px;">
				<img src="images/louisville_bottle.png" alt="" style="left: 175px; top: 1795px; scale: .800;">
				<img src="images/fat_ant.png" alt="" style="left: 133px; top: 2044px; rotate: 130deg;">
				<div id="insect-lamp" class="container clipped"
				onclick="this.querySelector('.light').classList.toggle('hidden');" style="left: -193px; top: 1461px; scale: .800">
					<div class="light hidden"></div>
					<img src="images/insect_lamp.png" alt="">
				</div>
				<img src="images/ancient_idol.png" alt="" style="left: -273px; top: 1997px; scale: .800;">
				<img src="images/suits_die.png" alt="" style="left: -149px; top: 2128px;">
				
				<!-- POKEMON BOOK -->
				<a href="/shrines/pokemon" class="book" style="rotate: -8deg; left: 311px; top: 1605px;">
					<div class="paper-popout"><span>Pokemon Shrine</span></div>
					<div class="back"><img src="images/books/pokemon_cover.png" alt=""></div>
					<!-- inner pages here, in reverse order -->
					<div class="page pageInner"><img src="images/books/pokemon_2.png" alt=""></div>
					<div class="page pageInner flip"><img src="images/books/pokemon_1.png" alt=""></div>
					<!-- end inner pages -->
					<div class="page page4"><img src="images/books/blank_5.png" alt=""></div><!--#5-->
					<div class="page page3"><img src="images/books/blank_2.png" alt=""></div><!--#2-->
					<div class="page page2"><img src="images/books/blank_1.png" alt=""></div><!--#6-->
					<div class="page page1"><img src="images/books/blank_1.png" alt=""></div><!--#1-->
					<div class="front"><img src="images/books/pokemon_cover.png" alt=""></div>
				</a>
				
				<!----------------- BOTTOM RIGHT ------------------>
				<!-- GOLD RECTANGLE WINDOW -->
				<div class="wrapper" style="left: 1536px; top: 1239px;"><div class="window window-80">
					<div class="window-scene"></div>
					<img src="images/gold_frame.png" alt="" style="width:280px;">
				</div></div>
				<img src="images/ceramic_cat.png" alt="" style="left: 1661px; top: 1382px;">
				
				<!-- ROUND PEARL PAINTED EYE BROOCH -->
				<button style="left: 1489px; top: 1565px;">
					<img src="images/pearl_eye_left.png" alt="" style="border-radius: 50%;">
					<img class="hover-hide" src="images/pearl_eye.png" alt="" style="border-radius: 50%;">
				</button>
				
				<img class="passthrough" src="images/hedgehog_shaker.png" alt="" style="left: 1445px; top: 1795px;">
				<img src="images/green_orb.png" alt="" style="left: 1865px; top: 1511px;">
				<img src="images/fat_caterpillar.png" alt="" style="rotate: 10deg; left: 1873px; top: 1827px;">
				
				<!----------------- TOP RIGHT ------------------>
				<!-- SPOONS STACK -->
				<button class="spoons interactive container" style="left: 1806px; top: 35px;">
					<img src="images/spoon_3.png" alt="">
					<img src="images/spoon_2.png" alt="">
					<img src="images/spoon_1.png" alt="">
				</button>
				
				<img src="images/lily_perfume.png" alt="" style="left: 808px; top: 364px;">
				<img src="images/centiworm.png" alt="" style="left: 799px; top: 976px;">
				
				<img src="images/green_glass_lanterns.png" alt="" style="left: 1485px; top: -200px; scale: .800;">
				
				<img src="images/ornate_ship_chain.png" alt="" style="z-index: -1; left: 1720px; top: 1390px; scale: .800;">
				<div id="ship" class="interactive" style="left: 1540px; top: 1636px; scale: .800;">
					<img class="passthrough" src="images/ornate_ship.png" alt="">
				</div>
				
				<!-- EGG DOLL -->
				<button id="egg-doll" class="clipped" style="rotate: 15deg; left: 480px; top: 1023px;">
					<img src="images/egg_doll_blink.png" alt="">
					<img class="hover-hide" src="images/egg_doll.png" alt="" style="border-radius: 50%;">
				</button>
				
				<!-- TINY TOPPERS -->
				<img src="images/button_ivory.png" style="left: 708px; top: 489px;" alt="">
				<img src="images/ammonite_worm.png" alt="" style="left: 1478px; top: 460px;">
				
				<img src="images/mirror_blue_star_sm.png" alt="" style="top: 548px; left: 303px;">
				<img src="images/mirror_blue_sun.png" alt="" style="top: 538px; left: 712px;">
				<img src="images/mirror_silver_moon.png" class="findable" data-findable-type="moon" alt="" style="top: 975px; left: 634px;">
				
				<a id="jack-box" href="toys" target="_self" class="container" style="left: 1966px; top: 499px;">
					<div class="paper-popout left"><span>Toy Trinkets</span></div>
					<img class="hover-hide" src="images/jack_box_closed.png" alt="">
					<img class="hover-show" src="images/jack_box_open.png" alt="" style="pointer-events: none;">
				</a>
				
				<!-- FINGER POT -->
				<div class="pot" style="left: 666px; top: 1676px;">
					<img class="back" src="images/finger_pot_back.png" alt="">
					<div class="contents"><div class="content-wrapper">
						<img src="images/taxidermy_rat.png" alt="">
					</div></div>
					<button class="front"><img src="images/finger_pot_front.png" alt=""></button>
				</div>
				
				<img src="images/lion_puppet.png" class="passthrough" alt="" style="left: 547px; top: 1777px; scale: .800;">
				
				<img src="images/skeleton_gaze.png" alt="" style="left: 1911px; top: 962px;">
				<img src="images/ivory_ring.png" alt="" style="left: 1739px; top: 1111px;">
				<img src="images/dark_cicada.png" alt="" style="left: 2016px; top: 804px; rotate: -34deg;">
				
				<!-- DICE BOX -->
				<button class="dice-box" style="rotate: -25deg; left: 1523px; top: 1097px; scale: .800;">
					<img class="inner" src="images/dice_box_inner.png" alt="">
					<img class="outer" src="images/dice_box_outer.png" alt="">
				</button>
				
				<!-- SPIRIT PHOTOGRAPHY BOOK -->
				<button id="spirit-book" class="book interactive container" style="width: 220px; height: 330px; rotate: 10deg; left: 1750px; top: 676px;">
					<div class="back"><img src="images/books/spirit_photography.png" alt=""></div>
					<!-- inner pages here, in reverse order -->
					<div class="page pageInner"><img src="images/books/spirit_photography_3.png" alt=""></div>
					<div class="page pageInner"><img src="images/books/spirit_photography_blank.png" alt=""></div>
					<div class="page pageInner"><img src="images/books/spirit_photography_2.png" alt=""></div>
					<div class="page pageInner flip"><img src="images/books/spirit_photography_1.png" alt=""></div>
					<!-- end inner pages -->
					<div class="page page5"><img src="images/books/spirit_photography_blank.png" alt=""></div><!--#3-->
					<div class="page page3"><img src="images/books/spirit_photography_blank.png" alt=""></div><!--#2-->
					<div class="page page1"><img src="images/books/spirit_photography_blank.png" alt=""></div><!--#1-->
					<div class="page page2"><img src="images/books/spirit_photography_blank.png" alt=""></div><!--#6-->
					<div class="page page4"><img src="images/books/spirit_photography_blank.png" alt=""></div><!--#5-->
					<div class="page page6"><img src="images/books/spirit_photography_blank.png" alt=""></div><!--#4-->
					<div class="front"><img src="images/books/spirit_photography.png" alt=""></div>
				</button>
				
				<!-- FOLLOWING EYES -->
				<!-- bottom left eye -->
				<div class="eye-wrapper" style="rotate: -10deg; left: 292px; top: 1459px; scale: .800;">
					<img class="bottom" src="images/eye_bead_bottom.png" alt="">
					<img class="pupil" src="images/eye_bead_center.png" alt="">
					<img class="top" src="images/eye_bead_top.png" alt="">
				</div>
				<!-- top right eye -->
				<div class="eye-wrapper" style="rotate:15deg; left: 1940px; top: 135px; scale: .800;">
					<img src="images/gem_snake.png" alt="" style="rotate: -8deg; left: -80px; top: 37px;">
					<img class="bottom" src="images/eye_bead_bottom.png" alt="">
					<img class="pupil" src="images/eye_bead_center.png" alt="">
					<img class="top" src="images/eye_bead_top.png" alt="">
				</div>
				<!-- following eye script -->
				<script src="follow-eye.js?fileversion=20261004"></script>
				
				<!-- MEDIEVAL SPINNING WINDOW -->
				<div class="wrapper" style="left: -50px; top: 930px; border-radius: 50%;"><div class="window window-50 window-round" style="overflow: hidden;">
					<div class="window-scene"></div>
					<div class="outer container" id="medieval-frame-rotate" style="pointer-events: initial; transform: rotate(0deg);">
						<img src="images/medieval_frame_outer.png" alt="">
						<div class="findable" data-findable-type="moon" style="left: 30px; top: 194px; width: 80px; height: 62px;"></div>
					</div>
					<img class="inner" src="images/medieval_frame_inner.png" alt="">
				</div></div>
				<!-- rotate medieval frame outer part on hover -->
				<script>
					(()=>{
						let f = document.getElementById('medieval-frame-rotate');
						let container = document.getElementById('medieval-frame-rotate').parentNode;
						container.addEventListener("mouseenter", rotateFrame);
						container.addEventListener("touchstart", rotateFrame);
						function rotateFrame() {
							let r = Number(f.style.transform.replaceAll("rotate(","").replaceAll("deg)","").replaceAll(" ",""));
							r += 45;
							f.style.transform = "rotate(" + r + "deg)";
						}
					})();
				</script>
				
				<!-- TOP EDGE -->
				<img src="images/tall_tapestries.png" alt="" style="left: 758px; top: -122px;">
			</div>
		</div></main>
	</body>
	<!--------------END BODY------------->
	
	<!-- script to update findable counts -->
	<script>findables.initElements();</script>
	
	<!-- script to enable the dragging movement -->
	<script src="trinkets-draggable.js?fileversion=20261004"></script>
	<!-- script for book behavior -->
	<script src="book.js?fileversion=20261004"></script>
</html>