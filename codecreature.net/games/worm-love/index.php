<?php

// include worm connection data
require_once "../worm-race/worm-functions.php";

// include users connection data
require_once "../worm-common/users.php";

// include shipping functions
require_once "functions.php";

?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>worm shipping</title>
		
		<!-- prevent warnings popup on this page -->
		<script>var showMainWarnings = false;</script>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260725"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260725" rel="stylesheet" type="text/css"></link>
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="favicon.png">
		
		<!--fonts-->
		<script>fonts.load('YetR','Super Comic');</script>
		
		<!-- svg icons -->
		<link href="/graphix/svg-icons/svg-icons-new.css?fileversion=20260725" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260725" rel="stylesheet" type="text/css" media="all">
		<!--worms common stylesheet-->
		<link href="/games/worm-common/style.css?fileversion=20260725" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20260725" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>
		<!--main page footer-->
		<?php include $_SERVER['DOCUMENT_ROOT'].'/games/worm-race/menu.php'; ?>
		
		<!-- menu & navigation -->
		<div id="content-wrapper">
			
			<main id="content">
				<div class="main">
					
					<section id="mail" class="<?php echo $mailboxOpen ? "" : "hidden" ?>">
						<div id="letter-display">
							<img class="type" src="" alt="">
							<img class="from" src="" alt="">
							<img class="to" src="" alt="">
							<img class="extra" alt="">
							<script>
								let lDisplay = document.getElementById("letter-display");
								let lFrom = "";
								let lTo = "";
								let lType = "love";
								function updateLetter(params) {
									if (params.to) lTo = params.to.replaceAll(' ','_');
									if (params.from) lFrom = params.from.replaceAll(' ','_');
									if (params.type) lType = params.type.replaceAll(' ','_');
									
									lDisplay.querySelector('img.to').src = `images/${lType}_to_${lTo}.png`;
									lDisplay.querySelector('img.from').src = `images/${lType}_from_${lFrom}.png`;
									lDisplay.querySelector('img.type').src = `images/${lType}.png`;
									// extra image on top
									if (lType == 'love') lDisplay.querySelector('img.extra').src = `images/love_rose.png`;
									else lDisplay.querySelector('img.extra').src = ``;
								}
								// default to blank love type
								updateLetter({type:"love"});
							</script>
						</div>
						
						<form id="mail-form" action="send-mail.php" method="POST">
							<header><h2>send mail</h2></header>
							
							<h3>to:</h3>
							<div class="button-list">
								<?php foreach ($worms as $w) { ?>
								<div class="name" style="background:var(--<?php echo $w["color_dark"]; ?>">
									<input type="radio" name="recipient" value="<?php echo $w["id"]; ?>" id="recipient-worm-<?php echo $w["id"]; ?>" onchange="updateLetter({to:'<?php echo $w["name"]; ?>'});"></input>
									<label for="recipient-worm-<?php echo $w["id"]; ?>"><?php echo $w["name"]; ?></label>
								</div>
								<?php } ?>
							</div>
							
							<h3>from:</h3>
							<div class="button-list">
								<?php foreach ($worms as $w) { ?>
								<div class="name" style="background:var(--<?php echo $w["color_dark"]; ?>">
									<input type="radio" name="sender" value="<?php echo $w["id"]; ?>" id="sender-worm-<?php echo $w["id"]; ?>" onchange="updateLetter({from:'<?php echo $w["name"]; ?>'});"></input>
									<label for="sender-worm-<?php echo $w["id"]; ?>"><?php echo $w["name"]; ?></label>
								</div>
								<?php } ?>
							</div>
							
							<div>
								<h3>type:</h3>
								<?php foreach ($relationship_types as $name => $data) { ?>
								<div>
									<input type="radio" name="type" value="<?php echo $name; ?>" id="rtype-<?php echo $name; ?>" onchange="updateLetter({type:'<?php echo $name; ?>'});" <?php echo $name == "love" ? "checked" : ""; ?>></input>
									<label for="rtype-<?php echo $name; ?>">
										<img class="emoji" src="<?php echo getRelationshipIcon($name); ?>" alt=""> <?php echo $data["display_name"]; ?>
									</label>
								</div>
								<?php } ?>
							</div>
							<button type="submit">send mail</button>
							<span id="form-response" class="hidden"></span>
							
							<script> 
								// send mail form without page refresh 
								document.addEventListener('DOMContentLoaded', function () {
									const form = document.getElementById('mail-form');
									
									form.addEventListener('submit', function (evt) { 
										evt.preventDefault(); // prevent normal form submit (page refresh) 
										
										// get form data
										var formData = new FormData(form);
									 
										// send data to server
										fetch("send-mail.php", {
											method: "POST",
											body: formData,
											headers: { 
												// marker used by PHP to detect AJAX
												'X-Requested-With': 'XMLHttpRequest' 
											}, 
											credentials: 'same-origin' // include cookies if needed 
										})
										// process response as json
										.then(response => { 
											if (!response.ok) throw new Error('Network response was not ok.');
											return response.json(); // PHP returns JSON 
										}) 
										// handle response
										.then(data => {
											if (data.sent) {
												// reset form
												form.reset();
												document.getElementById('form-response').innerHTML = `Sent a ${data.type} from ${data.sender} to ${data.recipient}!`;
											} else if (data.error) { 
												document.getElementById('form-response').innerHTML = data.error; 											
											} else {
												document.getElementById('form-response').innerHTML = 'Unexpected server response.';
											}
											document.getElementById('form-response').classList.remove('hidden');
										})
										// handle errors
										.catch(err => console.error(err));
									}); 
								}); 
							</script> 
						</form>
						<!-- end form section -->
					</section>
					
					<section id="info">
						<header>mailboxes open <?php echo $nextOpen ?></header>
						<p>there are two things all worms take seriously: <strong>COMPETITION</strong> and <strong>MAIL</strong>.</p>
						<p>every february, worms send each other letters to determine what relationships they will have for the next year. worms are also very forgetful and indecisive, so they figure out their own feelings based on what kind of letter they sent the most. they even use letters to discover how they feel about themselves!</p>
						<p>you, their loving/hating fans, are invited send mail on their behalf to help them choose. they make their decision at <strong>9:00am EST</strong> on <strong>february 14th</strong>.</p>
						
						<p><strong>note:</strong> letters affect the sender's feelings <strong>more</strong> than the recipient's.</p>
					</section>
					
					<div id="current">
						<section class="ship-table"><table>
							<tr>
								<th></th>
								<?php
								foreach ($worms as $w) {
									?>
									<th><img class="worm-image" src="/graphix/emojis/worm_<?php echo $w["color"]; ?>.png" alt="<?php echo $w["name"]; ?>"</th>
									<?php
								}
								?>
							</tr>
							<?php
								foreach ($worms as $w) {
									?>
									<tr>
										<th><img class="worm-image" src="/graphix/emojis/worm_<?php echo $w["color"]; ?>.png" alt="<?php echo $w["name"]; ?>"></th>
										<?php
										// display the worm's relationships
										foreach ($feelings[$w["id"]] as $worm => $relationship) {
											echo "<td>";
											$icon = getRelationshipIcon($relationship);
											if (!empty($icon)) {
												echo "<img src='$icon' alt='$relationship'>";
											}
											echo "</td>";
										}
										?>
									</td>
									<?php
								}
							?>
						</table></section>
						
						<section class="relationship-list">
							<header><h2>current status</h2></header>
							<h3>mutual</h3>
							<?php
								// get the mutual relationships
								if (count($mutual_relationships) > 0) { foreach ($mutual_relationships as $r) {
									$icon = getRelationshipIcon($r[2]);
									$w1 = "<strong>".$worms[$r[0]]["name"]."</strong>";
									$img1 = getWormIcon($r[0]);
									$w2 = "<strong>".$worms[$r[1]]["name"]."</strong>";
									$img2 = getWormIcon($r[1]);
									$rText = str_replace("worm1",$w1,str_replace("worm2",$w2,$relationship_types[$r[2]]["mutual"]));
									echo "<img src='$img1' alt=''><img src='$icon' alt=''><img src='$img2' alt=''> $rText<br>";
								} } else echo "none!";
							?>
							<h3>one-sided</h3>
							<?php
								// get the one-sided relationships
								if (count($one_sided_relationships) > 0) { foreach ($one_sided_relationships as $r) {
									$icon = getRelationshipIcon($r[2]);
									$w1 = "<strong>".$worms[$r[0]]["name"]."</strong>";
									$img1 = getWormIcon($r[0]);
									$w2 = "<strong>".$worms[$r[1]]["name"]."</strong>";
									$img2 = getWormIcon($r[1]);
									$rText = str_replace("worm1",$w1,str_replace("worm2",$w2,$relationship_types[$r[2]]["one-sided"]));
									$arrow = "<img src='/graphix/emojis/arrow_right.png' alt=''>";
									echo "<img src='$img1' alt=''><img src='$icon' alt=''>$arrow<img src='$img2' alt=''> $rText<br>";
								} } else echo "none!";
							?>
							<h3>internal</h3>
							<?php
								// get the relationships with themselves
								if (count($self_relationships) > 0) { foreach ($self_relationships as $r) {
									$icon = getRelationshipIcon($r[2]);
									$w1 = "<strong>".$worms[$r[0]]["name"]."</strong>";
									$img1 = getWormIcon($r[0]);
									$self_pronoun = $self_pronouns[array_rand($self_pronouns)];
									$pos_pronoun = $possessive_pronouns[array_rand($possessive_pronouns)];
									$rText = str_replace("worm1",$w1,str_replace("themself",$self_pronoun,str_replace("their",$pos_pronoun,$relationship_types[$r[2]]["self"])));
									$arrow = "<img src='/graphix/emojis/arrow_right.png' alt=''>";
									echo "<img src='$img1' alt=''><img src='$icon' alt=''> $rText<br>";
								} } else echo "none!";
							?>
						</section>
					</div>
					<!-- end current -->
					
				</div>
			</main>
			
			<!--main page footer-->
			<?php include $_SERVER['DOCUMENT_ROOT'].'/games/worm-common/footer.php'; ?>
		</div>
	</body>
</html>