var creditPopup;

window.addEventListener('load',function() {
	//----- TV -----//
	
	//----- CREDITS POPUP ----//
	creditPopup = document.getElementById('credit');
});

function credButton() {
	if ( creditPopup.style.display == 'block' ) closeCredit();
	else openCredit();
}

function openCredit() { creditPopup.style.display = 'block'; }
function closeCredit() { creditPopup.style.display = 'none'; }