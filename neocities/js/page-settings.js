/* script to add at top of files to load this:
		<!-- page settings -->
		<script src="/js/page-settings.js?fileversion=9"></script>
*/

// variable for element where page settings options should go
var pageSettingsContents;
// variable for the button that opens the page settings
var pageSettings;

// add the page settings style sheet to the document that loaded this
let psCss = document.createElement('link');
psCss.rel = 'stylesheet';
psCss.type = 'text/css';
psCss.href = '/js/page-settings.css?fileversion=5'; /* make sure this links to the location of the css file! */
document.querySelector('HEAD').appendChild(psCss);

// when page loads, set up menu
window.addEventListener("load", () => {
	// add page settings menu to top of <body> if one doesn't already exist
	makePageSettingsElement();
	// add custom cursor toggle to menu
	addCustomCursorToggle();
});

/******************************************************************************/
// PAGE SETTINGS BASIC SETUP

// makes page settings element and adds to top of parent element
// parent element (psParent) will be document body if no alternate element specified
function makePageSettingsElement(psParent) {
	// check if page settings not already present to avoid duplicates
	pageSettings = document.querySelector('#page-settings');
	if (!pageSettings) {
		// make the settings element
		pageSettings = document.createElement('div');
		pageSettings.classList.add('page-settings');
		
		// make the container for the visible settings button area
		let container = document.createElement('div');
		pageSettings.appendChild(container);
		
		// make the settings button (opens/closes the settings)
		let button = document.createElement('button');
		button.id = "page-settings";
		button.classList.add("open-page-settings"), button.classList.add("btn-strip");
		button.onfocusvisible = "togglePageSettings();";
		button.addEventListener('click', () => { togglePageSettings(); });
		button.ariaLabel = "page settings"
		button.innerHTML = `
			<i class="svg-icon svg-icon-solid" data-icon="gear-solid" alt="">
				<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">
					<path style="stroke-linejoin:round;stroke-linecap:butt;" d="M 58.475469,8.2100704 V 25.772997 A 41.184249,41.184253 0 0 0 35.106834,39.084493 L 20.308319,30.540394 12.64347,43.816052 27.439039,52.358188 a 41.184249,41.184253 0 0 0 -2.48311,13.787695 41.184249,41.184253 0 0 0 2.392781,13.545669 l -14.70524,8.490098 7.155267,13.56973 15.138236,-8.739987 a 41.184249,41.184253 0 0 0 23.538496,13.507377 v 16.9748 l 15.329698,0.58813 V 106.51877 A 41.184249,41.184253 0 0 0 97.497322,92.806186 l 15.493668,8.945194 7.15527,-13.56973 -15.124,-8.732125 A 41.184249,41.184253 0 0 0 107.3247,66.145883 41.184249,41.184253 0 0 0 105.01048,52.554559 L 120.14626,43.816052 112.4819,30.540394 97.340717,39.282337 A 41.184249,41.184253 0 0 0 73.805167,25.688558 V 8.2100704 Z m 7.664849,31.9490626 a 25.987005,25.986999 0 0 1 25.98724,25.98675 25.987005,25.986999 0 0 1 -25.98724,25.987241 25.987005,25.986999 0 0 1 -25.98675,-25.987241 25.987005,25.986999 0 0 1 25.98675,-25.98675 z" />
				</svg>
			</i>
		`;
		container.appendChild(button);
		
		// add the settings area to the top of the parent element
		if (!psParent) { psParent = document.querySelector('body') }
		psParent.insertBefore(pageSettings,document.querySelector('body').firstChild);
	}
	// define variables for the button and contents elements
	pageSettingsContents = document.getElementById('page-settings-contents');
	if (!pageSettingsContents) {
		// make the settings content dropdown
		pageSettingsContents = document.createElement('div');
		pageSettingsContents.classList.add("page-settings-contents","hidden");
		pageSettingsContents.id = "page-settings-contents";
		pageSettingsContents.ariaLabel = "page settings";
		// put in div container
		pageSettings.appendChild(pageSettingsContents);
		
		// put the close button in the settings area
		psClose = document.createElement('button');
		psClose.id = "page-settings-close-button";
		psClose.addEventListener("click",function(){ hidePageSettings(); });
		psClose.innerHTML = "close";
		pageSettingsContents.appendChild(psClose);
	}
	pageSettingsContents = document.getElementById('page-settings-contents');
	psClose = document.getElementById('page-settings-close-button');
	psButton = document.getElementById('page-settings');
}

// add element to page settings at end before close button
function addPageSettingEl(el) {
	let pageSettingsContentsEls = pageSettingsContents.childNodes;
	pageSettingsContents.insertBefore(el,document.getElementById('page-settings-close-button'));
}
function addPageSettingCheckbox(input, label, description) {
	if (input) {
		if (label) {
			let labelEl = document.createElement('label');
			labelEl.htmlFor = input.id;
			labelEl.innerHTML = label;
			addPageSettingEl(labelEl);
		};
		input.type = 'checkbox';
		addPageSettingEl(input);
		if (description) {
			let descriptionEl = document.createElement('span');
			descriptionEl.innerHTML = description;
			addPageSettingEl(descriptionEl);
		};
	}
}

// toggle visibility of settings contents
function togglePageSettings() { pageSettingsContents.classList.toggle('hidden'); }
// hide settings contents
function hidePageSettings() { pageSettingsContents.classList.add('hidden'); }
function showPageSettings() {
	pageSettingsContents.classList.remove('hidden');
	// focus the button for keyboard navigation
	psButton.focus();
}

/******************************************************************************/
// CUSTOM CURSOR TOGGLE

var customCursorOn = true;
var cursorOnCheckbox = document.createElement('input');
function addCustomCursorToggle() {
	cursorOnCheckbox.id = "cursorOnCheckbox";
	cursorOnCheckbox.addEventListener('click', toggleCustomCursor);
	addPageSettingCheckbox(cursorOnCheckbox,`default cursor`,`check above to disable custom cursors across the site`);
	// if there is already a custom cursor setting in local storage, apply it
	console.log("locally stored customCursorOn = " + localStorage.getItem("customCursorOn"));
	if (localStorage.getItem("customCursorOn")) {
		customCursorOn = localStorage.getItem("customCursorOn");
		updateCustomCursorCheckbox();
		// apply
		if (isTrue(customCursorOn)) { enableCustomCursor(); }
		else { disableCustomCursor(); }
	}
	// functions to enable/disable custom cursor
	function toggleCustomCursor() {
		if (isTrue(customCursorOn)) { disableCustomCursor(); }
		else { enableCustomCursor(); }
		console.log("locally stored customCursorOn = " + localStorage.getItem("customCursorOn"));
	}
	function enableCustomCursor() {
		customCursorOn = true;
		localStorage.setItem("customCursorOn", customCursorOn);
		updateCustomCursorCheckbox();
		document.body.classList.add('customCursor');
		console.log('custom cursors enabled');
	}
	function disableCustomCursor() {
		customCursorOn = false;
		localStorage.setItem("customCursorOn", customCursorOn);
		updateCustomCursorCheckbox();
		document.body.classList.remove('customCursor');
		console.log('custom cursors disabled');
	}
	// check or uncheck the settings box based on customCursorOn value
	function updateCustomCursorCheckbox() { cursorOnCheckbox.checked = !isTrue(customCursorOn); }
}