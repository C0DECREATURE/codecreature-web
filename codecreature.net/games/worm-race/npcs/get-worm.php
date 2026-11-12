<?php

// maximum worms per user
$max_worms = 3;

$worm_id = !empty($_GET["id"]) ? (int)$_GET["id"] : NULL;
$worm = [];

if (!empty($worm_id)) {
	// fetch worm data
	$sql = "SELECT * FROM fan_worms WHERE id = $worm_id;";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		while($row = mysqli_fetch_object($result)) {
			$worm = get_object_vars($row);
		}
	}
	if (!empty($worm)) {
		$worm["gallery"] = empty($worm["gallery"]) ? [] : json_decode($worm["gallery"],true);
		$worm["ownerName"] = getUsername($worm["owner"]);
		
		if (!isset($_SESSION["id"])) $edit_err = "<a href='/user'>Log in</a> and try again.";
		else if (getAuthorization($_SESSION["id"]) == "admin") $worm["canEdit"] = true;
		else if ($_SESSION["id"] != $worm["owner"]) $edit_err = "This worm doesn't belong to you.";
		else $worm["canEdit"] = true;
	}
}
// if worm data wasn't loaded, load an empty worm
if (empty($worm)) {
	$worm = ["id"=>NULL, "name"=>NULL, "icon"=>NULL, "length"=>NULL, "likes"=>NULL, "color"=>NULL, "text_color"=>NULL, "website"=>NULL];
	
	// check if user can edit
	$worm["canEdit"] = false;
	if (!isset($_SESSION["id"])) $edit_err = "<a href='/user'>Log in</a> and try again.";
	// if logged in
	else if (!empty(getUsername($_SESSION["id"]))) {
		// make sure user doesn't have too many worms
		$uid = (int)$_SESSION["id"];
		$sql = "SELECT id FROM fan_worms WHERE owner = $uid ;";
		if ($result = mysqli_query($worm_conn, $sql)) {
			$rowcount = mysqli_num_rows( $result );
			if ($rowcount < $max_worms) $worm["canEdit"] = true;
			else $edit_err = "Limit of $max_worms fan worms per account at this time.";
		}
	}
}

function setCssColor($name,$color) {
	global $worm;
	$cssColor = $color;
	if (empty($cssColor)) $cssColor = "var(--blue)";
	else if (!preg_match("/[0-9]/",$cssColor)) $cssColor = "var(--".$color.")";
	$worm["css$name"] = $cssColor;
}

setCssColor("Color",$worm["color"]);
if (empty($worm["text_color"])) $worm["text_color"] = $worm["color"];
setCssColor("TextColor",$worm["text_color"]);

$gallery_limit = 4;

?>