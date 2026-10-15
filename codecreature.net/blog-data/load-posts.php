<?php
require_once "connect.php";

// if a blog table name was specified
if (!empty($_GET["table"]) && in_array($_GET["table"],$allowedTables)) {
	$table = $_GET["table"];
	$basePath = "/" . ($table == "updates" ? $table : "blog/$table");
	
	// whether to load full post content (if not set, default true)
	$fullPost = isset($fullPost) ? $fullPost : true;
	
	// mysql select query to fetch posts
	$query = "SELECT id, date, summary".($fullPost ? ", tags, details":"")." FROM $table";

	// get any specific parameters for posts to display
	// parameterValues[n] holds the ? value for $parameterStrings[n];
	$parameterStrings = [];
	$parameterValues = [];
	// check for specific post id
	if (isset($_GET["id"])) {
		$parameterStrings[] = "id = ?";
		$parameterValues[] = $_GET["id"];
	}
	// check for tags to include (only load posts with AT LEAST ONE of these)
	if (isset($_GET["includeTags"])) {
		$tags = explode(",",$_GET["includeTags"]);
		$param = [];
		foreach ($tags as $t) {
			$t = trim($t);
			$strings[] = "JSON_CONTAINS(tags, ? )";
			$values[] = '"'.$t.'"';
		}
		$parameterStrings[] = "(".implode(" OR ",$strings).")";
		foreach ($values as $v) $parameterValues[] = $v;
	}
	// check for tags to require (only load posts with ALL of these)
	if (isset($_GET["requireTags"])) {
		$tags = explode(",",$_GET["requireTags"]);
		foreach ($tags as $t) {
			$t = trim($t);
			$parameterStrings[] = "JSON_CONTAINS(tags, ? )";
			$parameterValues[] = '"'.$t.'"';
		}
	}
	// check for tags to exclude
	if (isset($_GET["excludeTags"])) {
		$tags = explode(",",$_GET["excludeTags"]);
		foreach ($tags as $t) {
			$t = trim($t);
			$parameterStrings[] = "NOT JSON_CONTAINS(tags, ? )";
			$parameterValues[] = '"'.$t.'"';
		}
	}
	if (count($parameterStrings) > 0) $query .= " WHERE ".implode(" AND ", array_merge($parameterStrings,["date < CURRENT_TIMESTAMP() + 1"]));
	else $query .= " WHERE date < CURRENT_TIMESTAMP() + 1";
	// get bind parameter types string for $parameterValues
	$parameterTypes = "";
	foreach ($parameterValues as $v) $parameterTypes .= gettype($v) == "string" ? "s" : (gettype($v) == "integer" ? "i" : "d");
	
	// returns the id of the first post matching given sql query string
	// binds the parameters to the statement
	function resultFromPrepared($sql,$bindTypes,$bindParams) {
		global $blog_conn;
		$stmt = $blog_conn->prepare($sql);
		// get the string representing the types of the given parameters to bind
		if (!empty($bindTypes) && !empty($bindParams)) $stmt->bind_param($bindTypes,...$bindParams);
		$stmt->execute();
		return $stmt->get_result();
	}
	// get the id of the newest post matching parameters
	$arr = resultFromPrepared($query." ORDER BY date ASC LIMIT 1;", $parameterTypes, $parameterValues)->fetch_assoc();
	$oldestPostId = isset($arr["id"]) ? $arr["id"] : 0;
	// get the id of the oldest post matching parameters
	$arr = resultFromPrepared($query." ORDER BY date DESC LIMIT 1;",$parameterTypes,$parameterValues)->fetch_assoc();
	$newestPostId = isset($arr["id"]) ? $arr["id"] : 0;
	
	// order by date, newest to oldest
	$query .= " ORDER BY date DESC";
	// limit max number of updates to show
	$maxCount = !empty($_GET["count"]) ? (int)$_GET["count"] : ($fullPost ? 10 : 12);
	$minCount = !empty($page) && $page > 1 ? (($page - 1) * $maxCount).", " : "";
	$query .= " LIMIT $minCount$maxCount";
	// end query
	$query .= ";";

	// get all posts matching parameters
	$result = resultFromPrepared($query, $parameterTypes, $parameterValues);
	// fetch each as array, insert post HTML
	while ($post = $result->fetch_assoc()) {
		$id = $post["id"];
		$date = date('y/m/d',strtotime($post["date"]));
		include "post.php";
		$newestPostLoaded = !empty($newestPostLoaded) || $id == $newestPostId;
		$oldestPostLoaded = !empty($oldestPostLoaded) || $id == $oldestPostId;
	}
	
} else {
	echo "Error: Invalid blog table name provided.";
}
?>