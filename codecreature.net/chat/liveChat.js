// messages container element
var messageContainer;

$(document).ready(function(){    
	messageContainer = document.getElementById('messages');
	messageContainer.scrollTo(0, messageContainer.scrollHeight);
  loadChat();
});

// DEBUG: having difficulty figuring out how to get it to load ONLY new messages. ugh
function loadChat(){
	$("#messages").load("/chat/loader.php");
	setTimeout(loadChat, 2000);
}