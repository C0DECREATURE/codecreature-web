const thumbnail = {
	// thumbnail size bounds
	maxW: ()=>{ return Math.min(boxWrapper.offsetWidth, boxWrapper.offsetHeight); },
	maxWPercent: ()=>{ return (thumbnail.maxW() / boxWrapper.offsetWidth) * 100; },
	minW: ()=>{ return 150; },
	minWPercent: ()=>{
		return Math.min(100, (thumbnail.minW() / document.getElementById("full-size-image").offsetWidth) * 100);
	},
	// thumbnail default values
	default: { x: 0, y: 0, w: 100 },
	// show/hide the thumbnail box indicator
	hide: ()=>{ box.classList.add("hidden"); },
	show: ()=>{ box.classList.remove("hidden"); },
	// reset the thumbnail box size and position to default
	reset: ()=>{
		if (box.dataset.width) thumbnail.default.w = box.dataset.width;
		if (box.dataset.top) thumbnail.default.y = box.dataset.top;
		if (box.dataset.left) thumbnail.default.x = box.dataset.left;
		thumbnail.resize(thumbnail.default.w);
		thumbnail.repositionPercent(thumbnail.default.x, thumbnail.default.y);
	},
	// move box by given pixel amounts
	reposition: (x, y)=>{
		x = x / boxWrapper.offsetWidth;
		y = y / boxWrapper.offsetHeight;
		var minX = 0;
		var minY = 0;
		var maxX = (boxWrapper.offsetWidth - box.offsetWidth) / boxWrapper.offsetWidth;
		var maxY = (boxWrapper.offsetHeight- box.offsetHeight) / boxWrapper.offsetHeight;
		box.style.left = (Math.min(maxX,Math.max(minX,x)) * 100) + '%';
		box.style.top = (Math.min(maxY,Math.max(minY,y)) * 100) + '%';
	},
	// move box to given percentage coordinates
	repositionPercent: (x,y)=>{
		x = (x / 100) * boxWrapper.offsetWidth;
		y = (y / 100) * boxWrapper.offsetHeight;
		thumbnail.reposition(x,y);
	},
	// resize box to given percentage
	resize: (w)=>{
		//console.log(thumbnail.minWPercent());
		box.style.width = Math.max(thumbnail.minWPercent(),Math.min(thumbnail.maxWPercent(),w)) + '%';
	},
	// set form input values for current thumbnail state
	setValues: ()=>{
		var w = Number(box.style.width.replace("%",""));
		var valueX = w == 0 ? 0 : Math.round((Number(box.style.left.replace("%","")) / w) * -100);
		var valueY = w == 0 ? 0 : Math.round((Number(box.style.top.replace("%","")) / w) * -100);
		var valueW = w == 0 ? 100 : Math.round(10000 / w);
		document.getElementById("input-thumbnail").value =
			valueX + ","
			+ valueY  + ","
			+ valueW;
	},
}
var box = document.getElementById("thumbnail-dragbox");
var boxWrapper = document.getElementById("edit-thumbnail");

var initX, initY, mousePressX, mousePressY, initW;

// drag support
box.addEventListener('mousedown', function (event) {
	if (event.target.className.indexOf("dot") > -1) {
		return;
	}

	initX = this.offsetLeft;
	initY = this.offsetTop;
	mousePressX = event.clientX;
	mousePressY = event.clientY;
	
	function eventMoveHandler(event) {
		thumbnail.reposition(
			initX + (event.clientX - mousePressX),
			initY + (event.clientY - mousePressY)
		);
	}
	
	boxWrapper.addEventListener('mousemove', eventMoveHandler, false);
	
	window.addEventListener('mouseup', function () {
		boxWrapper.removeEventListener('mousemove', eventMoveHandler, false);
		thumbnail.setValues();
	}, false);

}, false);
// done drag support

// handle resize
function resizeHandler(event, left = false, top = false, resize = false) {
	initX = box.offsetLeft;
	initY = box.offsetTop;
	mousePressX = event.clientX;
	mousePressY = event.clientY;
	
	// largest size the thumbnail can be
	maxW = thumbnail.maxW();
	initW = box.offsetWidth;

	function eventMoveHandler(event) {
		var wDiff = event.clientX - mousePressX;
		var hDiff = event.clientY - mousePressY;
		
		if (!top) hDiff *= -1; 
		if (!left) wDiff *= -1; 
		
		var newW = initW, newX = initX, newY = initY;
		
		if (resize) {
			if (left) newX += wDiff;
			if (top) newY += hDiff;
			newW -= (wDiff + hDiff) / 2;
		}
		
		thumbnail.resize((newW / maxW) * 100);
		thumbnail.reposition(newX, newY);
	}
	
	window.addEventListener('mousemove', eventMoveHandler, false);
	
	window.addEventListener('mouseup', function () {
		window.removeEventListener('mousemove', eventMoveHandler, false);
		thumbnail.setValues();
	}, false);
}

// only bottom right behaves 100% correctly so i'm just hiding the others for now
//document.getElementById("left-top").addEventListener('mousedown', e => resizeHandler(e, true, true, true));
//document.getElementById("right-top").addEventListener('mousedown', e => resizeHandler(e, false, true, true));
document.getElementById("right-bottom").addEventListener('mousedown', e => resizeHandler(e, false, false, true));
//document.getElementById("left-bottom").addEventListener('mousedown', e => resizeHandler(e, true, false, true));

thumbnail.reset();
document.getElementById("thumbnail-image").addEventListener("load",()=>{
	thumbnail.reset();
	thumbnail.show();
});