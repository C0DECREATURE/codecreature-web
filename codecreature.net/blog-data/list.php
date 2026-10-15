<?php
	// whether to load full post content
	$fullPost = true;
	if (isset($_GET["full"]) && $_GET["full"] == "false") $fullPost = false;
	
	// whether the oldest/newest valid posts have been loaded on this page
	$oldestPostLoaded = $newestPostLoaded = false;
	
	$page = isset($_GET["page"]) ? $_GET["page"] : 1;
	
	$table = $_GET["table"];
	// base URL path for this table
	$basePath = "/" . ($table == "updates" ? $table : "blog/$table");
	// url parameters ($_GET)
	$urlParams = [];
	if (!empty($_GET["includeTags"]))	$urlParams["includeTags"] = $_GET["includeTags"];
	if (!empty($_GET["requireTags"]))	$urlParams["requireTags"] = $_GET["requireTags"];
	if (!empty($_GET["excludeTags"]))	$urlParams["excludeTags"] = $_GET["excludeTags"];
	// get the URL query string stripped of any parameters that should remain hidden
	$cleanUrlQuery = (count($urlParams) > 0 ? "?" : "").http_build_query($urlParams);
	
	// include user database connection file
	include $_SERVER['DOCUMENT_ROOT']."/user/database.php";
	// Initialize the session if not already started
	if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }
	// whether user is authorized to post
	$logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true;
	$userAuthorized = $logged_in && isset($_SESSION["id"]) && getAuthorization($_SESSION["id"]) == "admin";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>codecreature upd8 log</title>
		
		<base href="<?php echo $basePath; ?>">
		<base target="_parent">
		
		<!-- prevent warnings popup on this page IF it's in an iFrame -->
		<script>var showMainWarnings = window.self == window.top;</script>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		
		<!-- fonts -->
		<script>fonts.load('Comic Sans MS','Super Comic');</script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		
		<!--full image view-->
		<script defer src="/codefiles/full-image.js?fileversion=20260410"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260410" id="svg-icons-js"></script>
		
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260410"></script>
		
		<!--bbcode stylesheet-->
		<link href="/chat/bbcode.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<!--this page's stylesheet-->
		<link href="/blog-data/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
	</head>
	
	<!-----------BODY------------------->
	<body id="top" class="<?php echo $fullPost ? "full-posts" : "summaries-only"; ?>">
		<button class="skip-to-content" onclick="window.location.hash='posts'">skip to posts</button>
		<button class="skip-to-content" onclick="window.location.hash='pagination'">skip to pagination</button>
		<!--main content container -->
		<main class="main-container">
			
			<a id="title" class="title" href="<?php echo $basePath; ?>">
			<?php if ($fullPost) { ?>
				<h1>
					<img src="/graphix/deco/green-3d-spin-star.gif" alt="">
					Update Log
					<img src="/graphix/deco/green-3d-spin-star.gif" alt="">
				</h1>
			<?php } else { ?>
				<img class="block" src="/graphix/deco/new-cat.gif" alt="">
				<h1>Latest Updates</h1>
				
				<span class="subtitle" id="iframe-subtitle">
					click <u class="tq">4</u> full log
				</span>
			<?php } ?>
			</a>
			
			<?php if ($fullPost) { ?>
				<nav>
					<a href="/home">home</a>
				</nav>
				<?php if (!empty($urlParams["includeTags"])) {
					$tags = explode(",",$urlParams["includeTags"]); ?>
				<div class="tag-parameters">
					<?php foreach ($tags as $t) {
						$clearedParams = implode(",",array_diff($tags,[$t]));
						?>
						<button data-tag="<?php echo $t; ?>" onclick="removeIncludeTag(this.dataset.tag)">#<?php echo $t; ?> X</button>
					<?php } ?>
					<script>
						function removeIncludeTag(tag) {
							var searchParams = new URLSearchParams(window.location.search);
							var arr = searchParams.get("includeTags").split(",");
							var index = arr.indexOf(tag);
							if (index > -1) arr.splice(index, 1);
							if (arr.length == 0) searchParams.delete("includeTags");
							else searchParams.set("includeTags",arr.toString());
							window.location.search = searchParams.toString();
						}
					</script>
				</div>
				<?php } ?>
			<?php } ?>
			
			<ul class="posts" id="posts">
				<!-- posts inserted here -->
				<?php include "load-posts.php"; ?>
			</ul>
			
			<footer>
				<!-- link to full posts -->
				<?php if (!$fullPost) { ?><a href="<?php echo "$basePath$cleanUrlQuery"; ?>" id="more-link">more...</a><?php } ?>
				<!-- pagination -->
				<?php if ($fullPost) {
					$singlePost = !empty($_GET["id"]);
					$prevLink = "$basePath/".
												($singlePost ? "post/".($_GET["id"] +1) : "page/".($page -1)).
												"$cleanUrlQuery";
					$nextLink = "$basePath/".
												($singlePost ? "post/".($_GET["id"] -1) : "page/".($page +1)).
												"$cleanUrlQuery";
				?>
				<div id="pagination">
					<div><?php // LEFT BUTTON
					if (!$newestPostLoaded || $singlePost) { ?>
						<a id="previous-page" href="<?php echo $prevLink; ?>">
							<?php echo $singlePost ? "next<span class='sr-only'> post</span>" : "previous<span class='sr-only'> page</span>"; ?>
						</a>
					<?php } ?></div>
					
					<?php // MIDDLE BUTTON
					if ($singlePost) { ?>
						<a href="<?php echo $basePath; ?>">view all</a>
					<?php } else { ?>
						<a href="#top"><span class="sr-only">jump to </span>top</a>
					<?php } ?>
					
					<div><?php // RIGHT BUTTON
					if (!$oldestPostLoaded || ($singlePost && $_GET["id"] > 1)) { ?>
						<a id="next-page" href="<?php echo $nextLink; ?>">
							<?php echo $singlePost ? "previous<span class='sr-only'> post</span>" : "next<span class='sr-only'> page</span>"; ?>
						</a>
					<?php } ?></div>
				</div>
				<?php } ?>
			</footer>
		</div>
		
		
	</body>
	<!--------------END BODY------------->
</html>