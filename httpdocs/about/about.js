function ribbonClicked(ribbon) {
	var box = getBox(ribbon);
	box.innerHTML = ribbon.innerHTML;
}

function getBox(el) {
	if (el.classList.contains('identity')) { return document.getElementById(el.id+"-box") }
	else if (el.parentNode) { getBox(el.parentNode) }
	else { console.log('getBox failed') }
}

// ensure screenreader text on all views
for (let ribbon of Array.from(document.querySelectorAll('.ribbon'))) {
	let span = ribbon.querySelector('span');
	if (span) {
		ribbon.ariaLabel = span.innerHTML;
		span.ariaHidden = 'true';
	}
}

console.log('about.js loaded');