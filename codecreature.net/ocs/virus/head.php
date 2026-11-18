<link href="glitch-text.css?fileversion=20261116" rel="stylesheet" type="text/css" media="all">

<script>

window.addEventListener("load",()=>{
	let glitchElements = [
		document.querySelectorAll("h1"),
		document.querySelectorAll("h2"),
		document.querySelector("nav").getElementsByClassName("button"),
		document.getElementsByClassName("subheader"),
		document.getElementById("gallery").getElementsByClassName("link")
	];
	
	glitchElements.forEach((collection)=>{
		for (let i = 0; i < collection.length; i++) {
			let el = collection[i];
			el.classList.add("glitch-text");
			el.dataset.text = el.innerText;
		}
	});
	
	let prnEl = document.getElementById("identity-pronouns").querySelector(".value");
	let speciesEl = document.getElementById("about").querySelector(".subheader");
	prnEl.ariaLabel = "it/its, she/her";
	speciesEl.ariaLabel = "glitch dog/cat/thing";
	if (!isReducedMotion) {
		function cycleValues(element,values) {
			// increment the value index
			let i = Number(element.dataset.cur);
			if (!element.dataset.cur || element.dataset.cur >= values.length - 1) i = 0;
			else i += 1;
			element.dataset.cur = i;
			// start glitch animation
			element.classList.add("glitch-text","animate");
			// change the value
			setTimeout(()=>{ element.innerHTML = values[i]; }, 150);
			// stop glitch animation
			setTimeout(()=>{ element.classList.remove("glitch-text","animate"); }, 400);
		}
		
		let pronouns = ["▒t/its","she/██▒","INVALID_QU▒RY_LOCATOR▒FORMAT","404: NOT FO▒N█","ERROR_OU▒▒OFM█▒▒ORY"];
		setInterval(()=>{cycleValues(prnEl,pronouns)}, 2600);
		
		let species = ["glitch cat","???▒▒█??▒","▒RROR_DEV_NOT_E██ST","glitch dog"];
		setInterval(()=>{
			cycleValues(speciesEl,species);
			setTimeout(()=>{ document.title = "Virus the "+speciesEl.innerText; }, 200);
		}, 3800);
	} else {
		prnEl.innerText = "▒t/its, she/██▒";
	}
});

</script>