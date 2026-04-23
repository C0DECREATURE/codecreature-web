// on page load, if a valid tab is named in the location hash then open it
(()=>{
	let hash = window.location.hash.replaceAll('#','');
	if (hash.length > 1) {
		let el = document.getElementById(hash);
		if (el && el.classList.contains('tab')) openTab(hash);
	}
})();

// on page load, initialize custom scrollbars on certain elements
(()=>{
	if (typeof customScrollbarsOn !== 'undefined' && customScrollbarsOn) {
		var mainBoxContents = document.getElementById('main-box').getElementsByClassName('content');
		for (let el of mainBoxContents) {
			new SimpleBar(el, {
				autoHide: false,
			});
		}
	}
})();

var optionalCheckboxes = document.getElementsByClassName('warning-option-checkbox');

// on page load, check/uncheck appropriate boxes based on existing warnings selections
(()=>{
	if (localStorage.getItem('showSpecificWarnings')) {
		let arr = JSON.parse(localStorage.getItem('showSpecificWarnings'));
		for (let box of optionalCheckboxes) {
			if (arr.includes(box.name)) box.checked = true;
			else box.checked = false;
		}
	}
})();

// open specified tab of main box content
function openTab(id,updateFace) {
	// clear active tabs
	let tabs = document.getElementsByClassName('tab');
	for (let tab of tabs) tab.classList.remove('active');
	// set specified tab as active
	document.getElementById(id).classList.add('active');
	// scroll to top
	document.getElementById(id).scrollTo(0,0);
	if (typeof customScrollbarsOn !== 'undefined' && customScrollbarsOn) {
		let simplebarWrapper = document.getElementById(id).querySelector('.simplebar-content-wrapper');
		if (simplebarWrapper) simplebarWrapper.scrollTo(0,0);
	}
	// update window hash (blank if it's the default page)
	let url = new URL(window.location);
	url.hash = id == 'warnings-form' ? '' : `#${id}`;
	history.replaceState("", "", url.href);
	// update robot cat's face
	let faceImg = updateFace ? id + '.png' : '';
	document.getElementById('side-character-face').style.backgroundImage = `url('${faceImg}')`;
	document.getElementById('side-character-face-overlay').style.display = updateFace ? '' : 'none';
}

document.getElementById('warnings-form').addEventListener('submit',(e)=>{
	e.preventDefault();
	acceptWarnings();
});

// this function is called when the user clicks the button to accept warnings
// it saves the "don't show again" setting and redirects the user to the requested page
function acceptWarnings() {
	// don't show general warnings page to this user again
	let seenWarnings = true;
	localStorage.setItem('seenWarnings', seenWarnings);
	// save the date when warnings were accepted, in Unix epoch time
	let d = new Date();
	let acceptedWarningsTime = d.getTime();
	localStorage.setItem('acceptedWarningsTime', acceptedWarningsTime);
	
	// check which page-specific warnings to show in the future
	let futureWarnings = [];
	for (let box of optionalCheckboxes) {
		if (box.checked) { futureWarnings.push(box.name); }
	}
	futureWarnings = JSON.stringify(futureWarnings);
	
	// save page-specific warnings to browser storage
	localStorage.setItem('showSpecificWarnings', futureWarnings);
	console.log("Now receiving warnings for: "+localStorage.getItem('showSpecificWarnings'));
	
	// if a user is logged in, update user's settings in the database
	updateWarningsDatabase(seenWarnings,acceptedWarningsTime,futureWarnings);
	
}

// update user's settings in the database
function updateWarningsDatabase(seenWarnings,acceptedWarningsTime,futureWarnings) {
	// the URL to redirect the user to after they accept the warnings
	let urlParams = new URL(window.location.href).searchParams;
	let redirect = urlParams.has("redirect") ? decodeURI(urlParams.get("redirect")) : "/";
	
	const xhr = new XMLHttpRequest();
	xhr.open("POST", "/user/page-settings-update.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	// do stuff when request finishes
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			if (xhr.responseText != '') {
				// if a response was given, give an alert with response
				alert(xhr.responseText);
			}
			// go to the specified redirect page
			window.location.href = redirect;
		}
	};
	// send the variables
	xhr.send(`updateType=warnings&seenWarnings=${seenWarnings}&acceptedWarningsTime=${acceptedWarningsTime}&showSpecificWarnings=${futureWarnings}`);
}