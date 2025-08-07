/*
<!-- audio player -->
<script src="audioPlayer.js?fileversion=9"></script>
<link href="audioPlayer.css?fileversion=9" rel="stylesheet" type="text/css"></link>

*/

// force strict mode
"use strict";

/* when page loads, set up play/pause button */
window.addEventListener("load", () => {
	const playButton = document.getElementById("audio-player-playbutton");
	let state = 'pause';

	playButton.addEventListener('click', () => {
		if(state === 'play') {
			playButton.innerHTML = "play";
			state = 'pause';
		} else {
			playButton.innerHTML = "pause";
			state = 'play';
		}
	});
});