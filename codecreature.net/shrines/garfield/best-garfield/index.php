<!DOCTYPE html>
<html lang="en">
	<head>
		<script>if (window.location.pathname.includes('shrines')) window.location = '/best-garfield';</script>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>best garfield</title>
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="/shrines/garfield/favicon.gif">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260715"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260715" rel="stylesheet" type="text/css"></link>
		
		<script>fonts.load('Garfield','Ad Lib')</script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260715" id="svg-icons-js"></script>
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260715"></script>
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260715"></script>
		
		<!-- load jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js?fileversion=20260715"></script>
		<!-- load navigation -->
		<script> $(function(){ $("#nav-wrapper").load("/shrines/garfield/nav.txt"); }); </script> 
		<!-- load right bar -->
		<script> $(function(){ $("#right-bar-wrapper").load("/shrines/garfield/right.txt"); }); </script> 
		
		<!--this page's stylesheet-->
		<link href="/shrines/garfield/style.css?fileversion=20260715" rel="stylesheet" type="text/css" media="all">
		<link href="/shrines/garfield/best-garfield/style.css?fileversion=20260715" rel="stylesheet" type="text/css" media="all">
		<link href="/shrines/garfield/best-garfield/poll.css?fileversion=20260715" rel="stylesheet" type="text/css" media="all">
	</head>
	
	<!-----------BODY------------------->
	<body>
		<a class="skip-to-content" href="#content">skip to content</a>
		
		<main>
			<div id="nav-wrapper" class="left">
			</div>
			
			<div class="center">
				<div class="container">
					
					<div id="content"><!-- anchor for keyboard nav -->
						<form id="form" action="/best-garfield/vote.php">
							<h2>which garfield is best?</h2>
							<div class="options-container">
							<?php
							require_once $_SERVER['DOCUMENT_ROOT']."/shrines/garfield/best-garfield/options.php";
							foreach ($garfield_types as $name => $list) {
								?>
								<section class="type">
									<?php if ($name != "Comics") { ?>
										<header><h3><?php echo $name; ?></h3></header>
									<?php } ?>
									<div class="options">
									<?php
									foreach ($list as $g) {
										$simple = getSimpleName($g);
										$opt = "opt-" . str_replace(" ","-",$simple);
										$img = getImgSrc($g);
										?>
											<div class="option">
												<div class="checkbox"></div>
												<label for="<?php echo $opt; ?>">
													<img src="<?php echo $img; ?>" alt="">
													<span class="name"><?php echo $g; ?></span>
												</label>
												<input type="radio" id="<?php echo $opt; ?>" name="name" value="<?php echo $g; ?>" required></input>
											</div>
									<?php
									}
									?>
									</div>
								</section>
								<?php
							}
							?>
							</div>
							<button class="yellowbutton" type="submit">Vote!</button>
							<a class="yellowbutton" type="button" href="/best-garfield/results">Results</a>
							<script>
								let form = document.getElementById('form');
								form.addEventListener('submit',(e)=>{
									//e.preventDefault();
									//data = new FormData(form);
									//window.location = "/best-garfield/result.php?name=" + encodeURI(data.get('name')));
								});
							</script>
						</form>
					</div>
				</div>
			</div>
			
			<div id="right-bar-wrapper" class="right">
			</div>
		</main>
		
	</body>
	<!--------------END BODY------------->
</html>
