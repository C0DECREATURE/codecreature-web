/*
// put at top of html document
		<!--full image view-->
		<script src="/js/full-image.js"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js"></script>
*/

// force strict mode
"use strict";

// full image view html element
var fullImage = '';
// collection of img elements that can be clicked to full view
var fullImageList = [];
// fullImageList array index of the currently viewed image
var curFullImage = '';
// whether initFullImage function has been run already
var initFullImageCalled = false;

window.addEventListener('load', () => {
	// if another script hasn't disabled this script's auto init
	if (!dontAutoInitFIV) {
		// set up image full view
		initFullImage();
	}
});

// set up full image view
function initFullImage() {
	if (!initFullImageCalled) {
		initFullImageCalled = true;
		// add the associated style sheet to the document that loaded this
		let css = document.createElement('link');
		css.rel = 'stylesheet';
		css.type = 'text/css';
		css.href = '/js/full-image.css?fileversion=7';
		document.querySelector('HEAD').appendChild(css);
		
		// add overlay element to body of html document if one doesn't exist
		if (!document.querySelector('.full-image-view')) {
			fullImage = document.createElement('div');
			fullImage.classList.add('full-image-view');
		} else fullImage = document.querySelector('.full-image-view');
		// fill it with content
		fullImage.innerHTML = `
			<div class="fiv-clicker"></div>
				<button class="fiv-close" aria-label="close image full view">
					<i class="svg-icon svg-icon-outline svg-icon-bold" data-icon="rounded-x"></i>
				</button>
			<button class="fiv-prev" aria-label="previous image">
				<i class="svg-icon svg-icon-solid" data-icon="rounded-caret-left"></i>
			</button>
			<button class="fiv-next" aria-label="next image">
				<i class="svg-icon svg-icon-solid" data-icon="rounded-caret-right"></i>
			</button>
			<div class="fiv-content">
				<img src="" alt="">
				<p class="credit"></p>
				<p class="caption"></p>
				<p class="alt" aria-hidden="true"></p>
			</div>
		`;
		// add it to the body
		document.querySelector('body').appendChild(fullImage);
		
		// make background clicker and close button close full image view
		fullImage.querySelector('.fiv-clicker').addEventListener('click', closeFullImage);
		fullImage.querySelector('.fiv-close').addEventListener('click', closeFullImage);
		// make next/prev buttons open next/prev image
		fullImage.querySelector('.fiv-prev').addEventListener('click', openPrevFullImage);
		fullImage.querySelector('.fiv-next').addEventListener('click', openNextFullImage);
		
		// make all full-viewable class elements open the full image view overlay on click
		fullImageList = document.getElementsByClassName('full-viewable');
		for ( let i = 0; i < fullImageList.length; i++ ) {
			var img = fullImageList[i];
			img.dataset.fullImageListIndex = i;
			img.addEventListener('click', function() { openFullImage(this); } );
		}
		
		/////////////////////////////////////////
		// KEYBOARD & TOUCH CONTROLS
		
		// keyboard controls
		document.addEventListener('keydown', function(event) {
			// if the full image overlay is displayed
			if ( fullImage.style.display == 'block' ) {
				if (event.key === "Escape") closeFullImage();
				else if (event.key === "ArrowRight" || event.key === "ArrowDown") {
					event.preventDefault();
					openNextFullImage();
				}
				else if (event.key === "ArrowLeft" || event.key === "ArrowUp" ) {
					event.preventDefault();
					openPrevFullImage();
				}
			}
		});
		console.log('full image view setup complete');
	}
}

// touchscreen variables
let touchstartX = 0;
let touchendX = 0;
let touchstartY = 0;
let touchendY = 0;
// detect start of swipe/touch
document.addEventListener('touchstart', e => {
	touchstartX = e.changedTouches[0].screenX;
	touchstartY = e.changedTouches[0].screenY;
})
// detect end of swipe/touch
document.addEventListener('touchend', e => {
  touchendX = e.changedTouches[0].screenX;
  touchendY = e.changedTouches[0].screenY;
  checkFITouchInput();
})

// check touchscreen input
function checkFITouchInput() {
	// if the full image overlay is displayed
	if ( fullImage.style.display == 'block' ) {
		// minimum pixels of movement to consider a touch a swipe
		var minSwipe = 30;
		// if horizontal swipe was made
		// horizontal move greater than minSwipe and change in X was greater than change in Y
		if ( Math.abs(touchendX-touchstartX) > minSwipe && Math.abs(touchendX-touchstartX) > Math.abs(touchendY-touchstartY) ) {
			if (touchendX < touchstartX) openNextFullImage();
			if (touchendX > touchstartX) openPrevFullImage();
		}
	}
}

// opens the previous image in fullImageList
function openPrevFullImage() {
	var prev = Number(curFullImage) - 1;
	if ( prev < 0 ) prev = fullImageList.length - 1;
	openFullImage( fullImageList[prev] );
	fullImageList[prev].scrollIntoView({ behavior: "smooth" });
}

// opens the next image in fullImageList
function openNextFullImage() {
	var next = Number(curFullImage) + 1;
	if ( next >= fullImageList.length) next = 0;
	openFullImage( fullImageList[next] );
	fullImageList[next].scrollIntoView({ behavior: "smooth", block: "nearest" });
}

// opens the full image overlay for the given image element
function openFullImage(img) {
	// image source
	var src;
	// image alt text
	var alt = "";
	// if the given image element is an <img>, use its src data
	if (img.tagName.toLowerCase() == 'img') {
		src = img.src;
		if ( img.alt ) alt = img.alt;
	}
	// otherwise if the given image element has a background image, use that image
	else if (typeof(img.style.backgroundImage) == 'string') {
		src = img.style.backgroundImage;
		src = src.substring(5,src.length-2);
		if ( img.dataset.alt ) alt = img.dataset.alt;
	}
	else {
		console.log('no valid image found');
		return;
	}
	// update the index of the current image
	curFullImage = img.dataset.fullImageListIndex;
	
	let logNum = Number(curFullImage) + 1;
	console.log('opening full image #' + logNum + ': ' + src);
	
	// put the image in the overlay
	fullImage.querySelector('img').src = src;
	// if credit link was provided
	var credit = img.dataset.credit;
	var creditLabel = img.dataset.creditLabel;
	if ( credit ) {
		let txt = '<a href="' + credit + '">';
		if ( creditLabel ) txt += creditLabel + '</a>';
		else txt += 'credit</a>';
		fullImage.querySelector('.credit').innerHTML = txt;
	} else fullImage.querySelector('.credit').innerHTML = '';
	// if caption was provided
	var caption = img.dataset.caption;
	if ( caption ) fullImage.querySelector('.caption').innerHTML = caption;
	else fullImage.querySelector('.caption').innerHTML = '';
	// if image has alt text provided
	if ( alt && alt != "" ) {
		fullImage.querySelector('img').alt = alt;
		let txt = '';
		if (credit || caption) txt += '<hr>';
		fullImage.querySelector('.alt').innerHTML = txt + 'alt text: ' + alt;
	} else fullImage.querySelector('.alt').innerHTML = '';
	
	// display the full image overlay
	fullImage.style.display = 'block';
}

function closeFullImage() {
	fullImage.style.display = 'none';
}