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
<?php
	$warningOptions = ["flashing","unreality","gore"];
	$requirements = ["mobile","javascript","iframes"];
?>
<body><div class="body-wrapper">
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
			$detailSections = array_merge($warningOptions,$requirements);
			for ($i = 0; $i < count($detailSections); $i++) {
				$s = $detailSections[$i];
				echo "
					<div class='content tab warning-option-details' id='$s'>
					<header><h2>$s</h2></header>
				";
				include "details/$s.php";
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
	
	<div class="sub-box">
		<?php
			for ($i = 0; $i < count($requirements); $i++) {
				$r = $requirements[$i];
				echo "
					<!-- $r -->
					<button class='requirement' onclick='openTab(`$r`,false);'>
						<img src='$r.svg' alt='$r'>
					</button>
				";
			}
		?>
	</div>
	
	<script src="warnings.js?fileversion=20251216"></script>
</div></body>
</html>