/* INCLUDE THESE IN ANY DOC THAT LOADS THIS

// list of all playables for tv
const videos = document.getElementById('id').children;
// current video number (between 0 and videos.length-1)
var cur = 0;
// whether tv is currently on
var tvOn = true;

initTV();

*/

// returns current video
function curVideo() { return videos[cur]; }

function initTV() {
	for ( var i = 0; i < videos.length; ++i ) {
		videos[i].style.display = 'none';
		if ( tvOn && i == cur ) videos[i].style.display = 'block';
	}
}

function playPause() {
	if ( curVideo().paused ) {
		tvOn = true;
		curVideo().style.display = 'block';
		curVideo().play();
		paused = false;
	}
	else {
		tvOn = false;
		curVideo().style.display = 'none';
		curVideo().pause();
		paused = true;
	}
}

function prev() {
	if ( tvOn) {
		var paused = curVideo().paused;
		
		// current video is not near the beginning
		if ( curVideo().currentTime > 1.5 ) curVideo().currentTime = 0;
		// if there is more than one playable and current video is near the beginning
		else if ( videos.length > 1 ) {
			// pause and hide the current playable
			curVideo().currentTime = 0;
			curVideo().pause();
			curVideo().style.display = 'none';
			// set the next playable as current
			if ( cur > 0 ) cur -= 1;
			else cur = videos.length - 1;
			// show the next playable
			curVideo().style.display = 'block';
		}
		
		// if the previous video was not paused, play the new video
		if ( !paused ) curVideo().play();
	}
}

function next() {
	// if the tv is on
	if ( tvOn ) {
		var paused = curVideo().paused;
		
		curVideo().currentTime = 0;
		
		// if there is more than one playable
		if ( videos.length > 1 ) {
			// pause and hide the current playable
			curVideo().pause();
			curVideo().style.display = 'none';
			// set the next playable as current
			if ( cur < videos.length - 1 ) cur += 1;
			else cur = 0;
			// show the next playable
			curVideo().style.display = 'block';
		}
		
		// if the previous video was not paused, play the new video
		if ( !paused ) curVideo().play();
	}
}