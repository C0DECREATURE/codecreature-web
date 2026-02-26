// messages container element
var messageContainer;

$(document).ready(function(){    
	messageContainer = document.getElementById('messages');
	messageContainer.scrollTo(0, messageContainer.scrollHeight);
  loadChat();
});

// DEBUG: having difficulty figuring out how to get it to load ONLY new messages. ugh
function loadChat(){
	let messages = document.getElementsByClassName('message');
	let msgCount = 0;
	if (messages.length > 0) msgCount = messages[0].id.replaceAll('message-','');
	
	var content;
	$.get("/chat/loader.php?from=" + msgCount, function(data){
			content = data;
			$('#messages').prepend(content);
	});
	
	//$("#messages").load("/chat/loader.php?from=" + msgCount);
	setTimeout(loadChat, 2000);
}