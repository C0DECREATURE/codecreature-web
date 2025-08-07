/* ADD TO END OF ANY HTML DOC LOADING THIS SCRIPT
	
// check if this page has 'iframe' in its URL parameters
// if so, add the iframe class to this page's body
iFrameParams();

*/

// if this is being displayed in an iframe
function iFrameParams() {
	let urlParams = new URL(window.location.toLocaleString()).searchParams;
	if ( urlParams.has('iframe') && urlParams.get('iframe') != 'false' ) document.body.classList.add('iframe');
}