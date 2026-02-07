<!-- UPDATES IFRAME -->
<div class="updates" id="updates-container"><div class="wrapper">
	<button class="close" aria-label="close updates" onclick="document.getElementById('updates-container').classList.remove('open');">
		<i class="svg-icon i-x"></i>
	</button>
	<header>
		<a class="title" href="/updates?includedTags=worm+race">Latest Updates</a>
	</header>
	<p class="loading">loading...</p>
	<iframe title="updates" id="updates" src="/updates/?showWarnings=false&includedTags=worm+race&tqOn=false&showLimit=3"></iframe>
	<script>
		let updateCSS = document.createElement('link');
		updateCSS.href = '/games/worm-race/updates.css?fileversion=5';
		updateCSS.rel = 'stylesheet';
		updateCSS.type = 'text/css';
		updateCSS.media = 'all';
		
		let updateFonts = document.createElement('link');
		updateFonts.href = '/fonts/YetR/stylesheet.css?fileversion=5';
		updateFonts.rel = 'stylesheet';
		updateFonts.type = 'text/css';
		updateFonts.media = 'all';
		
		let iFrame = document.getElementById("updates");
		
		iFrame.onload = function() {
			document.querySelector('.updates').querySelector('.loading').style.display = 'none';
			iFrame.contentDocument.head.appendChild(updateCSS);
			iFrame.contentDocument.head.appendChild(updateFonts);
			iFrame.style.visibility = 'visible'; // show once loaded
		}
	</script>
</div></div>
<div class="updates shadow"></div>