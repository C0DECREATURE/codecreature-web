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
// returns integer id of latest message that has been loaded on the page
function getLatestLoadedMessage() {
	let messages = document.getElementsByClassName('message');
	let latestMsg = 0;
	if (messages.length > 0) latestMsg = Number(messages[0].id.replaceAll('message-',''));
	return latestMsg;
}

// whether an initial set of messages has already been loaded on the page
var initialLoaded = false;
// load all new messages
function loadChat(repeat){
	let latestMsg = getLatestLoadedMessage();
	
	var content;
	$.get("/chat/loader.php?chat_table=" + chatTableName + "&from=" + latestMsg + "&timezone-offset=" + timezoneOffset, function(data){
			content = data;
			$('#messages').prepend(content);
			updateLoadOlder();
	});
	
	/* DEBUG temprarily removing this because I need to find a way that doesn't involve an insane number of POST requests
	
	// if an initial set of messages has been loaded, refresh the existing messages
	if (initialLoaded) {
		let messages = document.getElementsByClassName('message');
		for (let i = 0; i < messages.length; i++) {
			refreshMessage(messages[i].id.replaceAll('message-',''));
		}
	}
	
	*/
	
	initialLoaded = true;
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