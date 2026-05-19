// Make the element draggable:
dragElement(document.getElementById("drag-wrapper"));

/* whether the page can currently be dragged */
let pageDraggable = true;

//let pos = { top: 0, left: 0, x: 0, y: 0 };
/* 
function dragScrollElement(ele) {
	
	ele.addEventListener('mousedown', mouseDownHandler);
	ele.addEventListener('touchstart', mouseDownHandler);

	function mouseDownHandler(e) {
		pos = {
			// current scroll
			left: ele.scrollLeft,
			top: ele.scrollTop,
			// current mouse pos
			x: e.clientX,
			y: e.clientY,
		};
		document.addEventListener('mousemove', mouseMoveHandler);
		document.addEventListener('mouseup', mouseUpHandler);
	};
	function mouseMoveHandler(e) {
		// How far the mouse has been moved
		const dx = e.clientX - pos.x;
		const dy = e.clientY - pos.y;

		// Scroll the element
		ele.scrollTop = pos.top - dy;
		ele.scrollLeft = pos.left - dx;
	};
	// reset on mouseup
	function mouseUpHandler() {
		document.removeEventListener('mousemove', mouseMoveHandler);
		document.removeEventListener('mouseup', mouseUpHandler);
	};
} */

 
function dragElement(elmnt) {
	elmnt.scrollLeft = 0;
	elmnt.scrollTop = 0;
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
			let curTop = Number(elmnt.scrollTop);
			let maxTopMove = bottomRightRect.bottom - window.innerHeight;
			top = Math.max(top, curTop-maxTopMove);
			// prevent dragging too far left
			let curLeft = Number(elmnt.scrollLeft);
			let maxLeftMove = bottomRightRect.right - window.innerWidth;
			left = Math.max(left, curLeft-maxLeftMove);
			// prevent dragging too far down
			top = Math.min(top, 0);
			// prevent dragging too far right
			left = Math.min(left, 0);
			
			//if (bottomRightRect.left > 0) { left = Math.min(Number(elmnt.style.left.replaceAll("px","")), left); }
			// set the element's new position:
			elmnt.scrollTop = top;
			elmnt.scrollLeft = left;
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