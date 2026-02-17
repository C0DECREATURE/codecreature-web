<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>worm chat</title>
		<meta name="description" content="Worm games chat room">
		<meta name="keywords" content="worm, game, chat, forum, discussion, message">
		<meta name="author" content="codecreature">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20251216"></script>
		
		<!-- fonts -->
		<script>fonts.load('Comic Sans MS','Super Comic')</script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20251216" id="svg-icons-js"></script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		
		<!--chat stylesheet-->
		<link href="../chat.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
</head>
<body>
  <header><h2>Worm Chat</h2></header>
		
	<main>
		<section class="messages" id="messages">
			
			<!-- this is a sample message -->
			<div class="message" id="message-1">
				<img class="icon" src="/user/icons/worm_blue.png" alt="">
				<div class="bubble">
					<header>
						<span class="username">username</span>
						<span class="date">01/01/26</span>
					</header>
					<div class="content">
						this is the message content!
					</div>
				</div>
			</div>
			
			<!-- this is a sample message -->
			<div class="message" id="message-1">
				<img class="icon" src="/user/icons/worm_yellow.png" alt="">
				<div class="bubble">
					<header>
						<span class="username">user 2</span>
						<span class="date">01/01/26</span>
					</header>
					<div class="content">
						this is the message content!
					</div>
				</div>
			</div>
			
			<!-- this is a sample message FROM CURRENT USER -->
			<div class="message self" id="message-1">
				<img class="icon" src="/user/icons/worm_yellow.png" alt="">
				<div class="bubble">
					<header>
						<span class="username">itsMe</span>
						<span class="date">01/01/26</span>
					</header>
					<div class="content">
						this is the message content!
					</div>
				</div>
			</div>
		</section>
		
		<form id="send-message">
			<input type="text" name="message"></input>
		</form>
	</main>
		
</body></html>