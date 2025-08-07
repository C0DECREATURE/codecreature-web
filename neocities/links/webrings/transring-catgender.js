/* widget code
<div id="transring">
<script type="text/javascript" src="https://transring.neocities.org/onionring-variables.js"></script>
<script type="text/javascript" src="https://transring.neocities.org/onionring-widget.js"></script>
<script type="text/javascript" src="/links/webrings/transring-catgender.js"></script>
</div>
*/

// all images in the transing the web widget
var transringImgs = document.querySelector('#transring').querySelectorAll('img');
// replace images
for ( let i = 0; i < transringImgs.length; i++ ) {
	var im = transringImgs[i];
	if ( im.src == 'https://transring.neocities.org/tleft.png' ) im.src = '/links/webrings/transring-catgender-left.png';
	if ( im.src == 'https://transring.neocities.org/transbutton.png' ) im.src = '/links/webrings/transring-catgender-mid.png';
	if ( im.src == 'https://transring.neocities.org/tright.png' ) im.src = '/links/webrings/transring-catgender-right.png';
}