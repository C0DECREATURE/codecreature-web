(()=>{
	document.addEventListener('mousemove', (e)=>{
		let x = e.clientX * 22 / window.innerWidth - 11;
		let y = e.clientY * 22 / window.innerHeight - 11;
		var pupils = document.getElementsByClassName('pupil');
		for (let i = 0; i < pupils.length; i++) {
			pupils[i].style.left = x + "%";
			pupils[i].style.top = y + "%";
		}
	});
})();