// force strict mode
"use strict";

var chatbox = '';
var chatHeader = '';
var toggleBtn = '';
var chattable = '';
var chatOpen = false;

function initChat() {
	chatbox = document.querySelector('.chat-box');
	chatHeader = chatbox.querySelector('header');
	toggleBtn = chatHeader.querySelector('.toggle');
	chattable = chatbox.querySelector('#chattable');
	
	// add padding for chatbox
	let height = chatHeader.offsetHeight + 5;
	document.querySelector('#chatspacer').style.height = height + 'px';
	
	chattable.addEventListener('load', function() {
		chattable.style.visibility = 'visible';
		chatbox.querySelector('#chat-load-text').style.display = 'none';
	});
	
	// styling chatbox
	// get parent document style
	var docStyle = getComputedStyle(document.querySelector('HTML'));
	// send the style info to chattable
	window.onload = function(){	
		chattable.contentWindow.postMessage(`
			:root {
				--white: ` + docStyle.getPropertyValue("--white") + `;
				--black: ` + docStyle.getPropertyValue("--black") + `;
				--orange: ` + docStyle.getPropertyValue("--orange") + `;
				--d-orange: ` + docStyle.getPropertyValue("--d-orange") + `;
				--yellow: ` + docStyle.getPropertyValue("--yellow") + `;
				--l-green: ` + docStyle.getPropertyValue("--l-green") + `;
				--green: ` + docStyle.getPropertyValue("--green") + `;
				--d-green: ` + docStyle.getPropertyValue("--d-green") + `;
				--dd-green: ` + docStyle.getPropertyValue("--dd-green") + `;
				--teal: ` + docStyle.getPropertyValue("--teal") + `;
				--l-blue: ` + docStyle.getPropertyValue("--l-blue") + `;
				--blue: ` + docStyle.getPropertyValue("--blue") + `;
				--d-blue: ` + docStyle.getPropertyValue("--d-blue") + `;
				--dd-blue: ` + docStyle.getPropertyValue("--dd-blue") + `;
				--ll-pink: ` + docStyle.getPropertyValue("--ll-pink") + `;
				--l-pink: ` + docStyle.getPropertyValue("--l-pink") + `;
				--pink: ` + docStyle.getPropertyValue("--pink") + `;
				--d-pink: ` + docStyle.getPropertyValue("--d-pink") + `;
				--red: ` + docStyle.getPropertyValue("--red") + `;
				--l-purple: ` + docStyle.getPropertyValue("--l-purple") + `;
				--purple: ` + docStyle.getPropertyValue("--purple") + `;
				--d-purple: ` + docStyle.getPropertyValue("--d-purple") + `;
				--dd-purple: ` + docStyle.getPropertyValue("--dd-purple") + `;
			}
			
			body { display: flex; flex-direction: column; }
			
			/***** SCROLLBAR *****/
			::-webkit-scrollbar { width: 20px; }
			::-webkit-scrollbar-track {
				box-shadow: inset 0 0 5px var(--green);
				background-color: var(--l-green); }
			::-webkit-scrollbar-thumb { background: var(--blue); }
			
			/***** CURSOR *****/
			body, * { cursor: url("https://codecreature.neocities.org/graphix/cursors/paw.png"), auto; }
			a, a:hover, button, button:hover { cursor: url("https://codecreature.neocities.org/graphix/cursors/paw-pointer.png"), auto; }
			
			.msgWrapper {
				color: var(--blue);
				word-wrap: break-word;
			}
			.allMessages {
				border-radius: .75em;
				background: white;
				box-shadow: .3em .4em var(--blue);
				text-align: left;
				padding: .75em;
				width: 80%;
			}
			.sent { margin-left: auto; border-bottom-right-radius: 0; border-top-right-radius: 1em; }
			.recieved { border-bottom-left-radius: 0; border-top-left-radius: 1em; }
			
			.msgWrapper:has(> .sent) + .msgWrapper:has(> .sent) > p { margin-block-start: .5em; }
			.msgWrapper:has(> .sent):has(+ .msgWrapper) > p { margin-block-end: .5em; }
			
			.senderInfo { color: var(--d-blue); font-weight: normal; font-family: 'Yet R', sans-serif; font-size: 1.1em; }
			.msgBody { color: var(--blue); }
			
			/****** REPLY QUOTES ******/
			blockquote {
				padding-left: 10px;
				background-color: var(--l-blue); color: var(--dd-blue);
				border-left: solid 3px var(--d-blue);
				opacity: 1;
			}
			.msgWrapper:has(.owner) blockquote {
				background-color: var(--l-green); color: var(--d-orange);
				border-left: solid 3px var(--green);
			}
			.msgWrapper:has(.mod) blockquote {
				background-color: var(--ll-pink); color: var(--red);
				border-left: solid 3px var(--pink);
			}
			
			/****** CHATTABLE BANNER ******/
			#top_banner { height: 2em; background: var(--green); color: var(--blue); }
			#settings { filter: invert(100%); height: calc(2em - 10px); width: calc(2em - 10px); }
			#settings::before {
				position: absolute; left: -.5em; top: 50%; transform: translate(-100%, -50%);
				width: 200px;
				text-align: right; font-weight: bold; font-size: 1.15em;
				filter: invert(100%); color: var(--blue);
				content: 'set name';
			}
			
			#background {
				border-top: .3em var(--blue) solid;
				border-bottom: .3em var(--blue) solid;
				flex: 1;
				padding: 5px 8px;
			}
			
			#input {
				font-size: 1em;
				height: 2em;
				background: var(--yellow);
				color: var(--red);
				border-radius: 0px;
			}
			#input:empty::before { color: var(--red); text-transform: lowercase; opacity: 0.6; }
			#input:focus { outline: 0; background-color: var(--l-green); color: var(--d-blue); }
			#input:focus:empty::before { color: var(--dd-green); }
			input[type="text" i] { writing-mode: vertical-lr !important; }
			
			/* ROLES */
			.allMessages:has(> .owner) > .senderInfo, .allMessages:has(> .owner) > .msgBody { color: var(--d-orange); }
			.allMessages:has(> .mod) > .senderInfo, .allMessages:has(> .mod) > .msgBody { color: var(--pink); }
			.owner:before, .mod:before {
				content: ''; display: inline-block;
				height: .9em; width: .9em; margin-bottom: -.1em; margin-right: .2em;
				background-size: 100% 100%; background-position: left top; background-repeat: no-repeat;
			}
			.owner:before { background-image: url("http://codecreature.helioho.st/games/wormrace/apple.png"); }
			.mod:before { background-image: url('` + window.location.href + `heal.png'); }
			/* hover text */
			.tooltip {
				background-color: var(--dd-blue) !important;
				transform: translate(-10%, -160%) !important;
				border: 0 !important;
				text-transform: lowercase;
				font-size: 1em !important;
			}
			
			/* SETTINGS WINDOW */
			#settingsWindow {
				background: var(--l-blue) !important;
				box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box;}
			/* the close button */
			#settingsWindow > :last-child { background: var(--red) !important; color: var(--white) !important; }
			
			/* in-chat mod controls */
			#ctxMenu > * { color: var(--blue) !important; }
		`, '*')
	}
}

function toggleOpenChat() {
	if (chatOpen) closeChat();
	else openChat();
}
function openChat() {
	chattable.style.display = 'block';
	document.querySelector('#chat-load-text').style.visibility = 'visible';
	chatOpen = true;
	toggleBtn.innerHTML = "—";
	toggleBtn.ariaLabel = "minimize chat";
}
function closeChat() {
	chattable.style.display = 'none';
	document.querySelector('#chat-load-text').style.visibility = 'hidden';
	chatOpen = false;
	toggleBtn.innerHTML = "+";
	toggleBtn.ariaLabel = "open chat";
}
