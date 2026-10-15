<?php
require_once "connect.php";

// include user database connection file
include $_SERVER['DOCUMENT_ROOT']."/user/database.php";
// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }
// whether user is authorized to post
$logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true;
$userAuthorized = $logged_in && isset($_SESSION["id"]) && getAuthorization($_SESSION["id"]) == "admin";

$table = trim($_GET["table"]);
// base URL path for this table
$basePath = "/" . ($table == "updates" ? $table : "blog/$table");

// get post info, or assign blank if not editing an existing post
$fullPost = true;
$editing = $table != "drafts" && !empty($_GET["id"]) && in_array($table,$allowedTables);
$draft = $table != "drafts" && !empty($_POST) && !empty($_POST["draft"]) && $_POST["draft"] == "true";
$id = empty($_GET["id"]) ? 0 : (int)$_GET["id"];
$post = [];
// add new update log to the database if valid form submitted
if (!empty($_POST) && $userAuthorized && in_array($_POST["table"],$allowedTables)) {
	$date = !empty($_POST["date"]) ? trim($_POST["date"]) : date("Y-m-d H:i");
	
	$authors = "[".trim($_POST["authors"])."]";
	$tags = json_encode(explode(",",trim($_POST["tags"])));
	$summary = trim($_POST["summary"]);
	$details = trim($_POST["details"]);
	echo $details;
	// get id if updating exising post
	$updating = false;
	if (isset($_POST["target_id"]) && trim($_POST["target_id"]) != "") {
		$id = (int)trim($_POST["target_id"]);
		$updating = true;
	}
	
	// SQL query template
	// columns
	$sql_cols = ["date","authors","tags","summary","details"];
	$sql_vals = ["'$date'","?","?","?","?"];
	if ($draft) {
		$sql_cols[] = "target_table";
		$sql_vals[] = "'$table'";
		if ($updating) {
			$sql_cols[] = "target_id";
			$sql_vals[] = "$id";
		}
	}
	// query string
	$sql = "";
	if ($updating) {
		$sql = "UPDATE ".($draft ? "drafts" : $table)." SET ";
		for ($i = 0; $i < count($sql_cols); $i++) {
			$sql .= $sql_cols[$i]." = ".$sql_vals[$i]." ";
			if ($i < count($sql_cols) - 1) $sql .= ", ";
		}
		if ($draft) $sql .= " WHERE target_table = '$table' AND ".($table == "drafts" ? "target_id" : "id")." = $id;";
		else $sql .= " WHERE id = $id;";
	} else {
		$sql = "INSERT INTO ".($draft ? "drafts" : $table)." (";
		$sql .= implode(", ",$sql_cols);
		$sql .= ") VALUES (";
		$sql .= implode(", ",$sql_vals);
		$sql .= ")";
	}
	echo $details;
	// Prepare the SQL query template
	if($stmt = $blog_conn->prepare($sql)) {
		$stmt->bind_param("ssss", $authors, $tags, $summary, $details);
		$stmt->execute();
		if ($updating) header("location: ".$basePath."/post/$id");
		else if (!$draft && !$table == "drafts") header("location: ".$basePath);
		else echo "<script>alert('Saved draft!');</script>";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	$stmt->close();
}

// if existing post id specified for editing, load the post data into the form
if (!empty($_GET["id"]) && in_array($table,$allowedTables)) {
	// check if a draft exists for this post
	$draftQuery = "SELECT COUNT(*) AS num_rows FROM drafts WHERE target_table = '$table' AND target_id = $id";
	
	$stmt = "";
	// if there is a draft version of this post
	$row = $blog_conn->query($draftQuery)->fetch_array();
	if ( $row["num_rows"] > 0 ) {
		$query = "SELECT date, authors, summary, tags, details FROM drafts WHERE target_table = ? AND target_id = ? ;";
		$stmt = $blog_conn->prepare($query);
		$stmt->bind_param("si",$table,$id);
		$stmt->execute();
	// if there is no draft of this post
	} else {
		$query = "SELECT date, authors, summary, tags, details".($table == "drafts" || $draft ? ", target_table, target_id":"")." FROM $table WHERE id = ? ;";
		$stmt = $blog_conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
	}
	
	$post = $stmt->get_result()->fetch_assoc();
	$date = !empty($post["date"]) ? $post["date"] : "";
} else {
	$date = date("Y-m-d H:i");
	$post["tags"] = '[]';
	$post["summary"] = "";
	$post["details"] = "";
}
if (isset($post["target_table"])) $table = $post["target_table"];
if (isset($post["target_id"])) $id = $post["target_id"];

function uploadOldUpdates() {
	global $updates; global $blog_conn;
	$updates = array_reverse($updates);
	foreach ($updates as $u) {
		
		$date = trim($u["date"]);
		
		$authors = [];
		if (!empty($u["authors"])) {
			foreach ($u["authors"] as $a) {
				if ($a == "emery") $authors[] = 3;
				else if ($a == "prax") $authors[] = 2;
			}
		}
		if (empty($authors)) $authors[] = 1;
		$authors = json_encode($authors);
		$tags = json_encode($u["tags"]);
		$summary = trim(str_replace("	","",$u["summary"]));
		$details = trim($u["details"]);
		
		// SQL query template
		$sql = "INSERT INTO updates (date, authors, tags, summary, details)
						VALUES (?, ?, ?, ?, ?)";
		// Prepare the SQL query template
		if($stmt = $blog_conn->prepare($sql)) {
			$stmt->bind_param("sssss", $date, $authors, $tags, $summary, $details);
			$stmt->execute();
			echo "<br>New post created!";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$stmt->close();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title><?php echo $editing ? "edit" : "new"; ?> blog post</title>
		
		<!-- prevent warnings popup on this page IF it's in an iFrame -->
		<script>var showMainWarnings = false;</script>
		
		<base href="/blog-data/<?php echo $table; ?>">
		
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
		
		<!--this page's stylesheet-->
		<link href="/blog-data/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		<link href="/blog-data/new-post.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
	</head>
	
	<!-----------BODY------------------->
	<body class="full-posts">
		<main class="main-container">
		
		<header id="title" class="title">
			<h1>
				<img src="/graphix/deco/green-3d-spin-star.gif" alt="">
				<?php echo $editing ? "Edit" : "New"; ?> Blog Post
				<img src="/graphix/deco/green-3d-spin-star.gif" alt="">
			</h1>
		</header>
		<div class="subtitle">posting to <a class="table-name" href="<?php echo $basePath; ?>"><?php echo $table; ?></a></div>
		
		<div class="posts">
			<?php // make sure user is authorized
			if (!$userAuthorized) { ?>
			
			<p>sorry, you're not authorized to be here!</p>
			
			<?php } else { ?>
			
			<form id="new-post" method="POST">
				<input type="hidden" name="table" value="<?php echo $table; ?>"></input>
				<input type="hidden" name="target_id" value="<?php echo $editing ? $id : ""; ?>"></input>
				<input id="input-draft" type="hidden" name="draft" value="false"></input>
				<input type="hidden" name="authors" value="<?php echo $_SESSION["id"]; ?>"></input>
				<!-- date -->
				<div class="form-group">
					<label for="input-date">Date:</label>
					<input id="input-date" type="text" name="date" value="<?php echo $date; ?>"></input>
				</div>
				<!-- summary -->
				<div class="form-group">
					<label for="input-summary">Summary:</label>
					<input id="input-summary" type="text" name="summary" value="<?php echo htmlspecialchars($post["summary"]); ?>"></input>
				</div>
				<!-- summary -->
				<div class="form-group">
					<label for="input-tags">Tags:</label>
			<input id="input-tags" type="text" name="tags" value="<?php echo str_replace(["[","]",'"'],"",$post["tags"]); ?>"></input>
				</div>
				<!-- details -->
				<div class="form-group">
					<label for="input-details">Body:</label>
					<textarea id="input-details" name="details"><?php echo $post["details"]; ?></textarea>
				</div>
				
				<div class="button-group">
					<button id="open-preview" class="btn" type="button" popovertarget="preview">preview</button>
					<button class="btn" type="submit">post</button>
					<button class="btn" type="submit" onclick="document.getElementById('input-draft').value='true';">save</button>
				</div>
				
				<script>(()=>{
					let form = document.getElementById("new-post");
					let inputSummary = document.getElementById("input-summary");
					let inputDetails = document.getElementById("input-details");
					form.addEventListener("submit",(e)=>{
						e.preventDefault();
						//inputSummary.value = encodeURI(inputSummary.value);
						console.log(inputDetails.value);
						//inputDetails.value = encodeURI(inputDetails.value);
						form.submit();
					});
				})();</script>
			</form>
			
			<div id="preview" class="tq-format" popover><ul>
				<?php include "post.php"; ?>
			</ul></div>
			<script>(()=>{
				<?php echo "let path = '/blog-data/".$table."';"; ?>
				let preview = document.getElementById("preview");
				let inputDate = document.getElementById("input-date");
				let inputSummary = document.getElementById("input-summary");
				let inputTags = document.getElementById("input-tags");
				let inputDetails = document.getElementById("input-details");
				
				function imgSources(str) {
					return str.replaceAll('src="images','src="'+path+'/images')
				}
				
				document.getElementById("open-preview").addEventListener('click',()=>{
					preview.querySelector(".date").innerHTML = inputDate.value;
					
					preview.querySelector(".summary").innerHTML = inputSummary.value ? tqFormatString(imgSources(inputSummary.value)) : "(empty)";
					
					preview.querySelector(".tags").innerHTML = "";
					let tags = inputTags.value.split(",");
					tags.forEach((tag)=>{
						preview.querySelector(".tags").innerHTML += "<a href=''>#"+tag+"</a>";
					});
					
					preview.querySelector(".details").innerHTML = inputDetails.value ? tqFormatString(imgSources(inputDetails.value)) : "(empty)";
					
					
				});
			})();</script>
			
			<?php } ?>
			<p><a href="/user"><?php echo $logged_in ? "view user details" : "log in"; ?></a> or <a href="/home">return home</a>.</p>
		</div></main>
	</body>
	<!--------------END BODY------------->
</html>