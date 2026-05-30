
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
		<iframe id="chat-iframe" class="hidden"></iframe>
		<div class="iframe-load-preview">Loading...</div>
	</div>
	<script>
		(()=>{
			let chatboxLoaded = false;
			let iFrame = document.getElementById('chat-iframe');
			let chatWrapper = document.getElementById('chatbox');
					
			function checkIframeLoaded() {
				console.log('check');
				let iFrameDoc = iFrame.contentDocument || iFrame.contentWindow.document;
				if (iFrameDoc && iFrameDoc.readyState == 'complete') showIframe();
				else window.setTimeout(checkIframeLoaded, 100);
			}
			function showIframe() {
				iFrame.classList.remove('hidden');
				chatWrapper.querySelector('.iframe-load-preview').classList.add('hidden');
			}
			function chatButtonClicked() {
				chatWrapper.classList.toggle('hidden');
				if (!chatboxLoaded) {
					chatboxLoaded = true;
					iFrame.src = "/chat/worms";
					window.setTimeout(checkIframeLoaded, 300);
				}
				else showIframe();
			}
			document.getElementById('chat-button').addEventListener('click',chatButtonClicked);
			document.getElementById('open-chatbox').addEventListener('click',chatButtonClicked);
		})();
	</script>
</footer>