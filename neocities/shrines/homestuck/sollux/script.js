/*
<!-- this page's script -->
<script src="script.js?fileversion=9"></script>

*/

// force strict mode
"use strict";

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

