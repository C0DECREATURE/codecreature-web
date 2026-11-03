<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>cool places on the web</title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css" rel="stylesheet" type="text/css" media="all">
		
		<!-- ministrife club styling -->
		<link href="/links/ministrife-club/style.css" rel="stylesheet" type="text/css" media="all">
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js"></script>
		
		<!--this page's stylesheet-->
		<link href="style.css" rel="stylesheet" type="text/css" media="all">
		
		<script>
			if (!window.location.hash) window.location.hash = "#clubs";
		</script>
	</head>
	
	<body>
		<main>
			
			<div class="sidebar">
				<div class="container-box" id="my-button">	
					<header><h2>my button</h2></header>
					<div class="content">
						<a href="/graphix/site-buttons/codecreature.png" download="codecreature.png"><img src="/graphix/site-buttons/codecreature.png"></a>
						<a href="/graphix/site-buttons/codecreature_animated.gif" download="codecreature.gif"><img src="/graphix/site-buttons/codecreature_animated.gif"></a>
						<br>
						(click a button <u class="tq">2</u> download it)
						<br><u class="tq">pls</u> rehost! if you add me, let me know so i can list <u class="tq">u</u> as a neighbor <u class="tq-e">:33</u>
					</div>
				</div>
				<nav class="container-box" aria-label="navigation">
					<a href="#clubs">webrings & clubs</a>
					<a href="#coding-resources">coding resources</a>
					<a href="#art-resources">art & images</a>
					<a href="#other-sites">indie websites</a>
					<a href="#other">other links</a>
					<a href="/games">games hub</a>
					<a href="/home">home</a>
				</nav>
			</div>
			
			<!-- WEBRINGS & CLUBS -->
			<div class="main-container container-box" id="clubs">
				<header><h2>webrings & clubs</h2></header>
				<div class="content">
						<!--
						<header><h3>webrings</h3></header>
						<div id="transring" class="hidden">
							<script type="text/javascript" src="https://transring.neocities.org/onionring-variables.js"></script>
							<script type="text/javascript" src="https://transring.neocities.org/onionring-widget.js"></script>
							<script type="text/javascript" src="/links/webrings/transring-catgender.js"></script>
						</div>-->
					<section id="webrings">
						<header><h3>webrings</h3></header>
						<div class="body">
							<script src="https://transring.neocities.org/ring.js"></script>
						</div>
					</section>
					<section id="pixel-clubs">
						<?php
						function fullLink($str) {
							if (!str_starts_with($str,"http")) $str = "https://".$str;
							return $str;
						}
						
						function insertPixelClub($c) {
							$n = strtolower(str_replace([" ","'"],"",$c["name"]));
							?>
							<h4><a href="<?php echo fullLink($c["link"]); ?>" target="_blank"><?php echo $c["name"]; ?></a></h4>
							<div id="pixel-club-<?php echo $n; ?>" class="pixel-club-images">
								<?php
								foreach ($c["adopted"] as $i) { ?>
								<a href="<?php echo fullLink($i["link"]); ?>" target="_blank"
									style="<?php if (!empty($i["style"])) echo $i["style"]; ?>"
									title="<?php echo $i["alt"]; ?>">
									<img src="/graphix/clubs/<?php echo $n."/".$i["img"]; ?>" alt="<?php echo $i["alt"]; ?>">
								</a>
								<?php } ?>
							</div><?php
						}
						$clubs = json_decode(file_get_contents('clubs.json'),true);
						?>
						
						<header><h3>pixel cliques</h3></header>
						<div class="body">
							<?php include $_SERVER['DOCUMENT_ROOT']."/links/ministrife-club/insert.php"; ?>
							<?php foreach ($clubs as $club) { if ($club["joined"]) insertPixelClub($club); } ?>
						</div>
					</section>
					<section id="clubs-to-join">
						<header><h3>adoptions only</h3></header>
						<div class="body">
							i haven't made my own contributions <u class="tq">2</u> these yet!
							<?php foreach ($clubs as $club) { if (!$club["joined"]) insertPixelClub($club); } ?>
						</div>
					</section>
					<section id="other-pixel-clubs">
						<header><h3>other clique collections</h3></header>
						<div class="body">
							<a href="https://lostletters.neocities.org/pixel-clubs/" target="_blank">lost letters</a>
							<a href="https://lavenderclavat.neocities.org/cliques" target="_blank">lavender clavat</a>
							<a href="https://artwork.neocities.org/cliques" target="_blank">artwork</a>
						</div>
					</section>
				</div>
			</div>
			<!-- end webrings container -->
			
			<!-- CODING RESOURCES -->
			<div class="main-container container-box" id="coding-resources">
				<header><h2>coding resources</h2></header>
				<div class="content">
					includes any tutorials or code i used on this site,
						<br>plus whatever else seemed useful!!
					<p>if its not on here i <u class="tq" data-a="probably">purrobably</u> did it from scratch
						<br>and/or cobbled it together from scraps off w3schools and stackoverflow</p>
					
					<section>
						<header><h3>my <u class="tq" data-a="projects">purrojects</u></h3></header>
						<div class="body">
							<a href="/codefiles/ACNLclock">ACNL clock widget</a>
							free widget to put an animal crossing themed clock on your site!
						</div>
					</section>
					
					<section>
						<header><h3>accessibility</h3></header>
						<div class="body">
							consider testing <u class="tq">ur</u> site <u class="tq">4</u> accessibility!! sometimes a few simple tweaks can make your page available <u class="tq">2</u> lots more <u class="tq">ppl</u>
							
							<a href="https://solaria.neocities.org/accessibility" target="_blank">web accessibility guide</a>
							detailed guide <u class="tq">2</u> things <u class="tq">u</u> can do <u class="tq">2</u> improve accessibility
							
							<h4>test in your browser:</h4>
							<a class="inline" href="https://firefox-source-docs.mozilla.org/devtools-user/accessibility_inspector/" target="_blank">firefox</a> /
							<a class="inline" href="https://learn.microsoft.com/en-us/microsoft-edge/devtools/accessibility/reference" target="_blank">edge</a> /
							<a class="inline" href="https://developer.chrome.com/docs/devtools/accessibility/reference" target="_blank">chrome</a>
						</div>
					</section>
					
					<section>
						<header><h3>layout</h3></header>
						<div class="body">
							<a href="https://css-tricks.com/seamless-responsive-photo-grid/" target="_blank">columns photo grid</a>
							how <u class="tq">2</u> make a seamless responsive grid with css columns
							
							<a href="https://masonry.desandro.com/" target="_blank">masonry library</a>
							extra fancy javascript grid layout that reorders items to fit as close as possible
							
							<a href="https://flexboxfroggy.com/" target="_blank">flexboxfroggy</a>
							small game <u class="tq">4</u> learning css flexbox
							
							<a href="https://css-tricks.com/snippets/css/a-guide-to-flexbox/" target="_blank">css tricks flexbox guide</a>
							all-purpose visual guide <u class="tq">2</u> flexbox, <u class="tq">i</u> go back <u class="tq">2</u> this constantly
							
							
							<a href="https://devtoolstips.org/tips/en/edit-position/" target="_blank">firefox edit position</a>
							<a class="mt-0" href="https://chromewebstore.google.com/detail/elements-position-drag-ov/hhcokjpdklpgebgklpelpkekgiojnjca" target="_blank">chrome elements drag extension</a>
							drag positioning <u class="tq">4</u> absolute or relative elements
						</div>
					</section>
					
					<section>
						<header><h3>interactivity</h3></header>
						<div class="body">
							
							<a href="https://github.com/PHPMailer/PHPMailer">PHPMailer</a>
							PHP class with lots of features for sending emails
							
							<a href="https://github.com/wiserim/WMPlayer">WMPlayer</a>
							open-source javascript music player
						</div>
					</section>
					
					<section>
						<header><h3>tools</h3></header>
						<div class="body">
							<a href="https://regex101.com/" target="_blank">regex101</a>
							tester for regular expressions, <u class="tq">rly</u> useful <u class="tq">4</u> complex regex
							
							<a href="https://www.jitbit.com/unusedcss/" target="_blank">jitbit unused CSS finder</a>
							find unused css on <u class="tq">ur</u> site
						</div>
					</section>
					
					<section>
						<header><h3>neocities & hosting</h3></header>
						<div class="body">
							<a href="https://heliohost.org/">heliohost</a>
							this non-profit is codecreature's current host. they have a solid free option or a $1/month plan. recommend checking them out if <u class="tq">u</u> want <u class="tq">2</u> try building a dynamic site (php, databases, etc!)
							
							<a href="https://neocities.org">neocities</a>
							free static web host! super easy <u class="tq">2</u> get started if <u class="tq">u</u> wanna try making a site
							
							<a href="https://github.com/marketplace/actions/deploy-to-neocities">deploy to neocities</a>
							github action <u class="tq">2</u> easily update <u class="tq">ur</u> site from a github repository. highly recommend
							
							<a href="https://control-neocities-thumbnail.neocities.org/">control neocities thumbnail</a>
							how <u class="tq">2</u> manipulate what the neocities screenshotter sees
						</div>
					</section>
					
					<section>
						<header><h3>fun stuff</h3></header>
						<div class="body">
							
							<a href="https://underwhite.neocities.org/tutorials/orbit">orbiting CSS</a>
							tutorial <u class="tq">4</u> css orbiting effect by underwhite
							
							<a href="https://pixelcorners.lukeb.co.uk/" target="_blank">pixelcorners</a>
							<u class="tq" data-a="generates">gener8s</u> <u class="tq" data-a="pixelated">pixel8d</u> rounded corners <u class="tq">4</u>
							css elements
							
							<a href="https://www.blobmaker.app/" target="_blank">blobmaker</a>
							random svg blob <u class="tq" data-a="generator">gener8r</u>
							
							<a href="https://foolishdeveloper.com/animated-eyes-follow-mouse-cursor-in-javascript/">following eyes</a>
							javascript tutorial <u class="tq">4</u> making eyes that follow the cursor
						</div>
					</section>
					
				</div>
			</div>
			<!-- end coding resources container -->
			
			<!-- ART RESOURCES -->
			<div class="main-container container-box" id="art-resources">
				<header><h2>art & images</h2></header>
				<div class="content">
						
						<p>note: <u class="tq">i</u> do not respect gen <u class="tq" data-a="AI">ai</u> whatsoever. if <u class="tq">i</u> accidentally included anything like that, let me know!</p>
						
						<section>
							<header><h3>image manipulation</h3></header>
							<div class="body">
								
								<a href="https://unlimited.waifu2x.net/">compressPNG</a>
								absolutely life-saving <u class="tq-nep">fr33</u> image compressor <u class="tq">4</u> multiple file types. helps a ton if file space is tight
								
								<a href="https://imagemagick.org/">imagemagick</a>
								open-source image manipulation suite
								
								<a href="https://unlimited.waifu2x.net/">waifu2x</a>
								image upscaler designed for anime art in 2015, often works well <u class="tq">4</u> other images
								
								<a href="https://yrlab.zatunen.com/webgl/gbpic/gbpic.html">gameboy image filter</a>
								green classic gameboy <u class="tq-nep">scr33n</u> style
								
								<a href="https://ditheringstudio.com">dithering studio</a>
								in-browser dithering tool with a wide range of palettes and algorithms
								
								<a href="https://ditherit.com/">dither it!</a>
								basic in-browser dithering tool
							</div>
						</section>
						
						<section>
							<header><h3>drawing reference</h3></header>
							<div class="body">
								
								<a href="https://app.justsketch.me/">justsketch.me</a>
								in-browser 3d posing tool
								
							</div>
						</section>
						
						<section>
							<header><h3>free assets</h3></header>
							<div class="body">
								
								<a href="https://www.rawpixel.com/public-domain/rawpixel-collection">people's graphic design archive</a>
								crowd-sourced archive of graphic design history, incredible variety
								
								<a href="https://www.rawpixel.com/public-domain/rawpixel-collection">rawpixel</a>
								collection of high resolution public domain art and photographs from books, famous artists, and scientific sources (has monetized elements)
								
								<a href="https://www.tapedeck.org" target="_blank">tapedeck.org</a>
								massive collection of old cassette tape designs!
								
							</div>
						</section>
						
						<section>
							<header><h3>silly generators</h3></header>
							<div class="body">
							
								<a href="http://www.glittertextonline.com/index.php">glittertextonline</a>
								glitter text gif <u class="tq" data-a="generator">gener8or</u>
								
								<a href="https://benisland.neocities.org/petpet/">petpet generator</a>
								makes silly gifs of a hand petting your image
								
							</div>
						</section>
						
						<section>
							<header><h3>tools & games</h3></header>
							<div class="body">
								
								<a href="https://rarebit.neocities.org/">rarebit</a>
								free open-source JS/HTML webcomic template
								
								<a href="https://unicornycopia.com/ezm/">electric zine maker</a>
								really fun little tool to make digital zines and collages! free or pay what you want on <a class="inline" href="https://alienmelon.itch.io/electric-zine-maker">itch.io</a>
								
								<a href="https://kidpix.app/">kidpix 1.0</a>
								rebuilt in javascript, plays within <u class="tq">ur</u> browser!
								
							</div>
						</section>
				</div>
			</div>
			<!-- end art resources container -->
			
			<!-- OTHER LINKS -->
			<div class="main-container container-box" id="other">
				<header><h2>other links</h2></header>
				<div class="content">
				
					<a href="http://catipsum.com/" target="_blank">cat ipsum</a>
					silly alternative <u class="tq">2</u> standard lorem ipsum text
					
					<a href="https://www.abowman.com/" target="_blank">aBowman</a>
					web app games, including an iframe-embeddable fish feeder
					
					<a href="https://curlie.org/" target="_blank">curlie.org</a>
					massive human-edited web directory
					
					<a href="https://www.webdesignmuseum.org/" target="_blank">web design museum</a>
					archive of sites, software, games, and more from the 90s to early 2000s
				</div>
			</div>
			<!-- end other links container -->
			
			<!-- SITE BUTTONS -->
			<div class="main-container container-box" id="other-sites">
				<header><h2>site buttons</h2></header>
				<div class="content">
					<!-- FAVE SITES -->
					<?php include "fave-sites.php"; ?>
				</div>
				<!-- end content -->
			</div>
			<!-- end other sites container -->
		</main>
			
			<?php $neighbors = json_decode(file_get_contents('neighbors.json'),true); ?>
			<section id="neighbors">
				<header>
					<h3>neighbors</h3>
					<a onclick="randomNeighbor();" href="">[random]</a>
				</header>
				<div class="marquee-wrapper" style="--speed:<?php echo 10 + (count($neighbors) / 2); ?>s;">
					<div class="marquee-track">
						<?php
						shuffle($neighbors);
						foreach ($neighbors as $n) { ?>
							<a href="https://<?php echo $n["link"]; ?>" class="button" target="_blank">
								<img src="/graphix/site-buttons/<?php echo strtolower(str_replace([" ","'"],"",$n["alt"])).".".$n["img"]; ?>" alt="<?php echo $n["alt"]; ?>"></a>
						<?php } ?>
					</div>
					<div class="marquee-track-2"></div>
				</div>
			</section>
			<script>
				// self-executing function to set up marquee
				(()=>{
					let marquee = document.getElementById("neighbors").querySelector(".marquee-wrapper");
					let duplicate = document.createElement("noindex"); // hide duplicate content from bots
					duplicate.ariaHidden = "true"; // hide duplicate track from screenreaders
					duplicate.innerHTML = marquee.querySelector(".marquee-track").innerHTML;
					marquee.querySelector(".marquee-track-2").appendChild(duplicate);
					let buttons = duplicate.getElementsByTagName("a");
					for (let i = 0; i < buttons.length; i++) {
						buttons[i].tabIndex = "-1"; // remove duplicate content from keyboard navigation tab index
					}
				})();
				function randomNeighbor() {
					let neighbors = document.getElementById("neighbors").getElementsByTagName("a");
					let i = Math.floor(Math.random() * (neighbors.length - 1));
					neighbors[i].click();
				}
			</script>

	</body>
</html>