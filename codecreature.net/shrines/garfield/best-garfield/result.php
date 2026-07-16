<?php

// include database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/codefiles/poll-connect.php";
// include list of best garfield options
require_once $_SERVER['DOCUMENT_ROOT']."/shrines/garfield/best-garfield/options.php";

$error = "";
$name = "";
$pollData = [];
$voted = false;
// which garfs this user has voted for in the past
$votedFor = !empty($_COOKIE["bestGarfieldVoted"]) ? json_decode($_COOKIE["bestGarfieldVoted"],true) : [];
// Check if name is empty or invalid
if (!empty($_GET["name"])) {
	$name = str_replace("-"," ",trim($_GET["name"]));
	// if this is a valid garf
	if (!in_array($name, $garfields)) {
		$error = "Invalid Garfield selection!";
	// Check if the user is voting or just viewing results
	} else if(!empty($_GET["voted"]) && trim($_GET["voted"]) == "true") {
		$voted = true;
		$alreadyVoted = in_array($name, $votedFor);
	}
} else {
	$name = "1980";
}

// get poll data
$sql = "SELECT * FROM best_garfield";
if ($result = mysqli_query($poll_conn,$sql)) {
	while($row = mysqli_fetch_object($result)) {
		$row = get_object_vars($row);
		$pollData[$row["name"]] = $row["votes"];
	}
	arsort($pollData); // sort descending
} else {
	$error = "Could not load poll data. Please try again later.";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>best garfield</title>
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="/shrines/garfield/favicon.gif">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260715"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260715" rel="stylesheet" type="text/css"></link>
		
		<script>fonts.load('Garfield','Ad Lib')</script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260715" id="svg-icons-js"></script>
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260715"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260715"></script>
		
		<!--this page's stylesheet-->
		<link href="/shrines/garfield/style.css?fileversion=20260715" rel="stylesheet" type="text/css" media="all">
		<link href="/shrines/garfield/best-garfield/result.css?fileversion=20260715" rel="stylesheet" type="text/css" media="all">
		
		<?php if (!empty($error)) {
			echo "<script>alert('ERROR: $error');</script>";
			echo "<script>window.location = '/best-garfield'</script>";
		} ?>
	</head>
	
	<!-----------BODY------------------->
	<body>
		<a class="skip-to-content" href="#content">skip to content</a>
		
		<main>
			<div id="nav-wrapper" class="left">
				<?php include $_SERVER['DOCUMENT_ROOT']."/shrines/garfield/nav.txt"; ?>
			</div>
			
			<div class="center">
				<div id="content" class="container"><!-- anchor for keyboard nav -->
					
					<section class="results">
						<h3 class="sr-only">Results</h3>
						
						<div class="poll-bars">
							<div id='status'><span>
							<?php if ($voted) { ?>
								<div class="subtext">You voted for</div>
								<div class="main"><?php echo $name; ?></div>
							<?php } else { ?>
								<div class="main">Results</div>
							<?php } ?>
							</span></div>
							<?php
								foreach ($garfields as $g) {
									if (empty($pollData[$g])) $pollData[$g] = 0;
								}
								foreach ($pollData as $g => $votes) {
									$percentage = count($pollData) > 0 ? $votes / max($pollData) * 100 : 0;
									$class = in_array($g, $votedFor) ? " fav" : "";
									?>
									<div class="row">
										<button class="col tooltip">
											<img src="<?php echo getImgSrc($g); ?>" alt="<?php echo $g; ?>">
											<div class="tooltip-text"><?php echo $g; ?></div>
										</button>
										<div class="col">
											<div class="bar<?php echo $class; ?>" style="width:<?php echo $percentage; ?>%;">
												<div class="votes"><?php echo $votes; ?></div>
											</div>
										</div>
									</div>
									<?php
								}
								
							?>
						</div>
					</section>
					<!-- end results section -->
					
					<section class="share">
						<h3 class="sr-only">Share</h3>
						<p><?php echo $voted ? "Download this image to share!" : "Vote to get your own share image!"; ?></p>
						<?php if (!empty($name)) { ?>
						<canvas id="canvas" width="220" height="285"></canvas>
						<script>
							<?php 
								echo "var pollResponse = `".$name."`;";
								echo "var imgSrc = '". getImgSrc($name) ."';";
							?>
							const canvas = document.getElementById("canvas");
							const ctx = canvas.getContext("2d");
							
							var borderWidth = 3;
							var rounded = 2;
							var padding = 10;
							var shadow = 3;
							var width = 200;
							
							canvas.width = width + (padding * 2);
							
							ctx.fillStyle = "white";
							ctx.fillRect(borderWidth, borderWidth, canvas.width - (borderWidth * 2), canvas.height - (borderWidth * 2));
							
							const img = new Image();
							img.addEventListener("load", () => {
								ctx.drawImage(img, padding, padding);
							});
							img.src = imgSrc;
							
							// draw black outline
							ctx.strokeStyle = "black";
							ctx.lineWidth = borderWidth;
							ctx.beginPath();
							ctx.roundRect(2, 2, canvas.width - 4, canvas.height - 4, [5]);
							ctx.stroke();
							
							// draw text
							ctx.fillStyle = "black";
							ctx.font = "13px Garfield";
							var textString = "My favorite Garfield is...", textWidth = ctx.measureText(textString).width;
							ctx.fillText(textString, (canvas.width/2) - (textWidth / 2), 200 + (padding * 3));
							
							textString = pollResponse;
							if (!isNaN(Number(textString))) textString += " Comics";
							let bigFont = 19, shrink = true;
							while (shrink) {
								ctx.font = bigFont + "px Garfield";
								textWidth = ctx.measureText(textString).width;
								if (textWidth < (canvas.width - (padding * 2))) shrink = false;
								else bigFont -= 1;
							}
							ctx.fillText(textString , (canvas.width/2) - (textWidth / 2), 200 + (padding * 3) + 23);
							
							
							ctx.fillStyle = "black";
							ctx.font = "12px Garfield";
							textString = "What's yours?"; textWidth = ctx.measureText(textString).width;
							ctx.fillText(textString , (canvas.width/2) - (textWidth / 2), 200 + (padding * 3) + 42);
						</script>
						<?php
						}
						if ($voted) { ?>
							<p class="directions">Replace "PATH" with your image link.</p>
							<textarea readonly><a href="https://codecreature.net/best-garfield"><img src="PATH" alt="My favorite Garfield is <?php echo $name; ?>! Whats yours?"></a></textarea>
						<?php } else { // if not voted ?>
							<p><a href="/best-garfield" class="yellowbutton">Vote now!</a></p>
						<?php } // end if/else statement ?>
					</section>
					<!-- end share section -->
				</div>
			</div>
			
			<div id="right-bar-wrapper" class="right">
				<?php include $_SERVER['DOCUMENT_ROOT']."/shrines/garfield/right.txt"; ?>
			</div>
		</main>
		
	</body>
	<!--------------END BODY------------->
</html>
