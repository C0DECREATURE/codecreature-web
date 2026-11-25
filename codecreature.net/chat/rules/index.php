<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widateh=device-widateh, initial-scale=1.0">
    <title>chatroom rules</title>
		<meta name="description" content="Rules for codecreature's chatrooms.">
		<meta name="keywords" content="rules, guide, guidelines, code of conduct, chat">
		<meta name="author" content="codecreature">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260629"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260629" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260629"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260629"></script>
		
		<!-- fonts -->
		<script>fonts.load('Yet R','Super Comic')</script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260629" id="svg-icons-js"></script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20261112" rel="stylesheet" type="text/css" media="all">
		<!--chatbox stylesheet-->
		<link href="../chat.css?fileversion=20261112" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20261112" rel="stylesheet" type="text/css" media="all">
</head>
<body class="chatbox">
	
	<header>
		<a href="/chat">back</a>
		
		<button id="page-settings-button" class="open-page-settings" aria-label="page settings">
			<i class="svg-icon svg-icon-solid" data-icon="gear-solid" alt="">
				<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">
					<path style="stroke-linejoin:round;stroke-linecap:butt;" d="M 58.475469,8.2100704 V 25.772997 A 41.184249,41.184253 0 0 0 35.106834,39.084493 L 20.308319,30.540394 12.64347,43.816052 27.439039,52.358188 a 41.184249,41.184253 0 0 0 -2.48311,13.787695 41.184249,41.184253 0 0 0 2.392781,13.545669 l -14.70524,8.490098 7.155267,13.56973 15.138236,-8.739987 a 41.184249,41.184253 0 0 0 23.538496,13.507377 v 16.9748 l 15.329698,0.58813 V 106.51877 A 41.184249,41.184253 0 0 0 97.497322,92.806186 l 15.493668,8.945194 7.15527,-13.56973 -15.124,-8.732125 A 41.184249,41.184253 0 0 0 107.3247,66.145883 41.184249,41.184253 0 0 0 105.01048,52.554559 L 120.14626,43.816052 112.4819,30.540394 97.340717,39.282337 A 41.184249,41.184253 0 0 0 73.805167,25.688558 V 8.2100704 Z m 7.664849,31.9490626 a 25.987005,25.986999 0 0 1 25.98724,25.98675 25.987005,25.986999 0 0 1 -25.98724,25.987241 25.987005,25.986999 0 0 1 -25.98675,-25.987241 25.987005,25.986999 0 0 1 25.98675,-25.98675 z" />
				</svg>
			</i>
		</button>
		<div id="page-settings-contents" class="page-settings-contents hidden" ariaLabel="page settings">
			<!--page settings go here-->
		</div>
	</header>
	
	<section class="page-content">
		
		<h1>Chatroom Rules</h1>
		
		<main>
			<p>This is a tiny personal website with a very small community, so I'm generally trusting you to behave yourselves!
				<br>If you're unsure, here are some general guidelines.</p>
			</p>Last update: 11/16/2026</p>
			
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
				loadRuleset("user");
				loadRuleset("chat");
				?>
			</ol>
			
			<h2>Consequences</h2>
			<p>For reasonable mistakes, you'll get a warning in chat and/or via email, or a temporary ban. For anything very obviously not okay (unambiguous bigotry, open harassment, etc) or for ignoring warnings, your account may be banned permanently.</p>
			<p>If enough bad behavior is coming from the same network, you may receive a blanket IP ban.</p>
			<p>Don't make me do this. Seriously.</p>
			
			<h2>Questions or Concerns?</h2>
			<p>Contact <a href="mailto:admin@codecreature.net">admin@codecreature.net</a>.</p>
			
		</main>
	</section>
	
</body>
</html>