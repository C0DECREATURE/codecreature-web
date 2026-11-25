<?php
	// include worm functions file
	require_once "../worm-functions.php";
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>rules of racing</title>
		<meta name="description" content="Rules for playing worm race.">
		<meta name="keywords" content="rules,policy,worms,worm,worm game,worms game,worm race">
		<meta name="author" content="codecreature">
		
		<!-- prevent warnings popup on this page -->
		<script>var showMainWarnings = false;</script>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="favicon.ico">
		
		<!--fonts-->
		<script>fonts.load('YetR','Super Comic');</script>
		
		<!-- svg icons -->
		<link href="/graphix/svg-icons/svg-icons-new.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--worms common stylesheet-->
		<link href="/games/worm-common/style.css?fileversion=20261125" rel="stylesheet" type="text/css" media="all">
		<!--worm race game stylesheet-->
		<link href="../style.css?fileversion=20261117" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="rules.css?fileversion=20261012" rel="stylesheet" type="text/css" media="all">
		
		<!-- worm race functions -->
		<script src="/games/worm-race/wormFunctions.js"></script>
	</head>
	<body>
		<!-- menu & navigation -->
		<?php include '../menu.php'; ?>
		
		<div id="content-wrapper">
			<!--main page header-->
			<?php include '../header.php'; ?>
			
			<main id="content">
				
				<section id="guide" class="tab info-box popup show">
					<header>
						<h2>Rules</h2>
					</header>
					<div class="main-container">
						<div class="details">
							<ol>
								<?php
								function addRule($r) { ?>
								<li>
									<h4><?php echo $r["title"]; ?></h4>
									<?php echo $r["details"]; ?>
								</li>
								<?php }
								
								function loadRuleset($name) {
									$rules = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/rules/$name.json"),true);
									foreach ($rules as $r) { addRule($r); }
								}
								
								loadRuleset("global");
								loadRuleset("worms");
								?>
							</ol>
						</div>
						
						<div class="subheader" id="awards">
							<h3>Consequences</h3>
						</div>
						
						<div class="details">
							<p>Occasional mistakes will likely be ignored, but if I notice a pattern of problematic behavior from a single user or network you may be temporarily banned. Repeated rule violations will result in permanent bans.</p>
						</div>
					</div>
						
					<footer>
						<div class="wrapper">
							<a href="../">
								<i class="svg-icon i-caret-left"></i> back
							</a>
						</div>
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