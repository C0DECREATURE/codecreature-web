// force strict mode
"use strict";

// maximum number of updates to show in full page
var showLimit = 10;
// maximum number of updates to show in iframe
var iFrameShowLimit = 12;
// first update to show on page
let firstUpdate = 0;

var updates = []; // list of all update elements
var includedTags = [];
var excludedTags = [];

let urlParams; // url search parameters

let updateArea; // area where update elements should be placed
let allTags = {}; // all update tags + their states

// tag related functions
const tags = {
	// toggle the state of the given tag between included, excluded, and neutral
	toggle: function(tag) {
		if ( tag in allTags ) {
			let included = includedTags.includes(tag);
			let excluded = excludedTags.includes(tag);
			
			if (included) { // the tag is currently included, exclude it
				tags.exclude(tag);
			}
			else if (excluded) { // if the tag is currently excluded, make it neutral
				neutralTag(tag);
			}
			else { // if the tag is currently neutral, include it
				this.include(tag);
			}
		}
	},
	// include this tag in the tags being shown
	include: function(tag,update) {
		// if the tag is valid
		if ( tag in allTags ) {
			// remove tag from excludedTags
			let excludeIndex = excludedTags.indexOf(tag);
			if (excludeIndex > -1) { excludedTags.splice(excludeIndex, 1); }
			// add tag to includedTags
			let added = false; // if tag was actually added
			if (!includedTags.includes(tag)) {
				includedTags.push(tag);
				added = true;
			}
			
			// if display should update, update it
			if (update != false && added) { updateTagDisplay(); }
			
			// update the toggle button style for the tag 
			var btn = document.getElementById(allTags[tag].tClass + '-toggle')
			if (btn) {
				btn.classList.add('included');
				btn.innerHTML = '+';
				btn.ariaLabel = 'exclude tag';
			}
			
			// log
			console.log('including tag: ' + tag);
		}
		else console.error('tags.include() could not add tag ' + tag + ' (not in allTags list)');
	},
	// exclude this tag from the tags being shown
	exclude: function(tag, update) {
		// if the tag is valid
		if ( tag in allTags ) {
			// remove tag from includedTags
			let includeIndex = includedTags.indexOf(tag);
			if (includeIndex > -1) { includedTags.splice(includeIndex, 1); }
			// remove tag from excludedTags
			let added = false;
			if (!excludedTags.includes(tag)) {
				excludedTags.push(tag);
				added = true; // if tag was actually added
			}
			
			// if display should update, update it
			if (update != false && added) { updateTagDisplay(); }
			
			// update the toggle button style for the tag 
			var btn = document.getElementById(allTags[tag].tClass + '-toggle')
			if (btn) {
				btn.classList.add('excluded');
				btn.innerHTML = '-';
				btn.ariaLabel = 'remove tag';
			}
			
			// log
			console.log('excluding tag: ' + tag);
		}
		else console.error('tags.exclude() could not add tag ' + tag + ' (not in allTags list)');
	},
};

// self executing initiation function
(()=>{
	// element to insert updates into
	updateArea = document.getElementById('updatelist');
	
	// url parameters
	let urlParams = new URL(window.location.toLocaleString()).searchParams;
	
	// reset hash link if is page nav
	let hash = window.location.hash;
	if (hash == '#top' || hash == '#pagination') window.location.hash = '';
	
	// check if this page has 'iframe' in its URL parameters
	// and that iframe parameter is not set to 'false'
	// if so, add the iframe class to this page's body
	// loaded from /js/iframe-detector.js
	iFrameParams();
	
	// if this is being displayed in an iframe
	if ( document.body.classList.contains('iframe') ) showLimit = iFrameShowLimit;
	
	// if url parameters specifies an update to start at
	if ( urlParams.has('firstUpdate') ) {
		// convert parameter from string to number
		firstUpdate = Number(urlParams.get('firstUpdate'));
	}
	
	// for each update in the log
	updateLog.forEach((update) => {
		// for each tag
		update.tags.forEach((t) => {
			t = t.trim();
			// if tag already in global tag list, update count
			if ( t in allTags ) { allTags[t].count += 1; }
			// if tag not in global tag list, add it
			else {
				allTags[t] = {
					name: t,
					tClass: t.replaceAll(' ','-'),
					count: 1
				};
				// create button element for tag, don't add to document yet
				allTags[t].btn = document.createElement('button');
				allTags[t].btn.addEventListener('click',()=>{ tags.include(allTags[t].tag); });
				allTags[t].btn.innerHTML = t;
			}
		});
	})
				
	// create sorted all tags array
	var allTagsArray = [];
	for (let key in allTags) { allTagsArray.push(allTags[key]); }
	allTagsArray.sort((a, b) => { return b.count - a.count });
	
	// put sorted tags in .all-tags element
	allTagsArray.forEach((t) => {
		// add tag count to tag button
		t.btn.innerHTML += ' [' + t.count + ']';
		// create tag view toggle button
		let toggleBtn = document.createElement('button');
		toggleBtn.classList.add('btn-strip','add-tag');
		toggleBtn.id = t.tClass + "-toggle";
		toggleBtn.innerHTML = "+";
		toggleBtn.addEventListener('click',()=>{ tags.toggle(t.name); });
		// add buttons to tag buttons area
		document.querySelector('.all-tags').appendChild(t.btn);
		document.querySelector('.all-tags').appendChild(toggleBtn);
	});
	
	// if this is being displayed in an iframe
	if ( document.body.classList.contains('iframe') ) {
		// set up iframe
		updateIFrameDisplay();
	}
	
	// if url parameters include or exclude tags, add those
	if ( urlParams.has('includedTags') && urlParams.get('includedTags') != "" ) {
		let includedTags = urlParams.get('includedTags').split(",");
		console.log('detected includedTags URL parameter with ' + includedTags.length + ' tags');
		// add included tags to list
		includedTags.forEach((t) => {
			t = t.replace("%20"," ");
			tags.include(t, false);
		});
	}
	if ( urlParams.has('excludedTags') && urlParams.get('excludedTags') != "" ) {
		var excludedTags = urlParams.get('excludedTags').split(",");
		console.log('detected excludedTags URL parameter with ' + excludedTags.length + ' tags');
		// add excluded tags, don't update display yet
		excludedTags.forEach((t) => {
			t = t.replace("%20"," ");
			tags.exclude(t, false)
		});
	}
	
	loadUpdates();
})();

function loadUpdates() {
	
	// clear loaded updates
	updateArea.textContent = '';
	
	// updates to load
	let loadUpdates = [];
	
	updateLog.forEach((update) => {
		// whether to load this update
		let load = true;
		
		// if it has tags
		if (update.tags) {
			// if it is missing an included tag, don't load
			includedTags.forEach((t) => { if ( !update.tags.includes(t) ) load = false; });
			// if it has an excluded tag, don't load
			excludedTags.forEach((t) => { if ( update.tags.includes(t) ) load = false; });
		}
		
		// if it meets requirements, add to list
		if (load) {
			loadUpdates.push(update);
			// if this is at the first update index or above, and max display limit not reached, load it
			if (
				loadUpdates.indexOf(update) >= firstUpdate &&
				loadUpdates.length <= firstUpdate + showLimit
			) { createUpdate(update); }
		}
	});
	
	console.log(`Updates loader detected ${loadUpdates.length} updates matching parameters.`);
	
	
	// if url parameters specifies an update to start at
	if (firstUpdate > 1) {
		let queryParams = new URL(window.location.toLocaleString()).searchParams;
		queryParams.set("firstUpdate", Math.max(0, firstUpdate - showLimit));
		document.getElementById('previous-page').href = window.location.pathname + "?" + queryParams.toString();
		// show previous page button
		document.querySelector('footer').classList.remove('hidden');
		document.getElementById('previous-page').classList.remove('hidden');
	}
	
	// if more updates were loadable than could be shown, show "next page" button
	if (loadUpdates.length > firstUpdate + showLimit) {
		document.querySelector('footer').classList.remove('hidden');
		document.getElementById('next-page').classList.remove('hidden');
		
		let nextUrl = new URL(location);
		nextUrl.searchParams.set('firstUpdate', firstUpdate + showLimit);
		document.getElementById('next-page').href = nextUrl;
	}
	
	// set up image full view
	initFullImage();
}

// create element for an update from updateLog
function createUpdate(update) {
	console.log('creating update');
	let u = document.createElement('li');
	u.classList.add('update');
	
	// add date area & put date inside, set id = date
	u.id = update.date.toLocaleString().replace(/\/| |:/g, '-').replace(/,/g,''); // replace / or space with dash
	let date = document.createElement('div');
	date.classList.add('date');
	date.innerHTML = update.date.toLocaleDateString('en-US',{dateStyle:'short'});
	u.appendChild(date);
	
	// add summary area & put summary inside
	let summary = document.createElement('div');
	summary.classList.add('summary');
	summary.innerHTML = tqFormatString(update.summary);
	u.appendChild(summary);
	
	// add tag area
	let tagArea = document.createElement('div');
	tagArea.classList.add('tag-area');
	// if it has tags, put the tag link in the tag area
	if (update.tags) {
		update.tags.forEach((tag) => {
			let a = document.createElement('a');
			a.href = "/updates/?includedTags=" + tag;
			a.innerHTML = "#" + tag;
			tagArea.appendChild(a);
		});
	}
	u.appendChild(tagArea);
	
	// add details area & put details inside
	let details = document.createElement('div');
	details.classList.add('details');
	details.innerHTML = tqFormatString(update.details);
	// if this page is not being displayed in an iframe
	if ( !document.body.classList.contains('iframe') ) {
		details.innerHTML +=
			`<p class="txt-pink">
				<a href="#title" class="txt-pink">jump <u class="tq">2</u> latest</a>
				/ <a href="/home" class="txt-pink">home</a>
			</p>`;
	}
	u.appendChild(details);
	
	// make images in detail area full viewable
	for (let img of Array.from(details.querySelectorAll('img'))) {
		let parType = img.parentNode.nodeName;
		if (!parType || (parType.toLowerCase() != 'button' && parType.toLowerCase() != 'button')) {
			img.classList.add('full-viewable');
		}
	}
	
	// if this is being displayed in an iframe
	if ( document.body.classList.contains('iframe') ) {
		// make dates link to the full entry
		u.querySelector('.date').innerHTML =
			`<a href="/updates/#${u.id}">${u.querySelector('.date').innerHTML}&#8605;`;
		u.querySelector('.date').innerHTML += '</a>';
	}
	
	// put the element in the main updates area
	updateArea.appendChild(u);
	
	// add the element to the updates array
	updates.push(u);
}

function updateIFrameDisplay() {
	
	document.getElementById('more-link').href = window.location.pathname + window.location.search;
}

// make tag neither specifically included nor excluded
function neutralTag(tag, update) {
	// if the tag is valid
	if ( tag in allTags ) {
		// remove tag from includedTags
		let includeIndex = includedTags.indexOf(tag);
		if (includeIndex > -1) { includedTags.splice(includeIndex, 1); }
		// remove tag from excludedTags
		let excludeIndex = excludedTags.indexOf(tag);
		if (excludeIndex > -1) { excludedTags.splice(excludeIndex, 1); }
		
		// if display should update, update it
		if (update != false && (includeIndex > -1 || excludeIndex > -1)) { updateTagDisplay(); }
		
		// update the toggle button style for the tag 
		var btn = document.getElementById(allTags[tag].tClass + '-toggle')
		if (btn) {
			btn.classList.remove('included','excluded');
			btn.innerHTML = '+';
			btn.ariaLabel = 'include tag';
		}
		
		// log
		console.log('not excluding or including tag: ' + tag);
	}
	else console.error('neutralTag(tag) could not add tag ' + tag + ' (not in allTags list)');
}

// update tags to show and reload
function updateTagDisplay() {
	let newUrl = new URL(location);
	newUrl.searchParams.set("includedTags", includedTags.toString());
	newUrl.searchParams.set("excludedTags", excludedTags.toString());
	firstUpdate = 0;
	newUrl.searchParams.set("firstUpdate", firstUpdate);
	// add new parameters to url
	history.pushState({}, "", newUrl);
	// reload updates with new parameters
	loadUpdates();
}