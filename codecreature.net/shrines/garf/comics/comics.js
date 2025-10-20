//force strict mode
"use strict";

const comic = {
	id: 'comic-insert',
	year: 1978,
	setYear: (year)=>{
		comic.year = year;
		comic.load();
	},
	firstDate: new Date(`June 19, 1978 00:00:00`),
	lastDate: new Date(`December 31, 2024 23:59:59`),
	num: 0,
	// gives the comic number to use in the archive URL, as a string with 4 digits
	// e.g. 1 --> "0001", 25 --> "0025"
	urlNum: ()=>{
		let urlNum = comic.num.toString();
    while (urlNum.length < 4) { urlNum = "0" + urlNum; }
    return urlNum;
	},
	showFavorites: false,
	// array of my favorite comics, in the format [year,number]
	// note: comic numbers start at zero, so one less than the display number on the page
	favorites: {
		'1978': [
			3, 36, 41, 48, 64, 86, 97,
			111, 112, 115, 118, 123, 124, 126, 129, 136, 141, 143, 146, 156, 167, 168, 173
		],
		'1979': [
			14, 16, 31, 55, 65, 67, 71, 77, 79, 97,
			101, 118, 134, 140, 158, 160, 169, 192, 193, 194,
			215, 226, 230, 239, 241, 281, 286, 303, 309, 316, 320, 326, 342, 343
		],
		'1980': [  ],
		// ^^^ left off here
		'2024': [ 327 ]
	},
	load: ()=>{
		comic.fixDates();
		document.getElementById(comic.id).src = '';
		document.getElementById(comic.id).src = `https://ia601204.us.archive.org/BookReader/BookReaderImages.php?zip=/15/items/garfield-complete/Garfield%20${comic.year}_jp2.zip&file=Garfield%20${comic.year}_jp2/Garfield%20${comic.year}_${comic.urlNum()}.jp2&id=garfield-complete&scale=1&rotate=0`;
		document.getElementById('comic-wrapper').querySelector('figcaption').innerHTML = `${comic.year} #${comic.num+1}`
		console.log(`Loading comic: ${comic.year} #${comic.num+1}`);
		// update url search parameters and page title
		comic.updateURL();
	},
	// update url search parameters and page title
	updateURL: ()=>{
		let url = new URL(location);
		url.searchParams.set('year',comic.year);
		url.searchParams.set('num',comic.num);
		url.searchParams.set('favorites',comic.showFavorites);
		history.pushState({}, "", url);
		// update the page title
		document.title = `garf archive ${comic.year} #${comic.num+1}`;
	},
	next: ()=>{
		// get url search parameters, if favorites = true then get the next favorited comic
		let urlParams = new URLSearchParams(window.location.search);
		if (comic.showFavorites) comic.nextFavorite();
		// if favorites is not set or not = true then load next day's comic
		else {
			comic.num += 1;
			comic.load();
		}
	},
	prev: ()=>{
		// get url search parameters, if favorites = true then get the next favorited comic
		let urlParams = new URLSearchParams(window.location.search);
		if (comic.showFavorites) comic.prevFavorite();
		// if favorites is not set or not = true then load previous day's comic
		else {
			comic.num -= 1;
			comic.load();
		}
	},
	// load the next closest favorited comic
	nextFavorite: ()=>{
		// if the last comic year has been passed, loop back to the first year
		if (comic.year > comic.lastYear) comic.year = comic.firstYear;
		// get list of favorites for this year
		let f = comic.favorites[comic.year];
		console.log(typeof f);
		// if favorites exist in this year
		if (f && f.length > 0) {
			for (let i = 0; i < f.length; i++) {
				// if this is the first favorite that is after the current comic,
				// load that favorite and end the function
				if (f[i] > comic.num) {
					comic.num = f[i];
					comic.load();
					return;
				}
			}
		}
		// if no comic was loaded for this year, go to next year and try again
		comic.year += 1;
		comic.num = 0;
		comic.nextFavorite();
	},
	// load the previous closest favorited comic
	prevFavorite: ()=>{
		if (comic.year < comic.firstYear) comic.year = comic.lastYear;
		let f = comic.favorites[comic.year];
		// if favorites exist in this year
		if (f) {
			for (let i = f.length - 1; i >= 0; i--) {
				// if this favorite is after the current comic, or is the current comic, keep searching
				if (f[i] >= comic.num) continue;
				// if this is the first favorite that is before the current comic,
				// load that favorite and end the function
				else {
					comic.num = f[i];
					comic.load();
					return;
				}
			}
		}
		// if no comic was loaded for this year, go to previous year and try again
		comic.year -= 1;
		comic.num = comic.yearMaxNum(comic.year);
		comic.prevFavorite();
	},
	// returns boolean showing whether current comic is favorited
	isFavorite: ()=>{
		let b = false;
		let f = comic.favorites[comic.year];
		if (f.includes(comic.num)) b = true;
		return b;
	},
	// toggles whether favorites should be shown
	// if set to true, jumps to nearest favorited comic
	toggleFavorites: ()=>{
		comic.showFavorites = !comic.showFavorites;
		// set page text
		let button = document.getElementById('toggle-favorites'); // toggle favorites button
		let subtitle = document.getElementById('page-subtitle'); // subtitle of page
		if (comic.showFavorites) {
			button.innerHTML = 'Show All Comics';
			subtitle.innerHTML = 'My Favorites';
		} else {
			button.innerHTML = 'Show My Favorites';
			subtitle.innerHTML = 'Comics Archive';
		}
		// if the current comic is not favorited, jump to next favorite
		if (!comic.isFavorite()) {
			comic.num -= 1;
			comic.nextFavorite();
		}
	},
	// fix any issues with num/year exceeding bounds
	fixDates: ()=>{
		if (comic.year > comic.lastYear) { comic.year = comic.lastYear; }
		if (comic.year < comic.firstYear) { comic.year = comic.firstYear; }
		
		if (comic.num > comic.yearMaxNum(comic.year)) {
			comic.year += 1;
			if (comic.year > comic.lastYear) { comic.year = comic.firstYear; }
			comic.num = 0;
		}
		else if (comic.num < 0) {
			comic.year -= 1;
			if (comic.year < comic.firstYear) { comic.year = comic.lastYear; }
			comic.num = comic.yearMaxNum(comic.year);
		}
	},
	// gets comic number for given date
	dateNum: (date)=>{
		let num; // variable to return
		// calculate comic number for year
		let start = new Date(date.getFullYear(), 0, 0); // first day of the year
		let diff = date - start; // difference in milliseconds between first day of year and today
		let day = Math.floor(diff / 86400000); // divide difference in milliseconds by number of milliseconds per day
		num = day - 1;
		// return comic number
		return num;
	},
	yearMaxNum: (year)=>{
		let date = new Date(`December 31, ${year} 00:00:00`);
		let num = comic.dateNum(date);
		// if year is first year, adjust for start date (because it didn't start Jan 1st)
		if (comic.year == comic.firstYear) num -= comic.dateNum(comic.firstDate) + 1;
		return num;
	},
	// set comic data for given date
	set: (date, load)=> {
		// get comic year and number
		comic.year = date.getFullYear();
		comic.num = comic.dateNum(date);
		// if year is first year, adjust for start date (because it didn't start Jan 1st)
		if (comic.year == comic.firstYear) comic.num -= comic.dateNum(comic.firstDate) + 1;
		// load comic if load parameter is true
		if (load == true) comic.load();
	},
	init: ()=>{
		// set min/max year values
		comic.firstYear = comic.firstDate.getFullYear(),
		comic.lastYear = comic.lastDate.getFullYear(),
		
		// navigate comics with arrow keys
		document.addEventListener('keyup', (event) => {
			if (event.key === "ArrowRight") {
				event.preventDefault();
				comic.next();
			}
			else if (event.key === "ArrowLeft") {
				event.preventDefault();
				comic.prev();
			}
		});
		// navigate comics with buttons
		document.getElementById('prev').addEventListener('click',comic.prev);
		document.getElementById('next').addEventListener('click',comic.next);
		
		// get url search parameters
		let urlParams = new URLSearchParams(window.location.search);
		
		// if year is defined, set that year as first to load
		if (urlParams.has('year')) {
			// if year parameter = "random", set a random year (skip the first year if )
			if (urlParams.get('year') == 'random') {
				// set random year
				comic.year = Math.floor(Math.random() * (comic.lastYear - comic.firstYear + 1) + comic.firstYear);
			} // otherwise set year to the value given
			else comic.year = Number(urlParams.get('year'));
		}
		
		// if comic number is defined, set that number as first to load
		if (urlParams.has('num')) {
			// if num parameter = "today", set the number corresponding to today's date
			if (urlParams.get('num') == 'today') {
				let now = new Date();
				now.setFullYear(comic.year);
				comic.set(now);
			} // otherwise set num to the value given
			else comic.num = Number(urlParams.get('num'));
		}
		
		// if favorites = true, show next favorite (or the original comic to load, if it is favorited)
		if (urlParams.has('favorites') && urlParams.get('favorites') == 'true') comic.toggleFavorites();
		
		// load comic
		comic.load();
	}
}
window.addEventListener('load',()=>{ comic.init(); });