<?php
// returns the given text in multicolored letter format
function multicolorText($str) {
	$i = 0;
	echo "<span class='sr-only'>$str</span><span class='multicolor' aria-hidden=true>";
	foreach (str_split($str) as $char) {
		if ($char == " ") echo " ";
		else echo "<span>$char</span>";
	}
	echo "</span>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title><?php echo $oc["name"]." the ".strtolower($oc["species"]); ?></title>
		<meta name="description" content="Codecreature's personal site on the indie web. Interactive web experiments, art, hobbies, and games.">
		<meta name="keywords" content="codecreature, code creature, indie web, personal site, personal website">
		<meta name="author" content="codecreature">
		
		<?php // favicon
		if (!empty($oc["icon"])) { echo '<link rel="icon" type="image/x-icon" href="images/'.$oc["icon"].'">'; }
		?>
		
		<base href="<?php echo $oc["path"] ?>" src="<?php echo $oc["path"] ?>">
		
		<?php if (!empty($oc["warnings"])) echo "<script>const specificWarnings = ".json_encode($oc["warnings"]).";</script>"; ?>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=4"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=4" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		
		<?php // load fonts if specified
		if (!empty($oc["fonts"])) {
			echo "<script>fonts.load(".str_replace(["[","]"],"",json_encode($oc["fonts"])).");</script>";
		} ?>
		
		<!--full image view-->
		<script src="/codefiles/full-image.js"></script>
		
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=4"></script>
		
		<!--template's stylesheet-->
		<link href="<?php echo $templatePath; ?>style.css?fileversion=20261108" rel="stylesheet" type="text/css" media="all">
		<!--oc's stylesheet-->
		<link href="style.css" rel="stylesheet" type="text/css" media="all">
	</head>
	
	<body>
		<main>
			<section id="about">
				<header>
					<h1><?php echo multicolorText($oc["name"]); ?></h1>
					<p class="subheader-mini">the</p>
					<p class="subheader"><?php echo $oc["species"]; ?></p>
				</header>
				
				<div class="content tq-format">
					<section id="basics"><?php echo $oc["description"]; ?></section>
					
					<section id="identity">
						<?php foreach ($oc["identity"] as $name => $value) { echo "<p><span class='label'>$name:</span> $value</p>"; } ?>
					</section>
					
					<?php foreach ($oc["stats"] as $title => $array) {
						echo "<h3>$title</h3>";
						if (array_key_exists("info",$array)) {
							echo "<p>".$array["info"]."</p>";
							$array = $array["list"];
						}
						echo "<ul>";
						foreach ($array as $li) { echo "<li>$li</li>"; }
						echo "</ul>";
					} ?>
				</div> <!-- end .content -->
				
			</section>
			
			<section id="main-image">
				<div class="image-wrapper">
					<?php if (hasCustom("main image")) {
						include $_SERVER["DOCUMENT_ROOT"].$oc["path"]."main-image.php";
					} else { ?>
						<img src="images/<?php echo $oc["mainImage"]; ?>" alt="">
					<?php } ?>
				</div>
				
				<nav>
					<a href="/home">home</a>
					<a href="/ocs">ocs</a>
					<button id="page-settings-button" class="open-page-settings" aria-label="page settings">
						<i class="svg-icon svg-icon-solid" data-icon="gear-solid" alt="">
							<?php include $_SERVER["DOCUMENT_ROOT"]."/graphix/svg-icons/gear_solid.svg"; ?>
						</i>
					</button>
					<div id="page-settings-contents" class="page-settings-contents hidden" ariaLabel="page settings">
						<!--page settings go here-->
					</div>
				</nav>
			</section>
			
			<section id="gallery">
				<header>
					<?php if (hasCustom("gallery header")) {
						include $_SERVER["DOCUMENT_ROOT"].$oc["path"]."gallery-header.php";
					} else { ?>
						<h2><?php echo multicolorText("Gallery"); ?></h2>
					<?php } ?>
				</header>
				
				<div class="content">
					<section id="gallery-images">
						<div class="img-wrapper">
							<?php
							foreach ($oc["images"]["gallery"] as $img) {
								$img["img"] = "images/".$img["img"];
								?>
								<div class="img-container"><?php echoImage($img); ?></div>
							<?php } ?>
						</div>
						<?php // load fonts if specified
						if (!empty($oc["toyhouse"])) { ?>
							<footer>
								<a href="<?php echo $oc["toyhouse"]; ?>">more art on toyhouse...</a>
							</footer>
						<?php } ?>
						<script>
							// add full-viewable class to all gallery images
							let images = document.getElementById('gallery-images').getElementsByTagName('img');
							for (let i = 0; i < images.length; i++) { images[i].classList.add('full-viewable'); }
						</script>
					</section>
					
					<div class="bottom-area">
						<section id="blinkies">
							<?php
							foreach ($oc["images"]["blinkies"] as $img) {
								$img["img"] = "/graphix/blinkies/".$img["img"];
								echoImage($img);
							} ?>
						</section>
						
						<section id="stamps">
							<?php
							foreach ($oc["images"]["stamps"] as $img) {
								$img["img"] = "/graphix/stamps/".$img["img"];
								echoImage($img);
							} ?>
						</section>
					</div>
					
				</div> <!-- end content div -->
			</section>
		</main>
		
	</body>
</html>