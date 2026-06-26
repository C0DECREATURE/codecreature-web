<?php
/* BBCODE PARSER */
require_once $_SERVER['DOCUMENT_ROOT'].'/codefiles/nbbc-3.0.0/Loader.php';
use Nbbc\BBCode;
$bbcode = new BBCode;

// set the directory to find smileys
$bbcode->ClearSmileys();
$bbcode->SetSmileyURL("/graphix/emojis");
$bbcode->AddSmiley(":heart:","heart.png");
$bbcode->AddSmiley(":brokenheart:","broken_heart.png");
$bbcode->AddSmiley(":right:","arrow_right.png");
$bbcode->AddSmiley(":left:","arrow_left.png");
$bbcode->AddSmiley(":up:","arrow_up.png");
$bbcode->AddSmiley(":down:","arrow_down.png");
$bbcode->AddSmiley(":star:","star.png");

$bbcode->AddSmiley(":jeremy:","worm_pink.png"); $bbcode->AddSmiley(":Jeremy:","worm_pink.png");
$bbcode->AddSmiley(":pretzel:","worm_orange.png"); $bbcode->AddSmiley(":Pretzel:","worm_orange.png");
$bbcode->AddSmiley(":stringcheese:","worm_yellow.png"); $bbcode->AddSmiley(":StringCheese:","worm_yellow.png"); $bbcode->AddSmiley(":string_cheese:","worm_yellow.png"); $bbcode->AddSmiley(":string-cheese:","worm_yellow.png");
$bbcode->AddSmiley(":matilda:","worm_green.png"); $bbcode->AddSmiley(":Matilda:","worm_green.png");
$bbcode->AddSmiley(":poolnoodle:","worm_blue.png"); $bbcode->AddSmiley(":PoolNoodle:","worm_blue.png"); $bbcode->AddSmiley(":pool_noodle:","worm_blue.png"); $bbcode->AddSmiley(":pool-noodle:","worm_blue.png");
$bbcode->AddSmiley(":microplastics:","worm_purple.png"); $bbcode->AddSmiley(":Microplastics:","worm_purple.png");
// long blue worm
$bbcode->AddSmiley(":poolnoodlehead:","long_worm_blue_3.png"); $bbcode->AddSmiley(":poolnoodle_head:","long_worm_blue_3.png"); $bbcode->AddSmiley(":pool_noodle_head:","long_worm_blue_3.png");
$bbcode->AddSmiley(":poolnoodlebody:","long_worm_blue_2.png"); $bbcode->AddSmiley(":poolnoodle_body:","long_worm_blue_2.png"); $bbcode->AddSmiley(":pool_noodle_body:","long_worm_blue_2.png");
$bbcode->AddSmiley(":poolnoodletail:","long_worm_blue_1.png"); $bbcode->AddSmiley(":poolnoodle_tail:","long_worm_blue_1.png"); $bbcode->AddSmiley(":pool_noodle_tail:","long_worm_blue_1.png");
// long purple worm
$bbcode->AddSmiley(":microplasticshead:","long_worm_purple_3.png"); $bbcode->AddSmiley(":microplastics_head:","long_worm_purple_3.png");
$bbcode->AddSmiley(":microplasticsbody:","long_worm_purple_2.png"); $bbcode->AddSmiley(":microplastics_body:","long_worm_purple_2.png");
$bbcode->AddSmiley(":microplasticstail:","long_worm_purple_1.png"); $bbcode->AddSmiley(":microplastics_tail:","long_worm_purple_1.png");
// long pink worm
$bbcode->AddSmiley(":jeremyhead:","long_worm_pink_3.png"); $bbcode->AddSmiley(":jeremy_head:","long_worm_pink_3.png");
$bbcode->AddSmiley(":jeremybody:","long_worm_pink_2.png"); $bbcode->AddSmiley(":jeremy_body:","long_worm_pink_2.png");
$bbcode->AddSmiley(":jeremytail:","long_worm_pink_1.png"); $bbcode->AddSmiley(":jeremy_tail:","long_worm_pink_1.png");

// automatically detect and style links
$bbcode->SetDetectURLs(true);
$bbcode->SetURLPattern('<a href="/url?redirect={$url/h}">{$text/h}</a>');

// remove default rules I don't want included in chat messages
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
