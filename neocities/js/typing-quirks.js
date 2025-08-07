/************* USAGE INSTRUCTIONS *****************

put this near the top of <head> element in a page that you want to run the script
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=9"></script>
		<!-- page settings -->
		<script src="/js/page-settings.js?fileversion=9"></script>
		<!-- typing quirk alt text -->
		<script src="/js/typing-quirks.js?fileversion=9"></script>

/*************************************************/
// SET UP ON LOAD

"use strict"; // force strict mode

// whether typing quirks are enabled by default
var tqOn = 'true';

window.addEventListener("load", (event) => {
	// url parameters
	let urlParams = new URL(window.location.toLocaleString()).searchParams;
	// if tqOn set in url parameters, use that
	if ( urlParams.has('tqOn') ) { tqOn = urlParams.get('tqOn'); }
	// otherwise get the stored typing quirk preference if one exists
	else if ( localStorage.getItem( "tqOn") ) { tqOn = localStorage.getItem( "tqOn"); }
	
	// assign text and alt text for all .tq elements
	tqAlts();
	
	// set up typing quirk settings menu
	tqInitMenu();
	
	// log that the menu setup has been done
	console.log('typing quirk menu setup complete')
});

/*************************************************
SETTINGS
make sure you have an element somewhere in the page that has id='page-settings-contents'	
this is the section where the typing quirk checkbox will be added

/*************************************************************************************************/
// TYPING QUIRK PAGE SETTINGS
// this section can be modified without affecting the basic typing quirk functions below

// toggle typing quirk checkbox
var tqOnCheckbox = document.createElement('input');

// set up typing quirk settings menu
function tqInitMenu() {
	pageSettingsContents = document.getElementById('page-settings-contents');
	if (pageSettingsContents) {
		// toggle typing quirk checkbox
		tqOnCheckbox.id = 'tqOnCheckbox';
		tqOnCheckbox.addEventListener('click', toggleTqs);
		// put tq settings in the settings area
		addPageSettingCheckbox(
			tqOnCheckbox, `proper english`,
			`check above to turn off puns, chatspeak, numbers in place of letters, etc`
		);
	}
	// make sure the settings checkbox is correctly checked/unchecked
	tqOnCheckbox.checked = !isTrue(tqOn);
}

/*************************************************
ACTIVATING THE SHORTHAND SCRIPT

add the class 'tq-format' to any element that you want the typing quirk shorthand script to run on
use the formatting described below on any typing quirks in this text.
the 'tq-format' class can be used on ANY html element and will affect all of its children.
it can also be used on as many html elements as you want.
you can even add it to the body element if you want it to run on everything in the page, though this may slow it down

example (to put in your HTML file):
<p class='tq-format'>
	anything you put in this section will have the typing quirk shorthand replacement script run on it!
</p>

*************************************************
FORMATTING SHORTHAND:

examples given are for converting "u" to "you" when typing quirks disabled and for screenreaders

for commonly used words/phrases, add the shortcut to TYPING QUIRK SHORTCUTS, then format like this:
sample shortcut: if (modTxt == `u`) alt = "you";
sample in page text: %%u%
1. %% starts the section
2. type the normal display text
3. % ends the section
if you don't want to use the shorthand, you can also use <u class="tq">u</u>

if you have not added a shortcut:
sample in page text: %A%you\\u%
1. %A% starts the section
2. provide the alt text
3. \\ is the divider
4. type the normal display text
5. % ends the section
if you don't want to use the shorthand, you can also use <u class="tq-a" data-alt="you">u</u>

*************************************************
FORMATTING TEXT EMOJIS:

emojis will NOT be altered for people viewing the page normally, but the description will be provided to screenreaders

for text emojis, add the shortcut to TEXT EMOJIS, then format like this:
sample shortcut: if (txt==`:3`) alt = "smiling kitty emoji";
sample in page text: %E%:3%
1. %E% starts the section
2. type the emoji
3. % ends the section
if you don't want to use the shorthand, you can also use <u class="tq-e">:3</u>

*************************************************/
// CHANGE THESE TO ALTER HOW YOU FORMAT TYPING QUIRK SHORTHAND IN TEXT

// text string to indicate start of SHORTCUT typing quirk
var tqShortcutStart = '%%';
// text string to indicate start of NON SHORTCUT typing quirk
var tqStandardStart = '%A%';
// text string to indicate break between alt text and regular text for NON SHORTCUT typing quirk
var tqBreakString = '\\'
// text string to indicate start of TEXT EMOJI
var tqTextEmojiStart = '%E%';
// text string to indicate end of typing quirk
var tqEndString = '%';

/******************************************************************************/

// add the typing quirk style sheet to the document that loaded this
let tqCss = document.createElement('link');
tqCss.rel = 'stylesheet';
tqCss.type = 'text/css';
tqCss.href = '/js/typing-quirks.css?fileversion=5'; /* make sure this links to the location of the css file! */
document.querySelector('HEAD').appendChild(tqCss);

// assign text and alt text for all .tq elements
function tqAlts() {
	// format all unformatted .tq-format elements
	document.querySelectorAll('.tq-format').forEach(tqFormatElement);
	
	// make sure the settings checkbox is correctly checked/unchecked
	tqOnCheckbox.checked = !isTrue(tqOn);
	
	let tq, txt, alt;
	
	// TYPING QUIRK SHORTCUTS
	for ( let i = 0; i < document.getElementsByClassName('tq').length; i++ ) {
		tq = document.getElementsByClassName('tq')[i];
		// typing quirk display text
		if (tq.dataset.txt) txt = tq.dataset.txt;
		else txt = tq.innerHTML;
		// alt text for tq
		alt = ' ';
		if (tq.dataset.a) alt = tq.dataset.a;
		else {
			let modTxt = txt.toLowerCase().trim();
			if (modTxt == `b`) alt = "be";
			else if (modTxt == `u`) alt = "you";
			else if (modTxt == `ur`) alt = "your";
			else if (modTxt == `2`) alt = "to";
			else if (modTxt == `4`) alt = "for";
			else if (modTxt == `r`) alt = "are";
			else if (modTxt == `abt`) alt = "about";
			else if (modTxt == `ppl`) alt = "people";
			else if (modTxt == `in2`) alt = "into";
			else if (modTxt == `pls`) alt = "please";
			else if (modTxt == `rly`) alt = "really";
			else if (modTxt == `urs`) alt = "yours";
			else if (modTxt == `were`) alt = "we're";
			else if (modTxt == `bc`) alt = "because";
			else if (modTxt == `thx`) alt = "thanks";
			else if (modTxt == `im`) alt = "I'm";
			else if (modTxt == `ive`) alt = "I've";
			else if (modTxt == `ill`) alt = "I'll";
			else if (modTxt == `were`) alt = "we're";
			else if (modTxt == `w`) alt = "with";
			else if (modTxt == `thru`) alt = "through";
			else if (modTxt == `2day`) alt = "today";
			else alt = txt;
		}
		if (isTrue(tqOn)) showTQ(tq,txt,alt);
		else hideTQ(tq,txt,alt);
	}
	
	// TEXT EMOJIS
	for ( let i = 0; i < document.getElementsByClassName('tq-e').length; i++ ) {
		tq = document.getElementsByClassName('tq-e')[i];
		tq.classList.add('tq');
		
		// typing quirk display text
		txt = tq.innerHTML;
		if (tq.dataset.txt) txt = tq.dataset.txt;
		// alt text for tq
		alt = ' ';
		if (tq.dataset.a) alt = tq.dataset.a;
		else {
			if (txt==`:3` || txt==`X3` || txt==`:33` || txt==`X33`) alt = "smiling kitty emoji";
			else if (txt==`:3c` || txt==`X3c` || txt==`:33c` || txt==`X33c`) alt = "mischievous kitty emoji";
			else if (txt==`:'3` || txt==`:''3` || txt==`:'''3` || txt==`:'33` || txt==`:''33` || txt==`:'''33` ) alt = "crying kitty emoji";
			else if (txt==`:)` || txt==`:))` || txt==`:)))`) alt = "smiling emoji";
			else if (txt==`:(` || txt==`:((` || txt==`:(((`) alt = "sad emoji";
			else if (txt==`B3` || txt==`B33`) alt = "sunglasses kitty emoji";
			else if (txt==`B3c` || txt==`B33c`) alt = "mischievous sunglasses kitty emoji";
			else if (txt==`B'3` || txt==`B''3` || txt==`B'''3` || txt==`B'33` || txt==`B''33` || txt==`B'''33`) alt = "crying sunglasses kitty emoji";
		}
		
		showTQ(tq,txt,alt);
	}
	
	// NEPETA/DAVEPETA TYPING QUIRK
	// for each .tq-nep element
	for ( let i = 0; i < document.getElementsByClassName('tq-nep').length; i++ ) {
		tq = document.getElementsByClassName('tq-nep')[i];
		tq.classList.add('tq');
		
		// typing quirk display text
		txt = tq.innerHTML;
		if (tq.dataset.txt) txt = tq.dataset.txt;
		// alt text for tq
		// alt text for tq
		alt = ' ';
		if (tq.dataset.a) alt = tq.dataset.a;
		else alt = txt.replace(/33/g, "ee");
		
		if (isTrue(tqOn)) showTQ(tq,txt,alt);
		else hideTQ(tq,txt,alt);
	}
	
	console.log('set typing quirk alt text, typing quirks visible = ' + tqOn);
}

// show the quirk text, add the screenreader alt
function showTQ(tq,txt,alt) {
	// set alt text span
	var altSpan = document.createElement("span");
	altSpan.classList.add("sr-only");
	altSpan.innerHTML = alt;
	// save original display text in data
	tq.dataset.txt = txt;
	// set the quirk text span (hidden on screenreaders)
	var txtSpan = document.createElement("span");
	txtSpan.ariaHidden = 'true';
	txtSpan.innerHTML = txt;
	// set the content
	tq.innerHTML = '';
	tq.appendChild(altSpan);
	tq.appendChild(txtSpan);
}

// show the alt text, save the original text
function hideTQ(tq,txt,alt) {
	// save original display text in data
	tq.dataset.txt = txt;
	// set content to alt text
	tq.innerHTML = alt;
}

function toggleTqs() {
	//if (localStorage.getItem("tqOn")) tqOn = localStorage.getItem( "tqOn");
	if (isTrue(tqOn)) disableTq();
	else enableTq();
}
function enableTq() {
	tqOn = true;
	localStorage.setItem("tqOn", tqOn);
	// reload
	tqAlts();
}
function disableTq() {
	tqOn = false;
	localStorage.setItem("tqOn", tqOn);
	// reload
	tqAlts();
}

// converts shorthand into properly formatted typing quirk text in the given string
function tqFormatString(str) {
	str = str.replace(/%%(.*?)%/g,`<u class="tq">$1</u>`);
	str = str.replace(/%A%(.*?)\\(.*?)%/g,`<u class="tq" data-a="$1">$2</u>`);
	str = str.replace(/%E%(.*?)%/g,`<u class="tq-e">$1</u>`);
	str = str.replace(/%N%(.*?)%/g,`<u class="tq-nep">$1</u>`);
	return str;
}
// converts shorthand into properly formatted typing quirk text in the given element
function tqFormatElement(el) {
	el.innerHTML = el.innerHTML.replace(/%%(.*?)%/g,`<u class="tq">$1</u>`);
	el.innerHTML = el.innerHTML.replace(/%A%(.*?)\\\\(.*?)%/g,`<u class="tq" data-a="$1">$2</u>`);
	el.innerHTML = el.innerHTML.replace(/%E%(.*?)%/g,`<u class="tq-e">$1</u>`);
	el.innerHTML = el.innerHTML.replace(/%N%(.*?)%/g,`<u class="tq-nep">$1</u>`);
}
// converts properly formatted typing quirk text into shorthand in the given string
function tqUnformatString(str) {
	str = str.replace(/\<u class="tq"\>(.*?)\<\/u\>/g,`%%$1%`);
	str = str.replace(/\<u class="tq" data-a="(.*?)"\>(.*?)\<\/u\>/g,`%A%$1\\\\$2%`);
	str = str.replace(/\<u class="tq-e"\>(.*?)\<\/u\>/g,`%E%$1%`);
	str = str.replace(/\<u class="tq-nep"\>(.*?)\<\/u\>/g,`%N%$1%`);
	return str;
}
// converts properly formatted typing quirk text into shorthand in the given element
function tqUnformatElement(el) {
	el.innerHTML = el.innerHTML.replace(/\<u class="tq"\>(.*?)\<\/u\>/g,`%%$1%`);
	el.innerHTML = el.innerHTML.replace(/\<u class="tq" data-a="(.*?)"\>(.*?)\<\/u\>/g,`%A%$1\\\\$2%`);
	el.innerHTML = el.innerHTML.replace(/\<u class="tq-e"\>(.*?)\<\/u\>/g,`%E%$1%`);
	el.innerHTML = el.innerHTML.replace(/\<u class="tq-nep"\>(.*?)\<\/u\>/g,`%N%$1%`);
}