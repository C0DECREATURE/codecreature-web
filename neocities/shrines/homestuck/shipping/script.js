/*
<!-- this page's script -->
<script src="script.js?fileversion=9"></script>

*/

// force strict mode
"use strict";


//////////////////////////////////////////////////////////////////////////////////
// DISPLAY SHIP DESCRIPTIONS

// ship description section
let shipDescriptionDisplay;

window.addEventListener('load', ()=>{
	shipDescriptionDisplay = document.getElementById('ship-description');
	
	let shipButtons = document.getElementsByClassName('ship');
	for (let i = 0; i < shipButtons.length; i++) {
		let description = shipButtons[i].querySelector('.description');
		// if description exists, make it clickable to open full description
		if (description) { shipButtons[i].addEventListener('click',()=>{ showShipDescription(shipButtons[i]); }); }
	}
});

function showShipDescription(ship) {
	ship.classList.add('cur-ship');
	let description = ship.querySelector('.description').innerHTML;
	shipDescriptionDisplay.querySelector('.description').innerHTML = description;
	shipDescriptionDisplay.dataset.shipId = ship.id;
	shipDescriptionDisplay.classList.remove('hidden');
	document.getElementById('ship-description-anchor').focus();
}
function closeShipDescription() {
	let ship = document.getElementById(shipDescriptionDisplay.dataset.shipId); 
	shipDescriptionDisplay.classList.add('hidden');
	ship.focus();
	ship.classList.remove('cur-ship');
}