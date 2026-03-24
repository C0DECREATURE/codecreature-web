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

function getOldestLoadedMessage() {
	let messages = document.getElementsByClassName('message');
	let oldestMsg = 1;
	if (messages.length > 0) oldestMsg = Number(messages[messages.length - 1].id.replaceAll('message-',''));
	return oldestMsg;
}
function getLatestLoadedMessage() {
	let messages = document.getElementsByClassName('message');
	let latestMsg = 0;
	if (messages.length > 0) latestMsg = Number(messages[0].id.replaceAll('message-',''));
	return latestMsg;
}

var initialLoad = true;
function loadChat(repeat){
	let latestMsg = getLatestLoadedMessage();
	
	var content;
	$.get("/chat/loader.php?chat_table=" + chatTableName + "&from=" + latestMsg + "&timezone-offset=" + timezoneOffset, function(data){
			content = data;
			$('#messages').prepend(content);
			updateLoadOlder();
	});
	
	if (!initialLoad) {
		let messages = document.getElementsByClassName('message');
		for (let i = 0; i < messages.length; i++) {
			refreshMessage(messages[i].id.replaceAll('message-',''));
		}
	}
	
	initialLoad = false;
	if (repeat !== false) setTimeout(loadChat, 2000);
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