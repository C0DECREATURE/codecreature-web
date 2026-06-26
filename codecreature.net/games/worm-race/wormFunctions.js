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
	else window.history.replaceState({}, "", newUrl);
	// display appropriate tabs
	let tabs = document.getElementsByClassName('tab');
	for (let i = 0; i < tabs.length; i++) {
		if (tabs[i].id == id) { tabs[i].classList.add('show'); }
		else { tabs[i].classList.remove('show'); }
	}
	showWormTab(id,'main-worm-tab');
}

// functions to hide or show a worm's tab sections (leaderboard, main, trophies)
function showWormTab(wormColor,tab) {
	if (tab == "details" || tab == "items") { tab = "main-worm-tab"; }
	// hide all tabs
	hideWormTabs(wormColor);
	// show leaderboard
	let tabs = document.getElementById(wormColor).getElementsByClassName(tab);
	for (let i = 0; i < tabs.length; i++) tabs[i].classList.remove('hidden');
}
// hide all worm tabs
function hideWormTabs(wormColor) {
	let detailBox = document.getElementById(wormColor);
	// hide tabs sections
	let tabs = detailBox.getElementsByClassName('tab');
	for (let i = 0; i < tabs.length; i++) tabs[i].classList.add('hidden');
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
			history.replaceState(null, '', newUrl);
		}
	}
}