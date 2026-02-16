<section id="menu">
	<header>
		<button class="toggle-menu" aria-label="toggle menu" onclick="document.getElementById('menu').classList.toggle('open');">
			<i class="open svg-icon i-menu-bars"></i>
			<i class="close svg-icon i-x"></i>
		</button>
		<h2>Menu</h2>
	</header>
	
	<nav id="menu-buttons">
		<a href="/">site home</a>
		<a href="../worm-race">worm race</a>
	</nav>
	<script>
		(()=>{
			let buttons = document.getElementById('menu-buttons').children;
			// on small screens, close menu when any button clicked
			for ( let i = 0; i < buttons.length; i++ ) {
				buttons[i].addEventListener('click', ()=>{
					document.getElementById('menu').classList.remove('open');
				});
			}
		})();
	</script>
</section>