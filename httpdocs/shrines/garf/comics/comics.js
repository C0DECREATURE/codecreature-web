//force strict mode
"use strict";

const comic = {
	id: 'comic-insert',
	year: 1978,
	setYear: (year)=>{
		comic.year = year;
		comic.load();
	},
	minYear: 1978,
	maxYear: 2024,
	yearSizes: {
		'1978': 195,
		'1979': 364,
		'1980': 365,
		'1981': 365,
		'1982': 365,
		'1983': 365,
		'1984': 366,
		'1985': 365,
		'1986': 365,
		'1987': 365,
		'1988': 366,
		'1989': 365,
		'1990': 365,
		'1991': 365,
		'1992': 366,
		'1993': 365,
		'1994': 365,
		'1995': 365,
		'1996': 366,
		'1997': 365,
		'1998': 365,
		'1999': 365,
		'2000': 366,
		'2001': 365,
		'2002': 365,
		'2003': 365,
		'2004': 366,
		'2005': 365,
		'2006': 365,
		'2007': 365,
		'2008': 366,
		'2009': 365,
		'2010': 365,
		'2011': 365,
		'2012': 366,
		'2013': 365,
		'2013': 365,
		'2014': 365,
		'2015': 365,
		'2016': 366,
		'2017': 365,
		'2018': 365,
		'2019': 365,
		'2020': 366,
		'2021': 365,
		'2022': 365,
		'2023': 365,
		'2024': 366,
	},
	num: 0,
	urlNum: ()=>{
		let urlNum = comic.num.toString();
    while (urlNum.length < 4) { urlNum = "0" + urlNum; }
    return urlNum;
	},
	load: ()=>{
		document.getElementById(comic.id).src = `https://ia601204.us.archive.org/BookReader/BookReaderImages.php?zip=/15/items/garfield-complete/Garfield%20${comic.year}_jp2.zip&file=Garfield%20${comic.year}_jp2/Garfield%20${comic.year}_${comic.urlNum()}.jp2&id=garfield-complete&scale=1&rotate=0`;
		console.log(`Loaded comic: ${comic.year} #${comic.num+1}`);
	},
	next: ()=>{
		comic.num += 1;
		comic.fix();
		comic.load();
	},
	prev: ()=>{
		comic.num -= 1;
		comic.fix();
		comic.load();
	},
	// fix any issues with num/year exceeding bounds
	fix: ()=>{
		if (comic.num > comic.yearSizes[comic.year.toString()] - 1) {
			comic.year += 1;
			if (comic.year > comic.maxYear) { comic.year = comic.minYear; }
			comic.num = 0;
		}
		else if (comic.num < 0) {
			comic.year -= 1;
			if (comic.year < comic.minYear) { comic.year = comic.maxYear; }
			comic.num = comic.yearSizes[comic.year.toString()] - 1;
		}
	},
	init: ()=>{
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
		comic.load();
	}
}
window.addEventListener('load',()=>{ comic.init(); });