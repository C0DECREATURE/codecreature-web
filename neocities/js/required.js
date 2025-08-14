// redirect immediately if warnings not shown yet and user is not Neocities screenshotter
if (
localStorage.getItem("showWarnings") != "false" &&
!window.location.pathname.includes("/warnings") &&
(navigator.userAgent.toLowerCase() != 'screenjesus' || window.location.href == "")
) {
	window.location.href = "/warnings?redirect="+window.location.href;
}

const isReducedMotion = window.matchMedia(`(prefers-reduced-motion: reduce)`) === true || window.matchMedia(`(prefers-reduced-motion: reduce)`).matches === true;

// returns true if a variable is true (boolean) or "true" (string)
// otherwise returns false
function isTrue(v) {
	if (v == "true" || v == true) { return true }
	else { return false }
}

// load fonts in given array of font names
function loadFonts(array) {
	if (typeof array == "string") array = array.split(',');
	for (let i = 0; i < array.length; i++) loadFont(array[i]);
}
// load font with given name
function loadFont(name) {
	name = name.replaceAll(' ','');
	// add the font style sheet to the document that loaded this
	let css = document.createElement('link');
	css.rel = 'stylesheet';
	css.type = 'text/css';
	css.href = '/fonts/' + name + '/stylesheet.css';
	document.querySelector('HEAD').appendChild(css);
}