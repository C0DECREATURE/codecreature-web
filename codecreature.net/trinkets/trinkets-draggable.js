// Make the DIV element draggable:
dragElement(document.getElementById("drag-wrapper"));

function dragElement(elmnt) {
	var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
	if (document.getElementById(elmnt.id + "header")) {
		// if present, the header is where you move the DIV from:
		document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
	} else {
		// otherwise, move the DIV from anywhere inside the DIV:
		elmnt.onmousedown = dragMouseDown;
	}

	function dragMouseDown(e) {
		e = e || window.event;
		e.preventDefault();
		// get the mouse cursor position at startup:
		pos3 = e.clientX;
		pos4 = e.clientY;
		document.onmouseup = closeDragElement;
		// call a function whenever the cursor moves:
		document.onmousemove = elementDrag;
	}

	function elementDrag(e) {
		e = e || window.event;
		e.preventDefault();
		// calculate the new cursor position:
		pos1 = pos3 - e.clientX;
		pos2 = pos4 - e.clientY;
		pos3 = e.clientX;
		pos4 = e.clientY;
		// lock dragging to prevent going too far off screen
		let top = elmnt.offsetTop - pos2;
		let left = elmnt.offsetLeft - pos1;
		// lock top left corner
		let topLeftRect = document.getElementById("top-left-marker").getBoundingClientRect();
		if (topLeftRect.top > 0) { top = Math.min(Number(elmnt.style.top.replaceAll("px","")), top); }
		if (topLeftRect.left > 0) { left = Math.min(Number(elmnt.style.left.replaceAll("px","")), left); }
		// lock bottom right corner
		let bottomRightRect = document.getElementById("bottom-right-marker").getBoundingClientRect();
		if (window.innerHeight - bottomRightRect.bottom > 0) {
			top = Math.max(Number(elmnt.style.top.replaceAll("px","")), top);
		}
		if (bottomRightRect.right - window.innerWidth < 0) {
			left = Math.max(Number(elmnt.style.left.replaceAll("px","")), left);
		}
		//if (bottomRightRect.left > 0) { left = Math.min(Number(elmnt.style.left.replaceAll("px","")), left); }
		// set the element's new position:
		elmnt.style.top = top + "px";
		elmnt.style.left = left + "px";
	}

	function closeDragElement() {
		// stop moving when mouse button is released:
		document.onmouseup = null;
		document.onmousemove = null;
	}
}