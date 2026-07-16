<?php
$garfields = [];
$garfield_types = [
	"Comics" => ["1978", "1979", "1980", "1985", "1990", "1995", "2005", "2010", "2015", "2020"],
	"Animation" => ["Here Comes Garfield", "Garfield and Friends", "Garfield Originals",
						"Garfield: The Movie", "Garfield Gets Real", "The Garfield Show", "Garfield's Pet Force", "The Garfield Movie", "Garfield Movie (Baby)"],
	"Games" => ["Konami Handheld", "Big Fat Hairy Deal", "Garfield (PS2)", "Saving Arlene (PS2)"],
	"Other Media" => ["Lab Cat", "It That Betrays", "Molten Collapse"],
	"Unofficial" => ["Gorefield"],
];
foreach ($garfield_types as $type_arr) {
	foreach ($type_arr as $g) {
		$garfields[] = $g;
	}
}

function getSimpleName($str) {
	return preg_replace("/:|'|\(|\)/i","",strtolower($str));
}
function getImgSrc($str) {
	$str = str_replace(" ","_",getSimpleName($str));
	return "/shrines/garfield/images/years/$str.png";
}
?>