/*
<!-- this page's script -->
<script src="script.js?fileversion=20251216"></script>

*/

// force strict mode
"use strict";


//////////////////////////////////////////////////////////////////////////////////
// DISPLAY SHIP DESCRIPTIONS

// ship description section
let shipDescriptionDisplay;
// all ship buttons/squares
let shipButtons = document.getElementsByClassName('ship');

window.addEventListener('load', ()=>{
	shipDescriptionDisplay = document.getElementById('ship-description');
	
	let shipButtons = document.getElementsByClassName('ship');
	for (let i = 0; i < shipButtons.length; i++) {
		let ship = shipButtons[i];
		// add quadrant icons
		for (let i = 0; i < ship.classList.length; i++) {
			let alt = "";
			
			if (ship.classList[i] == "pale") {
				alt = "diamond";
				ship.classList.add("conciliatory","red-romance");
			}
			else if (ship.classList[i] == "red") {
				alt = "heart";
				ship.classList.add("concupiscent","red-romance");
			}
			else if (ship.classList[i] == "black") {
				alt = "spade";
				ship.classList.add("concupiscent","black-romance");
			}
			else if (ship.classList[i] == "ashen") {
				alt = "clubs";
				ship.classList.add("conciliatory","black-romance");
			}
			else continue; // if this class is not quadrant related, move to the next one
			
			ship.querySelector('.icons').innerHTML += `<img src="images/quadrants_${ship.classList[i]}.png" alt="${alt}">`;
		}
		// if description exists, make it clickable to open full description
		if (ship.querySelector('.description')) {
			ship.addEventListener('click',()=>{ showShipDescription(ship); });
		}
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

function showShips(type) {
	document.body.classList.remove('all-only','red-only','pale-only','black-only','ashen-only','conciliatory-only','concupiscent-only','red-romance-only','black-romance-only');
	
	document.body.classList.add(type + '-only');
	
	if (type == 'red') type = 'matespritship';
	if (type == 'pale') type = 'moirallegiance';
	if (type == 'black') type = 'kismesissitude';
	if (type == 'ashen') type = 'auspisticism';
	document.getElementById('currently-showing-name').innerHTML = type.replaceAll('-',' ');
}