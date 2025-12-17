/*
<!-- this page's script -->
<script src="script.js?fileversion=20251216"></script>

*/

// force strict mode
"use strict";


var WMPlayersContainer = document.getElementById('music-player');
var WMPlayers = [];
var playlists = [solluxPlaylist,karkatPlaylist,tavrosPlaylist,aradiaPlaylist];
let curPlaylist = 0; // playlists index of currently loaded playlist

var playlistPattern = `<button class="$status">
	<span>$index.</span>
	<span>$title by $artist</span>
	<span>$duration</span>
</button>`;

window.addEventListener('load',()=>{
	let playlistTemplate = document.getElementById('playlist-template');
	
	for (let i = 0; i < playlists.length; i++) {
		
		// SET UP PLAYLIST CONTAINER
		let p = playlists[i];
		let el = document.createElement('div');
		
		el.id = 'playlist-'+i;
		el.classList.add(p.character,'playlist');
		
		// SET UP PLAYER
		WMPlayers[i] = new WMPlayer({
			parent: el, //Set player's container,
			template: playlistTemplate, //Set player template
			playlistPattern: playlistPattern, //Set playlist song pattern
			loop: true,
			YTApiKey: "AIzaSyBknQarg1E4Ux-3d6Ddyz5mR9iF9ZpgZuA", //YouTube API Key to fetch duration
			playlist: p.playlist
		});
		
		el.classList.remove('hidden');
		el.querySelector('.character-name').innerHTML = p.character;
		el.querySelector('.playlist-title').innerHTML = p.title;
		el.querySelector('.icon').src = '/shrines/homestuck/'+p.character+'/images/icon.png';
		
		el.querySelector('.wmp-playlist-item').addEventListener('click',()=>{
			console.log('!');
			// pause all other playlists
			for (let j = 0; j < WMPlayers.length; j++) {
				let curEl = document.getElementById('playlist-'+j);
				if (
					curEl.querySelector('.wmplayer').classList.contains('playing')
					&& curEl.id != 'playlist-'+i
				){
					console.log('pausing playlist '+ p.title);
					WMPlayers[Number(curEl.id.replaceAll('playlist-',''))].pause();
					console.log('pausing player '+j);
				}
			}
		});
		
		playlistTemplate.parentNode.appendChild(el);
	}
	
});


