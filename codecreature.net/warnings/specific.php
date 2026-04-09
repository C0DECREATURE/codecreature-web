<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widateh=device-widateh, initial-scale=1.0">
    <title>page warning</title>
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
<body><div class="body-wrapper">
	
	<div id="main-box" class="main-box">
		<header class="banner">
			<h1>Warning!</h1>
		</header>
	
		<form class="content tab active main" id="warnings-form">
			
			<h2>you're about to view a page with...</h2>
			
			<section id="specific-warnings">
			<?php
				$specificWarnings = !empty($_GET["warnings"]) ? explode(',', $_GET["warnings"]) : [];
				if (count($specificWarnings) < 1) {
					echo "<p align='center'>oops, no warnings to show.<br>how did you get here?</p>";
				} else {
					for ($i = 0; $i < count($specificWarnings); $i++) {
						$w = $specificWarnings[$i];
						echo "
							<!-- $w -->
							<div class='warning-option'>
								<div class='label'>
									<div class='img'><img src='$w.png' alt=''></div>
									<div class='text'>$w</div>
								</div>
								<button type='button' class='info' aria-label='more info'
								onclick='openTab(`$w`,true);'>?</button>
							</div>
						";
					}
				}
			?>
			</section>
			
			<div class="big-center">continue to view the page?</div>
			
			<section class="content-bottom">
				<div class="wrapper">
					<button type="button" class="big-button reject" onclick="goBack();">back</button>
					<script>
						function goBack() {
							let urlParams = new URL(window.location.href).searchParams;
							// get the page to go back to
							let redirect = urlParams.has("back") ? decodeURI(urlParams.get("back")) : "/";
							// if directed here from the warnings page, back goes home
							if (redirect.includes("/warnings")) redirect = "/";
							// send user to the page
							window.location = redirect;
						}
					</script>
				</div>
				<div class="wrapper">
					<button type="submit" class="big-button accept">continue</button>
				</div>
			</section>
			
			<section class="big-center sublink">
				<button type="button" class="simple" id="site-warnings-button"
				onclick="goToMainWarnings();">change which warnings you see...</button>
				<script>
					function goToMainWarnings() {
						let urlParams = new URL(window.location.href).searchParams;
						let redirect = urlParams.has("redirect") ? decodeURI(urlParams.get("redirect")) : "/";
						window.location = '/warnings?redirect='+redirect;
					}
				</script>
			</section>
			                                                                            
		</form>
		
		<?php
			// details for each of the warnings options
			for ($i = 0; $i < count($specificWarnings); $i++) {
				$w = $specificWarnings[$i];
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
			redirect = new URL(location.origin + redirect);
			
			redirect.searchParams.set('showWarnings','false');
			// go to the specified redirect page
			window.location = redirect;
		}
	</script>
</div></body>
</html>