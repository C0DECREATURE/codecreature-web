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
Date.prototype.isDstObserved = function () {
	return this.getTimezoneOffset() < this.stdTimezoneOffset();
}

function loadChat(){
	let messages = document.getElementsByClassName('message');
	let latestMsg = 0;
	if (messages.length > 0) latestMsg = messages[0].id.replaceAll('message-','');
	
	let localDate = new Date();
	let timezoneOffset = (localDate.getTimezoneOffset() + 60) * 60;
	
	var content;
	$.get("/chat/loader.php?from=" + latestMsg + "&timezone-offset=" + timezoneOffset, function(data){
			content = data;
			$('#messages').prepend(content);
	});
	
	setTimeout(loadChat, 2000);
}