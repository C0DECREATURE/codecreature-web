const coffin = {
	// coffin setup
	init: ()=>{
		coffin.btn = document.getElementById("coffin");
		coffin.btn.addEventListener('click',()=>{ coffin.click(); });
		coffin.key = document.getElementById("coffin-key");
		coffin.key.addEventListener('click',()=>{ coffin.getKey(); });
		// if user has already unlocked coffin in the past
		if (localStorage.getItem('vexCoffinLocked') == "false") {
			document.getElementById('coffin-key').remove();
			coffin.unlock();
		} else {
			coffin.lock();
		}
	},
	// called when coffin clicked
	click: ()=>{
		if (coffin.isLocked && document.querySelector('body').classList.contains('hasKey') ) {
			coffin.unlock();
			coffin.open();
		}
		else coffin.toggle();
	},
	// toggle coffin open/closed state
	toggle: ()=>{
		if ( coffin.btn.classList.contains('open') ) coffin.close();
		else coffin.open();
	},
	// open the coffin
	open: ()=>{
		if (!coffin.isLocked) {
			coffin.btn.classList.toggle('open');
			coffin.btn.querySelector('img').src = "images/coffin-open.png";
		}
	},
	// close the coffin
	close: ()=>{
		coffin.btn.classList.toggle('open'); 
		if (coffin.isLocked) coffin.btn.querySelector('img').src = "images/coffin-closed.png";
		else coffin.btn.querySelector('img').src = "images/coffin-closed-unlocked.png";
	},
	// lock the coffin
	lock: ()=>{
		console.log("locking coffin");
		coffin.isLocked = true;
		localStorage.setItem('vexCoffinLocked',coffin.isLocked);
	},
	// unlock the coffin
	unlock: ()=>{
		console.log("unlocking coffin");
		coffin.isLocked = false;
		localStorage.setItem('vexCoffinLocked',coffin.isLocked);
		coffin.useKey();
		coffin.btn.querySelector('img').src = "images/coffin-closed-unlocked.png";
	},
	// pick up the coffin key
	getKey: ()=>{
		document.querySelector('body').classList.add('hasKey');
		document.getElementById('coffin-key').remove();
		// if touch is primary input, unlock and open immediately
		if (window.matchMedia("(pointer: coarse)").matches) {
			coffin.unlock();
			coffin.open();
		}
	},
	// use the coffin key
	useKey: ()=>{
		document.querySelector('body').classList.remove('hasKey');
	}
};