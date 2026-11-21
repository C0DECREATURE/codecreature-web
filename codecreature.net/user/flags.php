<?php
// run self executing anonymous function
$flagData = [];
(function() {
	global $flagData;
	
	$genderFlags = [
		"agender" => [],
		"autigender" => ["symbol"=>true,"bgX"=>"-11%"],
		"bigender" => [],
		"boygirl" => [],
		"catgender" => ["symbol"=>true,"bgX"=>"-2%"],
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
		"demisexual" => ["symbol"=>true,"bgX"=>"100%"],
		"bi" => [],
		"gay" => [],
		"lesbian" => [],
		"mlm" => ["flag"=>"vincian.svg"],
		"pan" => [],
		"objectum" => ["symbol"=>true,"bgX"=>"-14%"],
		"polyamorous" => ["symbol"=>true,"bgX"=>"100%"],
		"queer" => [],
		"sapphic" => ["symbol"=>true],
		"straight" => ["symbol"=>true],
		"system" => [],
		"alterhuman" => [],
		"therian" => ["symbol"=>true,"bgX"=>"-6%"],
	];
	foreach ($otherFlags as $name => $data) $otherFlags[$name]["type"] = "other";
	
	$flagData = array_merge($genderFlags,$otherFlags);
	
	foreach ($flagData as $name => $data) {
		if (empty($data["name"])) $flagData[$name]["name"] = $name;
		if (empty($data["flag"])) $flagData[$name]["flag"] = "$name.svg";
		if (empty($data["blankFlag"])) {
			$flagData[$name]["blankFlag"] = $flagData[$name]["flag"];
			if (!empty($data["symbol"])) {
				$flagData[$name]["blankFlag"] = str_replace(".","-blank.",$flagData[$name]["blankFlag"]);
			}
		}
	}
})();
?>