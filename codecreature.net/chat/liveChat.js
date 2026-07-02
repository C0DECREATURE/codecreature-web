// messages container element
var messageContainer;

$(document).ready(function(){    
	messageContainer = document.getElementById('messages');
	messageContainer.scrollTo(0, messageContainer.scrollHeight);
  loadChat();
});

Date.prototype.stdTimezoneOffset = function () {
	var jan = new Date(this.getFullYear(), 0, 1);
	var jul = new Date(this.getFullYear(), 6, 1);
	return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
}

let localDate = new Date();
let timezoneOffset = localDate.getTimezoneOffset() * 60;

// returns integer id of oldest message that has been loaded on the page
function getOldestLoadedMessage() {
	let messages = document.getElementsByClassName('message');
	let oldestMsg = 1;
	if (messages.length > 0) oldestMsg = Number(messages[messages.length - 1].id.replaceAll('message-',''));
	return oldestMsg;
}

// whether an initial set of messages has already been loaded on the page
var initialLoaded = false;
// whether a new set of messages is currently being loaded
var chatIsLoading = false;
// timestamp of last edit check
var lastEditCheck = Date.now() / 1000;
// load all new messages
function loadChat(repeat){
	if ((typeof sendingMessage == 'undefined' || sendingMessage == false) && chatIsLoading == false) {
		chatIsLoading = true;
		
		let messages = document.getElementsByClassName('message','deleted');
		let latestMsgId = 0;
		if (messages.length > 0) latestMsgId = Number(messages[0].id.replaceAll('message-',''));
		
		let getVars = "chat_table=" + chatTableName + "&from=" + latestMsgId + "&timezone-offset=" + timezoneOffset;
		var content;
		$.get("/chat/loader.php?" + getVars, function(data){
				content = data;
				$('#messages').prepend(content);
				updateLoadOlder();
				// flag that loading is complete
				chatIsLoading = false;
		});
		
		if (initialLoaded) {
			const xhr = new XMLHttpRequest();
			xhr.open("POST", "/chat/check-edits.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			// do stuff when request finishes
			xhr.onreadystatechange = () => {
				if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
					if (xhr.responseText != "") {
						try {
							let editedMessages = JSON.parse(xhr.responseText);
							for (let i = 0; i < editedMessages.length; i++) {
								console.log('updating message id #'+editedMessages[i]);
								refreshMessage(editedMessages[i]);
							}
						} catch (error) {
							console.error(xhr.responseText);
						}
					}
				}
			};
			// send the variables
			xhr.send(`from=${getOldestLoadedMessage()}&since=${lastEditCheck}&chat-table=${chatTableName}`);
			// log the new last edit check time
			lastEditCheck = (Date.now() / 1000) - 5; // 5 seconds of extra just in case of lag
		} else {
			// flag that loading is complete
			chatIsLoading = false;
			// flag that initial message set has loaded
			initialLoaded = true;
		}
	}
	if (repeat !== false) setTimeout(loadChat, 4000);
}

function loadOlderChat() {
	document.getElementById('load-older').classList.add('hidden');
	
	let oldestMsg = getOldestLoadedMessage();
	
	$.get("/chat/loader.php?chat_table=" + chatTableName + "&to=" + oldestMsg + "&timezone-offset=" + timezoneOffset, function(data){
			content = data;
			$('#messages').append(content);
			updateLoadOlder();
	});
	
}
function updateLoadOlder() {
	if (oldestMessageId < getOldestLoadedMessage()) {
		document.getElementById('load-older').classList.remove('hidden');
	} else {
		document.getElementById('load-older').classList.add('hidden');
	}
}