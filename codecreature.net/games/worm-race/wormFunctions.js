let canFeed = true;

// enable/disable feed button based on current conditions
function updateFeedButton(color) {
	let form = document.getElementById(color);
	let btn = form.querySelector('.feed-button');
	
	// check if an item is selected
	let itemSelected = false;
	let itemInputs = form.querySelectorAll('.item-input');
	for (let i = 0; i < itemInputs.length; i++) {
		if (itemInputs[i].checked) itemSelected = true;
	}
	
	let hovertext = btn.querySelector('.tooltip-text');
	// if item has been selected and cooldown is over
	if ( itemSelected && canFeed ) {
		btn.classList.remove('tooltip');
		hovertext.innerHTML = '';
		btn.disabled = false;
	}
	// else disable button
	else {
		btn.classList.add('tooltip');
		btn.disabled = true;
		if ( !canFeed ) hovertext.innerHTML = 'too soon to feed again!';
		else if ( !itemSelected ) hovertext.innerHTML = 'select an item first';
	}
}
// update all feed buttons
function updateFeedButtons() {
	let forms = document.getElementsByClassName('worm-details')
	for (let i = 0; i < forms.length; i++) {
		updateFeedButton(forms[i].id);
	}
}

function openDetailBox(id) {
	// update the URL (no refresh)
	let newUrl = new URL(window.location.href);
	newUrl.pathname = newUrl.pathname.replaceAll('/racetrack','');
	newUrl.hash = '#' + id;
	if (window.location.pathname.includes('/racetrack')) window.location = newUrl;
	else window.history.pushState({}, "", newUrl);
	// display appropriate tabs
	let tabs = document.getElementsByClassName('tab');
	for (let i = 0; i < tabs.length; i++) {
		if (tabs[i].id == id) { tabs[i].classList.add('show'); }
		else { tabs[i].classList.remove('show'); }
	}
	hideFans(id);
}

// functions to hide or show a worm's leaderboard section
function hideFans(wormColor) {
	let detailBox = document.getElementById(wormColor);
	// show main sections
	let mainTabSections = detailBox.getElementsByClassName('main-worm-tab');
	for (let i = 0; i < mainTabSections.length; i++) mainTabSections[i].classList.remove('hidden');
	// hide leaderboard
	document.getElementById(wormColor+'-fans').classList.add('hidden');
	// change button text
	detailBox.querySelector('.leaderboard-button').innerHTML = 'fans';
}
function showFans(wormColor) {
	let detailBox = document.getElementById(wormColor);
	// hide main sections
	let mainTabSections = detailBox.getElementsByClassName('main-worm-tab');
	for (let i = 0; i < mainTabSections.length; i++) mainTabSections[i].classList.add('hidden');
	// hide leaderboard
	document.getElementById(wormColor+'-fans').classList.remove('hidden');
	// change button text
	detailBox.querySelector('.leaderboard-button').innerHTML = 'worm';
}
function toggleFans(wormColor) {
	let fans = document.getElementById(wormColor+'-fans');
	if (fans.classList.contains('hidden')) { showFans(wormColor); }
	else { hideFans(wormColor); }
}

// update the URL (no refresh) based on search params
// intended to convert old links to valid new ones
function updateUrl() {
	let wormParam = new URLSearchParams(window.location.search).get("worm");
	// if url parameters includes a value for worm and that result is a valid worm, open that worm
	if (wormParam) {
		let hash = "";
		
		// DEBUG: failed to do this with php, maybe try again later. clunky style for now
		if (wormParam == "0") hash = "#pink";
		else if (wormParam == "1") hash = "#orange";
		else if (wormParam == "2") hash = "#yellow";
		else if (wormParam == "3") hash = "#green";
		else if (wormParam == "4") hash = "#blue";
		else if (wormParam == "5") hash = "#purple";
		if (hash != "") {
			let newUrl = new URL(window.location.href);
			newUrl.search = "";
			newUrl.hash = hash;
			history.replaceState(null, null, newUrl);
		}
	}
}