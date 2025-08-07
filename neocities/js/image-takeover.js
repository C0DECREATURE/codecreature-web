/*

// put this at the top of html document
<!-- image takeover -->
<script src="/js/image-takeover.js"></script>

*/

// force strict mode
"use strict";

// set of images to randomly use if no target image given
const replaceImages = ['/graphix/bg/glitch.gif', '/graphix/bg/tv-static.gif'];

// variable tracking progressive increase in reps
var progressive = 1;

// replace a target with the given image
// image should be provided as a valid url string
function imageTakeover(target, image) {
	if (!image) image = replaceImages[Math.floor(replaceImages.length * Math.random())];
	// mark the target
	target.classList.add('image-takeover');
	if ( target.nodeName ) {
		var t = target.nodeName.toLowerCase();
		if ( t == 'img' ) {
			target.width = target.offsetWidth;
			target.height = target.offsetHeight;
			target.src = image;
		}
		else if ( t == 'span' || t == 'a' || t == 'p' ) {
			// make text transparent
			target.style.color = 'rgba(0, 0, 0, 0)';
			imageTakeoverBackground(target, image, 'contain', 'replace');
		}
		else if ( t == 'button' ) {
			target.innerHTML = '<span style="visibility: hidden;">' + target.innerHTML + '</span>';
			target.style.border = '0';
			target.style.boxShadow = 'none';
			imageTakeoverBackground(target, image, '100% 100%', 'replace');
		}
		else if ( t == 'div' ) {
			target.style.color = 'rgba(0, 0, 0, 0)';
			imageTakeoverBackground(target, image, 'cover', 'replace');
		}
		else if ( t == 'body' ) {
			target.style.color = 'rgba(0, 0, 0, 0)';
			imageTakeoverBackground(target, image, 'cover', 'no-replace');
		}
		else if ( t == 'iframe' ) {
			target.src = '';
			imageTakeoverBackground(target, image, 'cover', 'replace');
		}
	}
	/*
	var c = target.children;
	for ( i = 0; i < c.length; i++ ) {
		alert(c.innerHTML);
		imageTakeover(c.item(i), image)
	}
	*/
	return
}

function imageTakeoverBackground(target, image, size, replace) {
	if (replace == 'replace') target.style.background = 'url("' + image + '")';
	else target.style.backgroundImage = 'url("' + image + '")';
	target.style.backgroundSize = size;
	target.style.backgroundRepeat = 'no-repeat';
	target.style.backgroundPosition = 'center';
}

// takeover a random element on the page with the given image
// only runs through elements that have not already been taken over
// reps is optional number of times to run randomImageTakeover
function randomImageTakeover(image, reps) {
	// qualifiers for valid items
	var q = ':not(.image-takeover):not([style*="display:none"]):not([style*="visibility:hidden"]):not(.image-takeover-immune)';
	var list = [];
	// get all starter takeover elements
	list = document.querySelectorAll(
		'img' + q + ',' +
		'span' + q + ',' +
		'p' + q + ',' +
		'button' + q
	);
	// if all the previous list elements are taken over, get next level of takeover elements
	if ( list.length == 0 ) {
		list = document.querySelectorAll(
			'div' + q + ',' + 
			'iframe' + q
		);
	}
	// if all the previous list elements are taken over, get next level of takeover elements
	if ( list.length == 0 ) {
		list = document.querySelectorAll(
			'body' + q
		);
	}
	// if there are still elements to take over
	if ( list.length > 0 ) {
		var e = list[Math.floor(Math.random() * list.length)];
		imageTakeover(e, image);
	}
	// if it still needs to be repeated, repeat
	if ( reps ) {
		if ( reps == 'max' ) {
			randomImageTakeover(image, list.length - 1);
		}
		else if ( reps == 'progressive' ) {
			randomImageTakeover(image, progressive);
			progressive = Math.round(progressive * 1.5);
		}
		else {
			reps = Number(reps);
			if ( reps > 1 ) randomImageTakeover(image, reps - 1);
		}
	}
}