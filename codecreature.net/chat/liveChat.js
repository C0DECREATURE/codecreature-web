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

// DEBUG: having difficulty figuring out how to get it to load ONLY new messages. ugh
function loadChat(){
	let messages = document.getElementsByClassName('message');
	let msgCount = 0;
	if (messages.length > 0) msgCount = messages[0].id.replaceAll('message-','');
	
	let localDate = new Date();
	let timezoneOffset = (localDate.getTimezoneOffset() + 60) * 60;
	
	var content;
	$.get("/chat/loader.php?from=" + msgCount + "&timezone-offset=" + timezoneOffset, function(data){
			content = data;
			$('#messages').prepend(content);
	});
	
	setTimeout(loadChat, 2000);
}