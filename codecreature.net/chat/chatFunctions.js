function hideRightClickMenus() {
	let menus = document.getElementsByClassName('right-click-menu');
	for (let i = 0; i < menus.length; i++) { menus[i].classList.add("hidden"); }
}

function messageRightClick(e,id,ownMessage) {
	e.preventDefault();
	hideRightClickMenus();
	// show/hide the message edit option
	let canEdit = ownMessage;
	let editOpt = document.getElementById("right-click-edit");
	if (canEdit) editOpt.classList.remove('hidden'); else editOpt.classList.add('hidden');
	// show/hide the message delete option
	let canDelete = ownMessage || userAuth == "moderator" || userAuth == "admin";
	let deleteOpt = document.getElementById("right-click-delete");
	if (canDelete) deleteOpt.classList.remove('hidden'); else deleteOpt.classList.add('hidden');
	// show/hide the message report option
	let canReport = !ownMessage;
	let reportOpt = document.getElementById("right-click-report");
	if (canReport) reportOpt.classList.remove('hidden'); else reportOpt.classList.add('hidden');
	// display the right click menu
	let menu = document.getElementById("right-click-menu");
	menu.classList.remove('hidden');
	menu.style.left = Math.min(e.pageX, window.innerWidth - $(menu).outerWidth(true)) + "px";
	menu.style.top = Math.min(e.pageY, window.innerHeight - $(menu).outerHeight(true)) + "px";
	menu.dataset.messageId = id;
}

// submit new message
function sendMessage(message) {
	const xhr = new XMLHttpRequest();
	xhr.open("POST", "/chat/send-message.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	// do stuff when request finishes
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
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
	xhr.send(`chat-table=${chatTableName}&message=${message}`);
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

// edit message with given id
// replaces existing message body with new string
function editMessage(id,newText) {
	const xhr = new XMLHttpRequest();
	xhr.open("POST", "/chat/edit-message.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	// do stuff when request finishes
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
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

// delete message with given id
function deleteMessage(id) {
	const xhr = new XMLHttpRequest();
	xhr.open("POST", "/chat/delete-message.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	// do stuff when request finishes
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			// if an error occurred, give an alert with error message
			if (xhr.responseText != '') alert('Error deleting message:\n' + xhr.responseText);
			// if deleting was successful, delete the message element
			else document.getElementById('message-'+id).remove();
		}
	};
	// send the variables
	xhr.send(`message-id=${id}&chat-table=${chatTableName}`);
}

// report message with given id
function reportMessage(id) {
	console.log('Reporting message #' + id + '...'); // DEBUG temp
	
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

function refreshMessage(id) {
	const xhr = new XMLHttpRequest();
	xhr.open("POST", "/chat/get-message.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	// do stuff when request finishes
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			if (xhr.responseText != '') {
				let message = JSON.parse(xhr.responseText);
				let el = document.getElementById(`message-${id}`);
				
				if (message["exists"] == "false") {
					let del = document.createElement('div');
					del.classList.add('deleted');
					if (el.classList.contains('self')) del.classList.add('self');
					del.innerHTML = "(message deleted)";
					el.after(del);
					el.remove();
				} else {
					let html = message["message-HTML"];
					el.querySelector('.content').innerHTML = html;
					tqAlts(el);
					
					if (message["edited"] && message["edited"] != '') el.querySelector('.edited').classList.remove('hidden');
					
					// update date display text
					el.querySelector('.date-text').innerHTML = formatMessageDisplayDate(message["date"]);
				}
			} else {
				alert(`Couldn't load message #${id}.`);
			}
		}
	};
	// send the variables
	xhr.send(`message-id=${id}&chat-table=${chatTableName}`);
}

function formatMessageDisplayDate(seconds) {
	let date = new Date(Number(seconds) * 1000);
	let curDate = new Date();
	// get the composite parts
	let year = date.getFullYear();
	let month = date.getMonth();
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