<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widateh=device-widateh, initial-scale=1.0">
    <title>bbcode guide</title>
		<meta name="description" content="BBCode use guide for codecreature's chatrooms.">
		<meta name="keywords" content="bbcode, guide, formatting, documentation, chat">
		<meta name="author" content="codecreature">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260629"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260629" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260629"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260629"></script>
		
		<!-- fonts -->
		<script>fonts.load('Yet R','Super Comic')</script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260629" id="svg-icons-js"></script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260629" rel="stylesheet" type="text/css" media="all">
		<!--chatbox stylesheet-->
		<link href="../chat.css?fileversion=20260629" rel="stylesheet" type="text/css" media="all">
		<!--bbcode stylesheet-->
		<link href="/chat/bbcode.css?fileversion=20260629" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20260629" rel="stylesheet" type="text/css" media="all">
</head>
<body class="chatbox">
	
	<header>
		<a href="javascript:void(0);" onclick="history.back();">back</a>
		
		<button id="page-settings-button" class="open-page-settings" aria-label="page settings">
			<i class="svg-icon svg-icon-solid" data-icon="gear-solid" alt="">
				<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">
					<path style="stroke-linejoin:round;stroke-linecap:butt;" d="M 58.475469,8.2100704 V 25.772997 A 41.184249,41.184253 0 0 0 35.106834,39.084493 L 20.308319,30.540394 12.64347,43.816052 27.439039,52.358188 a 41.184249,41.184253 0 0 0 -2.48311,13.787695 41.184249,41.184253 0 0 0 2.392781,13.545669 l -14.70524,8.490098 7.155267,13.56973 15.138236,-8.739987 a 41.184249,41.184253 0 0 0 23.538496,13.507377 v 16.9748 l 15.329698,0.58813 V 106.51877 A 41.184249,41.184253 0 0 0 97.497322,92.806186 l 15.493668,8.945194 7.15527,-13.56973 -15.124,-8.732125 A 41.184249,41.184253 0 0 0 107.3247,66.145883 41.184249,41.184253 0 0 0 105.01048,52.554559 L 120.14626,43.816052 112.4819,30.540394 97.340717,39.282337 A 41.184249,41.184253 0 0 0 73.805167,25.688558 V 8.2100704 Z m 7.664849,31.9490626 a 25.987005,25.986999 0 0 1 25.98724,25.98675 25.987005,25.986999 0 0 1 -25.98724,25.987241 25.987005,25.986999 0 0 1 -25.98675,-25.987241 25.987005,25.986999 0 0 1 25.98675,-25.98675 z" />
				</svg>
			</i>
		</button>
		<div id="page-settings-contents" class="page-settings-contents hidden" ariaLabel="page settings">
			<!--page settings go here-->
		</div>
	</header>
	
	<section class="page-content">
		
		<h1>BBCode Guide</h1>
		<p>these are all the bbcode tags currently supported!</p>
	
		<div id="page-nav">
			<header><h2>jump to</h2></header>
			<div class="content">
			</div>
		</div>
		
		<main>
			
			<section class="category" id="text-styling">
				<header><h2>text styling</h2></header>
				
				<div class="style" id="b">
					<h4>[b] bold</h4>
					<div class="format">[b]...[/b]</div>
					<div class="description">The [b] tag formats its contents using <b>bold</b> text.</div>
				</div>
				
				<div class="style" id="i">
					<h4>[i] italics</h4>
					<div class="format">[i]...[/i]</div>
					<div class="description">The [i] tag formats its contents using <i>italicized</i> text.</div>
				</div>
				
				<div class="style" id="u">
					<h4>[u] underline</h4>
					<div class="format">[u]...[/u]</div>
					<div class="description">The [u] tag adds an <u>underline</u> to its contents.</div>
				</div>
				
				<div class="style" id="s">
					<h4>[s] strikeout</h4>
					<div class="format">[s]...[/s]</div>
					<div class="description">The [s] tag adds a <s>strikeout</s> to its contents.</div>
				</div>
				
				<div class="style" id="sub">
					<h4>[sub] subscript</h4>
					<div class="format">[sub]...[/sub]</div>
					<div class="description">The [sub] tag formats its contents as <sub>subscript</sub>.</div>
				</div>
				
				<div class="style" id="sup">
					<h4>[sup] superscript</h4>
					<div class="format">[sup]...[/sup]</div>
					<div class="description">The [sup] tag formats its contents as <sup>superscript</sup>.</div>
				</div>
				
				<div class="style" id="sup">
					<h4>[size] font size</h4>
					<div class="format">[size=n]...[/size]</div>
					<div class="description">
						The [size] tag sets the font size of its contents.
						<hr>
						<div style="font-size: 0.5em">This text is size 0.</div>
						<div style="font-size: 0.67em">This text is size 1.</div>
						<div style="font-size: 0.83em">This text is size 2.</div>
						<div style="font-size: 1.0em">This text is size 3.</div>
						<div style="font-size: 1.17em">This text is size 4.</div>
						<div style="font-size: 1.5em">This text is size 5.</div>
						<div style="font-size: 2.0em">This text is size 6.</div>
						<div style="font-size: 2.5em">This text is size 7.</div>
					</div>
				</div>
				
				<!-- hiding until i make it so color names use the site color palette
				<div class="style" id="color">
					<h4>[color] font color</h4>
					<div class="format">[color=n]...[/color]</div>
					<div class="description">
						The [color] tag sets the font color of its contents. You can specify the color as either a three-digit hex code, like #069, as a six-digit hex code, like #E34715, or as a standard HTML color name, like red.
						<br>For example,
						[color=goldenrod]gold[/color] will appear as
						<span style='color:goldenrod;'>gold</span>,
						and
						[color=#069]blue[/color] will appear as
						<span style='color:#069;'>blue</span>.
					</div>
				</div>
				-->
				
				
				
			</section>
			
			<section class="category" id="links">
				<header><h2>links</h2></header>
				
				<div class="style" id="url">
					<h4>[url] external links</h4>
					<div class="format">[url]address[/url] OR [url=address]...[/url]</div>
					<div class="description">
						The [url] tag allows you to insert links to external documents. In the first form, it simply marks the URL as a link:
						<br>[url]https://codecreature.net[/url] --> https://codecreature.net
						<hr>
						In the second form, you can specify the text to appear within the link:
						<br>[url=https://codecreature.net]codecreature![/url] --> codecreature!
						<hr>
						You can link to pages on codecreature.net without the domain name:
						<br>[url]/home[/url] or [url=/home]homepage[/url]
						<br>--> https://codecreature.net/home
					</div>
				</div>
			</section>
			
			<section class="category" id="images">
				<header><h2>images</h2></header>
				
				<div class="style" id="img">
					<h4>[img] image link</h4>
					<div class="format">[img]address[/img]</div>
					<div class="description">
						The [img] tag allows you to insert images. Paste a URL to the image between the start and end [img] tags, like this:
						<br>[img]https://codecreature.net/graphix/deco/maxwell.gif[/img]
						<hr>
						You can link to images on codecreature.net without the domain name:
						<br>[img]/graphix/deco/maxwell.gif[/img]
					</div>
				</div>
				
				<div class="style" id="emoji">
					<h4>emoji</h4>
					<div class="format">:name:</div>
					<div class="description">
						type a supported emoji name to insert it!
						<hr>
						<?php
						$emojis = [
							[ // kitty emojis
								[":happy: or :smile:","kitty_happy.svg"],
								[":bigsmile:","kitty_big_smile.svg"],
								[":laugh:","kitty_laugh.svg"],
								[":hearteyes:","kitty_heart_eyes.svg"],
								[":cool: or :sunglasses:","kitty_cool.svg"],
								[":sad:","kitty_sad.svg"],
								[":cry:","kitty_cry.svg"],
							],
							[ // objects
								[":star:","star.svg"],
								[":sword:","sword.svg"],
							],
							[ // hearts
								[":heart:","heart.svg"],
								[":brokenheart:","broken_heart.svg"],
								[":redheart:","heart_red.svg"],
								[":orangeheart:","heart_orange.svg"],
								[":yellowheart:","heart_yellow.svg"],
								[":greenheart:","heart_green.svg"],
								[":blueheart:","heart_blue.svg"],
								[":purpleheart:","heart_purple.svg"],
								[":blackheart:","heart_black.svg"],
								[":whiteheart:","heart_white.svg"],
							],
							[ // arrows
								[":up:","arrow_up.svg"],
								[":down:","arrow_down.svg"],
								[":left:","arrow_left.svg"],
								[":right:","arrow_right.svg"],
							],
							[ // jeremy
								[":jeremy:","worm_pink.png"],
								[":jeremytail:","long_worm_pink_1.png"],
								[":jeremybody:","long_worm_pink_2.png"],
								[":jeremyhead:","long_worm_pink_3.png"],
							],
							[ // pretzel
								[":pretzel:","worm_orange.png"],
								[":pretzeltail:","long_worm_orange_1.png"],
								[":pretzelbody:","long_worm_orange_2.png"],
								[":pretzelhead:","long_worm_orange_3.png"],
							],
							[ // string cheese
								[":stringcheese:","worm_yellow.png"],
								[":stringcheesetail:","long_worm_yellow_1.png"],
								[":stringcheesebody:","long_worm_yellow_2.png"],
								[":stringcheesehead:","long_worm_yellow_3.png"],
							],
							[ // matilda
								[":matilda:","worm_green.png"],
								[":matildatail:","long_worm_green_1.png"],
								[":matildabody:","long_worm_green_2.png"],
								[":matildahead:","long_worm_green_3.png"],
							],
							[ // pool noodle
								[":poolnoodle:","worm_blue.png"],
								[":poolnoodletail:","long_worm_blue_1.png"],
								[":poolnoodlebody:","long_worm_blue_2.png"],
								[":poolnoodlehead:","long_worm_blue_3.png"],
							],
							[ // microplastics
								[":microplastics:","worm_purple.png"],
								[":microplasticstail:","long_worm_purple_1.png"],
								[":microplasticsbody:","long_worm_purple_2.png"],
								[":microplasticshead:","long_worm_purple_3.png"],
							],
						];
						for ($i = 0; $i < count($emojis); $i++) {
							for ($j = 0; $j < count($emojis[$i]); $j++) {
								$e = $emojis[$i][$j];
								$code = $e[0];
								$img = "/graphix/emojis/".$e[1];
								if ($j != 0) { ?><br><?php }
								?>
								<img class="bbcode_smiley" src="<?php echo $img; ?>" alt=""> <?php echo $code; ?>
								<?php
							}
							if ($i != count($emojis) - 1) { ?><hr><?php }
						}
						?>
					</div>
				</div>
			</section>
			
			<section class="category" id="accessibility">
				<header><h2>accessibility</h2></header>
				
				<div class="style" id="alt">
					<h4>[alt] alt text</h4>
					<div class="format">[alt=alt text]...[/alt]</div>
					<div class="description">
						The [alt] tag allows you to add an accessible alternative to any text. This works for screenreaders and anyone with the "proper English" setting active on the site.
						<hr>
						Consider using this for chatspeak, unusual abbreviations, numbers in place of letters, and any other text that may be inaccessible to screenreaders, non-native English speakers, or anyone else not familiar with your personal style of typing.
						<hr>
						For example, [alt=please]pls[/alt] will display as "pls" to most users, but "please" for anyone requesting accessible text.
					</div>
				</div>
				
				<div class="style" id="e">
					<h4>[e] emoticon alt text</h4>
					<div class="format">[e=alt text]...[/e]</div>
					<div class="description">
						The [e] tag allows you to add an accessible description to text emoticons. This works similarly to [alt], but only replaces text for screenreaders.
						<hr>
						For example, [e=shocked cat face]83[/e] will display "83", but screen readers will read it as "shocked cat face."
						<hr>
						The following emoticons have pre-written alt text, so you can write them as [e]...[/e].
						<br>For example, screen readers will read [e]:)[/e] as "smiley face."
						<br>
							<span class="tq-e">:)</span>
							<span class="tq-e">;)</span>
							<span class="tq-e">:D</span>
							<span class="tq-e">XD</span>
							<span class="tq-e">B)</span>
						<br>
							<span class="tq-e">:(</span>
							<span class="tq-e">:'(</span>
							<span class="tq-e">D:</span>
						<br>
							<span class="tq-e">:3</span>
							<span class="tq-e">;3</span>
							<span class="tq-e">:'3</span>
							<span class="tq-e">B3</span>
							<span class="tq-e">:3c</span>
						<br>
							<span class="tq-e">:P</span>
							<span class="tq-e">XP</span>
					</div>
				</div>
			</section>
	
		</main>
	</section>
	
	<script>
		let pageNavContent = document.getElementById('page-nav').querySelector('.content');
		let styles = document.getElementsByClassName('style');
		for (let i = 0; i < styles.length; i++) {
			let navLink = document.createElement('a');
			navLink.href = "#" + styles[i].id;
			navLink.innerHTML = styles[i].querySelector('h4').innerHTML;
			pageNavContent.appendChild(navLink);
		}
	</script>
	
</body>
</html>