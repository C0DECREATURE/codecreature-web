<?php
require_once "functions.php";

$characters = ["prax","vex","lexicon"];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>creature containment</title>
		<meta name="description" content="Codecreature's original character stash.">
		<meta name="keywords" content="characters, ocs">
		<meta name="author" content="codecreature">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		
		<!-- fonts -->
		<link href="/fonts/ComicSansMS/stylesheet.css" rel="stylesheet" type="text/css">
		<link href="/fonts/SuperComic/stylesheet.css" rel="stylesheet" type="text/css">
		
		<!--base stylesheet-->
		<link href="/style.css" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="style.css" rel="stylesheet" type="text/css" media="all">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="/codefiles/jquery.lettering.js"></script>
		<script>
			$(document).ready(function() {
				$(".txt-rainbow").lettering(); /* automatically put each letter in a <span> */
			});
		</script>
	</head>
	
	<!-----------BODY------------------->
	<body>
		<div class="container">
			<h1 class="txt-rainbow">
				Containment Facility
			</h1>
			<p>this is where i store my creatures!!</p>
			
			<div class="characters">
				<?php
				foreach ($characters as $name) {
					$oc = characterData($name);
					?>
					<a href="<?php echo $name; ?>">
						<img class="icon" src="<?php echo $oc["path"]."images/".$oc["icon"]; ?>" alt="">
						<div class="name"><?php echo $oc["name"]; ?></div>
					</a>
					<?php
				}
				?>
			</div>
			
			<p>full character list and galleries on <a href="https://toyhou.se/praxis/characters">toyhou.se</a></p>
			
			<a class="btn btn-green" href="/home">home</a>
		</div>
	</body>
	<!--------------END BODY------------->
</html>
