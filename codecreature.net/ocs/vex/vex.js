// coffin img element
var coffin;
window.addEventListener('load',function(){ coffin = document.getElementById("coffin"); });

// called when coffin is clicked
function coffinClick() {
	if (coffinLocked && document.querySelector('body').classList.contains('hasKey') ) unlockCoffin();
	else toggleCoffin();
}

// open and close coffin image
function toggleCoffin() {
	if ( coffin.classList.contains('open') ) closeCoffin();
	else openCoffin();
}
function openCoffin() {
	if (!coffinLocked) {
		coffin.classList.add('open'); coffin.classList.remove('closed'); 
		coffin.querySelector('img').src = "images/coffin-open.png";
	}
}
function closeCoffin() {
	coffin.classList.add('closed'); coffin.classList.remove('open'); 
	if (coffinLocked) coffin.querySelector('img').src = "images/coffin-closed.png";
	else coffin.querySelector('img').src = "images/coffin-closed-unlocked.png";
}

// whether coffin is locked
var coffinLocked = true;
// unlock coffin
function unlockCoffin() {
	if ( document.querySelector('body').classList.contains('hasKey') ) {
		coffinLocked = false;
		useKey();
		openCoffin();
	}
}

// pick up coffin key
function getKey() {
	document.querySelector('body').classList.add('hasKey');
	document.getElementById('coffin-key').remove();
	// if touch is primary input, unlock immediately
	if (window.matchMedia("(pointer: coarse)").matches) { unlockCoffin(); }
}
// use coffin key
function useKey() { document.querySelector('body').classList.remove('hasKey'); }