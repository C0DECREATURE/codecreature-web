// self executing
(function(){
	if ( window.location.hostname.includes('codecreature.neocities.org') ) {
		window.location.hostname = window.location.hostname.replace('codecreature.neocities.org','codecreature.net');
	} else if (
		localStorage.getItem("showWarnings") == "false" &&
		(typeof showWarnings == 'undefined' || showWarnings != false) &&
		window.location.pathname.replaceAll('/','') == '' &&
		!window.location.search.includes('showWarnings=true')
	) {
		window.location.href = '/home';
	// redirect to warnings page immediately if:
	// warnings not shown yet, user is not Neocities screenshotter, not already redirecting
	} else if (
		localStorage.getItem("showWarnings") != "false" &&
		!window.location.search.includes('showWarnings=false') &&
		(typeof showWarnings == 'undefined' || showWarnings == true) &&
		navigator.userAgent.toLowerCase() != 'screenjesus' &&
		window.location.pathname.replaceAll('/','') != 'warnings' &&
		window.location.pathname.replaceAll('/','') != ''
	) {
		console.log('redirect');
		let redirect = window.location.pathname + window.location.search;
		window.location.href = `/?redirect=${redirect}`;
	}
})();

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

// fonts object
const fonts = {
	// load fonts with given names
	// takes any number of string arguments
	load: function(...names) {
		// if no arguments given
		if (names.length === 0) {
			throw new TypeError("At least one font name is required");
		} else {
			for (let name of names) { fonts.loadSingle(name); }
		}
	},
	// private function to load font with given name
	loadSingle: function(name) {
		let type = typeof name;
		try {
			if (type == 'string') {
				try {
					name = name.replaceAll(' ','');
					// add the font style sheet to the document that loaded this
					let css = document.createElement('link');
					css.rel = 'stylesheet';
					css.type = 'text/css';
					css.href = `/fonts/${name}/stylesheet.css`;
					document.querySelector('HEAD').appendChild(css);
				} catch(e) {
					console.error(e);
					console.log(`Could not load font ${name}`);
				}
			}
		} catch(e) {
			console.error(e);
			console.log(`Invalid font name input (must be string or array, was ${type})`)
		}
	},
	// prototype for font
	fontPrototype: {
		name: '', // string of family name for font
		fileTypes: [], // all file types available for this font as strings (e.g. "ttf")
		// returns whether font has given file type
		hasType: function(type) { return this.fileTypes.includes(type) },
		// takes string argument(s)
		// adds the given file type strings to the font's fileTypes array
		addFileTypes: function(...types) {
			// if no arguments given
			if (types.length === 0) {
				console.error("At least one font file type name is required.");
			} else {
				for (let i = 0; i < types.length; i++) {
					if (!this.hasType(types[0])) this.fileTypes.push(types[0]);
				}
			}
		},
		// has base font style by default
		styles: [''],
		// returns whether font has given style (regular/italic/bold/etc)
		hasStyle: function(style) { return this.styles.includes(style); },
		// takes string argument(s)
		// set the given string properties to boolean true
		addStyles: function(...styles) {
			// if no arguments given
			if (styles.length === 0) {
				console.error("At least one font style name is required.");
			} else {
				for (let i = 0; i < styles.length; i++) {
					if (!this.hasStyle(styles[0])) this.styles.push(styles[0]);
				}
			}
		},
		// set css string to insert into document
		setCss: function() {
			// start the css block
			let css = `<style>`;
			// add each font style
			for (let i = 0; i < this.styles.length; i++) {
				let style = this.styles[i];
				let fileName = this.name.replaceAll(' ','') + style; // remove spaces, add style name
				try {
					// add the font-face
					css += `@font-face{font-family:"${this.name}";font-display:swap;src:url('/fonts/${fileName}/${fileName}.${this.fileTypes[0]}');`;
					// if this font includes multiple file types, add them to the source
					if (this.fileTypes.length > 0) {
						css += `src:`;
						for (let i = 0; i < this.fileTypes.length; i++) {
							let type = this.fileTypes[i];
							// add the file info based on type
							if (type == 'eof') css+= `url("${fileName}.eot?#iefix")format("embedded-opentype")`;
							else if (type == 'woff') css+= `url("${fileName}.woff")format("woff")`;
							else if (type == 'woff2') css+= `url("${fileName}.woff2")format("woff2")`;
							else if (type == 'ttf') css+= `url("${fileName}.ttf")format("truetype")`;
							else throw new TypeError(`Font file type ${type} not recognized`);
							// add end of file type punctuation mark
							if (i == this.fileTypes.length - 1) css += `;`; // if this is the last type
							else css += `,`; // if this is NOT the last type
						}
					}
					// add the font-weight
					if (style.toLowerCase().includes('bold')) css += `font-weight:bold;`;
					else css += `font-weight:normal;`;
					// add the font-style
					if (style.toLowerCase().includes('italic')) css += `font-style:italic;`;
					else css += `font-style:normal;`;
					css += `}`;
				}
				catch(e) {
					if (typeof style != 'string') { console.error(`All font styles must be strings. Received type ${typeof style}`) }
					else throw new Error(e);
					continue;
				}
			}
			// end the css block
			css += `</style>`;
			this.css = css;
			console.log(css);
		},
		// load this font into the current document
		load: function() { fonts.load(this.name) },
	},
	// constructor for font
	Font: function(name,fileTypes,styles) {
		this.name = name;
		this.addFileTypes(fileTypes);
		if (styles) { for (let style of styles) { this.addStyles(style); } }
		// add this font to the fonts list
		fonts.list[this.name] = this;
	},
	// list of fonts
	list: {},
}

// set up Font object class
Object.assign(fonts.Font.prototype, fonts.fontPrototype);

new fonts.Font('Ad Lib',['ttf']);
new fonts.Font('Comic Sans MS',['ttf']);
new fonts.Font('Crimes Times Six',['ttf']);
new fonts.Font('DS Digital',['ttf'],['Bold','Italic','BoldItalic']);
new fonts.Font('Garfield',['ttf']);
new fonts.Font('Ghoulish Fright',['ttf']);
new fonts.Font('Halogen',['otf']);
new fonts.Font('Hiveswap Alternian',['ttf']);
new fonts.Font('Janda Closer To Free',['ttf']);
new fonts.Font('Kaiju Monster',['ttf']);
new fonts.Font('Letter-O-Matic',['ttf'],['Bold','Italic']);
new fonts.Font('Mabook',['ttf']);
new fonts.Font('Matura Regular',['otf']);
new fonts.Font('My Imaginary Friend',['ttf']);
new fonts.Font('Seconda Round',['woff'],['Bold','Italic','Bold Italic','Light');
new fonts.Font('Splatoon',['otf'],['1','2']);
new fonts.Font('Super Comic',['ttf']);
new fonts.Font('Terminax Regular',['woff']);
new fonts.Font('Unown',['otf'],['Light']);
new fonts.Font('Victorian Parlor',['ttf']);
new fonts.Font('Yet R',['ttf']);