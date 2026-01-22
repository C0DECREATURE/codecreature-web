let monthbox, daybox, hourbox, minutebox, weekdaybox, ampmbox;

const clock = {
	update: ()=>{
		let date = new Date();
		monthbox.innerHTML = date.getMonth() + 1;
		daybox.innerHTML = date.getDate();
		weekdaybox.innerHTML = clock.dayNames[date.getDay()];
		hourbox.innerHTML = date.getHours();
		minutebox.innerHTML = date.getMinutes();
		ampmbox.innerHTML = date.getHours() >= 12 ? 'pm' : 'am';
	},
	dayNames: [ 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa' ]
}

window.addEventListener('load', ()=>{
	let clockbox = document.getElementById('clock');
	monthbox = clockbox.querySelector('.month');
	daybox = clockbox.querySelector('.day');
	hourbox = clockbox.querySelector('.hour');
	minutebox = clockbox.querySelector('.minute');
	weekdaybox = clockbox.querySelector('.weekday');
	ampmbox = clockbox.querySelector('.ampm');
	clock.update();
});