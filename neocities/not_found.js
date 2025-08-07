// force strict mode
"use strict";

// how many dragboxes have been made
var boxCount = 0;
// the highest z-index of any Box
var maxZ = 20;
// how many times a complaint has been submitted
var complaints = 0;

// make a new dragbox
function newDragBox(params) {
	// get parameter variables
	var type = params.type; var title = params.title; var icon = params.icon; var iconFlash = params.iconFlash; var txt = params.txt; var lbtn = params.lbtn; var lClick = params.lClick; var rbtn = params.rbtn; var rClick = params.rClick; var url = params.url; var skipAd = params.skipAd; var download = params.download;
	
	var base = document.getElementById(type);
	// make a new dragbox clone
	var b = base.cloneNode(true);
	boxCount += 1;
	b.id = type + boxCount;
	b.style.display = "block";
	// put the box above all others
	boxToTop(b);
	// if there is at least one box on screen, put the new box
	// at a random location within the main container
	if ( boxCount > 1 && window.innerWidth > 640 ) {
		b.style.top = Math.floor(Math.random() * 80) + 1 + '%';
		b.style.right = Math.floor(Math.random() * 50) + 1 + '%';
	} else if ( boxCount > 1 ) {
		b.style.top = Math.floor(Math.random() * 80) + 1 + '%';
	}
	
	// fill in contents for any sections the box has:
	if ( b.querySelector("#title") && title ) { b.querySelector("#title").innerHTML = title; }
	// icon element
	if ( b.querySelector("#icon") && icon ) {
		b.querySelector("#icon").src = icon;
		if ( iconFlash == true ) { b.querySelector("#icon").classList.add("flashing"); }
	}
	// if this box has an ad image, add the image and set the width based on that image
	if ( type == "adbox" && icon ) {
		var a = document.createElement("a");
		a.classList.add("link");
		// create the image
		var img = document.createElement("img");
		img.src = icon;
		img.classList.add("ad");
		img.onload = function() { boxParent(this).style.width = Math.min(window.screen.width*.9,img.width,650)+"px"	}
		// add the image
		a.appendChild(img);
		b.querySelector("#content").appendChild(a);
	}
	
	// url link
	var bLink = b.querySelector(".link");
	if ( bLink ) {
		// if url is given, clicking the link opens the url
		if ( url ) {
			if ( typeof(bLink) == "a" ) { bLink.src = url }
			else {
				b.querySelector(".link").setAttribute('onclick',
					`boxToTop(boxParent(this)); window.open("`+url+`");`
				)
			}
		}
		// if no url is given but a download file is specified, clicking the link downloads the file
		else if ( download ) {
			if ( download == "img" && icon ) { download = icon; }
			bLink.download = download;
			bLink.href = download;
		}
	}
	// right section
	if ( b.querySelector("#right") && txt ) { b.querySelector("#right").innerHTML = txt; }
	// left button
	if ( b.querySelector("#lbtn") && lbtn && lClick ) {
		b.querySelector("#lbtn").innerHTML = "<span>" + lbtn + "</span>";
		b.querySelector("#lbtn").setAttribute('onclick', lClick);
	}
	// right button
	if ( b.querySelector("#rbtn") && rbtn && rClick  ) {
		b.querySelector("#rbtn").innerHTML = "<span>" + rbtn + "</span>";
		b.querySelector("#rbtn").setAttribute('onclick', rClick);
	}
	
	if ( b.querySelector("#content") && params.html ) { b.querySelector("#content").innerHTML += params.html; }
	if ( params.width ) { b.style.width = params.width; }
	
	// when button is focused, bring box to top
	b.querySelectorAll('a,button,.x,.link').forEach(function(focusable){
		focusable.addEventListener('focus',function(){ boxToTop(boxParent(this)) })
	});
	
	// add the new box to page
	base.parentNode.appendChild(b);
	
	// make the box draggable
	dragElement(b);
	
	// if this wasn't an ad, also make a new popup ad
	if ( type != "adbox" && skipAd != true ) { newAd() }
}

// remove a given dragbox
function removeBox(box) {
	boxCount -= 1;
	box.remove();
	// if this was the last box on screen, replace the default box
	if ( boxCount == 0 ) { makeDefaultBox() }
}

// return a given element's dragbox parent
function boxParent(el) {
	// if element's parent is the base document, return null
	if ( el.parentNode == document ) { return null }
	// if element is a dragbox, return it
	else if ( el.classList.contains("dragbox") ) { return el }
	// if element is not dragbox and has parent, check parent
	else { return boxParent(el.parentNode) }
}

// disable all buttons in a given dragbox
function disableBox(box) {
	box.querySelector("#lbtn").disabled = 'disabled';
	box.querySelector("#rbtn").disabled = 'disabled';
}

// put a given dragbox above all others
function boxToTop(box) {
	maxZ += 1; box.style.zIndex = maxZ;
	//box.querySelector('.x').focus();
	//box.querySelector('.x').blur();
}

// make default box
function makeDefaultBox(skipAd) {
	newDragBox({
		type:"errorbox",
		title:"Error: Broken Link",
		icon:"/graphix/icons/warning.png",
		iconFlash:true,
		txt:"File or directory at '" + window.location.pathname + "' not found." +
			"<br>Click below for assistance.",
		lbtn:"home",
		lClick:"window.location.href='/';",
		rbtn:"help me",
		rClick:"makeHelpBox();",
		skipAd:skipAd
	});
}

// make help box
function makeHelpBox() {
	newDragBox({
		type:"errorbox",
		title:"Error: Request Denied",
		icon:"/graphix/icons/warning.png",
		iconFlash:true,
		txt:"Your help request has been denied. Would you like to submit a complaint?",
		lbtn:"no",
		lClick:"removeBox(boxParent(this))",
		rbtn:"yes",
		rClick:"addComplaint(); makeComplaintBox();"
	});
}

// make complaint box
function makeComplaintBox() {
	newDragBox({
		type:"errorbox",
		title:"Complaints Department",
		icon:"/graphix/deco/smiley-spin-yellow.gif",
		txt:`<span>Complaints received: <span class='complaint-count'>` + complaints + `</span>
			<br>Submit another complaint?</span>`,
		lbtn:"no",
		lClick:"removeBox(boxParent(this));",
		rbtn:"yes",
		rClick:"addComplaint();"
	});
}

// submit a new complaint
function addComplaint() {
	complaints += 1;
	var complaintCounts = document.querySelectorAll(".complaint-count");
    for (var i = 0; i < complaintCounts.length; i++) {
		complaintCounts[i].innerHTML = complaints;
	}
}

// list of all popup ads
// required properties: img (link to image to display)
// optional properties: url (link to open on click), title (popup window title)
var popupAds = [
	{img:"send-me-your-teeth.jpg", title:"PLEASE", url:"mailto:iactuallywantyourteeth@gmail.com?subject=I will send you my teeth"},
	{img:"send-me-your-teeth.jpg", title:"PLEASE", url:"mailto:iactuallywantyourteeth@gmail.com?subject=I will send you my teeth"},
	{img:"send-me-your-teeth.jpg", title:"PLEASE", url:"mailto:iactuallywantyourteeth@gmail.com?subject=I will send you my teeth"},
	{img:"piracy-crime.gif", url:"https://fmhy.net/beginners-guide", title:"<img src='/graphix/icons/warning.png'> REPORT NOW"},
	{img:"report-piracy.gif", url:"https://fmhy.net/beginners-guide", title:"<img src='/graphix/icons/warning.png'> REPORT NOW"},
	{img:"fbi-warning.gif", url:"https://fmhy.net/beginners-guide", title:"<img src='/graphix/icons/warning.png'> REPORT NOW"},
	{img:"shop-joann.jpg", url:"https://www.joann.com/"},
	{img:"arm-pasta.jpg", title:"INSOMNIA IS OVER!"},
	{img:"caiman.jpg", title:"REJECT HUMANITY TODAY"},
	{img:"malevolent-god.jpg", title:"SPECIAL INVITATION"},
	{img:"nope-spray.jpg", title:"PROTECT YOURSELF!"},
	{img:"shape-delivery.jpg"},
	{img:"the-zone.jpg", title:"ENTER!!"},
	{img:"place-him-on-your-site.gif", title:"DO IT", download:"img"},
	{title:"NEW SITES",html:'<iframe width="180" height="180" src="https://dimden.neocities.org/navlink/" name="neolink"></iframe>',width:"190px"}
];
var unusedAds = []

// put a new ad popup on screen
function newAd() {
	// if unused ads list empty, repopulate with all ads
	if ( unusedAds.length == 0 ) { unusedAds = popupAds.slice(0); }
	// get a random unused ad
	var adIndex = Math.floor(Math.random() * unusedAds.length);
	
	var title = ""
	if (unusedAds[adIndex].title) { title = unusedAds[adIndex].title }
	else if (unusedAds[adIndex].url) { title = "<img src='/graphix/deco/smiley-spin-yellow.gif'> CLICK NOW" }
	else { title = "<img src='/graphix/deco/smiley-spin-green.gif'> URGENT MESSAGE"}
	
	var icon = unusedAds[adIndex].img;
	if (icon) icon = "/graphix/ads/popup/"+icon;
	
	newDragBox({
		type:"adbox",
		title:title,
		icon:icon,
		url:unusedAds[adIndex].url,
		download:unusedAds[adIndex].download,
		html:unusedAds[adIndex].html,
		width:unusedAds[adIndex].width
	})
	
	// remove the ad from unused ads list
	unusedAds.splice(adIndex,1)
}

// make flashing elements flash
window.addEventListener("load", function() {
	setInterval(function() {
		var flashers = document.querySelectorAll(".flashing");
		for (var i = 0; i < flashers.length; i++) {
			var f = flashers[i]
			if ( f.classList.contains('off') ) { f.classList.remove('off') }
			else { f.classList.add('off') };
		}
	}, 350);
}, false);