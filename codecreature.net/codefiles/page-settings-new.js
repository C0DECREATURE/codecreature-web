/*

place this where the element should be in the dom order
<?php include $_SERVER["DOCUMENT_ROOT"]."/codefiles/page-settings.php"; ?>

*/

const pageSettings = {
	// page settings container
	container: document.getElementById('page-settings'),
	// open/close button
	button: document.getElementById('page-settings-button'),
	// page settings options popup
	contents: document.getElementById('page-settings-contents'),
	// toggle visibility of contents
	toggle: ()=>{
		pageSettings.contents.classList.toggle('hidden');
	},
	// show contents
	show: ()=>{
		pageSettings.contents.classList.remove('hidden');
		// focus the button for keyboard navigation
		pageSettings.button.focus();
	},
	// hide contents
	close: ()=>{
		pageSettings.contents.classList.add('hidden');
		// focus the button for keyboard navigation
		pageSettings.button.focus();
	},
	// add element to page settings content box immediately before close button
	addElement: (el)=>{
		pageSettings.contents.insertBefore(el,document.getElementById('page-settings-close-button'));
	},
	// add a checkbox to the page settings content box
	addCheckbox: (input, label, description)=>{
		if (input) {
			input.type = "checkbox";
			// add label and checkbox
			let wrapper = document.createElement('div');
			// label section
			let labelWrapper = document.createElement('div');
			labelWrapper.classList.add("label-wrapper");
			let labelEl = document.createElement('label');
			labelEl.htmlFor = input.id;
			labelEl.innerHTML = label;
			// checkbox
			let inputWrapper = document.createElement('div');
			inputWrapper.classList.add("checkbox-wrapper");
			// nest elements into dom
			inputWrapper.appendChild(input);
			labelWrapper.appendChild(labelEl);
			labelWrapper.appendChild(inputWrapper);
			wrapper.appendChild(labelWrapper);
			// add to page settings contents
			pageSettings.addElement(wrapper);
			// add description if specified
			if (description) {
				let descriptionEl = document.createElement('span');
				descriptionEl.innerHTML = description;
				pageSettings.addElement(descriptionEl);
			};
		}
	},
	
	// functions to enable/disable custom cursor
	customCursorOn: true,
	toggleCustomCursor: ()=>{
		if (isTrue(pageSettings.customCursorOn)) { pageSettings.disableCustomCursor(); }
		else { pageSettings.enableCustomCursor(); }
	},
	enableCustomCursor: ()=>{
		pageSettings.customCursorOn = true;
		localStorage.setItem("customCursorOn", pageSettings.customCursorOn);
		pageSettings.updateCustomCursorCheckbox();
		document.body.classList.add('customCursor');
		document.body.classList.remove('defaultCursor');
		console.log('custom cursors enabled');
	},
	disableCustomCursor: ()=>{
		pageSettings.customCursorOn = false;
		localStorage.setItem("customCursorOn", pageSettings.customCursorOn);
		pageSettings.updateCustomCursorCheckbox();
		document.body.classList.add('defaultCursor');
		document.body.classList.remove('customCursor');
		console.log('custom cursors disabled');
	},
	// check or uncheck the settings box based on pageSettings.customCursorOn value
	updateCustomCursorCheckbox: ()=>{ cursorOnCheckbox.checked = !isTrue(pageSettings.customCursorOn); },
};

(()=>{

	// add the page settings style sheet to the document that loaded this
	let psCss = document.createElement('link');
	psCss.rel = 'stylesheet';
	psCss.type = 'text/css';
	psCss.href = '/codefiles/page-settings-new.css?fileversion=20261117'; /* make sure this links to the location of the css file! */
	document.querySelector('HEAD').prepend(psCss);
	
	// when page loads, set up menu
	window.addEventListener("load", ()=>{
		// add custom scrollbars toggle to menu
		addCustomScrollbarsToggle();
	});

	/******************************************************************************/
	// CUSTOM CURSOR TOGGLE
	
	var cursorOnCheckbox = document.createElement('input');
	cursorOnCheckbox.id = "cursorOnCheckbox";
	cursorOnCheckbox.addEventListener('click',pageSettings.toggleCustomCursor);
	pageSettings.addCheckbox(cursorOnCheckbox,`default cursor`,`check above to disable custom cursors across the site`);
	// if there is already a custom cursor setting in local storage, apply it
	if (localStorage.getItem("customCursorOn")) {
		pageSettings.customCursorOn = localStorage.getItem("customCursorOn");
		pageSettings.updateCustomCursorCheckbox();
		// apply
		if (isTrue(pageSettings.customCursorOn)) { pageSettings.enableCustomCursor(); }
		else { pageSettings.disableCustomCursor(); }
	} else {
		pageSettings.enableCustomCursor();
	}

	var customScrollbarsOn = true;
	var scrollbarsOnCheckbox = document.createElement('input');
	function addCustomScrollbarsToggle() {
		scrollbarsOnCheckbox.id = "scrollbarsOnCheckbox";
		scrollbarsOnCheckbox.addEventListener('click', toggleCustomScrollbars);
		pageSettings.addCheckbox(scrollbarsOnCheckbox,`default scrollbars`,`check above to disable custom or hidden scrollbars across the site (refresh to update)`);
		// if there is already a custom scrollbars setting in local storage, apply it
		if (localStorage.getItem("customScrollbarsOn")) {
			customScrollbarsOn = localStorage.getItem("customScrollbarsOn");
			updateCustomScrollbarsCheckbox();
			// apply
			if (isTrue(customScrollbarsOn)) { enableCustomScrollbars(); }
			else { disableCustomScrollbars(); }
		} else {
			enableCustomScrollbars();
		}
		// functions to enable/disable custom scrollbars
		function toggleCustomScrollbars() {
			if (isTrue(customScrollbarsOn)) { disableCustomScrollbars(); }
			else { enableCustomScrollbars(); }
		}
		function enableCustomScrollbars() {
			customScrollbarsOn = true;
			localStorage.setItem("customScrollbarsOn", customScrollbarsOn);
			updateCustomScrollbarsCheckbox();
			document.body.classList.add('customScrollbars');
			document.body.classList.remove('defaultScrollbars');
			console.log('custom scrollbars enabled');
		}
		function disableCustomScrollbars() {
			customScrollbarsOn = false;
			localStorage.setItem("customScrollbarsOn", customScrollbarsOn);
			updateCustomScrollbarsCheckbox();
			document.body.classList.add('defaultScrollbars');
			document.body.classList.remove('customScrollbars');
			console.log('custom scrollbars disabled');
		}
		// check or uncheck the settings box based on customScrollbarsOn value
		function updateCustomScrollbarsCheckbox() { scrollbarsOnCheckbox.checked = !isTrue(customScrollbarsOn); }
	}

})();