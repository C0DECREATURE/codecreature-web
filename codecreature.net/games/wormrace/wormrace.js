// force strict mode
"use strict";

// location of wormrace.php file
var phpSrc = '';

// define worms, put into array
const worms = [
	{name:"jeremy", length:"4", color:"pink", likes:"tax evasion",
		colorCode:"var(--l-pink)", colorCodeMed:"var(--pink)", colorCodeDark:"var(--d-pink)",
		image:"pink.png", raceImage:"pink_racer.png",
		movement: 0, health: '?', appleCount: 0, drinkCount: 0, poisonCount: 0, healCount: 0
		},
	{name:"pretzel", length:"8", color:"orange", likes:"being untangled",
		colorCode:"var(--orange)", colorCodeMed:"var(--d-orange)", colorCodeDark:"var(--d-purple)",
		image:"orange.png", raceImage:"orange_racer.png",
		movement: 0, health: '?', appleCount: 0, drinkCount: 0, poisonCount: 0, healCount: 0
		},
	{name:"string cheese", length:"6", color:"yellow", likes:"cannibalism",
		colorCode:"var(--yellow)", colorCodeMed:"var(--orange)", colorCodeDark:"var(--red)",
		image:"yellow.png", raceImage:"yellow_racer.png",
		movement: 0, health: '?', appleCount: 0, drinkCount: 0, poisonCount: 0, healCount: 0
		},
	{name:"matilda", length:"5", color:"green", likes:"nothing",
		colorCode:"var(--green)", colorCodeMed:"var(--d-green)", colorCodeDark:"var(--dd-green)",
		image:"green.png", raceImage:"green_racer.png",
		movement: 0, health: '?', appleCount: 0, drinkCount: 0, poisonCount: 0, healCount: 0
		},
	{name:"pool noodle", length:"7", color:"blue", likes:"extreme sports",
		colorCode:"var(--l-blue)", colorCodeMed:"var(--blue)", colorCodeDark:"var(--d-blue)",
		image:"blue.png", raceImage:"blue_racer.png",
		movement: 0, health: '?', appleCount: 0, drinkCount: 0, poisonCount: 0, healCount: 0
		},
	{name:"microplastics", length:"10", color:"purple", likes:"eating drywall",
		colorCode:"var(--l-purple)", colorCodeMed:"var(--purple)", colorCodeDark:"var(--d-purple)",
		image:"purple.png", raceImage:"purple_racer.png",
		movement: 0, health: '?', appleCount: 0, drinkCount: 0, poisonCount: 0, healCount: 0
		}
];

// define available items, put into array
const items = [
	{ name:"golden apple", image:"apple.png", icon:"icon-movement-1.png", bg:"var(--l-green)",
		tableName: 'apple', // name of its column in SQL database
		movement:4, health:0,
		movementEffect:[ 3/4, 1, 1, 5/4, 5/4 ],
		healthEffect:[ 1, 1, 1, 1, 1 ],
		cooldown: 10, // .5 min
		flavor:"room and board for one" },
	{ name:"battery juice", image:"drink.png", icon:"icon-movement-2.png", bg:"var(--l-blue)",
		tableName: 'drink', // name of its column in SQL database
		movement:40, health:-1,
		movementEffect:[ 1/2, 3/4, 1, 4.5/4, 5/4 ],
		healthEffect:[ 1, 1, 1, 1, 1 ],
		cooldown: 300, // 5 min
		flavor:"is it healthy? no! but does it taste good? also no" },
	{ name:"poison", image:"poison.png", icon:"icon-health-neg.png", bg:"var(--green)",
		tableName: 'poison', // name of its column in SQL database
		movement:-5, health:-1,
		movementEffect:[ 2, 1, 1, 1, 1 ],
		healthEffect:[ 0, 1, 1, 1, 1 ],
		cooldown: 180, // 3 min
		flavor:"pesticide for <span aria-label='your'></span><span aria-hidden='true'>ur</span> least favorite worm" },
	{ name:"heart potion", image:"heal.png", icon:"icon-health-pos.png", bg:"var(--l-pink)",
		tableName: 'heal', // name of its column in SQL database
		movement:0, health:1,
		movementEffect:[ 1, 1, 1, 1, 1 ],
		healthEffect:[ 1, 1, 1, 1, 0 ],
		cooldown: 240, // 4 min
		flavor:"love is good for u, 4<span aria-label='out of'></span><span aria-hidden='true'>/</span>5 worms agree" }
];

// max worm health
// if max health changed, make sure to change in php file also
var maxHealth = 4;

// open tab - set to default at start
var openTab = 'choices';
// previous open tab
var prevTab = '';

// chosen worm
var wormChoice = '';
// chosen item
var itemChoice = 'none';

// percent of race width worms should take up
var wormWidth = 20;
// farthest movement any worm has travelled
var maxDist = 0;

// limit on how often a person can feed worm, in seconds
var feedLimit = 5;
// whether the user can currently feed worm
var canFeed = true;

// whether database limit has been reached
var dbLimit = false;

// global element variables
var raceContent = ''; // main race content
var loadArea = ''; // race loading area
var loadStatus = ''; // race loading status text
var wormchoices = ''; // collection of all .wormchoice elements
var detailbox = ''; // details tab container
var sharebox = ''; // share tab container

// url parameter list
const urlParams = new URL(window.location.toLocaleString()).searchParams; 

/*
	////////////////////////////////////////////////////////////////////
	INITIALIZING PAGE
	////////////////////////////////////////////////////////////////////
*/

// initialize page
function init() {
	
	// element variables
	loadArea = document.querySelector( ".load-area" );
	loadStatus = document.querySelector( "#load-status" );
	raceContent = document.querySelector( ".race-content" );
	wormchoices = document.getElementsByClassName('wormchoice');
	detailbox = document.getElementById('details');
	sharebox = document.getElementById('sharebox');
	
	// update when the user can feed again every half second
	updateFeedTime();
	const feedTimeLoop = setInterval(function() {
		updateFeedTime();
	}, 500);
	
	// wormchoices open their corresponding detail box on click
	for ( let i = 0; i < worms.length; i++ ) {
		let wormButton = document.createElement('button');
		wormButton.classList.add('choice','wormchoice','wormbox');
		wormButton.type = 'button';
		wormButton.id = 'wormbox' + i;
		wormButton.addEventListener('click', function() { chooseWorm(i) });
		document.getElementById('worm-area').appendChild(wormButton);
		
		let div = document.createElement('div');
		div.classList.add('content');
		wormButton.appendChild(div);
		
		let img = document.createElement('img');
		img.src = worms[i].image;
		img.alt= worms[i].color + ' fuzzy worm';
		div.appendChild(img);
	}
	
	// put items in detailbox
	for ( let i = 0; i < items.length; i++ ) {
		document.getElementById('item-area').innerHTML +=
			'<button class="item choice item-' + items[i].tableName + '" ' +
			'id="item' + i + '"' +
			'aria-label="' + items[i].name + '"' +
			'onclick="chooseItem(this);">' +
				'<div class="wrapper"><div class="content">' +
					'<img src="' + items[i].image + '" alt="">' +
					'<div class="icon"><img src="' + items[i].icon + '" alt=""></div>' +
					'<div class="bg"></div>' +
					'<span class="tooltiptext"></span>' +
				'</div></div>'
			'</button>';
		document.getElementById('item' + i).querySelector('.bg').style.background = items[i].bg;
	}
	
	// set detailbox left and right arrows for small screens/mobile=
	document.querySelector('#details button.prev-worm').addEventListener('click', function() { chooseWorm(wormChoice-1) } );
	document.querySelector('#details button.next-worm').addEventListener('click', function() { chooseWorm(wormChoice+1) } );
	
	// make sure no item is chosen by default
	unChooseItem();
	
	// set up loading marquee
	var marqueeConts = document.querySelectorAll('.marquee-content');
	for ( let i = 0; i < marqueeConts.length; i++ ) {
		for ( let w = worms.length - 1; w >= 0 ; w-- ) { marqueeConts[i].innerHTML += '<img src="' + worms[w].raceImage +'" alt="">'; }
		for ( let w = worms.length - 1; w >= 0 ; w-- ) { marqueeConts[i].innerHTML += '<img src="' + worms[w].raceImage +'" alt="">'; }
	}
	
	// make all menu buttons toggle open menu
	document.querySelector('.menu').querySelectorAll('button').forEach((b) => { b.addEventListener('click', toggleMenu); });
	
	// adjust container width when window is resized
	document.querySelector('body').onresize = function(){ cwResize(); };
	// adjust width immediately on page load
	cwResize();
	
	var urlWorm = urlParams.get('worm');
	// if url parameters includes a value for results and that result is ':33'
	if ( urlParams.has('results') && urlParams.get('results') == ':33'  ) showRace();
	else {
		getWormData();
		// if url parameters includes a value for worm and that result is a valid worm, open that worm
		if ( urlWorm && urlWorm >= 0 && urlWorm < worms.length ) chooseWorm(Number(urlWorm));
		// if url parameters includes a value for share and that result is not 'false'
		if ( urlParams.has('share') && urlParams.get('share') != 'false' ) showShare();
	}
}

/*
	////////////////////////////////////////////////////////////////////
	KEYBOARD & TOUCH CONTROLS
	////////////////////////////////////////////////////////////////////
*/

// keyboard nevigation
document.addEventListener('keydown', function(event) {
	// if left key pressed
	if(event.key === "ArrowLeft") controlEvent('leftKey');
	// if right key pressed
	else if(event.key === "ArrowRight") controlEvent('rightKey');
	// if escape key pressed
	else if(event.key === "Escape") controlEvent('escapeKey');
});

/*
// touchscreen variables
let touchstartX = 0;
let touchendX = 0;
let touchstartY = 0;
let touchendY = 0;

// check touchscreen input
function checkTouchInput() {
	// minimum pixels of movement to consider a touch a swipe
	var minSwipe = 30;
	// if horizontal swipe was made
	// horizontal move greater than minSwipe and change in X was greater than change in Y
	if ( Math.abs(touchendX-touchstartX) > minSwipe && Math.abs(touchendX-touchstartX) > Math.abs(touchendY-touchstartY) ) {
		if (touchendX < touchstartX) controlEvent('leftSwipe');
		if (touchendX > touchstartX) controlEvent('rightSwipe');
	}
}
// detect start of swipe/touch
document.addEventListener('touchstart', e => {
	touchstartX = e.changedTouches[0].screenX;
	touchstartY = e.changedTouches[0].screenY;
})
// detect end of swipe/touch
document.addEventListener('touchend', e => {
  touchendX = e.changedTouches[0].screenX;
  touchendY = e.changedTouches[0].screenY;
  checkTouchInput();
})
*/

function controlEvent(e) {
	if ( openTab == 'details' ) {
		// if left key/left swipe
		if(e == 'leftKey') {
			if ( wormChoice == 0 ) wormChoice = worms.length;
			chooseWorm(wormChoice - 1);
		}
		// if right key/right swipe
		else if(e == 'rightKey') {
			if ( wormChoice == worms.length - 1 ) wormChoice = -1;
			chooseWorm(wormChoice + 1);
		}
		// if escape key
		else if(e == 'escapeKey') showChoices();
	}
	else if ( openTab == 'share' ) {
		// if escape key
		if(e == 'escapeKey') hideShare();
	}
	else if ( openTab == 'race' ) {
		// if escape key
		if(e == 'escapeKey') showChoices();
	}
}

/*
	////////////////////////////////////////////////////////////////////
	CALCULATING WIDTH
	////////////////////////////////////////////////////////////////////
*/

// adjust widths based on main container size
// called when window loads, then again every time window is resized
function cwResize() {
	var mw = document.querySelector('main').offsetWidth;
	
	var cw = mw;
	// if container is not filling screen
	if (cw < window.innerWidth) cw = cw * .85;
	
	// Set the value of --rw root variable (race width base)
	document.querySelector(':root').style.setProperty('--rw', cw + 'px');
	
	// Set the value of --wh root variable (window height)
	document.querySelector(':root').style.setProperty('--wh', window.innerHeight + 'px');
	
	cw = Math.min(755, cw - 15);
	// Set the value of --cw root variable (container width base)
	document.querySelector(':root').style.setProperty('--cw', cw + 'px');
	
	// if the full view menu for small screens is open and the close menu button has been hidden
	// due to the new size, close the full view menu
	if (window.getComputedStyle(document.querySelector('.open-menu')).display == 'none') closeMenu();
	
	// if the updates iframe is currently hidden, reset its display properties
	document.querySelectorAll('.updates').forEach((u) => {
		if (window.getComputedStyle(u).display == 'none') u.style.display = '';
	});
}

/*
	////////////////////////////////////////////////////////////////////
	LOADING WORM HEALTH
	////////////////////////////////////////////////////////////////////
*/

// loads data on all worms from database
function getWormData() {
	showLoading();
	
	// Create a http request object to talk to the server-side
	var xhr = new XMLHttpRequest();
	// Specify which functions to call request OK or error
	xhr.onerror = errorWormData;
	xhr.onload = loadWormData;
	// Specify the request type, and URL we want to talk to
	xhr.open("GET", phpSrc + "wormrace.php" );
	// Send the request
	xhr.send();
}

// called when getWormData fails to load worm health
function errorWormData() {
	// if the load area is displayed, set the text there
	if ( loadArea.style.display != 'none' ) {
		loadStatus.innerHTML = 'unable to load race data!';
		loadArea.querySelector('.subtitle').style.display = 'block';
	}
	// otherwise set an alert
	else {
		alert(
		'unable to load race data!' +
		'\n if this keeps happening, the database may be offline.' +
		'\n check ' + window.location.hostname + '/updates for updates.'
		);
	}
	document.querySelectorAll('.marquee').forEach((marquee) => marquee.style.display = 'none' );
}

// called when getWormData successfully loads worm data
function loadWormData(e) {
	// string echo returned from the server
	var str = e.currentTarget.responseText;
	// split the responseText into variables
	var strParts = str.split(",");
	
	// if the database has reached write limit
	if ( str === "LIMIT" ) {
		alert('Worm race has had too many visitors!' + '\n' + 'Please come back in an hour');
		dbLimit = true;
	}
	// if the database has not reached write limit
	else {
		for (let i = 0; i < worms.length; i++) {
			// the current worm
			var w = worms[i];
			// the str array # for the first data point of the current worm
			var n = 0;
			if ( i > 0 ) n = i * (strParts.length / worms.length);
			// put the data received for this worm in the worms array
			w.movement = strParts[n + 2];
			w.health = strParts[n + 3];
			w.appleCount = strParts[n + 4];
			w.drinkCount = strParts[n + 5];
			w.poisonCount = strParts[n + 6];
			w.healCount = strParts[n + 7];
			
			// update the max distance based on this worm's movement
			maxDist = Math.max(w.movement, maxDist);
			
			// if the race tab is currently open
			if ( openTab == 'race' ) {
				// set the aria label for screen readers
				document.querySelector('.worm-track-' + i).ariaLabel =
					w.color + ' worm movement: ' + w.movement.toString();
				
				// if this is the last worm to be done
				if ( i == worms.length - 1 ) {
					// clear stats area
					document.querySelector('.worm-stats-area').innerHTML = '';
					
					// for each worm
					for ( let x = 0; x < worms.length; x++ ) {
						var w = worms[x];
						let track = document.querySelector('.worm-track-' + x);
						
						// determine trail percentage
						var trailPercent = 0;
						if( maxDist > 0 ) trailPercent = w.movement / maxDist * ( 100 - wormWidth - 5 );
						
						// animate trail width
						let trail = track.querySelector('.trail');
						trail.animate(
							[
								// keyframes
								{ width: "0%" },
								{ width: trailPercent + "%" },
							],
							{
								// timing options
								duration: 30 * (trailPercent)
							},
						);
						trail.style.width = trailPercent + "%";
						
						// set bounce animation speed
						track.querySelector('.racer-img').animate(
							[
								// keyframes
								{ transform: "translateY(0%)" },
								{ transform: "translateY(-5%)" },
								{ transform: "translateY(0%)" },
							],
							{
								// timing options
								duration: 1000 - ((trailPercent + wormWidth)*8),
								iterations: Infinity,
							},
						);
						
						// show crown if this worm is winning
						if (w.movement == maxDist && w.movement > 0) track.querySelector('.crown').classList.toggle('show');
						else track.querySelector('.crown').classList.remove('show');
						
						// fill this worm's worm stats block
						document.querySelector('.worm-stats-area').innerHTML +=
							'<div class="worm-stats" style="background-color: ' + w.colorCodeMed + ';">' +
							'<div class="title"><a href="?worm=' + x + '">' + w.name + '</a></div>' +
							'<div class="movement">' + w.movement + '<img src="icon-movement-1.png" alt="movement"></div>' +
							'<div class="stat"><img src="apple.png" alt="apples"><br>' + w.appleCount + '</div>' + 
							'<div class="stat"><img src="drink.png" alt="battery juices"><br>' + w.drinkCount + '</div>' + 
							'<div class="stat"><img src="poison.png" alt="poisons"><br>' + w.poisonCount + '</div>' + 
							'<div class="stat"><img src="heal.png" alt="heart potions"><br>' + w.healCount + '</div>' + 
							'</div>';
					}
				}
			} else if ( openTab == 'details' ) {
				setHealth();
			}
		}
		
		// 0.5 second delay to make sure everything is where it should be
		setTimeout(function(){
			// hide loading indicator, show content
			hideLoading();
		}, 200);
	}
}

/*
	////////////////////////////////////////////////////////////////////
	SHOW + HIDE DETAILS/CHOICES
	////////////////////////////////////////////////////////////////////
*/

// show details box
function showDetails() {
	if ( openTab != 'details' ) {
		// hide worm choices
		hideChoices();
		// hide race screen
		hideRace();
		// set initial item info
		detailbox.querySelector('#item-info').innerHTML = '<span class="lg">SELECT AN ITEM</span>';
		detailbox.querySelector('.flavor-text').innerHTML = '';
		// show the detail box
		detailbox.style.display = 'block';
		// save new open tab
		openTab = 'details';
	}
}

// hide details box
function hideDetails() {
	// hide the detail box
	detailbox.style.display = 'none';
	// unselect all items
	unChooseItem();
}

// hide details, show worm choices
function showChoices() {
	if ( openTab != 'choices' ) {
		// display and enable worm choices
		for ( let i = 0; i < wormchoices.length; i++ ) {
			wormchoices[i].style.display = 'block';
			wormchoices[i].disabled = false;
		}
		// hide the detail box
		hideDetails();
		// hide the share box
		sharebox.style.display = 'none';
		// hide race screen
		hideRace();
		// save new open tab
		openTab = 'choices';
	}
}

// hide worm choices
function hideChoices() {
	for ( let i = 0; i < wormchoices.length; i++ ) wormchoices[i].style.display = 'none';
}

// show loading status
function showLoading() {
	// hide content, show load status
	loadArea.style.display = 'block';
	document.querySelectorAll('.load-hide').forEach((el) => { el.classList.add('load-hidden') });
	
	// set load status
	loadStatus.innerHTML = 'Loading...';
}

// hide loading status
function hideLoading() {
	loadArea.style.display = 'none';
	document.querySelectorAll('.load-hide').forEach((el) => { el.classList.remove('load-hidden') });
}

// show share box
function showShare() {
	if ( openTab != 'share' ) {
		prevTab = openTab;
		// hide worm choices
		hideChoices();
		// hide race screen
		hideRace();
		// hide the detail box
		hideDetails();
		// show the share box
		sharebox.style.display = 'block';
		// save new open tab
		openTab = 'share';
	}
}

// hide share box
function hideShare() {
	sharebox.style.display = 'none';
	if (prevTab == 'choices') showChoices();
	else if (prevTab == 'race') showRace();
	else if (prevTab == 'details') showDetails();
	prevTab = '';
}

// show updates
function showUpdates() {
	document.querySelectorAll('.updates').forEach((u) => { u.style.display = 'flex'; });
}

// hide updates
function hideUpdates() {
	document.querySelectorAll('.updates').forEach((u) => { u.style.display = 'none'; });
}

// toggle menu content display if .menu-open button is displayed
function toggleMenu() {
	// if open menu button is visible
	if (window.getComputedStyle(document.querySelector('.open-menu')).display != 'none') {
		// if content currently shown
		if (window.getComputedStyle(document.querySelector('.menu-content')).display != 'none') closeMenu();
		// if content currently hidden
		else openMenu();
	}
}
function openMenu() { document.querySelector('.menu').classList.add('full'); }
function closeMenu() { document.querySelector('.menu').classList.remove('full'); }

/*
	////////////////////////////////////////////////////////////////////
	SELECTING WORMS/ITEMS
	////////////////////////////////////////////////////////////////////
*/

// open the details for the selected worm
function chooseWorm(num) {
	if (num < 0) num = worms.length - 1;
	else if (num > worms.length - 1) num = 0;
	var w = worms[num];
	// save chosen worm
	wormChoice = num;
	
	// set detail box profile image and text
	document.getElementById('detail-image').src = w.image;
	detailbox.style.color = w.colorCodeMed;
	detailbox.querySelector('#name').innerHTML = w.name;
	detailbox.querySelector('.name').style.backgroundColor = w.colorCodeMed;
	detailbox.querySelector('.name').style.textShadow = '.08em .08em ' + w.colorCodeDark;
	detailbox.querySelector('.health').style.backgroundColor = w.colorCode;
	detailbox.querySelector('.health-effects').style.borderColor = w.colorCodeMed;
	detailbox.querySelector('.health-effects').querySelector('.title').style.background = w.colorCodeMed;
	detailbox.querySelector('#worm-details').innerHTML =
		'color: ' + w.color +
		'<br>length: ' + w.length + ' inches' +
		'<br>likes: ' + w.likes;
	detailbox.querySelector('.bottom').style.backgroundColor = w.colorCodeMed;
	
	setHealth();
	
	// update item choice data if a choice has been made already
	if ( itemChoice != 'none' ) chooseItem(document.querySelector("#item" + itemChoice));
	
	// show the details box
	showDetails();
	// style the initial item detail text
	detailbox.querySelector('.lg').style.textShadow = '.08em .08em ' + w.colorCodeDark;
}

// set the detail box health for the current wormChoice
function setHealth() {
	var w = worms[wormChoice];
	
	// set apple movement effect text
	var e = items[0].movementEffect[w.health];
	if (typeof e != 'number') e = '?';
	else {
		e = Math.round( (e - 1) * 100 );
		if ( e >= 0 ) e = '+' + e;
	}
	detailbox.querySelector('#apple-effect').innerHTML = e;
	
	// set drink movement effect text
	e = items[1].movementEffect[w.health];
	if (typeof e != 'number') e = '?';
	else {
		e = Math.round( (e - 1) * 100 );
		if ( e >= 0 ) e = '+' + e;
	}
	detailbox.querySelector('#drink-effect').innerHTML = e;
	
	var healthbar = detailbox.querySelector('.health').querySelector('.bar');
	// empty healthbar
	healthbar.innerHTML = ''; 
	// fill healthbar according to health
	for ( let i = 0; i <= w.health; i++ ) { healthbar.innerHTML += '<div class="section"></div>'; }
	// make bar red at low health
	for ( let i = 0; i < healthbar.childNodes.length; i++ ) {
		if ( w.health <= 1 ) healthbar.childNodes[i].style.background = 'var(--red)';
	}
	// screen reader health label
	healthbar.ariaLabel = "health level " + w.health + " out of " + maxHealth;
	
	// disable the heal item if health is at max
	var healItem = detailbox.querySelector('.item-heal');
	if ( healItem && w.health >= maxHealth ) {
		// make button disabled
		healItem.disabled = true;
		healItem.classList.add('tooltip');
		healItem.querySelector('.tooltiptext').innerHTML = w.name + `'s health is full!`;
		
		// if heal item already selected
		if ( itemChoice == '3' ) {
			itemChoice = 'none';
			healItem.classList.remove('selected');
		}
	}
	else {
		healItem.disabled = false;
		healItem.classList.remove('tooltip');
		healItem.querySelector('.tooltiptext').innerHTML = ``;
	}
}

// chooses item, where 'item' input is an item button
function chooseItem(item) {
	// remove background border from current item, if one exists
	unChooseItem();
	// set style on new selected item
	item.classList.add("selected");
	// set new chosen item
	itemChoice = Number(item.id.replace("item", ""));
	
	// set cooldown text in minutes or seconds
	var cooldownTxt = getTimeTxt(items[itemChoice].cooldown) + ' cooldown';
	
	// adjust movement as needed for health effect
	var m = items[itemChoice].movement * items[itemChoice].movementEffect[worms[wormChoice].health];
	m = Math.round(m);
	// movement text
	var mTxt = '';
	// determine if movement text should have plus sign
	if ( m > 0 ) mTxt = '+' + m + '<img src="icon-movement-1.png" alt="movement">';
	else if ( m < 0 ) mTxt =
		'<span aria-label="minus"></span><span aria-hidden="true">-</span>' + Math.abs(m) +
		'<img src="icon-movement-1.png" alt="movement">';
	
	// adjust health as needed for health effect
	var h = items[itemChoice].health * items[itemChoice].healthEffect[worms[wormChoice].health];
	h = Math.round(h);
	// health text
	var healthTxt = '';
	// determine if health text should have plus sign
	if ( h > 0 ) healthTxt = '+' + h + '<img src="icon-health-pos.png" alt="health">';
	else if ( h < 0 ) healthTxt =
		'<span aria-label="minus"></span><span aria-hidden="true">-</span>' + Math.abs(h) +
		'<img src="icon-health-pos.png" alt="health">';
	if ( mTxt && healthTxt ) mTxt = mTxt + ' <span aria-hidden="true">/</span> ';
	
	// set item info text
	detailbox.querySelector('#item-info').innerHTML =
		items[itemChoice].name +
		'<br>' + cooldownTxt + ' <span aria-hidden="true">/</span> ' +
		mTxt + healthTxt;
	detailbox.querySelector('.flavor-text').innerHTML = items[itemChoice].flavor;
	// enable/disable feed button based on current conditions
	updateFeedButton();
}

// unselect all items
function unChooseItem() {
	var itemElems = document.getElementsByClassName('item');
	for ( let i = 0; i < itemElems.length; i++ ) {
		itemElems[i].classList.remove("selected");
	}
	itemChoice = 'none';
	// enable/disable feed button based on current conditions
	updateFeedButton();
}

/*
	////////////////////////////////////////////////////////////////////
	RACE FUNCTIONS
	////////////////////////////////////////////////////////////////////
*/

// Init the race - called by init()
function initRace(e) {
	
	// clear racetracks
	document.querySelector('#race-tracks').innerHTML = '';
	
	// add a track for each worm
	for ( let i = 0; i < worms.length; i++ ) {
		var w = worms[i];
		document.querySelector('#race-tracks').innerHTML +=
			'<div class="worm-track worm-track-' + i + '">' +
				'<div class="trail" style="border-color:' + w.colorCode + '"></div>' +
				'<a class="racer-img" href="?worm=' + i + '">' +
					'<img class="crown" src="crown.png">' +
					'<img class="racer" src="' + w.raceImage + '" alt="">' +
				'</a>' +
			'</div>';
	}
	
	// show loading status
	showLoading();
	
	// if worm data has already been provided, load using that
	if ( e ) loadWormData(e);
	// otherwise get worm data
	else getWormData();
}


// hide other screens, show race screen
function showRace(e) {
	// hide the detail box and worm choices
	hideDetails();
	hideChoices();
	// save new open tab
	openTab = 'race';
	
	// display the race screen
	document.querySelector('.race').style.display = 'block';
	
	// initialize race, using e if given
	if ( e ) initRace(e);
	else initRace();
}

// hide race screen
function hideRace() {
	// hide the race screen
	document.querySelector('.race').style.display = 'none';
}

// variable to store time of latest feeding
var feedTime = '';

// feed worm, send data to server
function feedWorm() {
	if ( canFeed && itemChoice != 'none' ) {
		feedTime = new Date().getTime();
		
		// show loading status
		showLoading();
		
		// wormId in SQL table is one higher than javascript array key
		var wormId = wormChoice + 1;
		var wormName = worms[wormChoice].name;
		var wormHealth = worms[wormChoice].health;
		var itemTN = items[itemChoice].tableName;
		
		// how much to increase/decrease health
		var health = Math.round(items[itemChoice].health * items[itemChoice].healthEffect[wormHealth] );
		
		// how much to increase/decrease movement
		var dist = Math.round(items[itemChoice].movement * items[itemChoice].movementEffect[wormHealth] );
		
		// set the cooldown based on the ITEM
		feedLimit = items[itemChoice].cooldown;
		
		// Send feed data to the server
		var xhr = new XMLHttpRequest();
		xhr.onerror = onFeedError;
		xhr.onload = onFeedLoad;
		xhr.open("GET", phpSrc +
			"wormrace.php?wormId=" + wormId +
			"&name=" + wormName +
			"&movement=" + dist +
			"&health=" + health +
			"&item=" + itemTN
		);
		xhr.send();
		
		console.log("wormrace.php?wormId=" + wormId +
			"&name=" + wormName +
			"&movement=" + dist +
			"&health=" + health +
			"&item=" + itemTN);
	}
}

// runs when feeding xml request loads
function onFeedLoad(e) {
	// Locally save the date this user can feed again
	localStorage.setItem( "nextWormFeedTime", feedTime + (feedLimit * 1000) );
	// update when the user can feed again
	updateFeedTime();
	// load the race
	showRace(e);
}

// runs when feeding xml request fails
function onFeedError() {
	// Temporary html
	loadStatus.innerHTML = 'feeding failed!<br>refresh page and try again';
	loadArea.querySelector('.subtitle').style.display = 'block';
	document.querySelectorAll('.marquee').forEach((marquee) => marquee.style.display = 'none' );
}

// determine how long it's been since last feeding
// if it's been less than a certain threshold, lock feeding
function updateFeedTime() {
	// last feed time in milliseconds
	var nextWormFeedTime = localStorage.getItem( "nextWormFeedTime" );
	// current time in milliseconds
	var curDate = new Date().getTime();
	// seconds until next feeding
	var sec = (nextWormFeedTime - curDate) / 1000;
	
	if ( sec > 0 ) {
		// set page text indicating time until next vote
		document.querySelector( ".banner-subtitle" ).innerHTML = "Feed again in " + getTimeTxt(sec,'00:00');
		canFeed = false;
		// enable/disable feed button based on current conditions
		updateFeedButton();
		
	} else {
		document.querySelector( ".banner-subtitle" ).innerHTML = "FEED A WORM";
		canFeed = true;
		// enable/disable feed button based on current conditions
		updateFeedButton();
	}
}

// enable/disable feed button based on current conditions
function updateFeedButton() {
	var btn = document.querySelector("#feed-button");
	var hovertext = btn.querySelector('.tooltiptext');
	// enable button if not on cooldown, item has been chosen, and database limit has not been reached
	if ( canFeed && itemChoice != 'none' && dbLimit == false && maintenance == false ) {
		btn.disabled = false;
		btn.classList.remove('tooltip');
		hovertext.innerHTML = '';
	}
	// else disable button
	else {
		btn.classList.add('tooltip');
		if ( maintenance == true ) hovertext.innerHTML = 'in maintenance mode!';
		else if ( dbLimit == true ) hovertext.innerHTML = 'come back in an hour!';
		else if ( canFeed == false ) hovertext.innerHTML = 'too soon to feed again!';
		else if ( itemChoice == 'none' ) hovertext.innerHTML = 'select an item first';
		btn.disabled = true;
	}
}


// converts time (in seconds) into minutes and seconds
function getTimeTxt(time,style) {
	time = Math.round(time);
	var tTxt = '';
	var tMin = Math.floor(time / 60);
	var tSec = time - tMin * 60;
	
	if (style == '00:00') {
		if (tSec < 10) tSec = `0${tSec}`;
		tTxt = `${tMin}:${tSec}`;
	} else {
		if ( tMin > 0 ) {
			tTxt = tMin + ' min';
			if ( tSec > 0 ) tTxt += ' ' + tSec + ' sec';
		}
		else tTxt += tSec + ' sec';
	}
	return tTxt;
}