const updateLog = [
/*
	,
	{
		date: new Date('YYYY-MM-DDTHH:mm'),
		authors: [],
		tags: [],
		summary: `
			
		`,
		details: `
			
		`
	},
*/
	{
		date: new Date('2026-01-19T05:41'),
		authors: ['prax'],
		tags: ['new page','shrines','tangy'],
		summary: `
			<a href="/shrines/tangy">tangy shrine</a> added!
		`,
		details: `
			<p>
				<a href="/shrines/tangy">tangy shrine</a>!! %A%pretty\\purretty% simple %%4% now
			</p>
			<p align="center">
				<img src="images/tangy_2026_01_19.jpg" alt="Screenshot of the new page featuring Tangy the orange fruit Animal Crossing cat. It has a Tangy amiibo card at the center, a gif of a Tangy that is only a head and legs, and an Animal Crossing grass texture background.">
			</p>
		`
	},
	{
		date: new Date('2025-12-05T02:36'),
		authors: ['prax','emery'],
		tags: ['graphix','minor'],
		summary: `
			new <a href="/graphix">graphix</a>
		`,
		details: `
			<p align="center">
				<img src="/graphix/bumperstickers/louis_wain_happy.png" alt="Digital bumper sticker of Louis Wain's last painting. It reads 'I am happy because everyone loves me' beside a blue and red painting of a smiling cat.">
				<img src="/graphix/stamps/louis_wain_orange.png" alt="Stamp of Louis Wain's painting of a happy orange tabby cat on a green background.">
			</p>
			<p>added a few images %%2% the <a href="/graphix">graphix page</a>, including a couple %A%little\\lil% %A%Louis Wain\\louis wain% things %%i% made %%bc% %%i% love him</p>
		`
	},
	{
		date: new Date('2025-12-05T01:58'),
		authors: ['prax'],
		tags: ['games','worm race','minor'],
		summary: `
			<a href="/games/wormrace/?worm=1">pretzel</a> art fix!!
		`,
		details: `
			<p>the art %%4% <a href="/games/wormrace/?worm=1">pretzel</a> has %N%b33n% bothering me %%4% a while %%bc% it %A%didn't\\didnt% match the line weight on the other worms. adjusted that a bit!!</p>
		`
	},
	{
		date: new Date('2025-11-30-22:55'),
		authors: ['emery'],
		tags: ['general'],
		summary: `
			contact email addresses
		`,
		details: `
			<p>
				Set up various emails for contact purposes. I'll be integrating those on more parts of the site at some point. For now, the following addresses are functional if anyone wants to get in touch!
			</p>
			<ul>
				<li>admin@codecreature.net</li>
				<li>prax@codecreature.net</li>
				<li>emery@codecreature.net</li>
			</ul>
		`
	},
	{
		date: new Date('2025-11-30-22:27'),
		authors: ['emery'],
		tags: ['new page','teeth'],
		summary: `
			new <a href="/shrines/teeth">teeth</a> page
		`,
		details: `
			<p>
				Wanted to better understand how to make a PHP email form with <a href="https://github.com/PHPMailer/PHPMailer">PHPMailer</a>, so I made an advanced version of the old "send me your teeth" mailto link from the 404 page. No fancy styling on the page yet, though.
			</p>
			<p>
				I'm currently planning to theme it around Topolino, the Italian tooth fairy mouse! I am 100% serious about the teeth, %A%by the way\\btw%. If you <a href="/shrines/teeth">send me a tooth</a> of any kind, Topolino will send you something. I don't think anyone will actually do it, but the offer stands.
			</p>
			<p>
				I'd like to make a little cabinet of curiosities style page to display all the teeth I find or obtain, including the ones I already have (mostly my own.) Hoping to incorporate more teeth and bones into my room clutter and insect taxidermy art projects in the future. Much to be done.
			</p>
			<p align="center"><img src="/graphix/ads/popup/send_me_your_teeth.jpg" style="max-width: 450px;" alt="Send me your teeth ad"></p>
		`
	},
	{
		date: new Date('2025-11-30-20:01'),
		authors: ['emery'],
		tags: ['graphix','minor'],
		summary: `
			a few <a href="/graphix">%A%graphics\\graphix%</a> additions
		`,
		details: `
			<p>
				Couple new images added to the <a href="/graphix">%A%graphics\\graphix%</a> page - mostly backgrounds. Layout adjusted accordingly.
			</p>
		`
	},
	{
		date: new Date('2025-11-20T20:42'),
		authors: ['emery'],
		tags: ['games','worm race'],
		summary: `
			<a href="/games/wormrace">worm</a> play guide and racetrack button, plus poison adjustment!
		`,
		details: `
			<p>Added a basic how to play guide for the <a href="/games/wormrace">worm race</a>!</p>
			<p>Also made it possible to jump directly to the <a href="/games/wormrace#race">racetrack</a> without feeding a worm first - having it hidden made sense in the alpha version, but now it doesn't matter.</p>
			<p>The dark orange color has also been darkened a bit for better contrast!</p>
			<p>Poison is also now much stronger when health is at zero.</p>
		`
	},
	{
		date: new Date('2025-11-20T13:36'),
		authors: ['prax','emery'],
		tags: ['shrines','garfield','minor'],
		summary: `
			more <a href="/shrines/garf/comics">garfield</a> favorites, merch, & styling!!
		`,
		details: `
			<p>small %A%update\\upd8% %%2% the garf pages!! <a href="/shrines/garf/comics/?year=1980&num=0&favorites=true">favorite comics from 1980</a> added, plus a %A%little\\lil% red paw in the title %%2% mark favorites even not in favorites-only mode.</p>
			<p>%A%there's\\theres% also a bit more <a href="/shrines/garf/merch">merch</a> and new details and alt text for some of the existing ones!!</p>
		`
	},
	{
		date: new Date('2025-10-20T19:38'),
		authors: ['emery'],
		tags: ['games','worm race','minor'],
		summary: `
			minor <a href="/games/wormrace">worm</a> style adjustments
		`,
		details: `
			<p>
				The <a href="/games/wormrace">worm race</a> page layout has been tweaked for (hopefully) better function on large devices, a couple broken bits of css have been fixed, and the chatbox has been removed for now since the chat service I was using has stopped working. Fingers crossed nothing's broken now lol.
			</p>
		`
	},
	{
		date: new Date('2025-10-20T18:21'),
		authors: ['prax','emery'],
		tags: ['shrines','garfield'],
		summary: `
			<a href="/shrines/garf">garfield</a> comic updates
		`,
		details: `
			<p>
				i've logged <a href="/shrines/garf/comics?favorites=true">my favorite garfield comics</a> for the 1978 & 1979! use the toggle at the bottom %%2% show only those, or all comics in the archive. %%i% also added the ability to load a comic from <a href="/shrines/garf/comics/?year=random&num=today">today's date</a> in a random year. in theory %%u% could also load a comic from any specific date with the function, but there's no interface on the site for that (yet...)
			</p>
			<p>
				also added some garfield stamps to the right side!
			</p>
		`
	},
	{
		date: new Date('2025-10-20T15:06'),
		authors: ['emery'],
		tags: ['games','worm race','minor'],
		summary: `
			stronger <a href="/games/wormrace">worm race</a> poison, faster heart potion & apple
		`,
		details: `
			<p>
				apples reduced from 30 seconds to 10, heart potions reduced from 5 minutes to 4 minutes, and poison increased from -4 base effect to -5. will this mess up the balance? maybe! enjoy
			</p>
			<p>
				also a goblin has informed me that if you've just poisoned the winning worm, it will appear without a crown. I may or may not fix this because it is very confusing and also kind of funny
			</p>
		`
	},
	{
		date: new Date('2024-10-19T15:21'),
		authors: ['prax'],
		tags: ['graphix','minor'],
		summary: `
			new <a href="/graphix#stickers">stickers</a>!
		`,
		details: `
			<p align="center"><img src="/graphix/stickers/dbgci_cat_plush.png" alt=""></p>
			<p>added some fresh stickers to the <a href="/graphix#stickers">graphix page</a> %E%:33%</p>
		`
	},
	
	
	
	{
		date: new Date('2025-10-15T18:27'),
		authors: ['prax'],
		tags: ['minor','homestuck','mobile'],
		summary: `
			a few small <a href="/shrines/homestuck">homestuck</a> %A%updates\\upd8s%
		`,
		details: `
			<p>
				added a page %%4% <a href="/shrines/homestuck/images">homestuck %A%graphics\\graphix%</a> %%ive% made that %%r% %N%fr33% %%2% use, and the <a href="/shrines/homestuck/shipping">ship wall</a> top diagram sections can now be clicked %%2% sort by type!
			</p>
			<p>
				also working on some cassette tape art %%2% make the playlists page fancy, have a small preview
			</p>
			<p align="center">
				<img src="/shrines/homestuck/playlists/aradia_cassette.png" style="width:max(45%,200px)"
					alt="Dithered image of an Aradia cassette tape titled 'good to be alive!' It is black with a red label and stickers of the time aspect symbol, a white fedora, and a skull with Aradia's curled horns and red fairy wings.">
				<img src="/shrines/homestuck/playlists/sollux_cassette.png" style="width:max(45%,200px)"
					alt="Dithered image of a Sollux cassette tape titled 'binary mind.' It is blue with a red and blue label divided diagonally down the middle. It has stickers of Sollux's Gemini symbol, a purple bee, and a red floppy disk.">
			</p>
		`
	},
	{
		date: new Date('2025-10-15T09:59'),
		authors: ['prax'],
		tags: ['bug'],
		summary: `
			need %%2% fix music player again %E%://%
		`,
		details: `
			<p>
				%A%I don't know\\idk% %A%what's\\whats% up %%w% it, %A%maybe\\maaaaaybe% %N%n33d% %%2% try a %A%different\\diffurent% player?
				<br>ughhhhh %A%problem\\purroblem% %%4% %A%later\\l8r%, %%im% %N%d33p% %N%d33p% in the insomnia pit %A%at\\@% this time
			</p>
		`
	},
	{
		date: new Date('2025-10-08T01:36'),
		authors: ['emery'],
		tags: ['shrines','snailfish'],
		summary: `
			color palette for the <a href="/shrines/snailfish">snailfish</a> page
		`,
		details: `
			<p align="center">
				<img src="images/snailfish_2025_09_15.jpg" alt="A screenshot of the new snailfish aquarium layout. It includes an aquarium with a pale pink snailfish, a poster of a snail, a hadal zone diagram, a jar of fish food with a shrimp label, and a model of the Nautilus deep sea vehicle. The sketches have a smooth cartoonish style and use a limited color palette of blues, pinks, yellows, oranges.">
			</p>
			<p>
				Working on the <a href="/shrines/snailfish">snailfish</a> page a bit, new color palette, new sketches, and some layout adjustments! Art is still sketchy but it's a closer approximation than the previous version. Can't do the final art until I have my tablet again, but hopefully soon I'd like to work on some content additions, better navigation between screens, and video updates.
			</p>
		`
	},
	{
		date: new Date('2025-09-03T04:41'),
		authors: ['emery'],
		tags: ['shrines','garfield'],
		summary: `
			fancier <a href="/shrines/garf/comics">garfield comics</a>
		`,
		details: `
			<p align="center"><img src="images/garfield_2025_09_03.jpg"></p>
			<p>Various <a href="/shrines/garf">Garfield</a> page adjustments, mostly on the <a href="/shrines/garf/comics">comics</a> page! Added fancier styling, loading indicators, date info, cursor, and fancy previous/next buttons.</p>
		`
	},
	{
		date: new Date('2025-09-03T02:15'),
		authors: ['emery'],
		tags: ['bug fix'],
		summary: `
			directory errors fixed
		`,
		details: `
			<p>A couple pages were having some issues due to the host/domain transfer, hopefully sorted now. I'm really figuring the webhosting stuff out on the fly here lol</p>
		`
	},
	{
		date: new Date('2025-09-02T16:05'),
		authors: ['emery'],
		tags: ['general','important'],
		summary: `
			<b>NEW DOMAIN!!</b>
		`,
		details: `
			<p>Website domain has been updated to codecreature.net!</p>
			<p>Neocities links will continue to function as long as Neocities exists, but if you've bookmarked or linked anything with the codecreature.helioho.st domain, update those asap! I will be taking the heliohost domain down in about a month.</p>
			<p>The good news is, I should be able to maintain the .net domain forever, so even if I switch hosts in the future the links will be nice and stable %E%:)%</p>
		`
	},
	{
		date: new Date('2025-09-02T16:02'),
		authors: ['emery'],
		tags: ['shrines','garfield','minor'],
		summary: `
			<a href="/shrines/garf">garfield</a> image galleries added
		`,
		details: `
			<p>Garfield <a href="/shrines/garf/merch">merch</a> and <a href="/shrines/garf/posters">posters</a> images can now be clicked to open full image views. Also, the full image overlay on all pages across the site has some minor style and code fixes!</p>
		`
	},
	{
		date: new Date('2025-08-31T09:15'),
		authors: ['bug','emery'],
		tags: ['shrines','garfield'],
		summary: `
			added <a href="/shrines/garf">garfield</a> content
		`,
		details: `
			<p><a href="/shrines/garf">garfield shrine</a> expansion! added some <a href="/shrines/garf/merch">collectibles</a>, <a href="/shrines/garf/posters">posters</a>, and also every <a href="/shrines/garf/comics">daily comic</a> from 1978-2024. still need to finish making the tiling shelf pieces for the collectibles and pad out some of the pages with a bit more content!</p>
		`
	},
	{
		date: new Date('2025-08-27T03:12'),
		authors: ['prax'],
		tags: ['new page','shrines','garfield'],
		summary: `
			%A%little\\lil% shrine %%4% <a href="/shrines/garf">garf</a>
		`,
		details: `
			<p align="center"><img src="images/garfield_2025_08_27.jpg" alt="screenshot of garfield web page. it has the Garfield logo at the top. Garfield is lounging atop a white text boxx in the middle, and the sidebars have a tiling green pattern of his face. A newspaper with comic strips is poking up at an angle from the bottom right. There are several links on the sidebar with small pawprints on them."></p>
			<p>
				%A%I don't know\\idk% anything %%abt% garfield %%rly% but %%i% like %%2% look at him!! %%im% %A%going to\\gonna% put more stuff on there %A%later\\l8r% %%i% think. using the old garfield.com web archives %%4% %A%inspiration\\inspurration%, %%i% %N%n33d% %%2% find more good stuff %%2% fill it out. cool fat orange guy %E%B33%
			</p>
		`
	},
	{
		date: new Date('2025-08-26T16:40'),
		authors: ['prax'],
		tags: ['general','update log'],
		summary: `
			moved %%2% new host!!
		`,
		details: `
			<p>finally %A%migrated\\migr8d% the site %%2% heliohost!! now all our pages can have databases and stuff. all neocities links should redirect automatically %%2% the new host, %A%let me know\\lmk% if %%u% notice issues %%w% that %E%:33c%</p>
			<p>also fixed the %A%updates\\upd8s% issue %%w% pagination buttons not being hidden correctly, %A%improved\\impurroved% the styling on tag filters, and added option %%2% sort by newest/oldest %A%updates\\upd8s%</p>
		`
	},
	{
		date: new Date('2025-08-25T12:52'),
		authors: ['emery','prax'],
		tags: ['update log','general'],
		summary: `
			updates page (mostly) fixed
		`,
		details: `
			<p>
				the tags here are...... kinda mostly working!! there's a few weird bits with the pagination buttons but its fine for now. also we have pagination buttons now. no longer loading 50+ updates every time you open the page! hooray!
			</p>
			<p>
				also i'm playing with a bunch of the shared code, fixing some redirects and writing a font loader just to play with javascript a little. i'm trying to actually start respecting the object-oriented aspect of the object-oriented language
			</p>
		`
	},
	{
		date: new Date('2025-08-20T11:30'),
		authors: ['emery'],
		tags: ['general','minor'],
		summary: `
			directory change
		`,
		details: `
			<p>Altered the directory structure for the homepage/warnings, might want to refresh your cache if anything is acting strange. Please let me know if you notice anything still broken after that!</p>
		`
	},
	{
		date: new Date('2025-08-18T20:55'),
		authors: ['emery'],
		tags: ['homestuck','graphix','ocs','vex','art'],
		summary: `
			assorted small updates
		`,
		details: `
			<p>small improvements and additions to the <a href="/links">links</a>, blood paintings added to the <a href="/shrines/homestuck/shipping">homestuck ship wall</a> plus improved styling for the <a href="/shrines/homestuck/playlists">playlists</a>, a couple new <a href="/graphix">graphics</a> plus layout adjustments, and some additional styling and improved hitboxes for <a href="/ocs/vex">vex</a>! busy times</p>
			<p align="center">
				<img src="images/homestuck-shipping-2025-08-18.jpg" alt="" style="width:48%">
				<img src="images/vex-2025-08-18.jpg" alt="" style="width:48%">
				<br>red flavor. graphic design is my passion
			</p>
			<p align="center">
				<img src="/shrines/homestuck/nepeta/images/alterniabound_sprite.gif" alt="edit of nepeta's alterniabound talk sprite. she has green-tinted skin, freckles, and pawprint-shaped highlights in her eyes">
				<img src="/shrines/homestuck/nepeta/images/alterniabound_sprite_blush_talk.gif" alt="edit of nepeta's alterniabound blushing sprite">
				<img src="/shrines/homestuck/shipping/images/kanaya.png" alt="kanaya doodle">
				<img src="/shrines/homestuck/shipping/images/davepeta.png" alt="davepeta doodle">
				<br>fresh edits
			</p>
		`
	},
	{
		date: new Date('2025-08-17T05:45'),
		authors: ['prax'],
		tags: ['minor','new page','homestuck'],
		summary: `
			homestuck <a href="/shrines/homestuck/playlists">playlists</a> page
		`,
		details: `
			<p><a href="/shrines/homestuck/playlists">homestuck music</a> time!! gotta work on filling it out but %%im% gonna put all my character playlists in there. %%im% also gonna feature them on any character shrines %%i% do, but %%i% have playlists %%4% some %%i% dont plan %%2% do that with</p>
			<p>the layout is %%rly% basic and playlists dont auto %A%pause\\pawse% when %%u% start a %A%new\\mew% one, but %%ill% sort that stuff out later!!!!</p>
			<p align="center">
				<img src="/shrines/homestuck/sollux/images/alterniabound_sprite.gif" alt="sollux's talk sprite, edited so his skin has acne and a faint tinge of his blood color. his hair has small extra hairs at the ends">
				<img src="/shrines/homestuck/sollux/images/alterniabound_sprite_shrug_talk.gif" alt="a version of sollux's edited talk sprite where he is talking, looking down slightly, and shrugging one shoulder">
				<br>%%i% am also working on edits %%4% some of the sprites featured on the <a href="/shrines/homestuck">homestuck shrine base</a>
			</p>
		`
	},
	{
		date: new Date('2025-08-15T07:10'),
		authors: ['emery','prax'],
		tags: ['homestuck','art'],
		summary: `
			filling in the hs <a href="/shrines/homestuck/shipping">ship wall</a>
		`,
		details: `
			<p>getting some character art in %%4% the homestuck <a href="/shrines/homestuck/shipping">ship wall</a> buttons!! %%im% using a %A%combination\\combo% of art pulled from the <a href="https://mspaintadventures.fandom.com/wiki/Shipping_wall?file=Shipping_wall.gif">comic page</a> and custom drawn ones %%2% match the style. %%its% %N%b33n% %%rly% fun!! got more %%2% do %%tho%.</p>
			<p align="center">
				<img src="/shrines/homestuck/shipping/images/dave.png" alt="dave doodle">
				<img src="/shrines/homestuck/shipping/images/eridan.png" alt="eridan doodle">
				<img src="/shrines/homestuck/shipping/images/jade.png" alt="jade doodle">
				<img src="/shrines/homestuck/shipping/images/sollux_2.png" alt="sollux doodle">
				<img src="/shrines/homestuck/shipping/images/tavros.png" alt="tavros doodle">
			</p>
			<p>they also have some fun fancy borders and hover/select highlight effects!!</p>
		`
	},
	{
		date: new Date('2025-08-15T02:25'),
		authors: ['emery'],
		tags: ['links'],
		summary: `
			new <a href="/links">links</a> layout!
		`,
		details: `
			<p align="center">
				<img src="images/links-2025-08-15.jpg" alt="screenshot of the new links page. the content appears in rounded windows with black borders and light green outlines. the headers are underlined with a thick blue line ending in a four-pointed star. it has sections for other sites, coding resources, and webrings and clubs, as well as a small window with my site button.">
			</p>
			<p>
				finally working on the <a href="/links">links</a> page layout! got some plans to expand it later, but for now at least it's a lot better than before :)
			</p>
		`
	},
	{
		date: new Date('2025-08-14T04:56'),
		authors: ['emery'],
		tags: ['minor','new page','homestuck'],
		summary: `
			small <a href="/shrines/homestuck/~ATH-handbook">~ATH handbook</a> page added
		`,
		details: `
			<p>new <a href="/shrines/homestuck/~ATH-handbook">~ATH handbook</a> page, in CSS styled after the canon book interior. also made a silly cover for one of the links to it on <a href="/shrines/homestuck/sollux">sollux</a>'s page</p>
			<p align="center"><img src="/shrines/homestuck/~ATH-handbook/~ATH_for_dummies.jpg" style="max-width: 25%;" alt="a 'for dummies' book cover edited to be about the ~ATH programming language. the for dummies mascot man has been edited to look like a homestuck troll"></p>
		`
	},
	{
		date: new Date('2025-08-11T10:34'),
		authors: ['emery','prax'],
		tags: ['minor','art','general'],
		summary: `
			favicons and site button!
		`,
		details: `
			<p align="center">
				<img src="/graphix/icons/favicon-16.png" alt="">
				<img src="/graphix/icons/favicon-32.png" alt="">
				<img src="/graphix/icons/favicon-48.png" alt="">
				<img src="/graphix/site-buttons/codecreature.png" alt="codecreature pixel button">
				<br>finally in a pixel art mood, so we made some favicons and a site button!! if you wanna use the button, please save your own copy (the hosting is fine but the directory is likely to change depending on my impulse control)
			</p>
			<p align="center">
				also a small personal edit of the homestuck <a href="https://mspaintadventures.fandom.com/wiki/Ministrife" target="_blank">ministrife</a> pixel art
				<br><img src="/graphix/prax/prax_ministrife.png" alt="">
			</p>
		`
	},
	{
		date: new Date('2025-08-11T05:52'),
		authors: ['emery'],
		tags: ['general','homestuck'],
		summary: `
			music player!
		`,
		details: `
			<p>got a music player running, as implemented on the <a href="/shrines/homestuck/sollux">sollux</a> page! i'm using <a href="https://github.com/wiserim/WMPlayer">WMPlayer</a>, which is a nice little open source player that's easy to heavily customize and implement locally.</p>
			<p>during this process i did forget i set the youtube links to default to rick astley. rickrolled myself. got distracted by fixing something else. rickrolled myself a second time, this time with the pause button broken. in summary: many self-inflicted agonies</p>
		`
	},
	{
		date: new Date('2025-08-10T23:32'),
		authors: ['emery'],
		tags: ['minor','bug fix'],
		summary: `
			neocities screenshots fixed, thanks <a href="neocities.org/site/barndoors">barndoors</a> & <a href="neocities.org/site/juneish">juneish</a>!
		`,
		details: `
			<p>no longer have to suffer with all the previews on neocities being of the warnings page. i love you neocities community (in this case, especially <a href="neocities.org/site/barndoors">barndoors</a> and <a href="neocities.org/site/juneish">juneish</a>!) i do need to fix the post-warnings redirect system at some point</p>
		`
	},
	{
		date: new Date('2025-08-10T02:20'),
		authors: ['prax'],
		tags: ['minor','homestuck'],
		summary: `
			filling in the hs <a href="/shrines/homestuck/shipping">ship wall</a>
		`,
		details: `
			<p>many <a href="/shrines/homestuck/shipping">ships</a> to record, very serious work %E%B33c%</p>
			<p>%A%there's\\theres% some basic %A%new\\mew% code in there as well!! clickable %A%popups\\pawpups%</p>
		`
	},
	{
		date: new Date('2025-08-10T02:27'),
		authors: ['emery','prax'],
		tags: ['new page','minor','homestuck'],
		summary: `
			minor adjustments, simple placeholder pages
		`,
		details: `
			<p>
				page settings css behaves better and doesn't misuse the nav tag
			</p>
			<p>
				sollux page accessibility %A%improvements\\impurrovements% - better keyboard %A%navigation\\navig8ion% and supports reduced motion settings!!
			</p>
			<p>
				also made placeholder pages for some other <a href="/shrines/homestuck">homestuck</a> shrines (<a href="/shrines/homestuck/nepeta">nepeta</a> and <a href="/shrines/homestuck/shipping">shipping wall</a>). did a lil bit of code for the sprite animations but otherwise not much fancy going on there
			</p>
		`
	},
	{
		date: new Date('2025-08-09T02:34'),
		authors: ['emery'],
		tags: ['new page','shrines','raptor red'],
		summary: `
			new <a href="/shrines/raptor-red/">raptor red</a> shrine!
		`,
		details: `
			<p>Set up a shrine for <a href="/shrines/raptor-red/">Raptor Red</a>, one of my all-time favorite books! Visuals aren't very exciting for the moment, but there's some info about the book and in-browser embeds to read it as a PDF or audiobook. It's short and good, if you like dinosaurs I very much recommend it.</p>
		`
	},
	{
		date: new Date('2025-08-08T23:58'),
		authors: ['emery'],
		tags: ['shrines','homestuck'],
		summary: `
			<a href="/shrines/homestuck/sollux">mobius double reacharound virus</a> installed
		`,
		details: `
			<p align="center"><img src="images/sollux-2025-08-08.jpg" alt="Screenshot of a simulated code window titled 'check this shit out dot ~ATH.' It has white, red, and blue code written inside. There is a yellow-green arrow button at the bottom."></p>
			<p>
				<a href="/shrines/homestuck/sollux">sollux</a> page has a new loading animation, and the glasses light up on hover (the hover bit was, embarrassingly, a bit difficult to sort out).
			</p>
			<p>
				also, took a minute, but I figured out how to push to Neocities from a Github repository! going to work on moving the site over to another host now. and maybe.... custom domain?
			</p>
		`
	},
	{
		date: new Date('2025-07-31T21:45'),
		tags: ['games','toybox'],
		summary: `
			no more <a href="/games/toybox">toy</a> nudity
		`,
		details: `
			<p>
				basic <a href="/games/toybox">plushie collection</a> dress-up functionality added! you can now drag them into the closet, drag closet items onto them how you like, then return to the main area to arrange their fancy new decorated bodies. just a couple placeholder items for now, I need a better closet organization system before I can get really excessive with it.
			</p>
			<p>
				currently items will only be saved to the toy's outfit if their hitboxes are overlapping. I'll add something fancier in future, but for now no floating hats. sorry
			</p>
		`
	},
	{
		date: new Date('2025-07-22T21:12'),
		tags: ['new page','games','toybox'],
		summary: `
			rearrange my <a href="/games/toybox">plushie collection</a>
		`,
		details: `
			<p align="center">
				<img src="images/toybox-2025-07-22.jpg" alt="screenshot of new page. several stuffed animals are arranged on a pink arcade carpet background. there is a blue bar at the side with a square labelled 'drag here for info.' the caption on the page reads 'welcome to the toybox. come experience the joy of dragging my children around to arrange them inside this rectangle. limitless freedom. infinite replayability. it is beautiful and definitely not my first time working with canvases from scratch. promise. come back someday and maybe it will be better. or worse. certainly more complicated.'">
				<br>oh boy <a href="/games/toybox">new page</a>! canvas elements are weird but by god I am going to bend them to my will one way or another
			</p>
			<p>this one is almost certainly not mobile/keyboard/screenreader friendly right now. I'm not even sure it's desktop mouse user friendly. apologies and/or you're welcome</p>
		`
	},
	{
		date: new Date('2025-07-20T10:58'),
		tags: ['graphix','minor'],
		summary: `
			tons of new <a href="/graphix">graphix</a> added!
		`,
		details: `
			<p align="center"><img style="max-width: 200px;" src="/graphix/deco/wizard-orb.gif" alt="a blue wizard orb on a gold stand"></p>
			<p>so many more <a href="/graphix">images</a> to ponder and thieve, just as i have thieved them. enjoy. some of the code has also been improved, including background preview buttons, some better alt text, and support for blinkies/stamps/etc that go outside the lines so that they don't mess up the grid</p>
			<p>additionally. there are 2 new popup ads on the <a href="/404">404 error page</a>, including the first ad image i actually made myself. so that's neat.</p>
		`
	},
	{
		date: new Date('2025-07-19T09:01'),
		tags: ['new page','shrines','homestuck'],
		summary: `
			lil wip page %%4% <a href="/shrines/homestuck/sollux">sollux</a> plus boring code stuff
		`,
		details: `
			<p align="center"><img src="images/sollux-2025-07-19.jpg" alt="screenshot of the new page. it features various images of sollux from homestuck. the background is black with dark yellow-green accents matching sollux's shirt, and there is a tiling grid of hexagon buttons in blue and red matching his eyes.">
				<br>code guy with a thing %%4% numbers and colors. i like him
			</p>
			<p>
				page is a wip but %%its% less ambitious than my other stuff so maybe %%ill% actually finish this one. %%i% gotta %%b% more unreasonable %%abt% homestuck on the internet %%4% my own mental health. if %%u% have any hs pages on %%ur% site %%pls% show me</p>
			<p>
				the hexagons were a huge pain, it looks like %A%they're\\theyre% still not working right on chrome?? firefox supremacy i guess %E%:'33%</p>
			<p>
				<a href="/shrines/homestuck/sollux">(his glasses %%r% clickable btw)</a></p>
			<p>
				in other news %A%there's\\theres% a settings button %%4% disabling custom cursors now in case %%u% wanted that. %%i% reworked some of my javascripts and such so %A%they're\\theyre% more functional!! might have missed a page or 2 in the %A%updates\\upd8s%, %A%let me know\\lmk% if %%u% notice any broken bits and %%ill% get around %%2% it someday</p>
			<p>
				also...... %%im% considering moving %%2% another primary hosting site. %A%I'd\\id% %N%k33p% the neocities up so %%ppl% can %N%s33% when pages %A%update\\upd8% but it would all redirect %%2% the new site. tired of working around neocities %A%limitations\\limit8ions%. hmmmmm</p>
		`
	},
	{
		date: new Date('2025-07-08T08:18'),
		tags: ['games','worm race','art'],
		summary: `
			new %A%and\\n% fresh <a href="/games/wormrace">worm</a> art %%4% %%ur% eyeballs
		`,
		details: `
			<p align="center">
				<img src="images/wormrace-2025-07-08.png" alt="screenshot showing the new worm art. the pink worm wears many neckties along the length of its body. the orange worm is tangled in a knot with its own string. the yellow worm has multicolored liquid splotches along its body and a slightly crazed expression. the green worm is curled up holding a large leaf like an umbrella. the blue worm is sitting in a blue and white striped inner tube. the purple worm has multiple small legs and holds a chewed up plastic straw.">
				<br>behold, the <a href="/games/wormrace">worms</a> have %N%b33n% reborn in glorious new forms
			</p>
		`
	},
	{
		date: new Date('2024-12-15T13:07'),
		tags: ['minor'],
		summary: `
			bug fix (tysm <a href="https://wayword.neocities.org/">wayword</a>!!)
		`,
		details: `
			fixed an issue with %N%scr33nreader% only content that's %N%b33n% making some elements %%rly% wide!! huge shoutout %%2% <a href="https://wayword.neocities.org/">wayword</a> %%4% figuring this out %%4% me, %A%they're\\theyre% very cool and %%u% should check out their stuff
		`
	},
	{
		date: new Date('2024-12-15T10:33'),
		tags: ['ocs','vex','minor'],
		summary: `
			<a href="/ocs/vex">vex</a> adjustments
		`,
		details: `
			<p align="center">
				<img src="images/vex-2024-12-15.jpg" alt="screenshot of vex page showing new layout. the fonts have all been customized, some colors have been altered, and the menu has been moved from the left to the center.">
			</p>
			<p>key on <a href="/ocs/vex">vex's character page</a> is now clickable 2 unlock the coffin!! it "picks up" the key so %%u% can use it on the coffin (unless %A%you're\\ur% on touch devices, then it just opens the coffin instantly.) also did a small layout adjustmet and font %A%update\\upd8%, plus balloon animal button</p>
		`
	},
	{
		date: new Date('2024-12-09T11:49'),
		tags: ['new page','ocs','vex'],
		summary: `
			new wip page %%4% my oc <a href="/ocs/vex">vex</a>
		`,
		details: `
			<p align="center"><img src="images/vex-2024-12-09.png" alt="screenshot of my new page. the title reads "vex the vampire clown."  it has a text information section on the left and a character art gallery on the right, with a large coffin in the center wrapped in chains and a padlock. there is a small key in the lower right corner. it has a red background with dramatic yellow and red accents."></p>
			<p>working on a new oc page for my clown creature <a href="/ocs/vex">vex</a>!!!! %%im% hoping %%2% do better interactive features %A%later\\l8r% but %%4% now the coffin wiggles on hover and opens/closes on click!! the hitbox is too big %A%right now\\rn% %%pls% ignore that
		`
	},
	{
		date: new Date('2024-12-08T09:11'),
		tags: ['minor','404','links page'],
		summary: `
			warnings <a href="/warnings#accessibility">accessibility</a> and redirect, new <a href="/links">links</a>, <a href="/404">404</a> fixes
		`,
		details: `
			<p>better <a href="/warnings#accessibility">accessibility</a> info added %%2% the warnings page!! also, every page on the site should now redirect to warnings page until you've accepted them at least once</p>
			<p>fixed some bugs with the dragboxes on the <a href="/404">404 error page</a>, plus %A%updated\\upd8ed% the mini error boxes on the character art! %%i% %N%n33d% a new glitch %A%generator\\gener8r% %%2% have the glitch overlay match, %%i% lost my old bookmark</p>
			<p>also added a few new links to <a href="/links">links page</a></p>
			<p>finally, working on accessibility %A%updates\\upd8s%!! %A%prefers\\prefurs% reduced motion compatibility added to several pages with large flashing elements, working on improved header formats, keyboard %A%navigation\\navig8ion% %A%improved\\impurroved% in various places %E%:33c%
		`
	},
	{
		date: new Date('2024-12-07T00:06'),
		tags: ['minor','art'],
		summary: `
			lil furry art on <a href="/home">home</a> page
		`,
		details: `
			<p align="center">
				<img src="/home/furry-hell-2.png" alt="drawing of a purple and pink red panda wearing teal sunglasses waving in front of a neon rainbow" width="45%">
				<img src="/home/furry-hell-1.png" alt="same as previous image, but the purple red panda is hiding" width="45%">
				<br>furry time
			</p>
		`
	},
	{
		date: new Date('2024-12-05T07:41'),
		tags: ['new page','map'],
		summary: `
			new wip <a href="/experimental/map">site map</a>!!
		`,
		details: `
			<p align="center">
				<img src="images/map-2024-12-05.jpg" alt="screenshot of the site map. there is a scroll on the left side showing the names of the pages, and on the right side are rough sketches of floating islands representing some of the pages.">
				<br>%%i% have so many ideas and so little energy %%2% draw %E%:'33%
			</p>
			<p>
				%A%super\\supurr% sketchy and incomplete %%4% now!! but it has some fun stuff already, the %%lil% pointer finger works and when %%u% click on a page that has a floating island made, it jumps %%2% the island!! %%im% %A%going to\\gonna% make it so theres some info %A%about\\abt% the pages when the islands %%r% focused but %%im% tired %A%right now\\rn% and %N%n33d% a breakkkk
			</p>
		`
	},
	{
		date: new Date('2024-12-04T12:39'),
		tags: ['404','warnings','fonts'],
		summary: `
			%A%updates\\upd8s% %%2% the <a href="/404">404</a> and <a href="/warnings">warnings</a> pages!!
		`,
		details: `
			<p>
				<a href="/404">404 error</a> page now features valuable %A%popups\\pawpups%, including piracy, shopping, and more!
				some open links on click, some do not. many of the images %%r% just placeholders %%4% now, %%i% %A%want to\\wanna% do custom ones eventually!! complaint counts also %A%update\\upd8% live across all complaint %A%popups\\pawpups% if %%u% have more than 1 open %E%X33%
			</p>
			<p>
				(%%im% aware %A%there's\\theres% an issue with the %A%popups\\pawpups% changing size when dragged, %%ill% look %%in2% that %A%later\\l8r%)
			</p>
			<p>
				the <a href="/warnings">warnings</a> page was the 1st page %%i% made and %%i% %A%didn't\\didnt% know what %%i% was doing, so %%its% %N%b33n% almost 100% rewritten!! fixed a bunch of minor bugs and made the code much cleaner, as well as more %A%responsive\\respawnsive% %%2% %%N%scr33n% size!! also if %%u% click ok on the warnings page once it will skip it in the future (as long as %A%you're\\ur% using the same browser)
			</p>
			<p align="center">
				<img src="images/warnings-2024-12-01.jpg" alt="screenshot of the warnings page showing the robot cat sleeping. its screen face is displaying closed eyes. it has a speech bubble with Z's over its head.">
				<br>nap time
			</p>
			<p>
				in a more fun note, the cat bot blinks %A%every\\efurry% few seconds and does %%lil% expressions when %%u% hover over buttons!! it also goes %%2% %N%sl33p% if %%u% %A%haven't\\havent% clicked or hovered on anything %%4% a while
			</p>
			<p>
				%%ive% also added a couple new <a href="/fonts">fonts</a> %E%:33c%
			</p>
		`
	},
	{
		date: new Date('2024-03-14T03:46'),
		tags: ['games','worm race','mobile','minor'],
		summary: `
			minor %A%updates\\upd8s% %%2% mobile <a href="/games/wormrace">worm race</a>
		`,
		details: `
			<p align="center">
				<img class="tall" src="images/wormrace-2024-03-14.png" alt="">
				<br>nav arrows, %A%improved\\impurroved% top bar, fixed some %A%positioning\\pawsitioning% issues
			</p>
		`
	},
	{
		date: new Date('2024-03-09T00:40'),
		tags: ['bug fix'],
		summary: `
			broke the %%upd8% tag system again (resolved)
		`,
		details: `
			<p>Update from the future - fixed!</p>
			<p><s>
				something %A%about\\abt% my recent edits made the %A%update\\upd8% tag filters stop working %A%properly\\purroperly%. oops.
			</s></p>
			<p><s>
				%%im% %A%too\\2% busy %%2% fix it right %A%now\\meow% but %%ill% get %%2% that eventually %E%:'33%
			</s></p>
		`
	},
	{
		date: new Date('2024-03-09T00:32'),
		tags: ['snailfish','art','minor'],
		summary: `
			new <a href="/shrines/snailfish/#amphipods">amphipods</a> section %%4% snailfish %E%:33%
		`,
		details: `
			<p align="center">
				<img src="https://i.imgur.com/l41kQ4m.png" alt="sketch of a pale orange, shrimp-like crustacean.">
				<br>amphipods is bugs
			</p>
			<p>
				%N%b33n% doing some research on amphipods, starting %%2% fill in that bit of the snailfish page!! %%u% can currently get %%2% it by clicking the fish food %%2% the left of the <a href="/shrines/snailfish">aquarium tank</a> , or %%u% can just <a href="/shrines/snailfish/#amphipods">click here</a>. the layout is %A%temporary\\tempurrary% and the art is just a sketch %%4% %A%now\\meow%!!
			</p>
			<p>
				%%i% also added some trivia facts %%4% the main section
			</p>
		`
	},
	{
		date: new Date('2024-03-06T23:47'),
		tags: ['about page','mobile'],
		summary: `
			<a href="/about">about page</a> design %A%improved\\impurroved% and made mostly mobile %A%friendly!!\\furiendly!!%
		`,
		details: `
			<p align="center">
				<img src="https://i.imgur.com/kr1VgoL.png" alt="screenshot of the 'about the webmaster' page. the title is written on a rainbow banner ribbon, and the main information is displayed in a green and yellow box with cat ears. the box has ribbons of various pride flags sticking out along the sides.">
				<br>graphic design is my passion
			</p>
			<p>
				%A%there's\\theres% a few things %%2% adjust (the home button and top banner %%r% not done %%4% example, plus %%i% want clicking the ribbons %%2% do something) but mostly %A%it's\\its% good enough %%i% think!!
			</p>
			<p align="center"><img src="https://i.imgur.com/NjHcucq.png" alt="">
				<br>the ribbons pop out on hover/select!! fancy
			</p>
		`
	},
	{
		date: new Date('2024-03-05T17:30'),
		tags: ['minor','update log'],
		summary: `
			behind the scenes code stuff %%4% the %A%update\\upd8% page
		`,
		details: `
			<p>
				all the %A%updates\\upd8s% have %N%b33n% %A%transferred\\transfurred% %%2% the %A%new\\mew% system!! hopefully %%i% did it %A%without\\w/out% any major mistakes or errors lol
			</p>
			<p>
				%A%it's\\its% %A%SO\\SOOOO% much easier %%2% add fresh %A%updates\\upd8s% %%w% this system, %%im% %%rly% pleased %%w% it %E%X33%
			</p>
		`
	},
	{
		date: new Date('2024-03-04T05:00'),
		tags: ['new page','about page'],
		summary: `
			new <a href="/about">about</a> page
		`,
		details: `
			<p>
				new <a href="/about">about</a> page %%w% some basic details on the webmasters!! in case %%u% were wondering
			</p>
			<p>
				mostly %A%temporary\\tempurrary% layout but did some %A%little\\lil% ribbons %%4% pride flags that %%r% %A%pretty\\purretty% cool %A%in my opinion\\imo%!! not mobile %A%friendly\\furiendly% yet %A%though\\tho%
			</p>
			<p>
				more info %%2% come %A%later\\l8r%!!
			</p>
		`
	},
	{
		date: new Date('2024-03-01T13:00'),
		tags: ['general','minor'],
		summary: `
			small fixes
		`,
		details: `
			<p>
				finally fixed the bug that made %A%update\\upd8% page images not full view on click!! it was %%rly% simple actually so %%i% %A%didn't\\didnt% %N%n33d% %%2% put it off this long lol
			</p>
			<p>
				update page tag filters <u class="tq">r</u> hidden by default <u class="tq">w</u> a button %%2% open them now so things look a bit nicer!! plus a few edits %%2% the mobile layout
			</p>
			<p>
				also %A%updated\\upd8ed% my system %%4% the typing quirk alt text %%2% make it faster %%4% me %%2% type + %A%format\\furmat% things but %A%that's\\thats% not %%rly% exciting %%4% %A%anyone\\any1% but me
			</p>
		`
	},
	{
		date: new Date('2024-03-01T12:00'),
		tags: ['shrines','snailfish','art'],
		summary: `
			<a href="/shrines/snailfish">snailfish</a> layout %A%progress\\purrogress%
		`,
		details: `
			<p>
				working on a <u class="tq" data-a="proper">purroper</u> layout %%4% my <a href="/shrines/snailfish">hadal snailfish shrine</a>!! <u class="tq">abt</u> half the main page elements <u class="tq">r</u> <u class="tq" data-a="positioned">pawsitioned</u> so far <u class="tq">w</u> <u class="tq" data-a="temporary">tempurrary</u> sketch art. still deciding on the colors and compiling more fish research <u class="tq-e">:33c</u>
			</p>
			<p align="center">
				<img src="https://i.imgur.com/2dYItDp.png" alt="grayscale sketch of planned layout." class="tall">
				<img src="https://i.imgur.com/rbg80ct.png" alt="screenshot showing progress of actual snailfish page code." class="tall">
				<br>plan is coming <u class="tq" data-a="together">2gether</u>
			</p>
		`
	},
	{
		date: new Date('2024-02-24T12:00'),
		tags: ['games','worm race'],
		summary: `
			a bright new day %%4% worms!!
		`,
		details: `
			<p>
				%%i% figured out why worm race was broken!! neocities is a static website
				that doesnt allow databases %%2% %%b% hosted on-site, so %%i% was using an off-site host and pulling that data <u class="tq">in2</u> neocities. <u class="tq" data-a="UNFORTUNATELY">UNFURTUN8LY</u> neocities changed their privacy settings recently and thats no longer allowed %%4% <u class="tq-nep">fr33</u> accounts. so %%ive% moved the entire game %%2% the other host!! the old page will automatically redirect so %%u% can <u class="tq-nep">proc33d</u> as normal <u class="tq-e">:33c</u>
			</p>
			<p>
				might move back %%2% neocities if %%i% can %A%ever afford\\efur affurd% %%2% upgrade %%2% premium but thats not happening in the near future
			</p>
		`
	},
	{
		date: new Date('2024-01-23T12:00'),
		tags: ['general'],
		summary: `
			on semi-hiatus!!
		`,
		details: `
			<p>
				on hiatus %%4% a bit while %%i% <u class="tq" data-a="recover">recofur</u> from a chronic illness flareup!! might still poke at things but %A%updates\\upd8s% <u class="tq">r</u> limited until %%im% <u class="tq-nep">f33ling</u> a bit better and life is a %A%little\\lill% less busy <u class="tq-e">:'33</u>
			</p>
		`
	},
	{
		date: new Date('2024-01-10T12:00'),
		tags: ['bug fix','games','worm race'],
		summary: `
			wormrace down for maintenance (resolved)
		`,
		details: `
			<p><s>identified issue where %N%f33ding% worms no longer actually updates the database. still figuring out why</s></p>
			<p><s>existing worm data has %N%b33n% backed up, hopefully will have it working again soon. %%im% a bit busy this %N%w33k% so
				it might take a while to finish, sorry!</s></p>
		`
	},
	{
		date: new Date('2024-01-06T12:00'),
		tags: ['new page','shrines','snailfish'],
		summary: `
			shrine %%4% <a href="/shrines/snailfish">snailfish</a>!!!!
		`,
		details: `
			<p align="center">
				<img src="/shrines/snailfish/photos/mhs_01.png"
				alt="a hadal snailfish. it is a pale fish with a tadpole-like body, large pectoal fins, and a wide face that appears to be smiling.">
				<br>overflowing with snailfish %A%hyperfixation\\hyperfix8ion%. <u class="tq-nep">n33d</u> outlet. <a href="/shrines/snailfish">shrine</a>
			</p>
			<p>it's <u class="tq" data-a="SUPER">SUPURR</u> unfinished, <u class="tq">pls</u> dont come %%4%
				us if we got any snailfish lore wrong <u class="tq-e">:'33</u></p>
			<p>at some point we wanna make an aquarium page!! hopefully will have the spoons %%4% it soon.
				internet requires more fish</p>
		`
	},
	{
		date: new Date('2024-01-05T12:00'),
		tags: ['minor','general'],
		summary: `
			minor site-wide %A%updates\\upd8s% and adjustments
		`,
		details: `
			<p>
				happy %A%new\\mew% year!!!!
			</p>
			<p>
				chronic illness has %N%b33n% messing <u class="tq">w</u> us
				<u class="tq" data-a="lately">l8ly</u> so site %A%progress\\pawgress% has
				%N%b33n% limited %E%:((%
			</p>
			<p>
				got a bit done <u class="tq">2day</u> %A%though\\tho%!! cleaned up some small details across the site,
				mostly mobile views, efficiency, and accessibility
			</p>
		`
	},
	{
		date: new Date('2023-11-30T12:00'),
		tags: ['worm race','games','minor'],
		summary: `
			winners get <a href="/games/wormrace">crowns</a> <img src="/games/wormrace/crown.png" alt="" class="mini">
		`,
		details: `
			<p align="center"><img src="https://i.imgur.com/tJvNU78.png" alt="purple fuzzy worm wearing a gold crown"></p>
		`
	},
	{
		date: new Date('2023-11-29T12:00'),
		tags: ['worm race','games'],
		summary: `
			<a href="/games/wormrace">worm race</a> results animation, %A%updates\\upd8s% section, fancier menu, layout fixes
		`,
		details: `
			<p>put a simple animation <u class="tq">in2</u> the race results <u class="tq-nep">scr33n</u>!!!!</p>
			<p>
				also worm race %A%updates\\upd8s% <u class="tq">r</u>
				automatically displayed in the new %A%update\\upd8% section on the
				<a href="/games/wormrace">worm race</a> page!! %%i% want
				%%2% put a pin at the top so it looks like a %A%little\\lill% note but
				%%im% out of spoons %%4% the day <u class="tq-e">:'33</u>
			</p>
			<p align="center">
				<img src="https://i.imgur.com/fWyz3WV.png" alt="screenshot of the race page. there is a new green menu bar on the left side, and latest updates are shown on a piece of yellow note paper at the bottom. the worm race visual is now displayed side by side with the worm stats.">
			</p>
			<p>
				layouts should also %%b% nicer across devices!! i made a ton of edits and converted a bunch of things
				%%2% flexboxes so <u class="tq" data-a="let me know">lmk</u> in worm race chat if %%u% 
				run <u class="tq" data-a="into">in2</u> <u class="tq" data-a="problems">purroblems</u> on a specific device
			</p>
		`
	},
	{
		date: new Date('2023-11-28T12:00'),
		tags: ['minor','graphix page'],
		summary: `
			more <a href="/graphix#stickers">stickers</a> and <a href="/links">links</a>, better settings button, better image full view
		`,
		details: `
			<p>just a few %A%little\\lill% things <u class="tq">2day</u></p>
			<ul>
				<li>text settings button has actual styling and more descriptive text</li>
				<li>couple new <a href="/graphix#stickers">stickers</a> %%4% the graphix page, including
					some sandylion stickers i made transparent myself</li>
				<li>more descriptive content in image full view mode</li>
				<li>%A%update\\upd8% tags work as url parameters now so i can put page-specific
					%A%updates\\upd8s% in iframes (working on one %%4% worm race
				<u class="tq" data-a="right now">rn</u>!!)</li>
				<li>couple of new <a href="/links">links</a></li>
				<li>minor adjustments across several pages</li>
			</ul>
		`
	},
	{
		date: new Date('2023-11-27T13:00'),
		tags: ['minor','update log','general'],
		summary: `
			better <a href="/updates">update</a> tag filtering, typing quirk toggle
		`,
		details: `
			<p>
				now <u class="tq" data-a="possible">pawssible</u> %%2% filter <u class="tq" data-a="">4</u> multiple tags from the top of the %A%update\\upd8% page, and clicking the tag again excludes it!! useful.
			</p>
			<p>
				there's also a button (top right) on relevant pages that lets %%u% toggle typing quirk stuff, saves locally so %%u% don't have %%2% <u class="tq-nep">k33p</u> doing it unless %%u% clear %%ur% browser cookies <u class="tq-nep">(scr33nreaders</u> already read it normally, this is just %%4% sighted users <u class="tq-e">:33</u>)
			</p>
		`
	},
	{
		date: new Date('2023-11-27T12:00'),
		tags: ['games','worm race'],
		summary: `
			<a href="/games/wormrace">worm race</a> balance adjustments, bug fixes, new <a href="/games/wormrace/?share">share button</a>
		`,
		details: `
			<p>
				rebalanced items a bit!! with the old system, it wasn't worth <u class="tq-nep">f33ding</u> anything but health potions if health was under 100%, plus the battery juice was pretty useless. these changes should make health slightly more <u class="tq" data-a="forgiving">4giving</u>, and now the battery juice should %%b% a better option %%4% more casual visitors (%A%average\\avg% less than 5 clicks per 5 %A%minutes\\min%) while apples %%r% better %%4% more active visitors (%A%average\\avg% 5-10 clicks per 5 %A%minutes\\min%)</p>
			<p>balance changes:</p>
			<ul>
				<li>top 2 health levels have the same apple effect</li>
				<li>apple effect only decreased at the lowest health level</li>
				<li>battery juice base %A%movement\\mewvement% increased from 12 %A%to\\>>% 40</li>
				<li>battery juice cooldown increased from 90 %%seconds\\sec% %A%to\\>>% 5 %A%minutes\\min%</li>
				<li>poison %A%movement\\mewvement% effect increased from -2 to -4</li>
				<li>poison %A%movement\\mewvement% effect doubled when worm health is at minimum</li>
			</ul>
			<p align="center">
				<img src="https://i.imgur.com/nb6plvg.gif" alt="flashing rainbow worm race button">
				<br>mmmm flashing <u class="tq-e">:)</u></p>
			<p>other adjustments:</p>
			<ul>
				<li>%A%can't\\cant% give heal item when health is full</li>
				<li>better support across major browsers</li>
				<li>fixed bug causing chatbox %%2% block content on some devices</li>
				<li>chatbox always <u class="tq" data-a="positioned">pawsitioned</u> correctly and loads a little faster</li>
				<li>chatbox displays loading message</li>
				<li>chat mod/owner badges use wormrace art instead of the generic crowns</li>
				<li>accessibility adjustments (sizung, labels, alt text)</li>
				<li>race %A%movement\\mewvement% values moved %%2% stat boxes (better %%4% small <u class="tq-nep">scr33ns</u> and colorblindness)</li>
			</ul>
		`
	},
	{
		date: new Date('2023-11-27T11:00'),
		tags: ['games','worm race','art'],
		summary: `
			finalized <a href="/games/wormrace">worm race</a> background art!!
		`,
		details: `
			<p align="center">
				<img src="/games/wormrace/bg.png" alt="tiling background image featuring fuzzy worms intertwined with colorful shapes">
				<br>smooth and clean <u class="tq-e">:33</u>
			</p>
		`
	},
	{
		date: new Date('2023-11-25T14:00'),
		tags: ['update log'],
		summary: `
			<a href="/updates">updates</a> have tags now
		`,
		details: `
			<p>
				the %A%updates\\upd8s% page has a tag system, not pretty but working. and %%i% made a few changes %%2% the loading process especially in the iframe, should %%b% a bit faster and more efficient as the page %N%k33ps% getting longer
			</p>
		`
	},
	{
		date: new Date('2023-11-25T13:00'),
		tags: ['worm race','games'],
		summary: `
			worm race chatbox + loading <u class="tq-nep">scr33n</u> <a href="/games/wormrace">worm march</a>
			<br>
			<img src="/games/wormrace/pink_racer.png" alt="" class="mini"><img src="/games/wormrace/orange_racer.png" alt="" class="mini"><img src="/games/wormrace/yellow_racer.png" alt="" class="mini"><img src="/games/wormrace/green_racer.png" alt="" class="mini"><img src="/games/wormrace/blue_racer.png" alt="" class="mini"><img src="/games/wormrace/purple_racer.png" alt="" class="mini">
		`,
		details: `
			<p align="center"><img src="https://i.imgur.com/swbRgaD.png" alt="screenshot showing rows of rainbow worms on the loading screen">
				<br>significantly more worms per minute</p>
			<p><u class="tq">ive</u> made the loading <u class="tq-nep">scr33n</u> display an infinite worm train. this does not
				make it load faster but i like %%2% look at them</p>
			<p>also we have worm chat!! i want %%2% understand the worm <u class="tq" data-a="communicate">commewnity</u>.
				purple worm fan(s) %%im% looking at %%u%, woke up %%2% purple worm over 600 points ahead lol</p>
			<p>made using <a href="https://chattable.neocities.org/">chattable</a>, which i hope will b a good option. i looked
				at cbox <u class="tq">bc</u> i know thats <u class="tq" data-a="popular">pawpular</u> but its <u class="tq" data-a="pretty">p</u>
				limited in the <u class="tq-nep">fr33</u> plan %%4% how many messages it saves and user limits. chattable
				<u class="tq">doesnt</u> have icons and user logins and stuff but otherwise it has a ton of <u class="tq-nep">fr33</u>
				features!!</p>
			<p align="center"><img src="https://i.imgur.com/ICuUgZh.png" alt="screenshot of chat box design" class="tall"></p>
			<p>it took a lot longer than expected %%2% style it. lots of little
				things ended up being %%rly% time consuming, like getting the owner and mod message text %%2% b a
				<u class="tq" data-a="different">diffurent</u> color - chattable isnt technically designed %%2% do those
				things but its <u class="tq" data-a="possible">pawssible</u> if %%ur%
				determined enough!! might adjust it more <u class="tq" data-a="later">l8r</u></p>
		`
	},
	{
		date: new Date('2023-11-25T12:00'),
		tags: ['graphix page','minor'],
		summary: `
			<a href="/graphix#blinkies">blinkies</a> in the graphix page
		`,
		details: `
			<p>
				graphix page has some <a href="/graphix#blinkies">blinkies</a> now, including a few %%ive% made!! the nav also works on mobile/small %N%scr33ns% instead of vanishing off the page lol
			</p>
		`
	},
	{
		date: new Date('2023-11-25T11:00'),
		tags: ['new page','links page'],
		summary: `
			new <a href="/links">links page</a> with placeholder layout
		`,
		details: `
			<p>
				<a href="/links">links page</a> is up!! design is just slapped on there, %%ive% %N%b33n% %N%n33ding% the page %%4% %A%practical\\purractical% reasons but havent felt like doing a real layout yet!! links include webring, some art and coding resources, and a few other neocities sites %%i% like. %%ive% got lots more things %%2% put in there %A%later\\l8r% when %%i% %N%f33l% like it
			</p>
			<p align="center">
				<img src="/links/webrings/transring-catgender-mid.png" alt="'TRANSING THE INTERNET' button with cat ears and catgender pride flag colors" data-credit="https://transring.neocities.org"></img>
				<br>made myself a catgender edit %%4% the trans webring <u class="tq-e">:33c</u>
			</p>
			<p>working on some other things but idk when %A%they'll\\theyll% %%b%
				done enough %%2% post so thats all %%4% now!!</p>
		`
	},
	{
		date: new Date('2023-11-24T12:00'),
		tags: ['graphix page'],
		summary: `
			<a href="/graphix">graphix page</a> design %A%update\\upd8%!!
		`,
		details: `
			<p align="center">
				<img src="https://i.imgur.com/vFfBxAh.png">
				<br><u class="tq" data-a="navigating">navig8ing</u> is fun and cool
			</p>
			<ul>
				<li>new sparkly background</li>
				<li>real nav links that <u class="tq">r</u> not hiding at the bottom</li>
				<li><a href="/graphix#bgs">backgrounds section</a></li>
				<li><u class="tq" data-a="responsive">respawnsive</u> mobile
					<u class="tq" data-a="friendly">furiendly</u> layout</li>
				<li>better scrollbar</li>
				<li>dividers autofill width of section so i dont have %%2% repeat the images</li>
			<p align="center">also. i wrote this script %%4% a page that doesnt exist yet but %%4% now. here.</p>
			<p align="center">
				<!-- image takeover -->
				<script src="/codefiles/image-takeover.js"></script>
				<button class="btn-strip image-takeover-immune shake" onclick="randomImageTakeover('', 'max');" aria-label="don't click here! no!">
					<img class="image-takeover-immune" src="/graphix/buttons/dont-click-here.gif" alt="">
				</button>
			</p>
		`
	},
	{
		date: new Date('2023-11-24T11:00'),
		tags: ['games','worm race','mobile','general','minor'],
		summary: `
			better mobile worm race + minor adjustments
		`,
		details: `
			<p>main news %%4% this %A%update\\upd8% is that worm race should %%b% fully mobile
				<u class="tq" data-a="friendly">furiendly</u> %A%now\\meow%!! it sorta was before but %A%it's\\its% more intentional
				now</p>
			<p>other than that just some %A%little\\lil% things around the site!</p>
			<ul>
				<li>%N%touchscr33n% swipes work the same as keyboard arrow keys on all relevant pages</li>
				<li>tiling backgrounds scale correctly %%w% %N%scr33n% size</li>
				<li>worm race <u class="tq-nep">f33ding</u> cooldown no longer delayed based on load times</li>
				<li>worm race desktop layout adjusted</li>
			</ul>
		`
	},
	{
		date: new Date('2023-11-23T12:00'),
		tags: ['art','games','worm race','minor'],
		summary: `
			<a href="/games/wormrace">worm race</a> banner + background sketches!!
		`,
		details: `
			<p>new sketches %%4% the banner and background <u class="tq-e">:33</u></p>
			<p align="center"><img src="https://i.imgur.com/gpx4xD5.png" alt=""></p>
		`
	},
	{
		date: new Date('2023-11-22T13:00'),
		tags: ['graphix','update log','minor'],
		summary: `
			full view image popups %%4% <a href="/graphix">graphix</a> and <a href="/updates">%A%updates\\upd8s%</a>!!
		`,
		details: `
			<p>
				images in the <a href="/graphix">graphix galleries</a> and the update page can %%b% clicked %%2% open full view! it also has keyboard controls!! its boring basic functionality but it <u class="tq-nep">n33ded</u> doing <u class="tq-e">:33c</u>
			</p>
		`
	},
	{
		date: new Date('2023-11-22T12:00'),
		tags: ['games','worm race','art'],
		summary: `
			worm race <a href="/games/wormrace/?share">share buttons</a>
		`,
		details: `
			<p>
				<u class="tq" data-a="celebrate">celebr8</u> revival of worm race with buttons from the new <a href="/games/wormrace/?share">share section</a>!! theres a general race button plus one %%4% each worm that links direct %%2% their <u class="tq" data-a="profile">purrofile</u>
			</p>
			<p align="center">
				<img src="https://i.imgur.com/5Lbp7Id.png" alt="worm race button with colorful letters and pink fuzzy worm">
				<img src="https://i.imgur.com/LmNs5Mq.png" alt="vote pink worm button">
				<img src="https://i.imgur.com/oh2sVOa.png" alt="vote orange worm button">
				<img src="https://i.imgur.com/HCXZvih.png" alt="vote yellow worm button">
				<img src="https://i.imgur.com/gQGUviM.png" alt="vote green worm button">
				<img src="https://i.imgur.com/BHAxw1u.png" alt="vote blue worm button">
				<img src="https://i.imgur.com/N9Wgfro.png" alt="vote purple worm button">
			</p>
		`
	},
	{
		date: new Date('2023-11-22T11:00'),
		tags: ['games','worm race','art'],
		summary: `
			RETURN OF <a href="/games/wormrace">WORM RACE</a>
		`,
		details: `
			<p>
				after a whole <u class="tq-nep">w33k</u> of downtime, the <a href="/games/wormrace">worms rise again</a>!! stats reset one last time but %%ill% try %%2% back them up more often going <u class="tq" data-a="forward">furward</u>
			</p>
			<p align="center">
				<img src="/games/wormrace/pink_racer.png" alt="" width="15%">
				<img src="/games/wormrace/orange_racer.png" alt="" width="15%">
				<img src="/games/wormrace/yellow_racer.png" alt="" width="15%">
				<img src="/games/wormrace/green_racer.png" alt="" width="15%">
				<img src="/games/wormrace/blue_racer.png" alt="" width="15%">
				<img src="/games/wormrace/purple_racer.png" alt="" width="15%">
			</p>
			<p>
				basically i was running dozens of database read/write requests per user per minute, which is bad. had %%2% rewrite the whole php code and half the javascript from scratch (again) and then <u class="tq" data-a="navigate">navig8</u> a whole new host service but the fresh code is way more efficient!! %%u% just gotta refresh the page %%4% health updates if %%u% have had the worm details <u class="tq-nep">scr33n</u> sitting up for a while, no big deal. but <u class="tq">pls</u> dont spam refresh the page lol, it also %A%updates\\upd8s% when %%u% <u class="tq-nep">f33d</u> a worm.
			</p>
			<p>
				the <u class="tq" data-a="new">mew</u> system has built in overload limits so it will block <u class="tq">ppl</u> from voting %%4% a bit if we manage %%2% <u class="tq-nep">exc33d</u> database limits, but i think we should %%b% ok!! load times on the new host server <u class="tq">r</u> a bit slower but the limits <u class="tq">r</u> way higher so its worth it %A%in my opinion\\imo%</p>
			<p>
				there's also a home %A%navigation\\navig8ion% button and the game should %%b% at least mostly mobile <u class="tq" data-a="friendly">furiendly</u> now!! plus i fixed a <u class="tq" data-a="problem">purroblem</u> with the keyboard navigation system so %%u% can go thru the item choices <u class="tq">w</u> the tab key	like the other buttons
			</p>
			<p>
				now i can get back %%2% the actual planned updates, like more art stuff!! finalized the item icons %%4% a start <u class="tq-e">:33</u>
			</p>
			<p align="center">
				<img src="/games/wormrace/apple.png" alt="drawing of a golden apple" width="20%">
				<img src="/games/wormrace/drink.png" alt="drawing of a blue drink can with a lightning bolt label" width="20%">
				<img src="/games/wormrace/poison.png" alt="drawing of a green poison bottle with a skull label" width="20%">
				<img src="/games/wormrace/heal.png" alt="drawing of a pink heart shaped bottle with a teal bandaid label" width="20%">
				</p>
			<p align="center">
				<img src="/games/wormrace/icon-movement-1.png" alt="small icon of a green arrow">
				<img src="/games/wormrace/icon-movement-2.png" alt="small icon of a double arrow">
				<img src="/games/wormrace/icon-health-pos.png" alt="small icon of a pink heart">
				<img src="/games/wormrace/icon-health-neg.png" alt="small icon of a purple broken heart">
				</p>
			<p>
				there's also some fancy new UI! <u class="tq" data-a="proper">propurr</u> health bar, more <u class="tq" data-a="informative">infurmative</u> health effects section, and the race looks a %A%little\\lil% bit nicer</p>
			<p align="center">
				<img src="https://i.imgur.com/omGEaL9.png"
					alt="screenshot of the worm details page for string cheese, showing the new features" width="48%">
				<img src="https://i.imgur.com/95zd693.png"
					alt="screenshot of the race screen. the race now has a white background with rounded blue border,
					and colored boxes at the bottom showing worm stats" width="48%">
			</p>
		`
	},
	{
		date: new Date('2023-11-15T12:00'),
		tags: ['games','worm race','minor'],
		summary: `
			worm race balance adjustments
		`,
		details: `
			<p>minor balance edits %%2% the <a href="/games/wormrace">worm race!</a></p>
			<ul>
				<li>apple base %A%movement\\mewvement% increased from 3 %%2% 4</li>
				<li>maximum health effect decreased from 67% to 50%</li>
				<li>heart potion cooldown increased from 3min %%2% 5min</li>
			</ul>
		`
	},
	{
		date: new Date('2023-11-15T11:00'),
		tags: ['games','worm race'],
		summary: `
			added <a href="/games/wormrace">worm health system</a> <img src="/games/wormrace/icon-health-pos.png" alt="" class="mini">
		`,
		details: `
			<p>worm race health system is up, <a href="/games/wormrace">sabotage is now on the table</a> <u class="tq-e">B33</u></p>
			<p>other minor worm updates:</p>
			<ul>
				<li>worm stats on race page</li>
				<li>hover text for <u class="tq-nep">f33d</u> button</li>
				<li>ability for me %%2% view results without voting</li>
				<li>more efficient + less buggy race loading system</li>
				<li>no longer <u class="tq" data-a="possible">pawssible</u> %%2% cheat cooldowns by having multiple tabs open</li>
				<li>fixed bug allowing worms to have negative health or race progress</li>
			</ul>
			<p>up next on the worm agenda, visual updates and worm share!! i want %%2% make
				buttons so ppl can share the race or a specific worm on their page. the ability
				%%2% link %%2% a worm has already <u class="tq-nep">b33n</u>
				added (<a href="/games/wormrace?worm=0">here's one</a>)
				<u class="tq" data-a="although">altho</u> it doesn't display health correctly, gotta fix that</p>
		`
	},
	{
		date: new Date('2023-11-13T12:00'),
		tags: ['games','worm race','art'],
		summary: `
			big update %%2% the <a href="/games/wormrace">worm races</a>!!!! congrats %%2% purple worm %%4% winning alpha v1
		`,
		details: `
			<p align="center">
				<img src="https://i.imgur.com/uBi8HoR.png" alt="sketch of a purple fuzzy worm wrapped around a first place trophy" width="35%">
				<br>congratulations %%2% this <u class="tq-nep">w33k's</u>
				king worm!!!! 41<u class="tq" data-a=" out of ">/</u>58 clicks, not even close
			</p>
			<p>mostly done adding keyboard controls (arrows/tab/escape), profile basics <u class="tq">r</u> in,
				fresh unique worm art %%4% everyone except blue (<u class="tq">im</u> sorry), and the first half of a
				<u class="tq" data-a="currently">purrently</u> non-functional health system!! they're gonna take
				penalties %%4% low health but i have %%2% put in the UI %%4% that first <u class="tq-e">:'33</u></p>
			<p>redid most of the code from scratch with the stuff i learned from the first version,
				so the scores had %%2% %%b% reset. i think i got the structures in place correctly
				so i wont have %%2% do another full reset until i actually want %%2% %A%though\\tho%!!
				might have them run on a monthly tournament or something, with the option %%2% view
				past wins</p>
			<p>theres a few bugs %%im% aware of rn. the race results dont always load right and i havent figured
				out why yet. its also currently <u class="tq" data-a="possible">pawssible</u>
				%%2% put their stats in the negatives, which is less a bug and more a basic thing i did not put
				in yet lol. gonna patch those when i have time</p>
			<p>ALSO VERY MUCH LOOKING %A%FOR\\4% %A%FEEDBACK!!\\F33DBACK!!% %%pls% comment if %%u% have any worm thoughts</p>
			<p align="center">
				<img src="https://i.imgur.com/Vf2lljv.png" alt="screenshot of the worm choice screen showing the new art" width="45%">
			<img src="https://i.imgur.com/ovA8SDj.png" alt="screenshot of the profile page for the purple worm. its name is microplastics, it's 10 inches long, and it likes eating drywall" width="45%"></p>
		`
	},
	{
		date: new Date('2023-11-11T12:00'),
		tags: ['new page','games','worm race'],
		summary: `
			<a href="/games/wormrace">worm race alpha version</a> is live <u class="tq-e">:33</u>
		`,
		details: `
			<p>fresh new worm <u class="tq" data-a="popularity">pawpularity</u> contest!!</p>
			<p>extremely simple %%4% now <u class="tq">bc</u> even with
			<a href="https://scott2.neocities.org/blog/2023-09-17-neocities-php-and-sql/">a very helpful
				<u class="tq" data-a="tutorial">2torial</u></a>
			it took me a whole evening of banging my brain on the keyboard %%2% start understanding sql databases,
			but it works!!</p>
			<p align="center"><img src="https://i.imgur.com/7QOn7Bh.png" alt="screenshot of the worm race alpha version. 6 different colored worms on strings are competing, with orange worm in first place. each worm has a 'vote' button">
			<br><a href="/games/wormrace"><u class="tq" data-a="participate">particip8</u> in worm democracy <u class="tq">2day</u></a></p>
		`
	},
	{
		date: new Date('2023-11-09T12:00'),
		tags: ['graphix page','minor'],
		summary: `
			new <a href="/graphix">graphix</a>
		`,
		details: `
			<p>
				main notable %A%update\\upd8% %%2% the graphix collection is the <a href="/graphix#stamps">stamps</a> section!! also added alt text %%4% everything and some minor css adjustments
			</p>
		`
	},
	{
		date: new Date('2023-11-09T11:00'),
		tags: ['art','homepage','mobile'],
		summary: `
			made a placeholder tv player and corner guy %%4% the <a href="/home">homepage!!</a>
		`,
		details: `
			<p>
				tv player has clickable <u class="tq" data-a="pause/forward/back">paws/fwd/back</u> buttons, and i set it up %%2% %%b% easy %%2% change the playlist. hoping %%2% <u class="tq" data-a="improve">impurrove</u> the videos and features <u class="tq" data-a="later">l8r</u> but its functional %%4% now!!
			</p>
			<p align="center">
				<img src="https://i.imgur.com/fxu3npV.png" alt="sketch of a blue crt television with cat ears. a cat video is playing on screen" width="35%">
				<img src="https://i.imgur.com/p1D6cQ3.png" alt="sketch of a purple and pink red panda wearing sunglasses. it is waving in front of a sparkly rainbow" width="35%">
				<br>working tv!! waving little guy!!
			</p>
			<p>
				the homepage also got a rough mobile-<u class="tq" data-a="friendly">furiendly</u> %A%update\\upd8% <u class="tq-e">:33</u>
			</p>
		`
	},
	{
		date: new Date('2023-11-08T12:00'),
		tags: ['graphix page','update log','new page'],
		summary: `
			<a href="/graphix#stickers">stickers</a>, new <a href="/updates">%A%updates\\upd8s% page</a> and homepage iframe
		`,
		details: `
			<p>
				added a <a href="/graphix#stickers">sticker section</a> %%2% the graphix page, inspired by <a href="https://lu.tiny-universes.net/" target="_blank">neocities user lu</a>!!
			</p>
			<p>
				figured out how %%2% use iframes, so the updates have their own %A%dedicated\\dedic8d% page (%%u% found it, good job!!) plus a mini version embedded <u class="tq" data-a="into">in2</u> the <a href="/">homepage</a>. %%i% figured out the code 100% on my own so %%im% <u class="tq" data-a="proud">purroud</u> of that, even if %A%tutorials\\2torials% might have made it faster lol
			</p>
		`
	},
	{
		date: new Date('2023-11-08T11:00'),
		tags: ['general','minor'],
		summary: `
			username change, file system %A%improvements\\impurrovements%
		`,
		details: `
			<p>
				changed usernames from purraxis %%2% codecreature!! wanted %%2% move a %A%little\\lil% bit away from ties %%2% other social media %A%profiles\\purrofiles%, also %%2% reflect %A%participation\\pawticip8ion% of other members of my system %%bc% purraxis is based on one alter's name and others have %N%b33n% %A%contributing\\clawntributing% %E%:33%
			</p>
			<p>
				also moved big javascript chunks %%2% their own .js files, especially the ones %%i% want %%2% reuse on other pages. very exciting + functional %%4% me but doesn't look any %A%different\\diffurent% %%2% outsiders
			</p>
		`
	},
	{
		date: new Date('2023-11-07T12:00'),
		tags: ['art','mobile','warnings'],
		summary: `
			<a href="/warnings">landing page</a> %A%updated\\upd8ed% 2 b (mostly) <u class="tq" data-a="responsive">respawnsive</u>, plus new character art!!
		`,
		details: `
			<p>
				the landing page is kinda-sorta mobile %A%friendly\\furiendly% now, with some minor kinks that %N%n33d% %%2% %%b% worked out. more %A%importantly\\impurrtantly% it also works on %A%different\\diffurent% browser window sizes!!
			</p>
			<p align="center">
				<img src="https://i.imgur.com/ZIgCxRt.png" alt="screenshot of the landing page mobile layout" class="tall">
				<br>idk if mobile neocities users exist but %%i% hope %A%you're\\ur% happy.
				<br>this shaved years off my life
			</p>
		`
	},
	{
		date: new Date('2023-11-07T11:00'),
		tags: ['graphix page'],
		summary: `
			<a href="/graphix">%A%graphics\\graphix% collection</a> layout %A%improved\\impurroved%
		`,
		details: `
			<p>
				added <a href="https://masonry.desandro.com/">masonry cascading grid layout</a> %%2% the <a href="/graphix">graphix galleries</a> so all the shapes and sizes of image fit %A%together\\2gether% %E%:33%
			</p>
			<p align="center">
				<img src="https://i.imgur.com/zkumseU.png" alt="screenshot of the graphics page decoration section showing the new layout">
				<br>%%i% think this will look cooler when %A%there's\\theres% more images here
			</p>
		`
	},
	{
		date: new Date('2023-11-06T12:00'),
		tags: ['art','warnings','404'],
		summary: `
			%A%updated\\upd8ed% <a href="/warnings">landing page</a> warning icons, increased %A%popup\\pawpup% window limit on <a href="/404">404 page</a>
		`,
		details: `
			<p align="center">
				<img src="/graphix/icons/flashing.png" alt="drawing of colors radiating from white stars" width="30%">
				<img src="/graphix/icons/unreality.png" alt="drawing of a cat with spirals for eyes" width="30%">
				<img src="/graphix/icons/gore.png" alt="drawing of a bone and drop of blood" width="30%">
				<br>wow! fancy!!
			</p>
			
			<p align="center">
				<img src="https://i.imgur.com/Tr9llPn.png" alt="screenshot of the 404 error page showing dozens of overlapping error popups">
				<br>this is what good web design looks like. this is what the %%ppl% want.
			</p>
		`
	},
	{
		date: new Date('2023-11-05T12:00'),
		tags: ['new page','art','warnings','404'],
		summary: `
			new <a href="/warnings">landing page!!</a> %A%featuring\\ft% placeholder sketch art, warnings, hover effects; new <a href="/404">404 error page</a> %A%featuring\\ft% draggable boxes, hover effects, complaints %A%department\\depawtment%
		`,
		details: `
			<p align="center">
				<img src="https://i.imgur.com/jE6M1Zo.png"
					alt="screenshot of the landing page. it has a large caution tape warning label at the top, and icons warning for flashing, gore, and unreality. a robot cat sits to one side. the background is a colorful pawprints and stars pattern" width="45%">
				<img src="https://i.imgur.com/eeW4CYu.png" 
					alt="another screenshot of the landing page, showing the detail screen for the gore warning" width="45%">
				<br>warning %%4% things that dont even exist yet. its the %A%responsible\\respawnsible% thing %%2% do
			</p>
			<p align="center">
				<img src="https://i.imgur.com/1USRMUs.png"
					alt="screenshot of the 404 error page. a heavily glitched cartoon dog sits on a 90s computer monitor. the background is a glitchy bluescreen. beside it is a popup styled to look like an old Windows error message">
				<br>works just like %%ur% real pc %E%:33%
			</p>
		`
	},
	{
		date: new Date('2023-11-05T11:00'),
		tags: ['new page','homepage','graphix page','fonts'],
		summary: `
			new pages with placeholder layouts: <a href="/home">homepage</a>, <a href="/fonts">font credits</a>, <a href="/graphix">graphix collection</a>
		`,
		details: `
			<p>
				website is born!! placeholder layouts %%4% a few pages just %%2% start
			</p>
		`
	}
]