<?php

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

		$worm["canEdit"] = (isset($_SESSION["id"]) && $_SESSION["id"] == $worm["owner"]) || (isset($_SESSION["id"]) && getAuthorization($_SESSION["id"]) == "admin");
	}
}
// if worm data wasn't loaded, load an empty worm
if (empty($worm)) {
	$worm = ["id"=>NULL, "name"=>NULL, "icon"=>NULL, "length"=>NULL, "likes"=>NULL, "color"=>NULL, "text_color"=>NULL, "website"=>NULL];
	$worm["canEdit"] = isset($_SESSION["id"]) && !empty(getUsername($_SESSION["id"]));
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