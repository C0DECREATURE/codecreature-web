
<footer id="main-footer">
	<a id="user" href="/user" >
		<?php echo $logged_in ? $_SESSION["username"] : 'log in'; ?>
	</a>
	
	<button id="open-chatbox" onclick="toggleChatbox();">chat</button>
	<div id="chatbox" class="hidden">
		<header>
			Worm Chat
			<button onclick="toggleChatbox();">—</button>
		</header>
		<iframe src="/chat/worms"></iframe>
	</div>
	<script>
		function toggleChatbox() { document.getElementById('chatbox').classList.toggle('hidden'); }
	</script>
</footer>