/* INCLUDE THESE IN ANY DOC THAT LOADS THIS

// list of all playables for tv
const videos = document.getElementById('id').children;
// current video number (between 0 and videos.length-1)
var cur = 0;
// whether tv is currently on
var tvOn = true;

initTV();

*/

const videoPlayer = {
	videos: [],
	// whether player is active
	on: true,
	// index of current video
	curIndex: 0,
	// return current video
	curVideo: ()=>{ return videos[this.curIndex]; },
	// toggle video playing
	playPause: ()=>{
		let cur = this.curVideo();
		if ( cur.paused ) {
			this.on = true;
			cur.style.display = 'block';
			cur.play();
			paused = false;
		}
		else {
			this.on = false;
			cur.style.display = 'none';
			cur.pause();
			paused = true;
		}
	},
	// go to previous video
	prev: ()=>{
		if ( this.on ) {
			let cur = this.curVideo();
			let paused = cur.paused;
			
			// current video is not near the beginning
			if ( cur.currentTime > 1.5 ) cur.currentTime = 0;
			// if there is more than one playable and current video is near the beginning
			else if ( videos.length > 1 ) {
				// pause and hide the current playable
				cur.currentTime = 0;
				cur.pause();
				cur.style.display = 'none';
				// set the next playable as current
				if ( this.curIndex > 0 ) this.curIndex -= 1;
				else this.curIndex = videos.length - 1;
				// show the next playable
				this.curVideo().style.display = 'block';
			}
			
			// if the previous video was not paused, play the new video
			if ( !paused ) cur.play();
		}
	},
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