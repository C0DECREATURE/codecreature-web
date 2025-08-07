// get canvas element
const canvas = document.getElementById('toybox-canvas');
const ctx = canvas.getContext('2d');

// array holding all toys' info and locations
let toys = [
	{ name: "Brown Roger", src: "images/brown_roger", x: 100, y: 100, w: 100, h: 200 },
	{ name: "Alolan Rattata", src: "images/alolan_rattata", x: 400, y: 100, w: 140, h: 200 },
	{ name: "Munna", src: "images/munna", x: 100, y: 400, w: 110, h: 100 },
	{ name: "Aftonsparv", src: "images/aftonsparv", x: 400, y: 400, w: 110, h: 190 },
	{ name: "Snorunt", src: "images/snorunt", x:200, y: 200, w: 100, h: 100,
		toyRotations: ["", "_angle", "_side", "_back", "_side_reverse", "_angle_reverse"]
	}
];
// set initial values for toys
for (let i = 0; i < toys.length; i++) {
	toys[i].img = new Image();
	toys[i].img.src = toys[i].src + ".png";
	// if no z value set, default to stacking them in order of array position
	if ( toys[i].z == null ) { toys[i].z = i }
	// add empty outfit array to toy
	toys[i].outfit = [];
}

// current area that is open
var openArea;

// set canvas dimensions
canvas.width = 1000; canvas.w = canvas.width;
canvas.height = 700; canvas.h = canvas.height;
var offsetX = canvas.offsetLeft;
var offsetY = canvas.offsetTop;

// set side menu dimensions
var sideMenu = { w: 200, h: canvas.h, x: canvas.w - 200, y: 0, fill: "skyblue" };
// standard gap between side menu objects
sideMenu.gap = 20;
// side menu closet button
sideMenu.closet = { w: 180, h: 180, fill: "pink", text: "CLOSET\ndrag here!" };
sideMenu.closet.y = (sideMenu.w - sideMenu.closet.w) / 2;
sideMenu.closet.x = sideMenu.x + sideMenu.closet.y;
// side menu toy name
sideMenu.toyName = { w: sideMenu.w - (sideMenu.gap * 2), h: 50, fill: "pink" };
sideMenu.toyName.x = sideMenu.closet.x;
sideMenu.toyName.y = sideMenu.closet.y + sideMenu.closet.h + sideMenu.gap;
// side menu rotate button
sideMenu.rotate = { w: 90, h: 50, fill: "pink", text: "ROTATE" };
sideMenu.rotate.x = sideMenu.closet.x;
sideMenu.rotate.y = sideMenu.toyName.y + sideMenu.toyName.h + sideMenu.gap;

// set main play area dimensions
var playArea = { w: canvas.w - sideMenu.w, h: canvas.h, x: 0, y: 0 };

////////////////////////////////////////////////////////////////////////
// DRAWING ON CANVAS

// draw canvas elements on window load
window.addEventListener('load',()=>{ drawCanvas(); });

function drawCanvas() {
	if (openArea == "closet") drawClosetArea();
	else drawPlayArea();
}

// Redraw main play area
function drawSideMenu() {
	// fill side menu with color
	ctx.fillStyle = sideMenu.fill;
	ctx.fillRect(sideMenu.x, sideMenu.y, sideMenu.w, sideMenu.h);
	// draw given side menu area
	function drawSMArea(a,text) {
		// draw fill
		ctx.fillStyle = a.fill;
		ctx.fillRect(a.x, a.y, a.w, a.h);
		// draw text
		if (!text) { text = a.text; }
		if (text) {
			drawText({
				text: text,
				x: a.x + 2,
				y: a.y + (a.h / 2),
				color: "black",
				size: "20px"
			});
		}
	}
	// draw menu areas/buttons/etc
	drawSMArea(sideMenu.closet);
	// if a toy is selected, show its info/options
	if (curToy) {
		drawSMArea(sideMenu.toyName,curToy.name);
		// if toy can rotate, show rotate button
		if (curToy.toyRotations) { drawSMArea(sideMenu.rotate); }
	}
}

// Redraw main play area
function drawPlayArea() {
	openArea = "play";
	// draw side menu
	drawSideMenu();
  // Clear the play area
  ctx.clearRect(playArea.x, playArea.y, playArea.w, playArea.h);
	// Sort toys by Z position
	let toysZOrder = [];
	// Draw each toy in toys array
	for (var i = 0; i < toys.length; i++) {
		toysZOrder[toys[i].z] = i;
	}
	// draw all toys in z order from lowest to highest
	for (var i = 0; i < toysZOrder.length; i++) {
		drawToy( toys[toysZOrder[i]] );
	}
}

////////////////////////////////////////////////////////////////////////
// SHARED BASE DRAW FUNCTIONS

// draw given object on canvas at its defined x/y and width/height values
function drawObject(obj) {
	ctx.drawImage(obj.img, obj.x, obj.y, obj.w, obj.h);
}
// draw given object within given draw area
// if object exceeds area, prevent it from going over the edge
// if no draw area given, default area is canvas
function drawContainedObject(obj,drawArea) {
	if (!drawArea) { drawArea = canvas; }
	// Prevent overlap with the edge
	if (obj.x > drawArea.w - obj.w) { obj.x = drawArea.w - obj.w; }
	else if (obj.x < 0) { obj.x = 0; }
	// draw the object at its updated position
	drawObject(obj);
}

function drawToy(t) {
	drawContainedObject(t);
	// if toy has an outfit defined, draw the outfit items
	for (let i = 0; i < t.outfit.length; i++) {
		oItem = t.outfit[i];
		oItem.x = t.x + oItem.rX;
		oItem.y = t.y + oItem.rY;
		drawObject(oItem);
	}
}

// rotate given toy t
// if optional direction argument = "reverse", rotate counterclockwise
// otherwise rotate clockwise
function rotateToy(t,direction) {
	if (t && t.toyRotations) {
	// if rotation not set, default to 0
	if (!t.r) { t.r = 0; }
	// set new rotation value and console log text
	let logText = t.name + " rotated";
	if (direction && direction == "reverse") {
		t.r -= 1;
		logText += " counterclockwise";
	}
	else {
		t.r += 1;
		logText += " clockwise";
	}
	// validate rotation Number
	if (t.r < 0) { t.r = t.toyRotations.length; }
	else if (t.r >= t.toyRotations.length) { t.r = 0; }
	// set toy rotation image
	t.img.src = t.src + t.toyRotations[t.r] + ".png";
	// log rotation
	console.log(logText);
	} else {
		let errorText = "rotateToy failed.";
		if (!t) { errorText += " No toy provided."; }
		else if (!t.toyRotations) { errorText += " " + t.name + " cannot rotate."; }
		console.log(errorText);
	}
}

/* draw the given text args.text on the canvas
// REQUIRED: text, x, y
// OPTIONAL: color, font, size, align
// SAMPLE:
drawText({
	text: "",
	x: 0, y: 0,
	color: "black",
	font: "Arial",
	size: "20px",
	align: "center"
});
*/
function drawText(args) {
	// if arguments given with text parameter
	if (args && args.text && args.x && args.y) {
		// DISPLAY PROPERTIES
		// font color
		if (args.color) { ctx.fillStyle = args.color; }
		// font & size
		let font = args.font;
		let size = args.size;
		if (font || size) {
			if (!font) font = "Arial";
			if (!size) size = "20px";
			ctx.font = size + " " + font;
		}
		// horizontal alignment
		if (args.align) { ctx.textAlign = args.align; }
		
		// text string(s)
		let lines = args.text.split('\n');
		let h = Number(args.size.replaceAll("px",""));
		for (let i = 0; i < lines.length; i++) {
			// if this isn't the first line, add a line break
			if ( i > 0 ) { args.y += h + 2; }
			draw(i);
		}
		function draw(line) {
			let txt = lines[line];
			// draw the text
			ctx.fillText(txt, args.x, args.y);
		}
	} else {
		let errorText = "drawText failed.";
		if (!args.text) { errorText += " No string provided."; }
		else {
			errorText += " String '" + args.text + "' could not be drawn. Missing arguments:";
			if (!args.x || typeof(args.x) != "number" ) { errorText += " x"; }
			if (!args.y || typeof(args.y) != "number" ) { errorText += " y"; }
		}
		console.log(errorText);
	}
}

////////////////////////////////////////////////////////////////////////
// SHARED CANVAS OBJECT INTERACTIONS

// check if any object(s) in this array are being clicked
// if more than one being clicked, only select the topmost one (highest z value)
// returns the object being clicked, or null if no object in given array is being clicked
function findClicked(array) {
	let clicked; // variable to hold clicked object, if one exists
	for (var i = 0; i < array.length; i++) {
		let obj = array[i];
		// if click is inside boundary of this object
		if ( inArea(obj,mouseX,mouseY) ) {
			// if no other object being clicked OR this toy above other toy being clicked
			if ( !clicked || obj.z > clicked.z ) {
				// flag this toy as the one being clicked
				clicked = array[i];
			}
		}
	}
	return clicked;
}

// bring given object to the front (z value) relative to all other objects in the given array
function bringObjectToFront(array,obj) {
	let curZ = obj.z;
	obj.z = array.length - 1;
	// for all toys
	for (var i = 0; i < array.length; i++) {
		// if the toy is above obj object's original z position, bring it down 1
		if ( array[i] != obj && array[i].z > curZ ) { array[i].z -= 1; }
	}
}

// drag given object based on mouse movement
function dragCanvasElement(obj) {
	// move it by the change in mouse position, but not outside bounds of the canvas
	// x movement
	let newX = obj.x + (mouseX - lastX);
	if ( newX < 0 ) newX = 0;
	if ( newX > canvas.w - obj.w ) newX = canvas.w - obj.w;
	obj.x = newX;
	// y movement
	let newY = obj.y + (mouseY - lastY);
	if ( newY < 0 ) newY = 0;
	if ( newY > canvas.h - obj.h ) newY = canvas.h - obj.h;
	obj.y = newY;
}

////////////////////////////////////////////////////////////////////////
// PLAY AREA

// toy currently being interacted with
var curToy;
// toy currently being dragged
var curDragging;

function playMouseDown() {
	if ( inArea(sideMenu,mouseX,mouseY) ) {
		sideMenuMouseDown();
	}
	else {
		// toy clicked
		curToy = findClicked(toys);
		if (curToy) {
			curDragging = curToy;
			// log the initial location
			curToy.startX = curToy.x;
			curToy.startY = curToy.y;
			// put toy in front of all other toys
			bringObjectToFront(toys,curToy);
		}
	}
}

function sideMenuMouseDown() {
	// if rotate button clicked and a toy is selected
	if ( curToy && inArea(sideMenu.rotate,mouseX,mouseY) ) {
		rotateToy(curToy);
	}
}

// called when mouse button is released while in play screen
function playMouseUp() {
	// if a toy is selected
	if ( curDragging ) {
		let t = curDragging;
		// if toy has been dragged to closet
		if ( hasOverlap(sideMenu.closet,t) ) {
			if (t.startX) t.x = t.startX;
			if (t.startY) t.y = t.startY;
			drawClosetArea();
		}
		// otherwise put toy in nearest playArea spot
		else {
			// x movement
			let newX = t.x + (mouseX - lastX);
			if ( newX < playArea.x ) newX = playArea.x;
			if ( newX > playArea.x + playArea.w - t.w ) newX = playArea.x + playArea.w - t.w;
			t.x = newX;
			// y movement
			let newY = t.y + (mouseY - lastY);
			if ( newY < playArea.y ) newY = playArea.y;
			if ( newY > playArea.y + playArea.h - t.h ) newY = playArea.y + playArea.h - t.h;
			t.y = newY;
			// clear current toy index
			curDragging = null;
		}
	}
}

////////////////////////////////////////////////////////////////////////
// CLOSET

// object to hold closet data
var closet = {};
closet.toyScale = 2;
// items in closet
closet.items = [
	{ name: "Crown", src: "closet/crown", w: 100, h: 80 },
	{ name: "Mini Crown", src: "closet/crown", w: 50, h: 40 },
	{ name: "Party Hat", src: "closet/party_hat", w: 100, h: 150 },
	{ name: "Red Bow", src: "closet/red_bow", w: 85, h: 100 },
	{ name: "Smiles Kandi", src: "closet/kandi_necklace_smiles", w: 110, h:65 }
]
// set initial values for closet items
for (let i = 0; i < closet.items.length; i++) {
	let item = closet.items[i];
	item.x = 20;
	if (i > 0) {
		let prev = closet.items[i-1];
		item.y = prev.y + prev.h + 20;
	} else {
		item.y = 20;
	}
	// save initial locations of item
	item.startX = item.x;
	item.startY = item.y;
	// create img element for item
	item.img = new Image();
	item.img.src = item.src + ".png";
	// if no z value set, default to stacking them in order of array position
	if ( item.z == null ) { item.z = i }
}

// back button
closet.back = { w: 80, h: 30, x: 10, fill: "skyblue" };
closet.back.y = canvas.h - closet.back.h - closet.back.x;

// draw closet area with given toy t
// if no toy given, default to curToy
function drawClosetArea() {
	console.log(curToy.name + " has " + curToy.outfit.length + " items in its outfit.");
	let t = curToy;
	// if closet wasn't already open
	if (openArea != "closet") {
		// reset all closet item positions
		for (let i = 0; i < closet.items.length; i++) {
			let item = closet.items[i];
			item.x = item.startX;
			item.y = item.startY;
			item.inToyOutfit = false;
		}
		// set size and position of toy in closet
		closet.toy = {};
		closet.toy.w = t.w * closet.toyScale;
		closet.toy.h = t.h * closet.toyScale;
		closet.toy.x = (canvas.w - closet.toy.w) / closet.toyScale;
		closet.toy.y = (canvas.h - closet.toy.h) / closet.toyScale;
		// if toy already has an outfit defined, set the positions for those outfit items
		for (let i = 0; i < t.outfit.length; i++) {
			let oItem = t.outfit[i];
			for (let j = 0; j < closet.items.length; j++) {
				let item = closet.items[j];
				if ( !item.inToyOutfit && oItem.name == item.name ) {
					item.x = closet.toy.x + (oItem.rX * closet.toyScale);
					item.y = closet.toy.y + (oItem.rY * closet.toyScale);
					item.w = oItem.w * closet.toyScale;
					item.h = oItem.h * closet.toyScale;
					// register that this item was in the outfit
					item.inToyOutfit = true;
					item.z = i;
					// move on to next outfit item
					break;
				}
			}
		}
		// set Z values for items NOT in the toy's outfit
		let curZ = t.outfit.length;
		for (let i = 0; i < closet.items.length; i++) {
			let item = closet.items[i];
			if (!item.inToyOutfit) {
				item.z = curZ;
				curZ += 1;
			}
		}
		// register thaat closet is open
		openArea = "closet";
	}
  // Clear the canvas
  ctx.clearRect(0, 0, canvas.w, canvas.h);
	// draw toy in center
	ctx.drawImage(t.img, closet.toy.x, closet.toy.y, closet.toy.w, closet.toy.h);
	// Draw each item from the closet.items array from lowest to highest Z values
	let itemsZOrder = [];
	for (var i = 0; i < closet.items.length; i++) { itemsZOrder[closet.items[i].z] = closet.items[i]; }
	for (let i = 0; i < itemsZOrder.length; i++) { drawObject(itemsZOrder[i]); }
	// draw text
	drawText({
		text: t.name,
		x: canvas.width-10, y: 50,
		color: "black",
		font: "Arial",
		size: "40px",
		align: "end"
	});
	// draw back button
	ctx.fillStyle = closet.back.fill;
  ctx.fillRect(closet.back.x, closet.back.y, closet.back.w, closet.back.h);
	// back button text
	drawText({
		text: "BACK",
		x: closet.back.x + 2,
		y: closet.back.y + closet.back.h - 2,
		color: "black",
		font: "Arial",
		size: (closet.back.h - 2) + "px",
		align: "start"
	});
}

// called when mousedown while in closet screen
function closetMouseDown() {
	// if back button clicked, open play screen
	if (inArea(closet.back,mouseX,mouseY)) {
		setOutfit();
		drawPlayArea();
	}
	else {
		closet.cur = findClicked(closet.items);
		if (closet.cur) {
			// put item in front of all other items
			bringObjectToFront(closet.items,closet.cur);
		}
	}
}

// called when mouseup while in closet screen
function closetMouseUp() {
	if (closet.cur) {
		// clear current closet item being interacted with
		closet.cur = null;
	}
}

// set the current closet arrangement as the outfit for the current toy
function setOutfit() {
	// reset current toy's outfit
	curToy.outfit = [];
	// Sort closet items by Z position
	let itemsZOrder = [];
	// Draw each item from the closet.items array
	for (var i = 0; i < closet.items.length; i++) {
		itemsZOrder[closet.items[i].z] = closet.items[i];
	}
	for (let i = 0; i < itemsZOrder.length; i++) {
		let item = itemsZOrder[i];
		// if the item is overlapping with the toy, add it to the toy's outfit
		if ( hasOverlap(item, closet.toy) ) {
			let addItem = {};
			addItem.name = item.name;
			// x and y values relative to toy's x and y values
			addItem.rX = (item.x - closet.toy.x) / 2;
			addItem.rY = (item.y - closet.toy.y) / 2;
			// width and height
			addItem.w = item.w / 2;
			addItem.h = item.h / 2;
			// create img element for item
			addItem.img = new Image();
			addItem.img.src = item.src + ".png";
			// add outfit item to outfit
			curToy.outfit.push(addItem);
			console.log(item.name + " added to " + curToy.name + "'s outfit.");
		}
	}
}


////////////////////////////////////////////////////////////////////////
// MOUSE CLICKS & MOVEMENT
var mouseIsDown, lastX, lastY;

canvas.onmousedown = function(e){
  // flag that mouse is currently down
  mouseIsDown = true;
  // get the current mouse position relative to the canvas
  mouseX = parseInt(e.clientX-offsetX);
  mouseY = parseInt(e.clientY-offsetY);
	// save the initial click position
	lastX = mouseX;
	lastY = mouseY;
	
	if (openArea == "play") { playMouseDown(); }
	else if (openArea == "closet") { closetMouseDown(); }
}
// mouse up handler
document.onmouseup =  function(e){ 
	// get mouseX/mouseY
  mouseX = parseInt(e.clientX-offsetX);
  mouseY = parseInt(e.clientY-offsetY);
	
	if (openArea == "play") { playMouseUp(); }
	else if (openArea == "closet") { closetMouseUp(); }
	
  // clear the mouseIsDown flag
  mouseIsDown = false;
	// redraw the canvas
	drawCanvas();
}
// mouse movement handler
canvas.onmousemove = function(e){
  // if the mouse isn't down, end early
  if (!mouseIsDown) { return; }
	
  // get mouseX/mouseY
  mouseX = parseInt(e.clientX-offsetX);
  mouseY = parseInt(e.clientY-offsetY);
	
	// whether to redraw canvas at the end
	let redraw = false;
	// if a toy is being dragged in play area
	if (openArea == "play" && curDragging) {
		redraw = true;
		dragCanvasElement(curDragging);
  }
	// if a closet item is being dragged in closet
	else if (openArea == "closet" && closet.cur) {
		redraw = true;
		dragCanvasElement(closet.cur);
	}
	
	// update lastX/lastY to current mouse position
	lastX = mouseX;
	lastY = mouseY;
	
	// draw all toys in their new positions
	if (redraw) { drawCanvas(); }
}

// checks if given x,y coordinate is in area of given object
function inArea(obj,x,y) {
	if (x > obj.x && x < (obj.x + obj.w) && y > obj.y && y < (obj.y + obj.h)) { return true; }
	else { return false; }
}

// checks if two objects are overlapping each other
function hasOverlap(a,b) {
	let aLeftOfB = a.x + a.w < b.x;
	let aRightOfB = a.x > b.x + b.w;
	let aAboveB = a.y > b.y + b.h;
	let aBelowB = a.y + a.h < b.y;
	return !( aLeftOfB || aRightOfB || aAboveB || aBelowB );
}

////////////////////////////////////////////////////////////////////////
// KEYBOARD INPUT
/*
// key press handler
document.addEventListener('keydown', (event) => {
  if (event.key === 'ArrowLeft') {
  }
});
*/