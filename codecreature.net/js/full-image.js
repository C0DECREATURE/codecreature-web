/*
// put at top of html document
		<!--full image view-->
		<script src="/js/full-image.js?fileversion=9"></script>

// optional CSS options for pages that load this script
.full-image-view {
	--accent: var(--white);
	--text: inherit;
	--background: var(--black);
	--border: 1px var(--accent) dashed;
}

*/

// force strict mode
"use strict";

const fullImageView = {
	// full image view html element
	element: null,
	loadDependencies: function() {
		if (!document.getElementById('full-image-view-css')) {
			// add the associated style sheet to the document that loaded this
			let css = document.createElement('link');
			css.rel = 'stylesheet';
			css.type = 'text/css';
			css.href = "/js/full-image.css?fileversion=9";
			css.id = "full-image-view-css";
			document.querySelector('HEAD').appendChild(css);
		}
		if (!document.getElementById('svg-icons-js')) {
			try {
				// add the associated style sheet to the document that loaded this
				let js = document.createElement('script');
				js.src = "/graphix/svg-icons/svg-icons.js";
				js.id = "svg-icons-js";
				document.querySelector('HEAD').appendChild(js);
			} catch { console.error(`full image view couldn't load svg-icons.js`) }
		}
	},
	// collection of img elements that can be clicked to full view
	viewables: [],
	// this.viewables array index of the currently viewed image
	curEl: 0,
	// whether this.init function has been run already
	initCalled: false,
	// set up full image view
	init: function() {
		if (!this.initCalled) {
			this.initCalled = true;
			
			this.loadDependencies();
			
			// add overlay element to body of html document if one doesn't exist
			if (!document.querySelector('.full-image-view')) {
				this.element = document.createElement('div');
				this.element.classList.add('full-image-view','hidden');
			} else this.element = document.querySelector('.full-image-view');
			// fill it with content
			this.element.innerHTML = `
				<div id="fiv-clicker"></div>
				
				<button id="fiv-close" aria-label="close full image view">
					<i class="svg-icon svg-icon-outline svg-icon-bold" data-icon="rounded-x"></i>
				</button>
				
				<button id="fiv-prev" aria-label="previous full view image">
					<i class="svg-icon svg-icon-solid" data-icon="rounded-caret-left"></i>
				</button>
				
				<button id="fiv-next" aria-label="next full view image">
					<i class="svg-icon svg-icon-solid" data-icon="rounded-caret-right"></i>
				</button>
				
				<div class="fiv-content">
					<div><img class="image" src="" alt=""></div>
					<div class="text">
						<p class="credit"></p>
						<p class="caption"></p>
						<p class="alt" aria-hidden="true"></p>
					</div>
				</div>
			`;
			// add it to the body
			document.querySelector('body').appendChild(this.element);
			
			this.image = fullImageView.element.querySelector('.image');
			this.textbox = fullImageView.element.querySelector('.text');
			this.credit = fullImageView.element.querySelector('.credit');
			this.caption = fullImageView.element.querySelector('.caption');
			this.alt = fullImageView.element.querySelector('.alt');
			
			// make background clicker and close button close full image view
			document.getElementById('fiv-clicker').addEventListener('click', fullImageView.close);
			document.getElementById('fiv-close').addEventListener('click', fullImageView.close);
			// make next/prev buttons open next/prev image
			document.getElementById('fiv-prev').addEventListener('click', fullImageView.openPrev);
			document.getElementById('fiv-next').addEventListener('click', fullImageView.openNext);			
			
			/////////////////////////////////////////
			// KEYBOARD & TOUCH CONTROLS
			this.setUpViewables();
			
			// keyboard controls
			document.addEventListener('keydown', function(event) {
				// if the full image overlay is displayed
				if ( fullImageView.isOpen() ) {
					if (event.key === "Escape") fullImageView.close();
					else if (event.key === "ArrowRight" || event.key === "ArrowDown") {
						event.preventDefault();
						fullImageView.openNext();
					}
					else if (event.key === "ArrowLeft" || event.key === "ArrowUp" ) {
						event.preventDefault();
						fullImageView.openPrev();
					}
				}
				// otherwise, check if a full-viewable element is focused click on enter
				else {
					const { activeElement } = document;
					const hasButtonRole = activeElement?.getAttribute('role') === 'button';
					if (hasButtonRole) {
						// prevent default behaviour, including scrolling on spacebar
						if (['Spacebar', ' ', 'Enter'].includes(event.key)) { event.preventDefault() }
						if (event.key === 'Enter') { activeElement.click() }
					}
				}
			});
			// if full-viewable element is focused, click on spacebar up
			document.addEventListener('keyup', (event) => {
				if ( !fullImageView.isOpen() ) {
					const { activeElement } = document;
					const hasButtonRole = activeElement?.getAttribute('role') === 'button';
					if (hasButtonRole && ['Spacebar', ' '].includes(event.key)) {
						event.preventDefault()
						activeElement.click()
					}
				}
			});
			
			// if svg-icons has already run, run it again on the full image view element
			if (typeof defaultSvgIcons !== 'undefined' && defaultSvgIcons.loaded == true) {
				defaultSvgIcons.load(fullImageView.element);
			}
			
			console.log('full image view setup complete');
		}
	},
	setUpViewables: function() {
		// make all full-viewable class elements open the full image view overlay on click
		this.viewables = document.getElementsByClassName('full-viewable');
		for ( let i = 0; i < this.viewables.length; i++ ) {
			var img = this.viewables[i];
			img.dataset.fullImageListIndex = i;
			// make element behave like a button for accessibility
			img.role = 'button';
			img.tabIndex = '0';
			// trigger open function
			img.addEventListener('click', function() { fullImageView.open(this); } );
		}
		
	},
	// close the full image view
	close: function() {
		if (fullImageView.isOpen()) {
			// hide full view element
			fullImageView.element.classList.add('hidden');
			// focus image that was opened
			fullImageView.viewables[fullImageView.curEl].focus();
		}
	},
	// opens the full image overlay for the given image element
	open: function(img) {
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
		fullImageView.curEl = img.dataset.fullImageListIndex;
		
		let logNum = Number(fullImageView.curEl) + 1;
		console.log('opening full image #' + logNum + ': ' + src);
		
		// put the image in the overlay
		fullImageView.image.src = src;
		// if credit link was provided
		var credit = img.dataset.credit;
		var creditLabel = img.dataset.creditLabel;
		if ( credit ) {
			let txt = '<a href="' + credit + '">';
			if ( creditLabel ) txt += creditLabel + '</a>';
			else txt += 'credit</a>';
			fullImageView.credit.innerHTML = txt;
		} else fullImageView.credit.innerHTML = '';
		// if caption was provided
		var caption = img.dataset.caption;
		if ( caption ) fullImageView.caption.innerHTML = caption;
		else fullImageView.caption.innerHTML = '';
		// if image has alt text provided
		if ( alt && alt != "" ) {
			fullImageView.image.alt = alt;
			let txt = '';
			if (credit || caption) txt += '<hr>';
			fullImageView.alt.innerHTML = txt + 'alt text: ' + alt;
		} else fullImageView.alt.innerHTML = '';
		
		// if text content was provided
		if (credit || caption || alt) { fullImageView.textbox.classList.remove('hidden'); }
		else { fullImageView.textbox.classList.add('hidden'); }
		
		if (!fullImageView.isOpen()) {
			// display the full image overlay
			fullImageView.element.classList.remove('hidden');
			// focus the full image overlay
			document.getElementById('fiv-close').focus();
		}
	},
	// returns boolean - whether full image view is open
	isOpen: function() { return !fullImageView.element.classList.contains('hidden'); },
	// touchscreen variables
	touchInput: {
		startX: 0,
		endX: 0,
		startY: 0,
		endY: 0,
		check: function() {
			// if the full image overlay is displayed
			if ( fullImageView.isOpen() ) {
				// minimum pixels of movement to consider a touch a swipe
				var minSwipe = 30;
				// if horizontal swipe was made
				// horizontal move greater than minSwipe and change in X was greater than change in Y
				if (
					Math.abs(this.touchInput.endX-this.touchInput.startX) > minSwipe &&
					Math.abs(this.touchInput.endX-this.touchInput.startX) > Math.abs(this.touchInput.endY-this.touchInput.startY)
				) {
					if (this.touchInput.endX < this.touchInput.startX) fullImageView.openNext();
					if (this.touchInput.endX > this.touchInput.startX) fullImageView.openPrev();
				}
			}
		},
	},
}

// create css immediately when this script is loaded
fullImageView.loadDependencies();

window.addEventListener('load', () => {
	if (typeof dontAutoInitFIV !== 'undefined' && dontAutoInitFIV) {}
	// if another script hasn't disabled this script's auto init
	else {
		// set up image full view
		fullImageView.init();
	}
});

// detect start of swipe/touch
document.addEventListener('touchstart', e => {
	fullImageView.touchInput.startX = e.changedTouches[0].screenX;
	fullImageView.touchInput.startY = e.changedTouches[0].screenY;
})
// detect end of swipe/touch
document.addEventListener('touchend', e => {
  fullImageView.touchInput.endX = e.changedTouches[0].screenX;
  fullImageView.touchInput.endY = e.changedTouches[0].screenY;
  fullImageView.touchInput.check();
})

// check touchscreen input
fullImageView.touchInput.check = function() {
	// if the full image overlay is displayed
	if ( fullImageView.isOpen() ) {
		// minimum pixels of movement to consider a touch a swipe
		var minSwipe = 30;
		// if horizontal swipe was made
		// horizontal move greater than minSwipe and change in X was greater than change in Y
		if (
			Math.abs(this.touchInput.endX-this.touchInput.startX) > minSwipe &&
			Math.abs(this.touchInput.endX-this.touchInput.startX) > Math.abs(this.touchInput.endY-this.touchInput.startY)
		) {
			if (this.touchInput.endX < this.touchInput.startX) fullImageView.openNext();
			if (this.touchInput.endX > this.touchInput.startX) fullImageView.openPrev();
		}
	}
}

// opens the previous image in fullImageView.viewables
fullImageView.openPrev = function() {
	var prev = Number(fullImageView.curEl) - 1;
	if ( prev < 0 ) prev = fullImageView.viewables.length - 1;
	fullImageView.open( fullImageView.viewables[prev] );
	fullImageView.viewables[prev].scrollIntoView({ behavior: "smooth" });
}

// opens the next image in fullImageView.viewables
fullImageView.openNext = function() {
	var next = Number(fullImageView.curEl) + 1;
	if ( next >= fullImageView.viewables.length) next = 0;
	fullImageView.open( fullImageView.viewables[next] );
	fullImageView.viewables[next].scrollIntoView({ behavior: "smooth", block: "nearest" });
}