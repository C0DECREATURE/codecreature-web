/*
add to top of HTML document:

<!-- svg icons -->
<script src="/graphix/svg-icons/svg-icons.js"></script>

add to bottom of body to control when icons load
<script>
	// put the correct svg in each .svg-icon element
	defaultSvgIcons.load();
</script>
*/

// collection of all svg icon data
const svgIcons = {
	roundedcaretright:
	'<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">' +
		'<path d="m 31.357881,26.726285 v 88.185265 a 7.935505,7.3876756 0 0 0 13.016288,5.67491 L 98.098011,78.898997 a 11.298773,10.51876 0 0 0 0,-16.160153 L 44.374168,21.051378 a 7.9355045,7.3876752 0 0 0 -13.016287,5.674907 z" /></svg>',
	roundedcaretleft:
	'<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">' +
		'<path d="m 101.95848,26.726285 v 88.185265 a 7.935505,7.3876756 0 0 1 -13.016292,5.67491 L 35.218346,78.898997 a 11.298773,10.51876 0 0 1 0,-16.160153 L 88.942189,21.051378 a 7.9355045,7.3876752 0 0 1 13.016291,5.674907 z" /></svg>',
	circlequestionmarkoutline:
	'<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">' +
		'<ellipse style="stroke-linejoin:round;"' +
			'cx="66" cy="65.999992" rx="58.197803" ry="58.197796" />' +
		'<path style="stroke-linejoin:round;stroke-linecap:round;"' +
			'd="M 44.623599,46.920198 C 54.948173,24.442529 89.224921,32.165235 90.80037,48.577925 92.375823,64.990618 74.617683,66.325546 65.985481,65.6267 v 8.373975" />' +
		'<ellipse style="stroke-linejoin:round;stroke-linecap:round;stroke-dasharray:1000;fill-opacity:1;" ' +
			'cx="66.000031" cy="96.39196" rx="2.9115658" ry="2.911588" /></svg>',
	roundedx:
	'<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">' +
		'<path style="stroke-linejoin:round;stroke-linecap:round;" d="M 13.229201,13.229201 119.06281,119.06281" />' +
		'<path style="stroke-linejoin:round;stroke-linecap:round;" d="M 117.22258,13.229201 11.388968,119.06281" />' +
	'</svg>',
	copyoutline:
	'<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">' +
		'<path style="stroke-linejoin:round;stroke-linecap:butt;" d="m 86.25439,97.89609 v 22.48964 H 22.754225 V 34.92509 h 25.400067" />' +
		'<path style="stroke-linejoin:round;stroke-linecap:round;" d="M 48.154292,97.89609 V 12.170865 H 84.137718 L 111.65445,38.893851 V 97.89609 Z" />' +
		'<path style="stroke-linejoin:round;stroke-linecap:butt;" d="M 74.612693,12.170865 V 47.625124 H 111.65448" />' +
	'</svg>',
	gearoutline:
	'<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">' +
		'<path style="stroke-linejoin:round;stroke-linecap:butt;" d="M 54.977149,6.029105 V 21.931018 A 45.695179,45.695198 0 0 0 42.772694,26.977751 L 31.96609,16.171148 15.739649,31.534591 26.977751,42.772694 A 45.695179,45.695198 0 0 0 21.931018,54.977149 H 6.6394053 L 6.029105,77.314861 h 15.901913 a 45.695179,45.695198 0 0 0 4.422997,11.062403 L 13.97386,100.75742 29.768803,116.55288 41.631159,104.69052 a 45.695179,45.695198 0 0 0 13.34599,5.67047 v 15.29161 l 22.337712,0.6103 v -15.90191 a 45.695179,45.695198 0 0 0 12.203938,-5.04673 l 11.238621,11.23862 15.79546,-15.79546 -11.23862,-11.238621 a 45.695179,45.695198 0 0 0 5.04673,-12.203938 H 126.2629 V 54.977149 H 110.45349 A 45.695179,45.695198 0 0 0 104.69156,41.630125 L 114.78709,31.534591 98.560131,16.171148 88.451678,26.279601 A 45.695179,45.695198 0 0 0 77.314861,21.838517 V 6.029105 Z M 66.146005,42.999554 A 23.146313,23.146307 0 0 1 89.292456,66.146005 23.146313,23.146307 0 0 1 66.146005,89.292456 23.146313,23.146307 0 0 1 42.999554,66.146005 23.146313,23.146307 0 0 1 66.146005,42.999554 Z" />' +
	'</svg>',
	gearsolid:
	'<svg viewBox="0 0 132.29201 132.29201" xmlns="http://www.w3.org/2000/svg">' +
		'<path style="stroke-linejoin:round;stroke-linecap:butt;" d="M 58.475469,8.2100704 V 25.772997 A 41.184249,41.184253 0 0 0 35.106834,39.084493 L 20.308319,30.540394 12.64347,43.816052 27.439039,52.358188 a 41.184249,41.184253 0 0 0 -2.48311,13.787695 41.184249,41.184253 0 0 0 2.392781,13.545669 l -14.70524,8.490098 7.155267,13.56973 15.138236,-8.739987 a 41.184249,41.184253 0 0 0 23.538496,13.507377 v 16.9748 l 15.329698,0.58813 V 106.51877 A 41.184249,41.184253 0 0 0 97.497322,92.806186 l 15.493668,8.945194 7.15527,-13.56973 -15.124,-8.732125 A 41.184249,41.184253 0 0 0 107.3247,66.145883 41.184249,41.184253 0 0 0 105.01048,52.554559 L 120.14626,43.816052 112.4819,30.540394 97.340717,39.282337 A 41.184249,41.184253 0 0 0 73.805167,25.688558 V 8.2100704 Z m 7.664849,31.9490626 a 25.987005,25.986999 0 0 1 25.98724,25.98675 25.987005,25.986999 0 0 1 -25.98724,25.987241 25.987005,25.986999 0 0 1 -25.98675,-25.987241 25.987005,25.986999 0 0 1 25.98675,-25.98675 z" />' +
	'</svg>'
}

// add the associated style sheet to the document that loaded this
if (!document.getElementById('svg-icons-css')) {
	let svgCss = document.createElement('link');
	svgCss.rel = 'stylesheet';
	svgCss.type = 'text/css';
	svgCss.href = '/graphix/svg-icons/svg-icons.css';
	svgCss.id = 'svg-icons-css';
	document.querySelector('head').appendChild(svgCss);
}

// on window load
window.addEventListener("load", (event) => {
	defaultSvgIcons.load();
});

const defaultSvgIcons = {
	loaded: false,
	// put the correct svg in each .svg-icon element that is contained in given element parent
	load: function(el) {
		console.log('loading svg icons');
		if (!el) el = document.body;
		el.querySelectorAll('.svg-icon').forEach((i) => {
			let icon = svgIcons[i.dataset.icon.replaceAll('-','')];
			// if the data-icon is a valid icon
			if (icon) {
				i.innerHTML = icon;
				// set svg fill and stroke colors to text color
				i.style.fill = window.getComputedStyle(i).color;
				i.style.stroke = window.getComputedStyle(i).color;
				if (window.getComputedStyle(i).fontWeight == 'bold') i.classList.add('svg-icon-bold');
			} // if the data-icon is not valid
			else console.error('Could not locate svg icon "' + i.dataset.icon + '" in svgIcons');
		});
		this.loaded = true;
	},
}