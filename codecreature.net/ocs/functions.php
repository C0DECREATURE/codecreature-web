<?php
// echoes the image as an img element with all provided data
function echoImage($img) { ?>
	<img src="<?php echo $img["img"]; ?>"
		alt="<?php if (!empty($img["alt"])) echo $img["alt"]; ?>"
		<?php if (!empty($img["caption"])) echo "data-caption=\"".$img["caption"]."\""; ?>
		<?php if (!empty($img["credit"])) echo "data-credit=\"".$img["credit"]."\""; ?>
		<?php if (!empty($img["creditLink"])) echo "data-credit-link=\"".$img["creditLink"]."\""; ?>
	>
<?php }

// load the .json file in this OC's folder with the given file name
function loadJson($path,$filename) {
	return json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"].$path.$filename.".json"),true);
}

function characterData($name) {
	$path = "/ocs/".strtolower($name)."/";
	
	// load the info and images for the character
	$oc = loadJson($path,"info");
	if (empty($oc["favicon"])) { $oc["favicon"] = $oc["icon"]; }
	$oc["images"] = loadJson($path,"images");
	$oc["path"] = "/ocs/".strtolower($name)."/";
	return $oc;
}


?>