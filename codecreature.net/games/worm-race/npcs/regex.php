<?php
$fan_worm_settings = json_decode(file_get_contents('settings.json'),true);
$image_regex = "(.*)\.(".implode("|",$fan_worm_settings["image_formats"]).")\/?$";

// character limits
$name_limit = $fan_worm_settings["name_limit"];
$link_limit = 150;
$length_limit = 4;
$likes_limit = 50;
$color_limit = 25;
// regex validation
$name_regex = "[ 0-9A-Za-z\-]+";
$length_regex = "[0-9\.]+";
$color_regex = "#[0-9A-Za-z]{6}|#[0-9A-Za-z]{3}|rgba?\([0-9]+, ?[0-9]+, ?[0-9]+(, ?[0-9\.]+)?\)";
$link_protocol_regex = "^https?:\/\/.+";
$link_regex = "^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,63}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$";

?>