// Make the DIV element draggable:
dragElement(document.getElementById("drag-wrapper"));
//document.getElementById("drag-wrapper").addEventListener('touchstart',mouseDown,false);

/* whether the page can currently be dragged */
let pageDraggable = true;
console.log(pageDraggable);

function dragElement(elmnt) {
	
	var dx = 0, dy = 0, mouseX = 0, mouseY = 0;
	// move the DIV from anywhere inside the DIV:
	elmnt.addEventListener('mousedown', dragMouseDown);
	elmnt.addEventListener('touchstart', dragMouseDown);
	document.addEventListener('keydown', function(e) {
		if (pageDraggable) {
			e = e || window.event;
			
			let keyDragSpeed = 10;
			if (e.code == "ArrowRight" || e.code == "ArrowLeft" || e.code == "ArrowUp" || e.code == "ArrowDown") e.preventDefault();
			if (e.code == "ArrowRight") dragElementBy(keyDragSpeed,0);
			if (e.code == "ArrowLeft") dragElementBy(keyDragSpeed * -1,0);
			if (e.code == "ArrowUp") dragElementBy(0,keyDragSpeed * -1);
			if (e.code == "ArrowDown") dragElementBy(0,keyDragSpeed);
		}
	});

	function dragMouseDown(e) {
		if (pageDraggable) {
			e = e || window.event;
			e.preventDefault();
			// get the mouse cursor position at startup:
			mouseX = (e.clientX || e.targetTouches[0].pageX);
			mouseY = (e.clientY || e.targetTouches[0].pageY);
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
			dx = mouseX - (e.clientX || e.targetTouches[0].pageX);
			dy = mouseY - (e.clientY || e.targetTouches[0].pageY);
			mouseX = (e.clientX || e.targetTouches[0].pageX);
			mouseY = (e.clientY || e.targetTouches[0].pageY);
			dragElementBy(dx,dy);
		}
	}
	
	function dragElementBy(dx,dy) {
		// lock dragging to prevent going too far off screen
		let top = elmnt.offsetTop - dy;
		let left = elmnt.offsetLeft - dx;
		
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
		
		let defaultScale = .07;
		let parallaxElements = document.querySelectorAll('.parallax,.window-scene');
		for (let i = 0; i < parallaxElements.length; i++) {
			let el = parallaxElements[i];
			let bgs = window.getComputedStyle(el, false).backgroundImage.split(",");
			let elScale = el.dataset.parallaxScale ? el.dataset.parallaxScale : defaultScale;
			// farthest background doesn't move
			let bgPos = `0px 0px`;
			// parallax-reverse = as backgrounds get closer to foreground, they move LESS
			if (el.classList.contains('parallax-reverse')) {
				for (let b = 1; b < bgs.length; b++) { bgPos = `${bgPos}, ${left*(elScale/b)}px ${top*(elScale/b)}px`; }
			// default: as backgrounds get closer to foreground, they move MORE
			} else {
				for (let b = bgs.length; b > 1; b--) { bgPos = `${left*(elScale/b)}px ${top*(elScale/b)}px, ${bgPos}`; }
			}
			// set the element style
			parallaxElements[i].style.backgroundPosition = bgPos;
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