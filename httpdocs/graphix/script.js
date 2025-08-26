var dontAutoInitFIV = true;

function graphixPageInit() {
	// add full-viewable class to all gallery images
	var galleries = document.getElementsByClassName('gallery');
	for ( let i = 0; i < galleries.length; i++ ) {
		var images = galleries[i].getElementsByTagName('img');
		for ( let i = 0; i < images.length; i++ ) { images[i].classList.add('full-viewable'); }
	}
	
	// run full image setup code
	fullImageView.init();
	
	// set up background image samples
	backgrounds = document.getElementsByClassName('bg-image');
	defaultBackground = document.body.style.background;
	for ( let i = 0; i < backgrounds.length; i++ ) {
		var b = backgrounds[i];
		var img = b.querySelector('img');
		// create inner child div and set the image as the child's background
		let inner = document.createElement('div');
		inner.classList.add('inner');
		inner.style.backgroundImage = 'url("' + img.src + '")';
		inner.style.backgroundSize = 'min(100%, 100px)';
		b.appendChild(inner);
		// hide the image inside
		img.style.display = 'none';
		// make clicking the div click the hidden image
		inner.addEventListener('click', function() {
			let img = this.parentNode.querySelector('img');
			img.click();
		});
		let button = document.createElement('button');
		button.innerHTML = "[test background]";
		button.classList.add("set-background");
		button.dataset.innerHTML = button.innerHTML;
		button.addEventListener('click', function() {
			toggleBackgroundButton(this);
		});
		b.appendChild(button);
	}
	
	// set up dividers
	var dividers = document.getElementsByClassName('image-divider');
	for ( let i = 0; i < dividers.length; i++ ) {
		var d = dividers[i];
		var img = d.querySelector('img');
		// set the image as the div's background
		d.style.backgroundImage = 'url("' + img.src + '")';
		d.style.backgroundRepeat = "repeat-x";
		// hide the image inside
		img.style.visibility = 'hidden';
		// make clicking the div click the hidden image
		d.addEventListener('click', function() { this.querySelector('img').click(); } );
	}
	
	// set up nav
	var sections = document.getElementsByClassName('section');
	for ( let i = 0; i < sections.length; i++ ) {
		var s = sections[i];
		// for any sections with defined id
		if ( s.id ) {
			document.querySelector('.navlinks').innerHTML +=
				'<a href="#' + s.id + '">' + s.querySelector('h3').innerHTML + '</a>';
		}
	}
	// variables
	var nav = document.querySelector('.nav');
	var nl = document.querySelector('.navlinks');
	var db = nav.querySelector('.dropdown-btn');
	// adjust nav width when window is resized
	document.querySelector('body').onresize = function(){ navResize(); };
	// adjust nav width immediately on page load
	navResize();
	// adjust nav if window is too narrow
	function navResize() {
		// make sure nav is in large mode
		db.style.display = 'none';
		nl.classList.remove('navlinks-dropdown');
		nl.style.display = 'flex';
		// if the nav links are being forced to wrap, set to dropdown mode
		if ( nl.lastElementChild.offsetTop > 0 ) {
			nl.classList.add('navlinks-dropdown');
			closeNavDropdown();
			db.style.display = 'block';
		}
	}
	function toggleNavDropdown() { 
		if (nl.classList.contains('navlinks-dropdown') && nl.style.display == 'none' ) openNavDropdown();
		else if (nl.classList.contains('navlinks-dropdown') && nl.style.display == 'block' ) closeNavDropdown();
	}
	function openNavDropdown() { if (nl.classList.contains('navlinks-dropdown') && nl.style.display == 'none' ) nl.style.display = 'block'; }
	function closeNavDropdown() { if (nl.classList.contains('navlinks-dropdown') && nl.style.display != 'none' ) nl.style.display = 'none'; }
	db.addEventListener('click', toggleNavDropdown);
	nl.querySelectorAll('a, button').forEach((a) => a.addEventListener('click', closeNavDropdown) );
	nav.addEventListener('mouseleave', (event) => { closeNavDropdown() });
	
	// put the correct svg in each .svg-icon element
	loadSvgIcons();
}

// set up background image samples
var	backgrounds, defaultBackground;
// reset page background to default
function resetBackground() {
	let sections = document.getElementsByClassName('section');
	for (let i = 0; i < sections.length; i++) { sections[i].classList.remove('transparent'); }
	document.body.style.background = defaultBackground;
	// reset all background test buttons
	let btns = document.getElementsByClassName('set-background');
	for (let i = 0; i < btns.length; i++) { resetBackgroundButton(btns[i]); }
}
// toggle given background test button
function toggleBackgroundButton(btn) {
	if (btn.dataset.testing != "true") {
		setBackgroundButton(btn);
	} else {
		resetBackground();
	}
}
// activate given background test button
function setBackgroundButton(btn) {
	// reset all other background test buttons
	let btns = document.getElementsByClassName('set-background');
	for (let i = 0; i < btns.length; i++) { resetBackgroundButton(btns[i]); }
	// set data & display for this button
	testBackgroundImage(btn.parentNode.querySelector('img').src);
	btn.dataset.testing = "true";
	btn.innerHTML = "[reset background]";
}
// reset given background test button
function resetBackgroundButton(btn) {
	btn.dataset.testing = "false";
	btn.innerHTML = btn.dataset.innerHTML;
	console.log(btn.dataset.innerHTML);
}
// test given background image
function testBackgroundImage(img) {
	// set background image
	document.body.style.background = 'url("' + img + '")';
	// reset all background test buttons
	let sections = document.getElementsByClassName('section');
	for (let i = 0; i < sections.length; i++) { sections[i].classList.add('transparent'); }
	// reset all background test buttons
	let btns = document.getElementsByClassName('set-background');
	for (let i = 0; i < btns.length; i++) { resetBackgroundButton(btns[i]); }
}