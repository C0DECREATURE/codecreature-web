//force strict mode
"use strict";

const posters = {
	cur: 0, // current first poster on page
	pageSize: 4, // number of posters per page
	// called when poster container loads.
	// defines container variable and loads posters
	init: ()=>{
		posters.container = document.getElementById('posters');
		// load the posters into the page
		for (let i = posters.cur; i < posters.pageSize; i++) {
			if (i < posters.list.length) posters.loadPoster(i);
		}
	},
	loadPoster: (...indexes)=>{
		for (let index of indexes) {
			if (index < posters.list.length) {
				let img = document.createElement('img');
				img.src = posters.list[index].src;
				img.alt = "";
				img.classList.add('poster','full-viewable');
				// add the element to the page once the image loads
				img.addEventListener('load',()=>{ posters.container.appendChild(img) });
			}
		}
	},
	// pulled from garfieldposters.com web archive
	// https://web.archive.org/web/20070222055347/http://www.garfieldposters.com/shop/catalog_regular.asp?show=8&page=0
	list: [
		{
			title: "Booted",
			src: 'https://web.archive.org/web/20051217181207im_/http://garfieldposters.com/shop/1products1/%7B241E8839-42DF-4189-97D2-ACD7C107DE95%7D_450.jpg',
		},
		{
			title: "Compute This",
			src: 'https://web.archive.org/web/20070220191011im_/http://www.garfieldposters.com/shop/moeskeraj/%7BC721AB0D-2625-44AA-B159-333C1B95E73A%7D_450.jpg',
		},
		{
			title: "I Don't Have Time",
			src: 'https://web.archive.org/web/20070221043750im_/http://www.garfieldposters.com/shop/moeskeraj/%7B8518161D-862C-4B18-AD91-18A5684219D8%7D_450.jpg',
		},
		{
			title: "Good Morning",
			src: 'https://web.archive.org/web/20070221043727im_/http://www.garfieldposters.com/shop/moeskeraj/%7B5C2C8DDD-F5C1-4CDD-813D-805CA0005A9B%7D_450.jpg',
		},
		{
			title: "Imagination",
			src: 'https://web.archive.org/web/20070220191032im_/http://www.garfieldposters.com/shop/moeskeraj/%7BD0FA380A-CE10-48F3-A95B-7B2DFCCDBD6F%7D_450.jpg',
		},
		{
			title: "One of Those Days",
			src: 'https://web.archive.org/web/20070220191022im_/http://www.garfieldposters.com/shop/moeskeraj/%7BCDC4B15A-42D7-4BE7-9315-1E104DBA5879%7D_450.jpg',
		},
		{
			title: "Life's a Beach",
			src: 'https://web.archive.org/web/20070221005705im_/http://www.garfieldposters.com/shop/moeskeraj/%7BC661C346-CCF8-4E4D-A875-BCD4D28D034C%7D_450.jpg',
		},
		{
			title: "Mornings",
			src: 'https://web.archive.org/web/20070221043737im_/http://www.garfieldposters.com/shop/moeskeraj/%7B7C6A412A-588E-4FB7-90C1-058D95A033DC%7D_450.jpg',
		},
	],
}