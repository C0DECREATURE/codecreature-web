//force strict mode
"use strict";

// self executing
window.addEventListener('load', ()=>{
	let today = new Date();
	const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
	let todayFormatted =`${weekday[today.getDay()]}, ${month[today.getMonth()]} ${today.getDate()}, ${today.getFullYear()}`;
	document.getElementById('news-date').innerHTML = todayFormatted;
});