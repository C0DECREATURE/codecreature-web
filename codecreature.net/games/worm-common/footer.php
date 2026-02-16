<footer id="main-footer">
	<a id="user" href="/user" >
		<?php echo $logged_in ? $_SESSION["username"] : 'log in'; ?>
	</a>
</footer>