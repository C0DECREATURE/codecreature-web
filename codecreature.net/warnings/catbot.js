const catBot = {
	defaultEyes: '00',
	sleepDelay: 8000,
	init: ()=>{
		catBot.eyes = document.getElementById('catbot-eyes');
		catBot.wake();
		if (!isReducedMotion) catBot.blink(false); // don't blink if user prefers reduced motion
		window.addEventListener('click',catBot.wake);
	},
	// make bot blink
	// if display == false, don't blink but reset blink timer
	blink: (display,prevTime)=>{
		// if blink should be displayed
		if (
			display != false
			&& catBot.sleeping == false
		) {
			catBot.setEyes('closed');
			setTimeout(function () { catBot.setEyes('default'); }, 200);
		}
		// get time to next blink
		var randomTime;
		// if last blink was short, make next one longer
		if (prevTime && prevTime < 1000 ) { randomTime = Math.floor((Math.random()*3000)+2000) }
		// otherwise blink in .7-7 seconds
		else { randomTime = Math.floor((Math.random()*4300)+700) }
		// set blink timer to run this function again
		setTimeout(function(){ catBot.blink(true,randomTime) },randomTime);
	},
	// make bot sleep, disables blinking display
	sleep: ()=>{
		catBot.sleeping = true;
		catBot.setEyes('closed');
	},
	// wake bot up if sleeping, reset sleep timer
	wake: ()=>{
		catBot.setEyes('default');
		if (catBot.sleepTimer) clearTimeout(catBot.sleepTimer);
		catBot.sleepTimer = setTimeout(catBot.sleep,catBot.sleepDelay);
		catBot.sleeping = false;
	},
	// set expression
	setEyes: (name)=>{
		if (name == 'default') name = catBot.defaultEyes;
		catBot.eyes.src = `catnip_eyes_${name}.png`;
	},
};
catBot.init();