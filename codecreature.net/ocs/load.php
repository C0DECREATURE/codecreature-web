<?php
require_once "functions.php";

if (!isset($name)) $name = "Sample";

$oc = characterData($name);

// checks whether the oc has a custom php chunk for the given section name
// returns boolean
function hasCustom($section) {
	global $oc;
	return !empty($oc["customSections"]) && in_array($section,$oc["customSections"]);
}

// load the correct template for the character
if (!empty($forceTemplate)) $oc["template"] = $forceTemplate;
$templatePath = "/ocs/templates/".$oc["template"]."/";
include $_SERVER["DOCUMENT_ROOT"].$templatePath.$oc["template"].".php";
?>