function hideRightClickMenus() {
	let menus = document.getElementsByClassName('right-click-menu');
	for (let i = 0; i < menus.length; i++) { menus[i].classList.add("hidden"); }
}

function messageRightClick(e,id,ownMessage) {
	e.preventDefault();
	hideRightClickMenus();
	// show/hide the message edit option
	//let canEdit = ownMessage;
	let canEdit = false; // DEBUG - temp unti edit feature added
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
	menu.style.left = e.pageX + "px";
	menu.style.top = e.pageY + "px";
	menu.classList.remove('hidden');
	menu.dataset.messageId = id;
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