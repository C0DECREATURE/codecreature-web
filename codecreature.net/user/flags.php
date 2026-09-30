<?php
// run self executing anonymous function
$flagData = [];
(function() {
	global $flagData;
	
	$genderFlags = [
		"agender" => [],
		"autigender" => ["flag"=>"autigender-blank.svg"],
		"bigender" => [],
		"boygirl" => [],
		"catgender" => ["flag"=>"catgender-blank.svg"],
		"genderfluid" => [],
		"genderqueer" => [],
		"nonbinary" => [],
		"trans" => ["flag"=>"transgender.svg"],
		"transfem" => ["flag"=>"transfeminine.svg"],
		"trans woman" => ["flag"=>"transgender.svg"],
		"transmasc" => ["flag"=>"transmasculine.svg"],
		"trans man" => ["flag"=>"transgender.svg"],
	];
	foreach ($genderFlags as $name => $data) $genderFlags[$name]["type"] = "gender";
	
	$otherFlags = [
		"aroace" => [],
		"aromantic" => [],
		"asexual" => [],
		"demisexual" => [],
		"bi" => [],
		"gay" => [],
		"lesbian" => [],
		"mlm" => ["flag"=>"vincian.svg"],
		"pan" => [],
		"polyamorous" => ["flag"=>"polyamorous-blank.svg"],
		"queer" => [],
		"sapphic" => ["flag"=>"sapphic-blank.svg"],
		"system" => [],
		"alterhuman" => [],
		"therian" => ["flag"=>"alterhuman.svg"],
	];
	foreach ($otherFlags as $name => $data) $otherFlags[$name]["type"] = "other";
	
	$flagData = array_merge($genderFlags,$otherFlags);
	
	foreach ($flagData as $name => $data) {
		if (empty($data["name"])) $flagData[$name]["name"] = $name;
		if (empty($data["flag"])) $flagData[$name]["flag"] = "$name.svg";
	}
})();
?>