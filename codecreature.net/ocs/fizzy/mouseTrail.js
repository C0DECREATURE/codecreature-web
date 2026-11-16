/*
╔══════════════════════════════════════════════╗
║ Mouse Trail created with the                 ║
║ SweetCharm.net Mouse Trail Maker             ║
║ https://sweetcharm.net/                      ║
║ Please leave this credit box intact ♡        ║
╚══════════════════════════════════════════════╝

modified by codecreature
*/

const trailSettings = {

icons: ["images/bubble.png","images/bubble_star.png"],

amount: 1,

density: 5,

size: 7, // minimum size (in px)

variation: 30, // maximum amount to INCREASE size (in px)

};

(()=>{
	let bubbleLayer = document.createElement("div");
	bubbleLayer.classList.add("mouse-trail","mouse-bubbles");
	
	window.addEventListener("load",()=>{
		document.body.appendChild(bubbleLayer);
	});

	// only produce mouse trail if user hasn't requested reduced motion
	document.addEventListener("mousemove",(e)=>{
		if (!isReducedMotion) {
			let spawnChance;

			switch(trailSettings.density){

					case 1: spawnChance=.01; break;
					case 2: spawnChance=.03; break;
					case 3: spawnChance=.06; break;
					case 4: spawnChance=.12; break;
					case 5: spawnChance=.25; break;
					case 6: spawnChance=.45; break;
					case 7: spawnChance=.70; break;
					default: spawnChance=1;

			}

			if(Math.random()>spawnChance) return;

			for(let i=0;i<trailSettings.amount;i++){
				
				// create a random image from the icons list
				let img = document.createElement("img");
				let icon = Math.random() > .2 ? 0 : 1;
				img.src = trailSettings.icons[icon];
				
				// create wrapper div for image
				let wrapper = document.createElement("div");
				wrapper.classList.add("mouse-bubble");
				
				// set horizontal movement direction
				let direction = Math.floor(Math.random() * 3);
				switch(direction) {
					case 1: wrapper.classList.add("left"); break;
					case 2: wrapper.classList.add("right"); break;
					case 3: break;
				}
				
				// set position
				wrapper.style.left = (e.clientX + (Math.random()*16-8)) + "px";
				wrapper.style.top= (e.clientY + (Math.random()*16-8)) + "px";
				
				// set rotation (star only)
				if (icon == 1) {
					img.style.rotate = Math.floor((Math.random()*360)-10) + "deg";
				}
				
				// set size
				let sizeVar = trailSettings.size + (Math.random()*trailSettings.variation);
				// 20% chance of big bubbles, 0% chance of big stars
				if (icon == 1 || Math.random() < .8) sizeVar *= .5;
				
				wrapper.style.width = (trailSettings.size + sizeVar) + "px";
				
				// insert the elements into the document
				wrapper.appendChild(img);
				bubbleLayer.appendChild(wrapper);
				
				// delete after animation concludes
				setTimeout(()=>{
					wrapper.remove();
				},2050);
				
			}
		}
	});
	
})();