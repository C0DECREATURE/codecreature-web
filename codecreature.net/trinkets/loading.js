// runs when all images have loaded
window.addEventListener('load', ()=>{
	Promise.all(Array.from(document.images).filter(img => !img.complete).map(img => new Promise(resolve => { img.onload = img.onerror = resolve; }))).then(() => {
		document.getElementById('drag-wrapper').classList.remove('hidden');
		document.getElementById('load-screen').classList.add('hidden');/* Execute the magnify function: */
		// execute magnifier function
		if (typeof magnify != "undefined") magnify("shadow-box-img", 2);
	});
});