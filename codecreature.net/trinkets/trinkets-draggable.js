// Make the DIV element draggable:
dragElement(document.getElementById("drag-wrapper"));
//document.getElementById("drag-wrapper").addEventListener('touchstart',mouseDown,false);

/* whether the page can currently be dragged */
let pageDraggable = true;
console.log(pageDraggable);

function dragElement(elmnt) {
	var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
	// move the DIV from anywhere inside the DIV:
	elmnt.addEventListener('mousedown', dragMouseDown);
	elmnt.addEventListener('touchstart', dragMouseDown);

	function dragMouseDown(e) {
		if (pageDraggable) {
			e = e || window.event;
			e.preventDefault();
			// get the mouse cursor position at startup:
			pos3 = (e.clientX || e.targetTouches[0].pageX);
			pos4 = (e.clientY || e.targetTouches[0].pageY);
			document.ontouchend = closeDragElement;
			document.onmouseup = closeDragElement;
			// call a function whenever the cursor moves:
			document.ontouchmove = elementDrag;
			document.onmousemove = elementDrag;
		}
	}

	function elementDrag(e) {
		if (pageDraggable) {
			e = e || window.event;
			e.preventDefault();
			// calculate the new cursor position:
			pos1 = pos3 - (e.clientX || e.targetTouches[0].pageX);
			pos2 = pos4 - (e.clientY || e.targetTouches[0].pageY);
			pos3 = (e.clientX || e.targetTouches[0].pageX);
			pos4 = (e.clientY || e.targetTouches[0].pageY);
			// lock dragging to prevent going too far off screen
			let top = elmnt.offsetTop - pos2;
			let left = elmnt.offsetLeft - pos1;
			
			// get bottom right corner marker
			let bottomRightRect = document.getElementById("bottom-right-marker").getBoundingClientRect();
			// prevent dragging too far up
			let curTop = Number(elmnt.style.top.replaceAll("px",""));
			let maxTopMove = bottomRightRect.bottom - window.innerHeight;
			top = Math.max(top, curTop-maxTopMove);
			// prevent dragging too far left
			let curLeft = Number(elmnt.style.left.replaceAll("px",""));
			let maxLeftMove = bottomRightRect.right - window.innerWidth;
			left = Math.max(left, curLeft-maxLeftMove);
			// prevent dragging too far down
			top = Math.min(top, 0);
			// prevent dragging too far right
			left = Math.min(left, 0);
			
			//if (bottomRightRect.left > 0) { left = Math.min(Number(elmnt.style.left.replaceAll("px","")), left); }
			// set the element's new position:
			elmnt.style.top = top + "px";
			elmnt.style.left = left + "px";
		}
	}

	function closeDragElement() {
		// stop moving when mouse button is released:
		document.onmouseup = null;
		document.ontouchstart = null;
		document.onmousemove = null;
		document.ontouchmmove = null;
	}
}