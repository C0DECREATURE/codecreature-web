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
		<a href="<?php echo $worm_race_path ?>">feed worms</a>
		<a href="<?php echo $worm_race_path ?>racetrack">racetrack</a>
		<a href="<?php echo $worm_race_path ?>guide">guide</a>
		<a href="<?php echo $worm_race_path ?>share">propaganda</a>
		<a href="/games/worm-fishing">fishing</a>
		<button id="open-updates" onclick="">
			updates
		</button>
	</nav>
	<script>
		(()=>{
			let buttons = document.getElementById('menu-buttons').children;
			for ( let i = 0; i < buttons.length; i++ ) {
				buttons[i].addEventListener('click', ()=>{
					// on small screens, close menu when any button clicked
					document.getElementById('menu').classList.remove('open');
					// any button except open-updates should also close the updates container
					if ( buttons[i].id != 'open-updates' ) document.getElementById('updates-container').classList.remove('open');
					else document.getElementById('updates-container').classList.add('open');
				});
			}
		})();
	</script>
</section>