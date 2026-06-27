function hideRightClickMenus() {
	let menus = document.getElementsByClassName('right-click-menu');
	for (let i = 0; i < menus.length; i++) { menus[i].classList.add("hidden"); }
}

function messageRightClick(e,id,ownMessage) {
	e.preventDefault();
	hideRightClickMenus();
	// show/hide the message edit option
	let canEdit = ownMessage && loggedIn;
	let editOpt = document.getElementById("right-click-edit");
	if (canEdit) editOpt.classList.remove('hidden'); else editOpt.classList.add('hidden');
	// show/hide the message delete option
	let canDelete = loggedIn && (ownMessage || userAuth == "moderator" || userAuth == "admin");
	let deleteOpt = document.getElementById("right-click-delete");
	if (canDelete) deleteOpt.classList.remove('hidden'); else deleteOpt.classList.add('hidden');
	// show/hide the message report option
	let canReport = !ownMessage;
	let reportOpt = document.getElementById("right-click-report");
	if (canReport) reportOpt.classList.remove('hidden'); else reportOpt.classList.add('hidden');
	// show/hide the ban user option
	let canBan = !ownMessage && loggedIn && (userAuth == "moderator" || userAuth == "admin");
	let banOpt = document.getElementById("right-click-ban");
	if (canBan) banOpt.classList.remove('hidden'); else banOpt.classList.add('hidden');
	// display the right click menu
	let menu = document.getElementById("right-click-menu");
	menu.classList.remove('hidden');
	menu.style.left = Math.min(e.pageX, window.innerWidth - $(menu).outerWidth(true)) + "px";
	menu.style.top = Math.min(e.pageY, window.innerHeight - $(menu).outerHeight(true)) + "px";
	menu.dataset.messageId = id;
}

// whether a message is currently being sent
var sendingMessage = false;
// submit new message
function sendMessage(message) {
	if (!sendingMessage) {
		sendingMessage = true;
		const xhr = new XMLHttpRequest();
		xhr.open("POST", "/chat/send-message.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		// do stuff when request finishes
		xhr.onreadystatechange = () => {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				sendingMessage = false;
				document.getElementById('new-message-submit').disabled = false;
				if (xhr.responseText != '') {
					let response = JSON.parse(xhr.responseText);
					// if an error occurred, give an alert with error message
					if (response["error"] && response["error"] != '') alert('Error sending message:\n' + response["error"]);
					// if sending was successful, clear input and load new chat messages
					else {
						document.getElementById('message-input').value = "";
						loadChat(false);
					}
				} else {
					alert("Something went wrong! Try again later.");
				}
			}
		};
		// send the variables
		xhr.send(`chat-table=${chatTableName}&message=${encodeURIComponent(message)}`);
	}
}

// copy message text with given id
function copyMessage(id) {
	let msg = document.getElementById(`message-${id}`);
	if (msg) {
		// make a temporary copy of the message
		let el = msg.querySelector('.content').cloneNode(true);
		// delete screen reader only content from the copy
		let hiddenContent = el.getElementsByClassName('sr-only');
		for (let i = 0; i < hiddenContent.length; i++) { hiddenContent[i].remove(); }
		// copy the modified display text of the temporary copy
		navigator.clipboard.writeText(el.innerText);
		// delete the copy
		el.remove();
	}
}

// copy message text with given id
function copyMessageBbcode(id) {
	let msg = document.getElementById(`message-${id}`);
	if (msg) navigator.clipboard.writeText(msg.dataset.rawBbcode);
}

// array of message ids currently being modified
var modifyingMessages = [];
// edit message with given id
// replaces existing message body with new string
function editMessage(id,newText) {
	if (modifyingMessages[id] == null) {
		modifyingMessages[id] = true;
		const xhr = new XMLHttpRequest();
		xhr.open("POST", "/chat/edit-message.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		// do stuff when request finishes
		xhr.onreadystatechange = () => {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				modifyingMessages[id] = null;
				if (xhr.responseText != '') {
					let response = JSON.parse(xhr.responseText);
					// if an error occurred, give an alert with error message
					if (response["error"] && response["error"] != '') alert('Error editing message:\n' + response["error"]);
					// if editing was successful, update the message element
					else refreshMessage(id);
				} else {
					alert("Something went wrong! Try again later.");
				}
			}
		};
		// send the variables
		xhr.send(`message-id=${id}&chat-table=${chatTableName}&new-message=${newText}`);
	}
}

// delete message with given id
function deleteMessage(id) {
	if (modifyingMessages[id] == null) {
		modifyingMessages[id] = true;
		const xhr = new XMLHttpRequest();
		xhr.open("POST", "/chat/delete-message.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		// do stuff when request finishes
		xhr.onreadystatechange = () => {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				modifyingMessages[id] = null;
				// if an error occurred, give an alert with error message
				if (xhr.responseText != '') alert('Error deleting message:\n' + xhr.responseText);
				// if deleting was successful, delete the message element
				else deleteLocalMessage(id);
			}
		};
		// send the variables
		xhr.send(`message-id=${id}&chat-table=${chatTableName}`);
	}
}

// check if newer sibling message exists and is by the same user as the given message
function newerStackSibling(message) {
	let sib = message.previousElementSibling;
	if (sib && isStackSiblings(message,sib)) {
		return sib;
	} else return false;
}
// check if older sibling message exists and is by the same user as the given message
function olderStackSibling(message) {
	let sib = message.nextElementSibling;
	if (sib && isStackSiblings(message,sib)) {
		return sib;
	} else return false;
}
// check if two messages are by the same user and posted close together in time
function isStackSiblings(m1,m2) {
	return m1.dataset.uid !== "0"
		&& m1.dataset.uid == m2.dataset.uid
		&& Math.abs(Number(m1.dataset.timestamp) - Number(m2.dataset.timestamp)) < 3600 // less than 1 hour apart
}

// delete the LOCAL HTML element of a message only (no permission check required)
function deleteLocalMessage(id) {
	let message = document.getElementById('message-'+id);
	// put in 'deleted' placeholder
	let del = document.createElement('div');
	del.classList.add('message','deleted');
	del.id = 'message-'+id;
	if (message.classList.contains('self')) del.classList.add('self');
	del.innerHTML = "(message deleted)";
	message.after(del);
	// delete the element
	message.remove();
	// check if this message is part of a stack by a single user
	updateMessageStackStatus(id);
}

// report message with given id
function reportMessage(id) {
	const xhr = new XMLHttpRequest();
	xhr.open("POST", "/chat/report-message.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	// do stuff when request finishes
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			// alert with the response
			if (xhr.responseText != '') alert(xhr.responseText);
			else alert('Error: No response. Try again later.');
		}
	};
	// send the variables
	xhr.send(`message-id=${id}&chat-table=${chatTableName}`);
}


// report message with given id
function banMessageAuthor(id,reason,duration,includeIP) {
	console.log('Banning author of message #' + id + '...'); // DEBUG temp
	
	if (typeof reason == "undefined") { reason = "None given." }
	
	const xhr = new XMLHttpRequest();
	xhr.open("POST", "/chat/ban-message.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	// do stuff when request finishes
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			// alert with the response
			if (xhr.responseText != '') alert(xhr.responseText);
			else alert('Error: No response. Try again later.');
		}
	};
	// send the variables
	xhr.send(`message-id=${id}&chat-table=${chatTableName}&ban-reason=${reason}&ban-duration=${duration}&include-IP=${includeIP}`);
}

function refreshMessage(id) {
	id = Number(id);
	let getVars = "chat_table=" + chatTableName + "&message_id=" + id + "&timezone-offset=" + timezoneOffset;
	var content;
	$.get("/chat/loader.php?" + getVars, function(data){
			let message = document.getElementById(`message-${id}`);
			message.id = "";
			// insert the refreshed message
			message.insertAdjacentHTML("afterend",data);
			// delete the original
			message.remove();
			// run setup on the refreshed message
			let refreshedMessage = document.getElementById(`message-${id}`);
			messageSetup(id);
	});
}

function messageSetup(id) {
	let message = document.getElementById(`message-${id}`);
	if (message && !message.classList.contains('deleted')) {
		message.querySelector('.date-text').innerHTML = formatMessageDisplayDate(message.dataset.timestamp);
		// assign text and alt text for all typing quirk elements in the message that was just loaded
		tqAlts(message);
		// open special message right click menu on right clicking message
		message.querySelector('.bubble').addEventListener("contextmenu",(e)=>{
			messageRightClick(e,id,message.classList.contains('self'));
		});
		// check if this message is part of a stack by a single user
		updateMessageStackStatus(id);
	} else if (!message) {
		console.error(`Could not locate message with id = ${id} in the DOM`);
	}
}

// updates whether the message is in a stack of messages by the same user
function updateMessageStackStatus(id,updateSiblings) {
	if (typeof id == 'string') id = id.replaceAll('message-','');
	let message = document.getElementById(`message-${id}`);
	
	if (message) {
		// update its siblings
		if (updateSiblings !== false) {
			if (message.nextElementSibling) updateMessageStackStatus(message.nextElementSibling.id,false);
			if (message.previousElementSibling) updateMessageStackStatus(message.previousElementSibling.id,false);
		}
		if (!message.classList.contains('deleted')) {
			let nSS = newerStackSibling(message);
			let oSS = olderStackSibling(message);
			// if it's in a stack
			if (nSS || oSS) {
				message.classList.add('stack');
				// if it's at the top of a stack
				if (nSS) { message.classList.add('stack-top'); }
				// if it's not at the top of a stack
				if (oSS) { message.classList.remove('stack-top'); }
			} else {
				message.classList.remove('stack','stack-top');
			}
		}
	} else {
		console.error(`Could not locate message with id = ${id} in the DOM`);
	}
}

function formatMessageDisplayDate(seconds) {
	let date = new Date(Number(seconds) * 1000);
	let curDate = new Date();
	// get the composite parts
	let year = date.getFullYear();
	let month = date.getMonth() + 1;
	let day = date.getDate();
	let hour = date.getHours();
	let minute = date.getMinutes();
	// figure out how much detail to show
	let show = 'hour';
	if (curDate.getFullYear() !== year) show = 'year';
	else if (curDate.getDate() !== day) show = 'day';
	// modify year to 2 digit format
	year = year.toString().substring(2);
	// modify hour into am/pm format
	let ampm = hour < 12 ? "am" : "pm";
	hour = hour > 12 ? hour - 12 : hour == 0 ? 12 : hour;
	// prepend zero to single digit minutes
	minute = minute < 10 ? "0"+minute : minute;
	// return text string
	let str = `${hour}:${minute}${ampm}`;
	if (show == 'year') str = `${year}/${month}/${day} ${str}`;
	else if (show == 'day') str = `${month}/${day} ${str}`;
	return str;
}