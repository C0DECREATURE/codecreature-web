// force strict mode
"use strict";

var draggables; // variable to hold all draggable elements

window.addEventListener('load', () => {
	draggables = document.getElementsByClassName('draggable');
	for (let i = 0; i < draggables.length; i++) {
		let d = draggables[i];
		d.style.zIndex = "" + i;
		// make element draggable
		dragElement(d);
	}
});

// Make the given element draggable
function dragElement(elmnt) {
	var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
	
	// set selectable area to drag element with
	if (elmnt.querySelector("#dragzone")) {
		// if present, the header is where you move the DIV from:
		elmnt.querySelector("#dragzone").onmousedown = dragMouseDown;
	} else {
		// otherwise, move the DIV from anywhere inside the DIV:
		elmnt.onmousedown = dragMouseDown;
	}
	
	function dragMouseDown(e) {
		elmnt.style.position = "absolute";
		e = e || window.event;
		e.preventDefault();
		// bring element to the front
		if ( Number(elmnt.style.zIndex) < draggables.length) {
			// get the current z index of element
			let curZ = Number(elmnt.style.zIndex);
			// bring element to front
			elmnt.style.zIndex = "" + draggables.length;
			// move all elements above this one down by one
			for (let i = 0; i < draggables.length; i++) {
				let d = draggables[i];
				let dZ = Number(d.style.zIndex);
				if (dZ > curZ) { d.style.zIndex = dZ - 1; }
			};
		}
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
		// set the element's new position:
		elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
		elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
	}
	
	function closeDragElement() {
		// stop moving when mouse button is released:
		document.onmouseup = null;
		document.onmousemove = null;
	}
}