// force strict mode
"use strict";

//////////////////////////////////////////////////////////////////////////////////
// SPRITE ANIMATIONS

function setSpriteState(sprite,state,talking) {
	if (state == "neutral") state = "";
	else state = "_" + state;
	// if this is a new state, set the state and image
	if (sprite.dataset.state != state) {
		sprite.dataset.state = state;
	}
	// start the talking animation
	if (talking) { spriteTalk(sprite); }
	else {
		sprite.dataset.talking = "false";
		sprite.src = sprite.dataset.src + state + ".gif";
	}
}

function spriteTalk(sprite,speed) {
	// if sprite not already talking
	if (!isTrue(sprite.dataset.talking)) {
		if (!speed) speed = 400;
		let src = sprite.dataset.src;
		let state = sprite.dataset.state;
		sprite.dataset.talking = "true";
		
		function loop() {
			if (isTrue(sprite.dataset.talking)) {
				sprite.src = src + state + "_talk.gif";
				setTimeout(()=>{
					if (isTrue(sprite.dataset.talking)) { sprite.src = src + state + ".gif" }
				},speed/2);
				setTimeout(loop,speed);
			}
		}
		// start the loop
		loop();
	}
}

// hover/focus and unhover/unfocus events
function hoverSprite(s) {
	if (s.dataset.hoverState) setSpriteState(s,s.dataset.hoverState);
	spriteTalk(s);
}
function unHoverSprite(s) { setSpriteState(s,"neutral"); }

window.addEventListener('load', ()=>{
	let sprites = document.getElementsByClassName('sprite');
	for (let i = 0; i < sprites.length; i++) {
		let s = sprites[i];
		// set to default state on load
		if (!s.dataset.state) s.dataset.state = "neutral";
		setSpriteState(s,s.dataset.state);
		// talk animation on hover
		s.addEventListener('mouseenter', ()=>{ hoverSprite(s); });
		s.addEventListener('focus', ()=>{ hoverSprite(s); });
		s.addEventListener('mouseleave', ()=>{ unHoverSprite(s); });
		s.addEventListener('blur', ()=>{ unHoverSprite(s); });
	}
});