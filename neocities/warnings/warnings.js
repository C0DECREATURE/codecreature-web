// element variables
var miniInfo, bigInfo, mainContent;

// when window loads
window.addEventListener("load", function(){
	// assign elements to variables
	miniInfo = document.getElementById("mini-info");
	bigInfo = document.getElementById("big-info");
	mainContent = document.getElementById("main-content");
	cornerImg = document.getElementById("cornerimg").querySelector('img');
	
	// position corner image
	updateCornerImagePos();
	
	// initiate blinking timer
	cornerImgBlink(false);
	// check if corner image should be asleep every second
	resetCornerImgWakeup();
	const cornerImgSleepLoop = setInterval(checkCornerImgSleep, 1000);
	
	// jump to info section if relevant hash in url
	// DEBUG - this is broken so it's commented for now
	if(location.hash) { showBigInfo(location.hash.replace("#","")) }
	//if(location.hash) { location.hash="" }
});

// show the mini popup for given element
function showMiniInfo(src) {
	if (cornerImgSleeping == true) { cornerImgWake(); }
	if (cornerImg.src != cornerImgExcitedSrc) { cornerImgExcited(); } // excited expression
	
	var newTxt = "";
	if ( typeof(src) == "string" ) { newTxt = src }
	else if (src.classList.contains('warninglink')) { newTxt = "click 4 more info"; }
	else if (src.classList.contains("javascript")) { newTxt = "javascript required"; }
	else if (src.classList.contains("mobile")) { newTxt = "some pages are not mobile friendly!"; }
	else { newTxt = ":3"; }
	
	miniInfo.querySelector('.text').innerHTML = newTxt;
	miniInfo.style.visibility = "visible";
}

function hideMiniInfo() {
	cornerImgDefault(); // reset expression
	miniInfo.style.visibility = "hidden";
	miniInfo.querySelector('.text').innerHTML = "";
}

function showBigInfo(name) {
	var validId = false;
	
	var infoElements = bigInfo.getElementsByClassName("info");
	for (var i = 0; i < infoElements.length; i++) {
		if (infoElements[i].id == name) { validId = true; infoElements[i].classList.remove('hide'); }
		else { infoElements[i].classList.add('hide'); }
	}
	
	if (validId) {
		mainContent.classList.add("hide");
		bigInfo.classList.remove("hide");
		//bigInfo.scrollTo(0,0);
		bigInfo.querySelector('header').innerHTML = name;
	}
}

function showMainContent() {
	mainContent.classList.remove("hide");
	bigInfo.classList.add("hide");
	mainContent.scrollTo(0,0);
	window.location.hash='';
};

// position clipped corner image elements based on corner image position
function updateCornerImagePos() {
	var back = document.getElementById('cornerimg-back'),
		overlap = document.getElementById('cornerimg-overlap'),
		box = document.getElementById('content-box'),
		backRect = back.getBoundingClientRect(),
		overlapRect = overlap.getBoundingClientRect(),
		offsetTop = backRect.top - overlapRect.top
			- Number(window.getComputedStyle(overlap).bottom.replace('px','')),
		offsetRight = backRect.right - overlapRect.right
			- Number(window.getComputedStyle(overlap).right.replace('px',''));
	overlap.style.bottom = "-" + offsetTop + "px";
	overlap.style.right = "-" + offsetRight + "px";
}
window.addEventListener('resize', function(event) { updateCornerImagePos(); }, true);

// image path names for corner image
var cornerImgSrcPath = "/ocs/catnip/images/sitting-chib";
var cornerImgDefaultSrc = cornerImgSrcPath + ".png";
var cornerImgBlinkSrc = cornerImgSrcPath + "-blink.png";
var cornerImgExcitedSrc = cornerImgSrcPath + "-excited.png";
var cornerImgSleeping = false;

// make corner image blink
// if display == false, don't blink but reset blink timer
function cornerImgBlink(display,prevTime) {
	// if corner image is currently in default state
	if (
		display != false &&
		cornerImg.src.replace(window.location.protocol+"//"+window.location.hostname,"") == cornerImgDefaultSrc
		&& cornerImgSleeping == false
	) {
		// set to blink image
		cornerImg.src = cornerImgBlinkSrc;
		// reset after .2 seconds
		setTimeout(function () { cornerImgDefault(); }, 200);
	}
	// blink again in a random amount of time
	var randomTime;
	// if last blink was short, make this one longer
	if (prevTime < 1000 ) { randomTime = Math.floor((Math.random()*3000)+2000) }
	// otherwise blink in .7-7 seconds
	else { randomTime = Math.floor((Math.random()*4300)+700) }
	
	// set blink timer to run this function again
	setTimeout(function(){cornerImgBlink(true,randomTime)},randomTime);
}
function cornerImgExcited() { cornerImg.src = cornerImgExcitedSrc; }
function cornerImgDefault() { cornerImg.src = cornerImgDefaultSrc; }
function cornerImgSleep() { showMiniInfo("zzz..."); cornerImgSleeping = true; cornerImg.src = cornerImgBlinkSrc; }
function cornerImgWake() {
	// reset sleep timer
	resetCornerImgWakeup();
	// reset image
	cornerImgDefault();
	// hide the sleep speech bubble
	hideMiniInfo();
	// update sleeping variable
	cornerImgSleeping = false;
}
// log time of every click
window.addEventListener("click", function(){
	if (cornerImgSleeping) { cornerImgWake(); }
	else { resetCornerImgWakeup(); }
});
function resetCornerImgWakeup() { sessionStorage.setItem("lastCornerImgWakeup",new Date().getTime()); }
// check if corner image should be asleep
function checkCornerImgSleep() {
	var diff = Math.abs(sessionStorage.getItem("lastCornerImgWakeup") - new Date().getTime());
	// if it has been more than 8 seconds since last interaction, sleep
	if (diff > 8000) { cornerImgSleep(); }
}

function okButton() {
	// log that user has accepted warnings on this browser
	localStorage.setItem('showWarnings', false );
	// go to redirect page if specified, otherwise go home
	const urlParams = new URL(window.location.href).searchParams;
	if ( urlParams.has("redirect") ) { window.location.href = urlParams.get("redirect") }
	else { window.location.href="/home" }
}