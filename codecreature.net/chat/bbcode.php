<?php

$username_pattern = '/@(?!Anonymous)([a-z0-9_])([a-z0-9_]*)/i';

/* BBCODE PARSER */
require_once $_SERVER['DOCUMENT_ROOT'].'/codefiles/nbbc-3.0.0/Loader.php';
use Nbbc\BBCode;
$bbcode = new BBCode;

// set the directory to find smileys
$bbcode->ClearSmileys();
$bbcode->SetSmileyURL("/graphix/emojis");

$bbcodeSmileyList = [
	//["image"=>"","codes"=>[""]],
	
	// symbols
	["image"=>"star.svg","codes"=>["star"]],
	["image"=>"arrow_right.svg","codes"=>["right","right arrow"]],
	["image"=>"arrow_left.svg","codes"=>["left","left arrow"]],
	["image"=>"arrow_up.svg","codes"=>["up","up arrow"]],
	["image"=>"arrow_down.svg","codes"=>["down","down arrow"]],
	
	// hearts
	["image"=>"trans_heart.svg","codes"=>["trans heart","transgender heart"]],
	
	// items
	["image"=>"maple_leaf.svg","codes"=>["maple leaf"]],
	["image"=>"falling_leaves.svg","codes"=>["falling leaves","autumn leaf","fall leaf"]],
	["image"=>"apple.svg","codes"=>["apple","golden apple"]],
	["image"=>"poison.svg","codes"=>["poison"]],
	["image"=>"sword.svg","codes"=>["sword","dagger"]],
	["image"=>"dollar.svg","codes"=>["cash","dollar","dollar bill"]],
	["image"=>"ghost.svg","codes"=>["ghost"]],
	["image"=>"jack_o_lantern.svg","codes"=>["jack o lantern","halloween"]],
	
	// kitty faces
	["image"=>"kitty_happy.svg","codes"=>["smile","happy","smiley","kitty"]],
	["image"=>"kitty_big_smile.svg","codes"=>["big smile","grin"]],
	["image"=>"kitty_laugh.svg","codes"=>["laugh","cry laugh"]],
	["image"=>"kitty_plead.svg","codes"=>["pleading","plead"]],
	["image"=>"kitty_sad.svg","codes"=>["sad"]],
	["image"=>"kitty_cry.svg","codes"=>["cry","crying"]],
	["image"=>"kitty_heart_eyes.svg","codes"=>["heart eyes"]],
	["image"=>"kitty_cool.svg","codes"=>["cool","sunglasses"]],
];

foreach ($bbcodeSmileyList as $key => $arr) {
	foreach ($arr["codes"] as $code) {
		// if the code contains spaces,
		// add a version with no spaces, underscores, and hyphens
		if (preg_match("/ /",$code)) {
			$splitCodes = [
				str_replace(" ","",$code),
				str_replace(" ","_",$code),
				str_replace(" ","-",$code),
			];
			foreach ($splitCodes as $str) { $bbcode->AddSmiley(":$str:",$arr["image"]); }
		// if the code contains no spaces, add it
		} else { $bbcode->AddSmiley(":$code:",$arr["image"]); }
	}
}

// hearts
$bbcode->AddSmiley(":heart:","heart.svg"); $bbcode->AddSmiley(":pinkheart:","heart.svg"); $bbcode->AddSmiley(":pink-heart:","heart.svg");
$bbcode->AddSmiley(":brokenheart:","broken_heart.svg");
$bbcode->AddSmiley(":redheart:","heart_red.svg"); $bbcode->AddSmiley(":red-heart:","heart_red.svg");
$bbcode->AddSmiley(":orangeheart:","heart_orange.svg"); $bbcode->AddSmiley(":orange-heart:","heart_orange.svg");
$bbcode->AddSmiley(":yellowheart:","heart_yellow.svg"); $bbcode->AddSmiley(":yellow-heart:","heart_yellow.svg");
$bbcode->AddSmiley(":greenheart:","heart_green.svg"); $bbcode->AddSmiley(":green-heart:","heart_green.svg");
$bbcode->AddSmiley(":blueheart:","heart_blue.svg"); $bbcode->AddSmiley(":blue-heart:","heart_blue.svg");
$bbcode->AddSmiley(":purpleheart:","heart_purple.svg"); $bbcode->AddSmiley(":purple-heart:","heart_purple.svg");
$bbcode->AddSmiley(":blackheart:","heart_black.svg"); $bbcode->AddSmiley(":black-heart:","heart_black.svg");
$bbcode->AddSmiley(":whiteheart:","heart_white.svg"); $bbcode->AddSmiley(":white-heart:","heart_white.svg");

// davepeta kitty faces
$bbcode->AddSmiley(":dpsmile:","dp_happy.svg"); $bbcode->AddSmiley(":dphappy:","dp_happy.svg"); $bbcode->AddSmiley(":dpsmiley:","dp_happy.svg");
$bbcode->AddSmiley(":dpbigsmile:","dp_big_smile.svg"); $bbcode->AddSmiley(":big_smile:","dp_big_smile.svg"); $bbcode->AddSmiley(":big-smile:","dp_big_smile.svg"); $bbcode->AddSmiley(":dpgrin:","dp_big_smile.svg");
$bbcode->AddSmiley(":dplaugh:","dp_laugh.svg"); $bbcode->AddSmiley(":dpcrylaugh:","dp_laugh.svg");
$bbcode->AddSmiley(":dpcool:","dp_cool.svg"); $bbcode->AddSmiley(":dpsunglasses:","dp_cool.svg");

// animals
$bbcode->AddSmiley(":redpanda:","red_panda.svg"); $bbcode->AddSmiley(":red_panda:","red_panda.svg"); $bbcode->AddSmiley(":red-panda:","red_panda.svg");

// ocs
$bbcode->AddSmiley(":ringodingo:","junk.svg"); $bbcode->AddSmiley(":junk:","junk.svg");

// external characters
$bbcode->AddSmiley(":nepeta:","nepeta.svg"); $bbcode->AddSmiley(":nepetasmile:","nepeta.svg"); $bbcode->AddSmiley(":nepetahappy:","nepeta.svg");
$bbcode->AddSmiley(":garfield:","garfield.svg"); $bbcode->AddSmiley(":garf:","garfield.svg");
$bbcode->AddSmiley(":falfal:","falfal.svg");

// worms
$bbcode->AddSmiley(":jeremy:","worm_pink.png"); $bbcode->AddSmiley(":Jeremy:","worm_pink.png");
$bbcode->AddSmiley(":pretzel:","worm_orange.png"); $bbcode->AddSmiley(":Pretzel:","worm_orange.png");
$bbcode->AddSmiley(":stringcheese:","worm_yellow.png"); $bbcode->AddSmiley(":StringCheese:","worm_yellow.png"); $bbcode->AddSmiley(":string_cheese:","worm_yellow.png"); $bbcode->AddSmiley(":string-cheese:","worm_yellow.png");
$bbcode->AddSmiley(":matilda:","worm_green.png"); $bbcode->AddSmiley(":Matilda:","worm_green.png");
$bbcode->AddSmiley(":poolnoodle:","worm_blue.png"); $bbcode->AddSmiley(":PoolNoodle:","worm_blue.png"); $bbcode->AddSmiley(":pool_noodle:","worm_blue.png"); $bbcode->AddSmiley(":pool-noodle:","worm_blue.png");
$bbcode->AddSmiley(":microplastics:","worm_purple.png"); $bbcode->AddSmiley(":Microplastics:","worm_purple.png");
// long pink worm
$bbcode->AddSmiley(":jeremyhead:","long_worm_pink_3.png"); $bbcode->AddSmiley(":jeremy_head:","long_worm_pink_3.png");
$bbcode->AddSmiley(":jeremybody:","long_worm_pink_2.png"); $bbcode->AddSmiley(":jeremy_body:","long_worm_pink_2.png");
$bbcode->AddSmiley(":jeremytail:","long_worm_pink_1.png"); $bbcode->AddSmiley(":jeremy_tail:","long_worm_pink_1.png");
// long orange worm
$bbcode->AddSmiley(":pretzelhead:","long_worm_orange_3.png"); $bbcode->AddSmiley(":pretzel_head:","long_worm_orange_3.png");
$bbcode->AddSmiley(":pretzelbody:","long_worm_orange_2.png"); $bbcode->AddSmiley(":pretzel_body:","long_worm_orange_2.png");
$bbcode->AddSmiley(":pretzeltail:","long_worm_orange_1.png"); $bbcode->AddSmiley(":pretzel_tail:","long_worm_orange_1.png");
// long yellow worm
$bbcode->AddSmiley(":stringcheesehead:","long_worm_yellow_3.png"); $bbcode->AddSmiley(":stringcheese_head:","long_worm_yellow_3.png"); $bbcode->AddSmiley(":string_cheese_head:","long_worm_yellow_3.png");
$bbcode->AddSmiley(":stringcheesebody:","long_worm_yellow_2.png"); $bbcode->AddSmiley(":stringcheese_body:","long_worm_yellow_2.png"); $bbcode->AddSmiley(":string_cheese_body:","long_worm_yellow_2.png");
$bbcode->AddSmiley(":stringcheesetail:","long_worm_yellow_1.png"); $bbcode->AddSmiley(":stringcheese_tail:","long_worm_yellow_1.png"); $bbcode->AddSmiley(":string_cheese_tail:","long_worm_yellow_1.png");
// long green worm
$bbcode->AddSmiley(":matildahead:","long_worm_green_3.png"); $bbcode->AddSmiley(":matilda_head:","long_worm_green_3.png");
$bbcode->AddSmiley(":matildabody:","long_worm_green_2.png"); $bbcode->AddSmiley(":matilda_body:","long_worm_green_2.png");
$bbcode->AddSmiley(":matildatail:","long_worm_green_1.png"); $bbcode->AddSmiley(":matilda_tail:","long_worm_green_1.png");
// long blue worm
$bbcode->AddSmiley(":poolnoodlehead:","long_worm_blue_3.png"); $bbcode->AddSmiley(":poolnoodle_head:","long_worm_blue_3.png"); $bbcode->AddSmiley(":pool_noodle_head:","long_worm_blue_3.png");
$bbcode->AddSmiley(":poolnoodlebody:","long_worm_blue_2.png"); $bbcode->AddSmiley(":poolnoodle_body:","long_worm_blue_2.png"); $bbcode->AddSmiley(":pool_noodle_body:","long_worm_blue_2.png");
$bbcode->AddSmiley(":poolnoodletail:","long_worm_blue_1.png"); $bbcode->AddSmiley(":poolnoodle_tail:","long_worm_blue_1.png"); $bbcode->AddSmiley(":pool_noodle_tail:","long_worm_blue_1.png");
// long purple worm
$bbcode->AddSmiley(":microplasticshead:","long_worm_purple_3.png"); $bbcode->AddSmiley(":microplastics_head:","long_worm_purple_3.png");
$bbcode->AddSmiley(":microplasticsbody:","long_worm_purple_2.png"); $bbcode->AddSmiley(":microplastics_body:","long_worm_purple_2.png");
$bbcode->AddSmiley(":microplasticstail:","long_worm_purple_1.png"); $bbcode->AddSmiley(":microplastics_tail:","long_worm_purple_1.png");

// automatically detect and style links
$bbcode->SetDetectURLs(true);
$bbcode->SetURLPattern('<a href="/url?redirect={$url/h}">{$text/h}</a>');

// custom rules for alt text and emoticons
$bbcode->AddRule('alt',[
		'mode' => BBCode::BBCODE_MODE_ENHANCED,
		'template' => '<span class="tq" data-a="{$_default}">{$_content}</span>',
		'class' => 'inline',
		'content' => 'BBCODE_REQUIRED',
		'allow_in' => ['listitem', 'block', 'columns', 'inline', 'link']
]);
$bbcode->AddRule('e',[
		'mode' => BBCode::BBCODE_MODE_ENHANCED,
		'template' => '<span class="tq-e" data-a="{$_default}">{$_content}</span>',
		'class' => 'inline',
		'content' => 'BBCODE_REQUIRED',
		'allow_in' => ['listitem', 'block', 'columns', 'inline', 'link']
]);
$bbcode->AddRule('reply',[
		'mode' => BBCode::BBCODE_MODE_ENHANCED,
		'template' => '<div class="bbcode_reply"><a href="#message-{$message}" target="_self">Reply</a> to @{$user}:</div>{$_content}',
		'class' => 'inline',
		'content' => 'BBCODE_REQUIRED',
		'allow_in' => ['listitem', 'block', 'columns'],
]);

// remove default rules I don't want included in chat messages
$bbcode->RemoveRule('acronym');
$bbcode->RemoveRule('font');
$bbcode->RemoveRule('code');
$bbcode->RemoveRule('email');
$bbcode->RemoveRule('wiki');
$bbcode->RemoveRule('columns');

function replaceEmojis($str) {
	$str = str_replace("🙂",":smile:",$str);
	$str = str_replace("😺",":smile:",$str);
	$str = str_replace("😄",":bigsmile:",$str);
	$str = str_replace("😁",":bigsmile:",$str);
	$str = str_replace("😸",":bigsmile:",$str);
	$str = str_replace("😂",":laugh:",$str);
	$str = str_replace("😹",":laugh:",$str);
	$str = str_replace("🙁",":sad:",$str);
	$str = str_replace("☹️",":sad:",$str);
	$str = str_replace("😭",":cry:",$str);
	$str = str_replace("😿",":cry:",$str);
	$str = str_replace("😎",":cool:",$str);
	$str = str_replace("😍",":hearteyes:",$str);
	$str = str_replace("😻",":hearteyes:",$str);
	$str = str_replace("🥺",":plead:",$str);
	$str = str_replace("⭐️",":star:",$str);
	$str = str_replace("🩷",":heart:",$str);
	$str = str_replace("❤️",":redheart:",$str);
	$str = str_replace("🧡",":orangeheart:",$str);
	$str = str_replace("💛",":yellowheart:",$str);
	$str = str_replace("💚",":greenheart:",$str);
	$str = str_replace("💙",":blueheart:",$str);
	$str = str_replace("🩵",":blueheart:",$str);
	$str = str_replace("💜",":purpleheart:",$str);
	$str = str_replace("🤍",":whiteheart:",$str);
	$str = str_replace("🖤",":blackheart:",$str);
	$str = str_replace("💔",":brokenheart:",$str);
	$str = str_replace("⬆️",":up:",$str);
	$str = str_replace("⬇️",":down:",$str);
	$str = str_replace("⬅️",":left:",$str);
	$str = str_replace("➡️",":right:",$str);
	$str = str_replace("🍁",":mapleleaf:",$str);
	$str = str_replace("🍂",":fallingleaves:",$str);
	$str = str_replace("🍎️",":apple:",$str);
	$str = str_replace("🗡️",":sword:",$str);
	$str = str_replace("👻️",":ghost:",$str);
	$str = str_replace("🎃",":jackolantern:",$str);
	$str = str_replace("🎃️",":jackolantern:",$str); // these jack-o-lanterns are separate characters...
	return $str;
}

function addUserLinks($str) {
	global $username_pattern;
	$replacement = '<a href=/u/${1}${2}>@${1}${2}</a>';
	return preg_replace($username_pattern,$replacement,$str);
}

function getPolishedBbcode($str) {
	global $bbcode;
	return htmlspecialchars_decode(addUserLinks($bbcode->Parse(replaceEmojis($str))));
}
?>
