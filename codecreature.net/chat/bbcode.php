<?php
/* BBCODE PARSER */
require_once $_SERVER['DOCUMENT_ROOT'].'/codefiles/nbbc-3.0.0/Loader.php';
use Nbbc\BBCode;
$bbcode = new BBCode;

// set the directory to find smileys
$bbcode->ClearSmileys();
$bbcode->SetSmileyURL("/graphix/emojis");

// symbols
$bbcode->AddSmiley(":right:","arrow_right.svg");
$bbcode->AddSmiley(":left:","arrow_left.svg");
$bbcode->AddSmiley(":up:","arrow_up.svg");
$bbcode->AddSmiley(":down:","arrow_down.svg");
$bbcode->AddSmiley(":star:","star.svg");

// items
$bbcode->AddSmiley(":apple:","apple.svg"); $bbcode->AddSmiley(":goldenapple:","apple.svg");
$bbcode->AddSmiley(":poison:","poison.svg");
$bbcode->AddSmiley(":sword:","sword.svg"); $bbcode->AddSmiley(":knife:","sword.svg"); $bbcode->AddSmiley(":dagger:","sword.svg");
$bbcode->AddSmiley(":ghost:","ghost.svg");
$bbcode->AddSmiley(":jackolantern:","jack_o_lantern.svg"); $bbcode->AddSmiley(":jack-o-lantern:","jack_o_lantern.svg"); $bbcode->AddSmiley(":pumpkin:","jack_o_lantern.svg");

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

// kitty faces
$bbcode->AddSmiley(":smile:","kitty_happy.svg"); $bbcode->AddSmiley(":happy:","kitty_happy.svg"); $bbcode->AddSmiley(":smiley:","kitty_happy.svg");
$bbcode->AddSmiley(":bigsmile:","kitty_big_smile.svg"); $bbcode->AddSmiley(":big_smile:","kitty_big_smile.svg"); $bbcode->AddSmiley(":big-smile:","kitty_big_smile.svg"); $bbcode->AddSmiley(":grin:","kitty_big_smile.svg");
$bbcode->AddSmiley(":laugh:","kitty_laugh.svg"); $bbcode->AddSmiley(":crylaugh:","kitty_laugh.svg");
$bbcode->AddSmiley(":sad:","kitty_sad.svg");
$bbcode->AddSmiley(":cry:","kitty_cry.svg"); $bbcode->AddSmiley(":crying:","kitty_cry.svg");
$bbcode->AddSmiley(":hearteyes:","kitty_heart_eyes.svg"); $bbcode->AddSmiley(":heart_eyes:","kitty_heart_eyes.svg");
$bbcode->AddSmiley(":cool:","kitty_cool.svg"); $bbcode->AddSmiley(":sunglasses:","kitty_cool.svg");

// davepeta kitty faces
$bbcode->AddSmiley(":dpsmile:","dp_happy.svg"); $bbcode->AddSmiley(":dphappy:","dp_happy.svg"); $bbcode->AddSmiley(":dpsmiley:","dp_happy.svg");
$bbcode->AddSmiley(":dpbigsmile:","dp_big_smile.svg"); $bbcode->AddSmiley(":big_smile:","dp_big_smile.svg"); $bbcode->AddSmiley(":big-smile:","dp_big_smile.svg"); $bbcode->AddSmiley(":dpgrin:","dp_big_smile.svg");
$bbcode->AddSmiley(":dplaugh:","dp_laugh.svg"); $bbcode->AddSmiley(":dpcrylaugh:","dp_laugh.svg");
$bbcode->AddSmiley(":dpcool:","dp_cool.svg"); $bbcode->AddSmiley(":dpsunglasses:","dp_cool.svg");

// animals
$bbcode->AddSmiley(":redpanda:","red_panda.svg"); $bbcode->AddSmiley(":red_panda:","red_panda.svg"); $bbcode->AddSmiley(":red-panda:","red_panda.svg");

// ocs
$bbcode->AddSmiley(":junk:","junk.svg");

// nepeta
$bbcode->AddSmiley(":nepeta:","nepeta.svg"); $bbcode->AddSmiley(":nepetasmile:","nepeta.svg"); $bbcode->AddSmiley(":nepetahappy:","nepeta.svg");

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

// remove default rules I don't want included in chat messages
$bbcode->RemoveRule('acronym');
$bbcode->RemoveRule('font');
$bbcode->RemoveRule('code');
$bbcode->RemoveRule('email');
$bbcode->RemoveRule('wiki');
$bbcode->RemoveRule('columns');
?>
