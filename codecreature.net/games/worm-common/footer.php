
<footer id="main-footer">
	<a id="user" href="/user" >
		<?php echo $logged_in ? $_SESSION["username"] : 'log in'; ?>
	</a>
	
	/
	
	<button id="open-chatbox">chat</button>
	
	<div id="chat-notification" class="hidden">0</div>
	
	<div id="chatbox" class="hidden">
		<header>
			<span id="chat-title">Worm Chat</span>
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
			
			let defaultPageTitle = document.title;
			let notification = document.getElementById('chat-notification');
			let unreadMessages = 0;
					
			function checkIframeLoaded() {
				let iFrameDoc = iFrame.contentDocument || iFrame.contentWindow.document;
				if (iFrameDoc && iFrameDoc.readyState == 'complete') showIframe();
				else window.setTimeout(checkIframeLoaded, 100);
			}
			function showIframe() {
				// show the iframe, hide "loading" screen
				iFrame.classList.remove('hidden');
				chatWrapper.querySelector('.iframe-load-preview').classList.add('hidden');
				// clear unread message notifications
				resetUnreadCount();
			}
			function chatButtonClicked() {
				chatWrapper.classList.toggle('hidden');
				// hide any new message notifications
				notification.classList.add('hidden');
				// if this is the first time opening the chat
				if (!chatboxLoaded) {
					chatboxLoaded = true;
					iFrame.src = "/chat/worms";
					window.setTimeout(checkIframeLoaded, 300);
				}
				// if this isn't the first time opening chat, just show it
				else if (!chatWrapper.classList.contains('hidden')) showIframe();
			}
			document.getElementById('chat-button').addEventListener('click',chatButtonClicked);
			document.getElementById('open-chatbox').addEventListener('click',chatButtonClicked);
			// reset unread message count and display
			function resetUnreadCount() {
				iFrame.contentWindow.postMessage("resetUnread", '*');
				unreadMessages = 0;
				notification.innerHTML = unreadMessages;
			}
			
			// detect when new messages sent
			window.onmessage = function(e) {
				data = JSON.parse(e.data);
				if (data.type == 'newMessage') {
					// if the chat window is hidden, add notification popup
					if (chatWrapper.classList.contains('hidden')) {
						unreadMessages = data.unread;
						notification.innerHTML = unreadMessages;
						notification.classList.remove('hidden');
					}
					// if the window isn't open/focused, update title to reflect unread messages
					if (!document.hasFocus()) {
						unreadMessages = data.unread;
						document.title = unreadMessages + " new message" + (unreadMessages == 1 ? "" : "s");
					}
				} else if (data.type == 'newChatroom') {
					document.getElementById('chat-title').innerHTML = data.name + " Chat";
				}
			};
			// on window focus, reset page title
			window.addEventListener("focus",()=>{
				document.title = defaultPageTitle;
				if (!chatWrapper.classList.contains('hidden')) resetUnreadCount();
			});
		})();
	</script>
</footer>