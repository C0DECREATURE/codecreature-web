
<footer id="main-footer">
	<a id="user" href="/user" >
		<?php echo $logged_in ? $_SESSION["username"] : 'log in'; ?>
	</a>
	
	/
	
	<button id="open-chatbox">chat</button>
	<div id="chatbox" class="hidden">
		<header>
			Worm Chat
			<button id="chat-button">—</button>
		</header>
		<iframe id="chat-iframe"></iframe>
		<div class="iframe-load-preview">Loading...</div>
	</div>
	<script>
		(()=>{
			let chatboxLoaded = false;
			function chatButtonClicked() {
				if (!chatboxLoaded) {
					chatboxLoaded = true;
					document.getElementById('chat-iframe').src = "/chat/worms";
					document.getElementById('chatbox').querySelector('.iframe-load-preview').classList.add('hidden');
				}
				document.getElementById('chatbox').classList.toggle('hidden');
			}
			document.getElementById('chat-button').addEventListener('click',chatButtonClicked);
			document.getElementById('open-chatbox').addEventListener('click',chatButtonClicked);
		})();
	</script>
</footer>