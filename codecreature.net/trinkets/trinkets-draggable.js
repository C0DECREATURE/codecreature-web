// Make the element draggable:
dragElement(document.getElementById("drag-wrapper"));

/* whether the page can currently be dragged */
let pageDraggable = true;
 
function dragElement(elmnt) {
	// move the DIV from anywhere inside the DIV:
	elmnt.addEventListener('mousedown', dragMouseDown);
	elmnt.addEventListener('touchstart', dragMouseDown);

	function dragMouseDown(e) {
		if (pageDraggable) {
			e = e || window.event;
			e.preventDefault();
			// get the mouse cursor position at startup:
			startX = (e.clientX || e.targetTouches[0].pageX);
			startY = (e.clientY || e.targetTouches[0].pageY);
			document.addEventListener('mouseup', closeDragElement);
			document.addEventListener('touchend', closeDragElement);
			// call a function whenever the cursor moves:
			document.addEventListener('touchmove', elementDrag);
			document.addEventListener('mousemove', elementDrag);
		}
	}

	function elementDrag(e) {
		if (pageDraggable) {
			e = e || window.event;
			e.preventDefault();
			// calculate the change in cursor position:
			dx = (e.clientX || e.targetTouches[0].pageX) - startX;
			dy = (e.clientY || e.targetTouches[0].pageY) - startY;
			// set the element's new position:
			elmnt.scrollTop = elmnt.scrollTop - (dy / 3);
			elmnt.scrollLeft = elmnt.scrollLeft - (dx / 3);
		}
	}

	function closeDragElement() {
		// stop moving when button/touch is over
		document.removeEventListener('mouseup', closeDragElement);
		document.removeEventListener('touchend', closeDragElement);
		document.removeEventListener('touchmove', elementDrag);
		document.removeEventListener('mousemove', elementDrag);
	}
}