<?php

function setCssColor($name,$color) {
	global $worm;
	$cssColor = $color;
	if (empty($cssColor)) $cssColor = "var(--blue)";
	else if (!preg_match("/[0-9]/",$cssColor)) $cssColor = "var(--".$color.")";
	$worm["css$name"] = $cssColor;
}

?>