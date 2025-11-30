/* ADD TO END OF ANY HTML DOC LOADING THIS SCRIPT
	
// check if this page has 'iframe' in its URL parameters
// if so, add the iframe class to this page's body
iFrameParams();

*/

var isIFrame = false;

// if this is being displayed in an iframe
function iFrameParams() {
	// Validation: it must be loaded as the top page, or if it is loaded in an iframe 
	// then it must be embedded in my own domain.
	// Info: IF top.location.href is not accessible THEN it is embedded in an iframe 
	// and the domains are different.
	try {
			var tophref = top.location.href;
			var tophostname = top.location.hostname.toString();
			var myhref = location.href;
			if (tophref === myhref) {
				isIFrame = false;
			} else if (tophostname !== "www.yourdomain.com") {
				isIFrame = true;
			}
	} catch (error) { 
		// error is a permission error that top.location.href is not accessible 
		// (which means parent domain <> iframe domain)!
		isIFrame = true;
	}
	if (isIFrame) document.body.classList.add('iframe');
}