var creditPopup;

window.addEventListener('load',function() {
	/*
	//----- TV -----//
	// list of all playables for tv
	const videos = document.getElementById('tv-screen').children;
	// current video
	var cur = 0;
	// whether tv is currently on
	var tvOn = false;

	initTV();
	*/
	//----- CREDITS POPUP ----//
	creditPopup = document.getElementById('credit');
});

function credButton() {
	if ( creditPopup.style.display == 'block' ) closeCredit();
	else openCredit();
}

function openCredit() { creditPopup.style.display = 'block'; }
function closeCredit() { creditPopup.style.display = 'none'; }