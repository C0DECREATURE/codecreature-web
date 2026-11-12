<?php
	$baseLink = "/games/worm-race/npcs/";
	
	// include worm functions file
	require_once $_SERVER['DOCUMENT_ROOT']."/games/worm-race/worm-functions.php";
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>fan worms</title>
		<meta name="description" content="Worm race NPCs and fan characters.">
		<meta name="keywords" content="worms,worm race, worm game, fan worms, original characters, npc">
		<meta name="author" content="codecreature">
		
		<base src="<?php echo $baseLink; ?>" href="<?php echo $baseLink; ?>">
		
		<!-- prevent warnings popup on this page -->
		<script>var showMainWarnings = false;</script>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="../favicon.ico">
		
		<!--fonts-->
		<script>fonts.load('YetR','Super Comic');</script>
		
		<!-- svg icons -->
		<link href="/graphix/svg-icons/svg-icons-new.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--worms common stylesheet-->
		<link href="/games/worm-common/style.css?fileversion=20261011" rel="stylesheet" type="text/css" media="all">
		<!--worm race game stylesheet-->
		<link href="../style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20261012" rel="stylesheet" type="text/css" media="all">
		
		<!-- worm race functions -->
		<script src="/games/worm-race/wormFunctions.js"></script>
	</head>
	<body>
		<!-- menu & navigation -->
		<?php include '../menu.php'; ?>
		
		<div id="content-wrapper">
			
			<main id="content">
				<!--main page header-->
				<?php include '../header.php'; ?>
				
				<section id="fan-worms" class="tab info-box">
					<header>
						<h2>Fan Worms</h2>
					</header>
					<div class="main-container">
						<div class="details">
							worm characters created by fans!
							
							<p><a href="/fan-worms/new">submit a worm</a></p>
							
							<div class="worm-container">
								<?php
								$fanWorms = [];
								$sql = "SELECT * FROM fan_worms ORDER BY edited DESC, id";
								if ( $result = mysqli_query($worm_conn,$sql) ) {
									while($row = mysqli_fetch_object($result)) {
										$fanWorms[] = get_object_vars($row);
									}
								}
								foreach ($fanWorms as $worm) { ?>
								<div class="worm">
									<a href="/fan-worms/worm/<?php echo $worm["id"]; ?>">
										<img src="<?php echo $worm["icon"] ?>" alt="<?php echo $worm["name"] ?>">
									</a>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</section>
				
				
				
			</main>
			
			<!--main page footer-->
			<?php include '../../worm-common/footer.php'; ?>
		</div>
		
		<!--worm race updates-->
		<?php include '../updates.php'; ?>
	</body>
</html>