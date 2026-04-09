<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widateh=device-widateh, initial-scale=1.0">
    <title>Site Warnings</title>
		<meta name="description" content="Site content warnings.">
		<meta name="keywords" content="">
		<meta name="author" content="codecreature">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20251216"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20251216"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20251216" id="svg-icons-js"></script>
		
		<!-- fonts -->
		<script>fonts.load('SuperComic','JandaCloserToFree');</script>
		
		<!-- custom scrollbars -->
		<script src="/codefiles/simplebar.min.js"></script>
		<noscript>
			<style>
				/* Reinstate scrolling for non-JS clients */
				.simplebar-content-wrapper {
					scrollbar-width: auto;
					-ms-overflow-style: auto;
				}
				.simplebar-content-wrapper::-webkit-scrollbar,
				.simplebar-hide-scrollbar::-webkit-scrollbar {
					display: initial;
					width: initial;
					height: initial;
				}
			</style>
		</noscript>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
</head>
<body>
	
	<div id="main-box" class="main-box">
		<header class="banner">
			<h1>Warning!</h1>
		</header>
	
		<form class="content tab active main" id="warnings-form">
			
			<h2>this site contains...</h2>
			
			<div>
				bright colors, strong language, and possible mature themes (16+) without additional warnings
			</div>
			
			<section id="optional-warnings">
				<header>
					<h3>enable warnings for...</h3>
					<!--<button type="button" class="simple" id="toggle-optional-warnings" onclick="toggleOptionalWarnings();" data-state="uncheck">uncheck all</button>-->
				</header>
				
				<div class="warning-options">
					<?php
						$warningOptions = ["flashing","unreality","gore"];
						for ($i = 0; $i < count($warningOptions); $i++) {
							$w = $warningOptions[$i];
							echo "
								<!-- $w -->
								<div class='warning-option'>
									<div class='check-wrapper'>
										<input type='checkbox' id='$w-option' name='$w' class='warning-option-checkbox'>
									</div>
									<label for='$w-option'>
										<div class='img'><img src='$w.png' alt=''></div>
										<div class='text'>$w</div>
									</label>
									<button type='button' class='info' aria-label='more info'
									onclick='openTab(`$w`,true);'>?</button>
								</div>
							";
						}
					?>
				</div>
			</section>
			
			<section class="big-center">
				<button type="button" class="simple" id="accessibility-info-button"
				onclick="openTab('accessibility');">more accessibility options...</button>
			</section>
			
			<section class="content-bottom">
				<div class="wrapper">
					<span>proceed at <u class="tq">ur</u> own risk!!</span>
				</div>
				<div class="wrapper">
					<button type="submit" class="big-button accept">ok!</button>
				</div>
			</section>
			                                                                            
		</form>
		
		<?php
			// details for each of the warnings options
			for ($i = 0; $i < count($warningOptions); $i++) {
				$w = $warningOptions[$i];
				echo "
					<div class='content tab warning-option-details' id='$w'>
					<header><h2>$w</h2></header>
				";
				include "details/$w.php";
				echo "
					<button class='big-button back' onclick='openTab(`warnings-form`);'>back</button>
					</div>
				";
			}
		?>
		
		<div class="content tab" id="accessibility">
			<header>
				<h2>accessibility</h2>
			</header>
			
			<p>
				i do my best to make the site accessible where i can. keep in mind that it's an experimental art site, some pages prioritize visual aesthetics over function.
			</p>
			<section id="typing-quirks">
				<header><h3>typing quirks</h3></header>
				<p>
					numbers in place of letters, abbreviations, misspellings, and other <b>non-essential text silliness</b> can be disabled via the <b>proper english</b> checkbox in the <a onclick="showPageSettings();">settings menu</a> at the top of the page.
				</p>
				<p>
					<b>screenreaders</b> always receive the proper english version.
				</p>
			</section>
			<section id="custom-cursors">
				<header><h3>custom cursors</h3></header>
				<p>
					many pages have <b>custom cursors</b>. if you want default cursors instead, check the box in the <a onclick="showPageSettings();">settings menu</a> at the top of the page.
				</p>
			</section>
			<section id="custom-scrollbars">
				<header><h3>custom scrollbars</h3></header>
				<p>
					some elements use <b>javascript scrollbars</b> (including this one, if you're not using a touchscreen!) check the box in the <a onclick="showPageSettings();">settings menu</a> at the top of the page to disable them. scrollbar CSS styling supported by your browser may still be used.
				</p>
			</section>
			<section id="keyboard-navigation">
				<header><h3>keyboard navigation</h3></header>
				<p>
					i have made an effort to test keyboard navigation as much as possible. work in progress pages may not work as well.
				</p>
			</section>
			<section>
				<p>
					if you notice a screenreader or keyboard navigation problem, please send me a message on neocities or email <a href="mailto:admin@codecreature.net">admin@codecreature.net</a> and i'll do my best to correct it if i can!!
				</p>
			</section>
			
			<button class="big-button back" onclick="openTab('warnings-form');">back</button>
		</div>
		
		<?php include "side-character.php"; ?>
	</div>
	
	<script>
		// initialize custom scrollbars on certain elements
		(()=>{
			if (typeof customScrollbarsOn !== 'undefined' && customScrollbarsOn) {
				var mainBoxContents = document.getElementById('main-box').getElementsByClassName('content');
				for (let el of mainBoxContents) {
					new SimpleBar(el, {
						autoHide: false,
					});
				}
			}
		})();
		
		function openTab(id,updateFace) {
			// clear active tabs
			let tabs = document.getElementsByClassName('tab');
			for (let tab of tabs) tab.classList.remove('active');
			// set specified tab as active
			document.getElementById(id).classList.add('active');
			// scroll to top
			document.getElementById(id).scrollTo(0,0);
			if (typeof customScrollbarsOn !== 'undefined' && customScrollbarsOn) {
				document.getElementById(id).querySelector('.simplebar-content-wrapper').scrollTo(0,0);
			}
			// update robot cat's face
			let faceImg = updateFace ? id + '.png' : '';
			document.getElementById('side-character-face').style.backgroundImage = `url('${faceImg}')`;
			document.getElementById('side-character-face-overlay').style.display = updateFace ? '' : 'none';
		}
		
		var optionalCheckboxes = document.getElementsByClassName('warning-option-checkbox');
		
		// check/uncheck appropriate boxes based on existing warnings selections
		(()=>{
			if (localStorage.getItem('showSpecificWarnings')) {
				let arr = JSON.parse(localStorage.getItem('showSpecificWarnings'));
				for (let box of optionalCheckboxes) {
					if (arr.includes(box.name)) box.checked = true;
					else box.checked = false;
				}
			}
		})();
		
		document.getElementById('warnings-form').addEventListener('submit',(e)=>{
			e.preventDefault();
			acceptWarnings();
		});
		
		// this function is called when the user clicks the button to accept warnings
		// it saves the "don't show again" setting and redirects the user to the requested page
		function acceptWarnings() {
			// the URL to redirect the user to after they accept the warnings
			let urlParams = new URL(window.location.href).searchParams;
			let redirect = urlParams.has("redirect") ? decodeURI(urlParams.get("redirect")) : "/";
			
			// don't show general warnings page to this user again
			localStorage.setItem('seenWarnings', true);
			// save the date when warnings were accepted, in Unix epoch time
			let d = new Date();
			let time = d.getTime();
			localStorage.setItem('acceptedWarningsTime', time);
			
			// check which page-specific warnings to show in the future
			let futureWarnings = [];
			for (let box of optionalCheckboxes) {
				if (box.checked) { futureWarnings.push(box.name); }
			}
			futureWarnings = JSON.stringify(futureWarnings);
			
			// save page-specific warnings to browser storage
			localStorage.setItem('showSpecificWarnings', futureWarnings);
			console.log("Now receiving warnings for: "+localStorage.getItem('showSpecificWarnings'));
			
			// go to the specified redirect page
			window.location.href = redirect;
		}
	</script>
</body>
</html>