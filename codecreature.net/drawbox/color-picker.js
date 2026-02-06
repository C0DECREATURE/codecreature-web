/*    BELOW CODE ADDED BY AGLOVALE.NEKOWEB.ORG    */
 
let colors = [
	"white", "dd-purple", "d-purple", "dd-blue", "purple", "l-purple", "l-pink", "pink", "d-pink",
	"red", "d-orange", "orange", "yellow", "l-green", "green", "d-green", "l-blue",
	"blue", "d-blue"
];

function getStrokeColorId(c) { return "stroke-color-" + c.replace('#','hash-code-'); }

function changeColor(el){
	el.classList.add('current');
	let color = el.dataset.color;
	let curColor = el.dataset.hexColor;
	stroke_color = curColor;
	
	document.getElementById('custom-color-wrapper').classList.remove('current');
	colors.forEach((c) => {
		if (c != color) {
			let e = document.getElementById(getStrokeColorId(c));
			e.classList.remove('current');
		}
	});
}

function customColorPicked() {
	let el = document.getElementById('custom-color-wrapper');
	// check if the color is dark
	if (getLightness(document.getElementById('custom-color-picker').value) < 30) el.classList.add("dark");
	else el.classList.remove("dark");
	// display this as the current selection
	el.classList.add('current');
	colors.forEach((c) => {
		let e = document.getElementById(getStrokeColorId(c));
		e.classList.remove('current');
	});
}
 
function renderColor(){
		let container = document.getElementById('drawbox-stroke-colors');
		colors.forEach((c) => {
			let computedColor = window.getComputedStyle(document.body).getPropertyValue(`--${c}`);
			let color = document.createElement('button');
			color.setAttribute('onclick',"changeColor(this)");
			color.setAttribute('style',`background:var(--${c})`);
			color.dataset.color = c;
			color.dataset.hexColor = computedColor;
			color.id = getStrokeColorId(c);
			color.ariaLabel = c;
			color.classList.add('stroke-color');
			if (getLightness(computedColor) < 30) { color.classList.add("dark"); }
			container.appendChild(color);
		});
}

function hexToRgb(hex) {
  var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result ? {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
  } : null;
}

function getLightness(color) {
	let Rint, Gint, Bint;
	// if color is a hex code
	if (color.includes('#') && !color.includes('rgb') && !color.includes(',')) {
		let rgb = hexToRgb(color);
		Rint = rgb.r;
		Gint = rgb.g;
		Bint = rgb.b;
	} else {
		color = color.toString();
		color = color.replaceAll("rgb","").replaceAll("(","").replaceAll(")","").replaceAll(" ","");
		let arr = color.split(",");
		Rint = Number(arr[0]);
		Gint = Number(arr[1]);
		Bint = Number(arr[2]);
	}
	var Rlin = (Rint / 255.0) ** 2.218;   // Convert int to decimal 0-1 and linearize
	var Glin = (Gint / 255.0) ** 2.218;   // ** is the exponentiation operator, older JS needs Math.pow() instead
	var Blin = (Bint / 255.0) ** 2.218;   // 2.218 Gamma for sRGB linearization. 2.218 sets unity with the piecewise sRGB at #777 .... 2.2 or 2.223 could be used instead
	
	var Ylum = Rlin * 0.2126 + Glin * 0.7156 + Blin * 0.0722;   // convert to Luminance Y
	return Math.pow(Ylum, 0.68) * 100;  // Convert to lightness (0 to 100)
}
 
renderColor();