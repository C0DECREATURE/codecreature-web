<?php
$galleryTitle = "Gallery";

if (!empty($oc["multicolorHeaders"]) && $oc["multicolorHeaders"]) {
	// returns the given text in multicolored letter format
	function multicolorText($str) {
		$output = "<span class='sr-only'>$str</span><span class='multicolor' aria-hidden=true>";
		foreach (str_split($str) as $char) {
			if ($char == " ") $output .= " ";
			else $output .= "<span>$char</span>";
		}
		$output .= "</span>";
		return $output;
	}
	$oc["name"] = multicolorText($oc["name"]);
	$galleryTitle = multicolorText($galleryTitle);
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
		$favicon = !empty($oc["favicon"]) ? $oc["favicon"] : (!empty($oc["icon"]) ? $oc["icon"] : "");
		if (!empty($favicon)) { echo '<link rel="icon" type="image/x-icon" href="images/'.$favicon.'">'; }
		?>
		
		<base href="<?php echo $oc["path"] ?>" src="<?php echo $oc["path"] ?>">
		
		<?php if (!empty($oc["warnings"])) echo "<script>const specificWarnings = ".json_encode($oc["warnings"]).";</script>"; ?>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=4"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=4" rel="stylesheet" type="text/css"></link>
		
		<?php // load fonts if specified
		if (!empty($oc["fonts"])) {
			echo "<script>fonts.load(".str_replace(["[","]"],"",json_encode($oc["fonts"])).");</script>";
		} ?>
		
		<!--full image view-->
		<script src="/codefiles/full-image.js"></script>
		
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks-new.js?fileversion=4"></script>
		
		<!--template's stylesheet-->
		<link href="<?php echo $templatePath; ?>style.css?fileversion=20261116" rel="stylesheet" type="text/css" media="all">
		<!--oc's stylesheet-->
		<link href="style.css?fileversion=20261117" rel="stylesheet" type="text/css" media="all">
		
		<?php if (hasCustom("head")) {
			include $_SERVER["DOCUMENT_ROOT"].$oc["path"]."head.php";
		} ?>
	</head>
	
	<body>
		<main>
			<section id="about">
			
				<header>
					<?php if (hasCustom("about header")) {
						include $_SERVER["DOCUMENT_ROOT"].$oc["path"]."about-header.php";
					} else { ?>
					<h1><?php echo $oc["name"]; ?></h1>
					<p class="subheader-mini">the</p>
					<p class="subheader"><?php echo $oc["species"]; ?></p>
					<?php } ?>
				</header>
				
				<div class="content tq-format">
					<section id="basics"><?php echo $oc["description"]; ?></section>
					
					<section id="identity">
						<?php foreach ($oc["identity"] as $name => $value) { echo "<p id='identity-$name'><span class='label'>$name:</span> <span class='value'>$value</span></p>"; } ?>
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
					<a href="/home" class="button"><span>home</span></a>
					<a href="/ocs" class="button"><span>ocs</span></a>
					<?php $psType = "inline"; include $_SERVER["DOCUMENT_ROOT"]."/codefiles/page-settings.php"; ?>
				</nav>
			</section>
			
			<section id="gallery">
				<header>
					<?php if (hasCustom("gallery header")) {
						include $_SERVER["DOCUMENT_ROOT"].$oc["path"]."gallery-header.php";
					} else { ?>
						<h2><?php echo $galleryTitle; ?></h2>
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
								<a class="link" href="<?php echo $oc["toyhouse"]; ?>"><span>more art on toyhouse...</span></a>
							</footer>
						<?php } ?>
						<script>
							// add full-viewable class to all gallery images
							let images = document.getElementById('gallery-images').getElementsByTagName('img');
							for (let i = 0; i < images.length; i++) { images[i].classList.add('full-viewable'); }
						</script>
					</section>
					
					<div class="bottom-area">
						<?php if (!empty($oc["images"]["blinkies"])) { ?>
						<section id="blinkies">
							<?php
							foreach ($oc["images"]["blinkies"] as $img) {
								$img["img"] = "/graphix/blinkies/".$img["img"];
								echoImage($img);
							} ?>
						</section>
						<?php 
						}
						if (!empty($oc["images"]["stamps"])) { ?>
						<section id="stamps">
							<?php
							foreach ($oc["images"]["stamps"] as $img) {
								$img["img"] = "/graphix/stamps/".$img["img"];
								echoImage($img);
							} ?>
						</section>
						<?php } ?>
					</div>
					
				</div> <!-- end content div -->
			</section>
		</main>
		
	</body>
</html>