<?php

$image_formats = ["png","gif","jpg","jpeg","webp"];
$image_regex = "(.*)\.(".implode("|",$image_formats).")\/?$";

// character limits
$name_limit = 15;
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