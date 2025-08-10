/*
<!-- this page's script -->
<script src="script.js?fileversion=9"></script>

*/

// force strict mode
"use strict";


//////////////////////////////////////////////////////////////////////////////////
// TYPING EFFECTS

let enterButton;

// assign elements to variables on window load
window.addEventListener("load", () => {
	enterButton = document.getElementById("enter-button");
	enterButton.addEventListener("click", loadMain);
	
	typeWriter(document.getElementById('loading').querySelector('pre'));
});

/* speed each letter is typed, in milliseconds */
let typeWriterSpeed = 16;
// types out each span within an element. will ignore anything not in a span
function typeWriter(el) {
	let textCursor = document.createElement('div');
	textCursor.innerHTML = "|";
	textCursor.classList.add('text-cursor');
	el.appendChild(textCursor);
	
	// all children of the specified element
	let children = el.getElementsByTagName('span');
	
	// if the user hasn't requested reduced motion settings
	if (!isReducedMotion) {
		let curChild = 0;
		
		function writeNextChild() {
			let child = children[curChild];
			let i = 0;
			let txt = child.innerHTML;
			child.innerHTML = "";
			child.style.display = "inline";
			// function to loop through the child's contents adding one character at a time
			function loop() {
				child.innerHTML += txt[i];
				if (i < txt.length - 1) {
					i++;
					setTimeout(loop, typeWriterSpeed);
				}
				else if (curChild < children.length - 1) {
					curChild++;
					writeNextChild();
				}
				else { finishedTypeWriter(el); }
			}
			// start the loop
			loop();
		}
		// start writing children
		writeNextChild();
	}
	// if the user has requested reduced motion
	else {
		for (let i = 0; i < children.length; i++) {
			children[i].style.display = "inline";
		}
		// finish immediately
		finishedTypeWriter(el);
	}
}
// called when typeWriter finishes writing an element
function finishedTypeWriter(el) {
	let textCursor = el.querySelector('.text-cursor');
	function textCursorBlink() { textCursor.classList.add('blinking') }
	function textCursorBlinkStop() { textCursor.classList.remove('blinking'); }
	// start text cursor blinking
	textCursorBlink();
	// when loading box finishes typing, show enter button
	if (el.id == "loading-typebox") { enterButton.classList.remove('hidden'); }
}


//////////////////////////////////////////////////////////////////////////////////
// MAIN AREA LOAD

function loadMain() {
	// set hex buttons to appear at random staggered rate
	let hexes = document.getElementById('hexgrid').querySelector('.hex-container').children;
	for (let i = 0; i < hexes.length; i++) {
		let delay =  (Math.random() * .75) + .25;
		hexes[i].style.setProperty("--appear-speed", delay + "s");
	}
	// hide load screen and show main
	document.getElementById('loading').classList.add('hidden');
	document.querySelector('main').classList.remove('hidden');
}

//////////////////////////////////////////////////////////////////////////////////
// HEADER IMAGE GLASSES FUNCTIONS
var glassesImage, glassesOnSvg, glassesOffSvg;

// assign elements to variables on window load
window.addEventListener("load", () => {
	glassesImage = document.getElementById('header-hero-mode');
	glassesOnSvg = document.getElementById('hero-mode-glasses-on-svg');
	glassesOffSvg = document.getElementById('hero-mode-glasses-off-svg');
	// initialize
	setGlassesImage();
	// set up click/hover events for svg maps
	let paths = document.getElementById('hero-mode-glasses-toggle').getElementsByTagName('path');
	for (let i = 0; i < paths.length; i++) {
		paths[i].addEventListener("mouseenter", glassesHover);
		paths[i].addEventListener("mouseleave", setGlassesImage);
	}
});

// whether glasses are currently on
var glassesOn = false;
var glassesSrc = "images/hero_mode";

function toggleGlasses() {
	if (glassesOn) takeGlassesOff();
	else putGlassesOn();
}
// show glasses on image and log that glasses are on
function putGlassesOn() { glassesOn = true; setGlassesImage(); }
// show glasses off image and log that glasses are off
function takeGlassesOff() { glassesOn = false; setGlassesImage(); }

function glassesHover() {
	if (glassesOn) glassesImage.src = glassesSrc + "_glasses_hover.png";
	else glassesImage.src = glassesSrc + "_hover.png";
}
function setGlassesImage() {
	if (glassesOn) {
		glassesImage.src = glassesSrc + "_glasses.png";
		glassesOffSvg.style.display = "none";
		glassesOnSvg.style.display = "block";
	}
	else {
		glassesImage.src = glassesSrc + ".png";
		glassesOffSvg.style.display = "block";
		glassesOnSvg.style.display = "none";
	}
}

//////////////////////////////////////////////////////////////////////////////////
// AUDIO PLAYER

// playlist for audio player
const audioPlayerPlaylist = [
	{ title:"5-4-3-2-1 Lisp Off", artist:"Modest Mouse" },
	{ title:"Hacking Machine", artist:"Guerilla Toss" }
];

// when page loads, set up play/pause button
window.addEventListener("load", () => {
	const playlistEl = document.getElementById("audio-player-playlist");
	// put song buttons in playlist
	for (let i = 0; i < audioPlayerPlaylist.length; i++) {
		let song = document.createElement("button");
		song.innerHTML = audioPlayerPlaylist[i].title + " by " + audioPlayerPlaylist[i].artist;
		playlistEl.appendChild(song);
	}
	// button to open playlist dropdown
	const playlistButton = document.getElementById("audio-player-open-playlist");
	playlistButton.addEventListener('click', () => {
		playlistEl.classList.toggle('hidden');
		if (playlistButton.innerHTML == "+") { playlistButton.innerHTML = "-" }
		else { playlistButton.innerHTML = "+" };
	});
});