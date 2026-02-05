<?php
	// include worm functions file
	require_once "../worm-functions.php";
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>spread the worm</title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="favicon.ico">
		
		<!--fonts-->
		<script>fonts.load('YetR','Super Comic');</script>
		
		<!-- svg icons -->
		<link href="/graphix/svg-icons/svg-icons-new.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--worm race game stylesheet-->
		<link href="../../worm-common/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="share.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>
		<!-- menu & navigation -->
		<?php include '../../worm-common/menu.php'; ?>
		
		<div id="content-wrapper">
			<!--main page header-->
			<?php include '../../worm-common/header.php'; ?>
			
			<main id="content">
				
				<section id="propaganda" class="tab info-box popup show">
					<header>
						<h2>Propaganda</h2>
					</header>
					<div class="main-container">
						<div class="details">
							<div class="share-btn-section">
								<span><img src="https://i.postimg.cc/MTr3Rh4d/button_flash.gif" alt=""></span>
								<textarea rows="2" cols="60" name="flashing worm race button code"><a href="https://codecreature.net/games/worm-race" aria-label="worm race"><img src="https://i.postimg.cc/MTr3Rh4d/button_flash.gif" alt=""></a></textarea>
							</div>
							<div class="share-btn-section">
								<span><img src="https://i.postimg.cc/bJFVbKML/button.png" alt=""></span>
								<textarea rows="2" cols="60" name="static worm race button code"><a href="https://i.postimg.cc/bJFVbKML/button.png" aria-label="worm race"><img src="https://i.imgur.com/5Lbp7Id.png" alt=""></a></textarea>
							</div>
							<div class="share-btn-section">
								<span><img src="https://i.postimg.cc/631bRDSr/button_pink.png" alt=""></span>
								<textarea rows="2" cols="60" name="vote pink button code"><a href="https://codecreature.net/games/worm-race/#pink" aria-label="worm race - vote pink"><img src="https://i.postimg.cc/631bRDSr/button_pink.png" alt=""></a></textarea>
							</div>
							<div class="share-btn-section">
								<span><img src="https://i.postimg.cc/85Cn71yX/button_orange.png" alt=""></span>
								<textarea rows="2" cols="60" name="vote orange button code"><a href="https://codecreature.net/games/worm-race/#orange" aria-label="worm race - vote orange"><img src="https://i.postimg.cc/85Cn71yX/button_orange.png" alt=""></a></textarea>
							</div>
							<div class="share-btn-section">
								<span><img src="https://i.postimg.cc/RFbpfj8d/button_yellow.png" alt=""></span>
								<textarea rows="2" cols="60" name="vote yellow button code"><a href="https://codecreature.net/games/worm-race/#yellow" aria-label="worm race - vote yellow"><img src="https://i.postimg.cc/RFbpfj8d/button_yellow.png" alt=""></a></textarea>
							</div>
							<div class="share-btn-section">
								<span><img src="https://i.postimg.cc/tTgmsXrr/button_green.png" alt=""></span>
								<textarea rows="2" cols="60" name="vote green button code"><a href="https://codecreature.net/games/worm-race/#green" aria-label="worm race - vote green"><img src="https://i.postimg.cc/tTgmsXrr/button_green.png" alt=""></a></textarea>
							</div>
							<div class="share-btn-section">
								<span><img src="https://i.postimg.cc/d1SNdzX5/button_blue.png" alt=""></span>
								<textarea rows="2" cols="60" name="vote blue button code"><a href="https://codecreature.net/games/worm-race/#blue" aria-label="worm race - vote blue"><img src="https://i.postimg.cc/d1SNdzX5/button_blue.png" alt=""></a></textarea>
							</div>
							<div class="share-btn-section">
								<span><img src="https://i.postimg.cc/DZYpstDQ/button_purple.png" alt=""></span>
								<textarea rows="2" cols="60" name="vote purple button code"><a href="https://codecreature.net/games/worm-race/#purple" aria-label="worm race - vote purple"><img src="https://i.postimg.cc/DZYpstDQ/button_purple.png" alt=""></a></textarea>
							</div>
						</div>
					</div>
					
					<footer>
						<a href="../">
							<i class="svg-icon i-caret-left"></i> back
						</a>
					</footer>
				</section>
				
			</main>
			
			<!--main page footer-->
			<?php include '../../worm-common/footer.php'; ?>
		</div>
		
		<!--worm race updates-->
		<?php include '../updates.php'; ?>
	</body>
</html>