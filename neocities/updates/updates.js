// force strict mode
"use strict";

// maximum number of updates to show in full page
var showLimit = 200;
// maximum number of updates to show in iframe
var iFrameShowLimit = 15;

var updates = '';
var displayUpdates = [];
var includedTags = [];
var excludedTags = [];

let updateArea;
let allTags = {};

loadUpdates();

function loadUpdates() {
	// check if this page has 'iframe' in its URL parameters
	// and that iframe parameter is not set to 'false'
	// if so, add the iframe class to this page's body
	// loaded from /js/iframe-detector.js
	iFrameParams();
	
	// url parameters
	let urlParams = new URL(window.location.toLocaleString()).searchParams;
	
	updateArea = document.getElementById('updatelist');
	
	// if this is being displayed in an iframe
	if ( document.body.classList.contains('iframe') ) showLimit = iFrameShowLimit;
	
	for (let update of updateLog) {
		let u, tagArea;
		
		if (updateLog.indexOf(update) < showLimit) {
			u = document.createElement('li');
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
			tagArea = document.createElement('div');
			tagArea.classList.add('tag-area');
			u.appendChild(tagArea);
			
			// add details area & put details inside
			let details = document.createElement('div');
			details.classList.add('details');
			details.innerHTML = tqFormatString(update.details);
			u.appendChild(details);
			
			// make images in detail area full viewable
			for (let img of Array.from(details.querySelectorAll('img'))) {
				let parType = img.parentNode.nodeName;
				if (!parType || (parType.toLowerCase() != 'button' && parType.toLowerCase() != 'button')) {
					img.classList.add('full-viewable');
				}
			}
		}
		
		if (update.tags) {
			// for each tag
			for (let t of update.tags) {
				t = t.trim();
				
				// add this tag to the global tag list
				if ( t in allTags ) { allTags[t].count += 1; }
				else {
					allTags[t] = {
						tag: t,
						btnTxt: `<button class="tag" onclick="includeTag('${t}');">#${t}`,
						tClass: tClass,
						show: 'neutral',
						count: 1
					};
				}
				
				if (u) {
					// add this tag's class to the update
					var tClass = 'tag-' + t.replace(' ', '-');
					u.classList.add(tClass);
					// put the tag link in the update's tag area
					tagArea.innerHTML += `<a href="/updates/?includeTags=${t}">#${t}</a> `;
				}
			}
		}
		if (u) updateArea.appendChild(u);
	}
	
	// list of all updates
	updates = document.querySelectorAll('.update');
	
	// create sorted tag array, put sorted tags in .all-tags element
	var allTagsArray = [];
	for (let key in allTags) { allTagsArray.push(allTags[key]); }
	allTagsArray.sort((a, b) => { return b.count - a.count });
	
	for (let t of allTagsArray) {
		document.querySelector('.all-tags').innerHTML +=
			t.btnTxt + ' [' + t.count + ']</button>' +
			`<button class="btn-strip add-tag" id="` + t.tClass + `-toggle" onclick="toggleTagState('` + t.tag + `', this);">+</button>`;
	}
	
	// if url parameters include or exclude tags, add those
	if ( urlParams.has('includeTags') ) {
		var includeTags = urlParams.get('includeTags').split(",");
		console.log('detected includeTags URL parameter with ' + includeTags.length + ' tags');
		// add included tags, don't update display yet
		includeTags.forEach((t) => { t = t.replace("%20"," "); includeTag(t, false); });
	}
	if ( urlParams.has('excludeTags') ) {
		var excludeTags = urlParams.get('excludeTags').split(",");
		console.log('detected excludeTags URL parameter with ' + excludeTags.length + ' tags');
		// add excluded tags, don't update display yet
		excludeTags.forEach((t) => { t = t.replace("%20"," "); excludeTag(t, false) });
	}
	// if url parameter include/exclude tags were added, update the posts to display
	if ( urlParams.has('includeTags') || urlParams.has('excludeTags') ) { updateTagDisplay(); }
	
	// if this is being displayed in an iframe
	if ( document.body.classList.contains('iframe') ) {
		// hide the show tag selections button
		document.getElementById('links').classList.add('hidden');
		
		let t = '/updates';
		if ( includedTags.length == 1 ) t += '?includeTags=' + includedTags[0].tag;
		
		title.innerHTML = '<img class="block" src="/graphix/deco/new-cat.gif" alt="">LATEST UPDATES';
		title.href = t;
		
		subtitle.innerHTML = 'click <u class="tq">4</u> full log';
		subtitle.href = t;
		
		updateIFrameDisplay();
		
	}
	// if this page is not being displayed in an iframe
	else {
		title.href = "/updates";
		title.innerHTML = '<img src="/graphix/deco/green-3d-spin-star.gif" alt=""> UPDATE LOG <img src="/graphix/deco/green-3d-spin-star.gif" alt="">';
		
		// for all update elements
		updates.forEach((u) => {
			if (includedTags.length == 0 && excludedTags.length == 0) u.style.display = 'block';
			
			// add nav links at bottom of posts
			u.querySelector('.details').innerHTML +=
				`<p class="txt-pink">
					<a href="#title" class="txt-pink">jump <u class="tq">2</u> latest</a>
					/ <a href="/" class="txt-pink">home</a>
				</p>`;
		});
		
		// hide the footer
		footer.display = 'none';
		
		// set up image full view
		initFullImage();
	}
}

function updateIFrameDisplay() {
	var iframeUpdates = updates;
	if (includedTags.length > 0) iframeUpdates = displayUpdates;
	
	// if there are more updates than shown, add "view more" link at bottom
	if ( updateLog.length > showLimit ) {
		footer.innerHTML= '<a href="/updates">more...</a>';
	}
	
	// for all updates in the list, up to the limit
	for (let u of iframeUpdates) {
		// make dates link to the full entry
		u.querySelector('.date').innerHTML =
			'<a href="/updates/#' + u.id + '">' + u.querySelector('.date').innerHTML + " &#8605;";
		u.querySelector('.date').innerHTML += '</a>';
	}
}

function toggleTagState(tag) {
	if ( tag in allTags ) {
		var t = allTags[tag];
		// if the tag is currently neutral, include it
		if ( t.show == 'neutral' ) {
			includeTag(tag);
		}
		// the tag is currently included, exclude it
		else if (t.show == 'include') {
			excludeTag(tag);
		}
		// if the tag is currently excluded, make it neutral
		else if (t.show == 'exclude') {
			neutralTag(tag);
		}
	}
}

// include this tag in the tags being shown
function includeTag(tag, update) {
	// if the tag is valid
	if ( tag in allTags ) {
		// mark the tag as included
		allTags[tag].show = 'include';
		
		// if not told not to update the display
		if (update != false) {
			// update what is being shown
			updateTagDisplay();
		}
		
		// update the toggle button style for the tag 
		var btn = document.getElementById(allTags[tag].tClass + '-toggle')
		if (btn) {
			btn.classList.add('selected');
			btn.innerHTML = '+';
			btn.ariaLabel = 'exclude tag';
		}
	}
	else console.log('includTag(tag) could not add tag ' + tag + ' - error: not in allTags list');
}

// exclude this tag from the tags being shown
function excludeTag(tag, update) {
	// if the tag is valid
	if ( tag in allTags ) {
		// mark the tag as excluded
		allTags[tag].show = 'exclude';
		
		// if not told not to update the display
		if (update != false) {
			// update what is being shown
			updateTagDisplay();
		}
		
		// update the toggle button style for the tag 
		var btn = document.getElementById(allTags[tag].tClass + '-toggle')
		if (btn) {
			btn.classList.add('selected');
			btn.innerHTML = '-';
			btn.ariaLabel = 'default tag';
		}
		
		// log
		console.log('now excluding tag ' + tag);
	}
}

// make tag neither specifically included nor excluded
function neutralTag(tag, update) {
	// if the tag is valid
	if ( tag in allTags ) {
		// mark the tag as neutral
		allTags[tag].show = 'neutral';
		
		// if not told not to update the display
		if (update != false) {
			// update what is being shown
			updateTagDisplay();
		}
		
		// update the toggle button style for the tag 
		var btn = document.getElementById(allTags[tag].tClass + '-toggle')
		if (btn) {
			btn.classList.remove('selected');
			btn.innerHTML = '+';
			btn.ariaLabel = 'include tag';
		}
		
		// log
		console.log('now not excluding or including tag ' + tag);
	}
}

// update what should be shown
function updateTagDisplay() {
	// reset arrays of included and excluded tag classes
	includedTags = [];
	excludedTags = [];
	// reset array of updates to be displayed
	displayUpdates = [];
	// for each tag that exists
	for ( let tag in allTags ) {
		if ( allTags[tag].show == 'include' ) includedTags.push(allTags[tag]);
		else if ( allTags[tag].show == 'exclude' ) excludedTags.push(allTags[tag]);
	}
	// for each update, hide it unless it contains all included tags and no excluded tags
	updates.forEach((u) => {
		let incl = true;
		// if it is missing an included tag, set incl as false
		includedTags.forEach((t) => { if ( !u.classList.contains(t.tClass) ) incl = false; });
		// if it has an excluded tag, set incl as false
		excludedTags.forEach((t) => { if ( u.classList.contains(t.tClass) ) incl = false; });
		// if it meets all requirements, display it
		if (incl) {
			u.style.display = 'block';
			displayUpdates.push(u);
		}
		// otherwise hide it
		else { u.style.display = 'none'; }
	});
	console.log('updated display based on tag parameters. showing ' + displayUpdates.length + ' out of ' + updateLog.length + ' updates');
}