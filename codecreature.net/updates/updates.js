// force strict mode
"use strict";

// maximum number of updates to show in full page
var showLimit = 10;
// maximum number of updates to show in iframe
var iFrameShowLimit = 12;
// first update to show on page
let firstUpdate = 0;

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
				tags.reset(tag);
			}
			else { // if the tag is currently neutral, include it
				this.include(tag);
			}
		}
	},
	// include given tag in the tags being shown
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
			if (update != false && added) { tags.update(); }
			
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
	// exclude given tag from the tags being shown
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
			if (update != false && added) { tags.update(); }
			
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
	// make given tag neither specifically included nor excluded
	reset: function(tag, update) {
		// if the tag is valid
		if ( tag in allTags ) {
			// remove tag from includedTags
			let includeIndex = includedTags.indexOf(tag);
			if (includeIndex > -1) { includedTags.splice(includeIndex, 1); }
			// remove tag from excludedTags
			let excludeIndex = excludedTags.indexOf(tag);
			if (excludeIndex > -1) { excludedTags.splice(excludeIndex, 1); }
			
			// if display should update, update it
			if (update != false && (includeIndex > -1 || excludeIndex > -1)) { tags.update(); }
			
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
		else console.error('tags.reset() could not reset tag ' + tag + ' (not in allTags list)');
	},
	// update the tags to show via the URL parameters, then reset the page
	update: function() {
		let newUrl = new URL(location);
		newUrl.searchParams.set("includedTags", includedTags.toString());
		newUrl.searchParams.set("excludedTags", excludedTags.toString());
		firstUpdate = 0;
		newUrl.searchParams.set("firstUpdate", firstUpdate);
		// add new parameters to url
		history.pushState({}, "", newUrl);
		// reload updates with new parameters
		updates.load();
	},
};

const updates = {
	// list of all update elements
	list: [],
	// current sort function
	sort: 'newest',
	// sorts by the given string ('newest','oldest')
	sortBy: function(sort) {
		filters.close();
		if (updates.sort != sort) {
			updates.sort = sort;
			let newUrl = new URL(location);
			newUrl.searchParams.set("updateSort", sort);
			// add new search parameters to url
			history.pushState({}, "", newUrl);
			// reload updates with new parameters
			updates.load();
		}
	},
	load: function() {
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
				// if sorting oldest to newest, add to beginning
				if (updates.sort == 'oldest') { loadUpdates.unshift(update); }
				// if sorting newest to oldest (default), add to end
				else { loadUpdates.push(update); }
			}
		});
		
		// load updates above the first update index & below max display limit
		for (let i = firstUpdate; (i < loadUpdates.length && i < firstUpdate + showLimit); i++) {
			updates.createElement(loadUpdates[i]);
		}
		
		console.log(
			`Updates loader detected ${loadUpdates.length} updates matching parameters.`,
			`Displaying ${showLimit} updates, #${firstUpdate+1} to #${firstUpdate+showLimit}`
		);
		
		
		// if url parameters specifies an update to start at
		if (firstUpdate > 1) {
			let prevUrl = new URL(window.location.toLocaleString()).searchParams;
			prevUrl.set("firstUpdate", Math.max(0, firstUpdate - showLimit));
			document.getElementById('previous-page').href = window.location.pathname + "?" + prevUrl.toString();
			// show previous page button
			document.querySelector('footer').classList.remove('hidden');
			document.getElementById('previous-page').classList.remove('hidden');
		} else { 
			document.getElementById('previous-page').classList.add('hidden');
		}
		
		// if more updates were loadable than could be shown, show "next page" button
		if (loadUpdates.length > firstUpdate + showLimit) {
			document.querySelector('footer').classList.remove('hidden');
			document.getElementById('next-page').classList.remove('hidden');
			
			let nextUrl = new URL(location);
			nextUrl.searchParams.set('firstUpdate', firstUpdate + showLimit);
			document.getElementById('next-page').href = nextUrl;
		} else { 
			document.getElementById('next-page').classList.add('hidden');
		}
		
		// set up image full view
		fullImageView.init();
	},
	// create element for an update from updateLog
	createElement: function(update) {
		let u = document.createElement('li');
		u.classList.add('update');
		
		// set id = array index
		u.id = update.index;
		
		// add date area & put date inside
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
					<a href="/updates#top" class="txt-pink">jump <u class="tq">2</u> latest</a>
					/ <a href="/" class="txt-pink">home</a>
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
				`<a href="/updates/#${u.id}">${u.querySelector('.date').innerHTML}&#8605;</a>`;
		}
		
		// put the element in the main updates area
		updateArea.appendChild(u);
	},
};

// self executing initiation function
(()=>{
	// element to insert updates into
	updateArea = document.getElementById('updatelist');
	
	// url parameters
	let urlParams = new URL(window.location.toLocaleString()).searchParams;
	
	// reset hash link if is page nav
	let hash = window.location.hash.replace('#','');
	if (hash == 'top' || hash == 'pagination') window.location.hash = '';
	else if (!isNaN(Number(hash))) firstUpdate = Number(hash);
	
	// if url parameters specifies an update to start at
	if ( urlParams.has('firstUpdate') ) { firstUpdate = Number(urlParams.get('firstUpdate')); }
	
	
	// if url parameters specifies a number of updates to show
	if ( urlParams.has('showLimit') ) {
		let limit = Number(urlParams.get('showLimit'));
		if( !isNaN(limit) ) {
			showLimit = limit;
			iFrameShowLimit = limit;
		}
	}
	
	// normalize first update based on page length limit
	firstUpdate = Math.floor(firstUpdate/showLimit) * showLimit;
	
	// if url parameters specifies a sort order
	if ( urlParams.has('updateSort') ) { updates.sort = urlParams.get('updateSort'); }
	
	// check if this page has 'iframe' in its URL parameters
	// and that iframe parameter is not set to 'false'
	// if so, add the iframe class to this page's body
	// loaded from /codefiles/iframe-detector.js
	iFrameParams();
	
	// if this is being displayed in an iframe
	if ( document.body.classList.contains('iframe') ) showLimit = iFrameShowLimit;
	
	// for each update in the log
	for (let i = 0; i < updateLog.length; i++) {
		let update = updateLog[i];
		update.index = i;
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
	}
	
	// create sorted all tags array
	var allTagsArray = [];
	for (let key in allTags) { allTagsArray.push(allTags[key]); }
	allTagsArray.sort((a, b) => { return b.count - a.count });
	
	// put sorted tags in #all-tags element
	allTagsArray.forEach((t) => {
		let buttonDiv = document.createElement('div');
		// add tag count to tag button
		t.btn.innerHTML += ' [' + t.count + ']';
		t.btn.classList.add('tag-name');
		// create tag view toggle button
		let toggleBtn = document.createElement('button');
		toggleBtn.classList.add('add-tag');
		toggleBtn.id = t.tClass + "-toggle";
		toggleBtn.innerHTML = "+";
		toggleBtn.addEventListener('click',()=>{ tags.toggle(t.name); });
		// add buttons to tag buttons area
		buttonDiv.appendChild(t.btn);
		buttonDiv.appendChild(toggleBtn);
		document.getElementById('all-tags').appendChild(buttonDiv);
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
	
	updates.load();
})();

const filters = {
	toggle: function() { document.getElementById('sort-filter').classList.toggle('hidden'); },
	open: function() { document.getElementById('sort-filter').classList.remove('hidden'); },
	close: function() { document.getElementById('sort-filter').classList.add('hidden'); }
}

function updateIFrameDisplay() {
	document.getElementById('more-link').href = window.location.pathname + window.location.search;
}