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
		document.getElementById(id).querySelector('.simplebar-content-wrapper').scrollTo(0,0);
	}
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
	// the URL to redirect the user to after they accept the warnings
	let urlParams = new URL(window.location.href).searchParams;
	let redirect = urlParams.has("redirect") ? decodeURI(urlParams.get("redirect")) : "/";
	
	// don't show general warnings page to this user again
	localStorage.setItem('seenWarnings', true);
	// save the date when warnings were accepted, in Unix epoch time
	let d = new Date();
	let time = d.getTime();
	localStorage.setItem('acceptedWarningsTime', time);
	
	// check which page-specific warnings to show in the future
	let futureWarnings = [];
	for (let box of optionalCheckboxes) {
		if (box.checked) { futureWarnings.push(box.name); }
	}
	futureWarnings = JSON.stringify(futureWarnings);
	
	// save page-specific warnings to browser storage
	localStorage.setItem('showSpecificWarnings', futureWarnings);
	console.log("Now receiving warnings for: "+localStorage.getItem('showSpecificWarnings'));
	
	// go to the specified redirect page
	window.location.href = redirect;
}