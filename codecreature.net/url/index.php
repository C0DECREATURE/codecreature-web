<?php
$redirect = "";

// if no redirect specified, go back
if (empty($_GET["redirect"])) echo "<script>history.back()</script>";
else {
	// decode the redirect url
	$redirect = urldecode(trim($_GET["redirect"]));
	// if this is a local link, just go straight there
	if (preg_match("/^\/|^https?:\/\/codecreature.net|^codecreature.net/",$redirect)) { 
		header("Location: $redirect");
	}
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>leaving codecreature!</title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!--base stylesheet-->
		<link href="/style.css" rel="stylesheet" type="text/css" media="all">
		
		<script>fonts.load('Super Comic');</script>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js"></script>
		
		<!--this page's stylesheet-->
		<link href="style.css" rel="stylesheet" type="text/css" media="all">
	</head>
	
	<body>
		
		<h3>Warning</h3>
		<p>
			You are about to leave codecreature.net.
			<br>The safety of this link has not been verified.
		</p>
		<p>Do you want to open <strong id="redirect-url-display"><?php echo $redirect; ?></strong>?</p>
		<script>document.getElementById('redirect-url-display').innerHTML = redirectUrl;</script>
		
		<div id="proceed-options">
			<a class="btn btn-red" href="javascript:void(0);" onclick="history.back()">Go Back</button>
			
			<a class="btn btn-green" id="continue" href="<?php echo $redirect; ?>">Open Link</a>
		</div>

	</body>
</html>