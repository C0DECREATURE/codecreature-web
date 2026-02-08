(()=>{
	document.addEventListener('mousemove', (e)=>{
		let x = e.clientX * 20 / window.innerWidth - 10;
		let y = e.clientY * 20 / window.innerHeight - 10;
		var pupils = document.getElementsByClassName('pupil');
		for (let i = 0; i < pupils.length; i++) {
			pupils[i].style.left = x + "%";
			pupils[i].style.top = y + "%";
		}
	});
})();