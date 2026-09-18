<?php
// include users connection data
require_once $_SERVER['DOCUMENT_ROOT']."/games/worm-common/users.php";

// include database connection file
require_once "../worm-race/connect.php";

// set default timezone
date_default_timezone_set('America/New_York');

// get worm data
$worms = [];
$sql = "SELECT * FROM worms;";
if ( $result = mysqli_query($worm_conn,$sql) ) {
	// go through each worm row, assign to variables
	while($row = mysqli_fetch_object($result)) $worms[] = get_object_vars($row);
}

// mail sending history
$mail_log = [];
$mail_frequency = 300; // how often user can send a letter, in seconds

$mailboxOpen = date("m") == 2 && (date("d") < 14 || (date("d") == 14 && date("H") < 9));
$mailboxOpen = true; // TEMP VALUE FOR DEVELOPMENT
$nextOpen = $mailboxOpen ? "now" : (date("m") == 1 ? date("Y")."/02/01" : (date("Y")+1)."/02/01");

$feelings = [];
$mutual_relationships = [];
$one_sided_relationships = [];
$self_relationships = [];

$relationship_types = [
	"love" => [
		"display_name" => "romantic love",
		"letter_name" => "Valentine",
		"mutual" => "worm1 and worm2 are in love!",
		"one-sided" => "worm1 has an unrequited crush on worm2!",
		"self" => "worm1 is in love with themself!",
		"icon" => "heart.png",
	],
	"hate" => [
		"display_name" => "hatred",
		"letter_name" => "hate letter",
		"mutual" => "worm1 and worm2 hate each other!",
		"one-sided" => "worm1 hates worm2!",
		"self" => "worm1 hates themself!",
		"icon" => "broken_heart.png",
	],
	"friend" => [
		"display_name" => "friendship",
		"letter_name" => "PALentine",
		"mutual" => "worm1 and worm2 are friends!",
		"one-sided" => "worm1 wants to be friends with worm2!",
		"self" => "worm1 is their own best friend!",
		"icon" => "kitty_happy.png",
	],
	"rival" => [
		"display_name" => "rivalry",
		"letter_name" => "RIVALentine",
		"mutual" => "worm1 and worm2 are rivals!",
		"one-sided" => "worm1 wants to be worm2's rival!",
		"self" => "worm1 is their own biggest competition!",
		"icon" => "arrow_up.png",
	],
	"queerplatonic" => [
		"display_name" => "queerplatonic love",
		"letter_name" => "declaration of queerplatonic affection",
		"mutual" => "worm1 and worm2 are in a QPR!",
		"one-sided" => "worm1 wants to be QPPs with worm2!",
		"self" => "worm1 is in a queerplatonic relationship with themself!",
		"icon" => "star.png",
	],
	"business" => [
		"display_name" => "business relationship",
		"letter_name" => "business proposal",
		"mutual" => "worm1 and worm2 are doing business together!",
		"one-sided" => "worm1 wants to do business with worm2!",
		"self" => "worm1 is self-employed!",
		"icon" => "kitty_cool.png",
	],
	"neutral" => [
		"display_name" => "apathy",
		"letter_name" => "boring letter",
		"mutual" => "worm1 and worm2 feel nothing about each other!",
		"one-sided" => "worm1 feels nothing about worm2!",
		"self" => "worm1 feels nothing about themself!",
		"icon" => "",
	],
];

$sql = "SELECT * FROM relationships;";
if ( $result = mysqli_query($worm_conn,$sql) ) {
	// go through each worm row, assign to variables
	while($row = mysqli_fetch_object($result)) {
		$row = get_object_vars($row);
		// get how this worm feels about each other worm
		$arr = [];
		foreach ($row as $worm => $value) {
			$arr[(int)str_replace("worm_","",$worm)] = $value;
		}
		// add that worm's feelings
		$feelings[(int)$row["worm_id"]] = $arr;
	}
}

foreach ($feelings as $subject => $arr) {
	foreach ($arr as $object => $feeling) {
		if (!empty($feeling)) {
			$data = [$subject,$object,$feeling];
			if ($object == $subject) $self_relationships[] = $data;
			else if ($feelings[$object][$subject] == $feeling) {
				if(!in_array([$object,$subject,$feeling],$mutual_relationships)) $mutual_relationships[] = $data;
			} else $one_sided_relationships[] = $data;
		}
	}
}

function getRelationshipIcon($relationship) {
	global $relationship_types;
	if (array_key_exists($relationship,$relationship_types)) return "/graphix/emojis/".$relationship_types[$relationship]["icon"];
}

function getWormIcon($id) {
	global $worms;
	$color = $worms[$id]["color"];
	return "/graphix/emojis/worm_$color.png";
}

// returns error message if user or ip is not allowed to send mail right now
function sendMailError() {
	global $logged_in; global $mail_log; global $mail_frequency;
	// message to return if error found
	$error = "";
	// get user info
	if (!empty($_SESSION["id"])) {
		$reference = $_SESSION["id"];
		$type = "user_id";
		$error = "Too much mail received from your account!<br>Try again in a few minutes.";
	} else {
		$reference = $_SERVER['REMOTE_ADDR'];
		$type = "IP_address";
		$error = "Too much mail received from your IP address!<br>Try again in a few minutes, or <a href='/user/login'>sign in</a>.";
	}
	
	$max_users = $type == "IP_address" ? 2 : 1.25; // maximum users for this user type
	
	// get all mail log data if not already fetched
	if ( count($mail_log) == 0 ) { getMailLogData(); }
	
	// time period to check, in seconds
	$time_period = 600;
	// accumulated cooldown time in the last 10 minutes
	$cooldown_accumulated = 0;
	
	for ($i = count($mail_log) - 1; $i >= 0; $i--) {
		$row = $mail_log[$i];
		// if the row matches the user data provided
		// if validating against IP address only, don't check IP of logged in users
		if (
			$row[$type] == $reference &&
			($type == "user_id" || $row["user_id"] == NULL)
		) {
			if ( $row['date'] > (time() - $time_period) ) {
				$cooldown_accumulated += $mail_frequency;
			} else {
				break; // if we have reached results older than the time period, break for loop
			}
		}
	}
	if ($cooldown_accumulated > ($time_period * $max_users)) { return $error; } else { return ""; }
}

// get mail log data
function getMailLogData() {
	global $worm_conn; global $mail_log;
	// get all rows
	$sql = "SELECT * FROM valentines_mail_log";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		// go through each row, assign to variables
		while($row = mysqli_fetch_object($result)) {
			$row = get_object_vars($row);
			
			if ( $row['date'] < (time() - 172800) ) {
				// delete log data older than 48 hours
				$del_sql = "DELETE FROM valentines_mail_log WHERE id=".$row['id'];
				if ($worm_conn->query($del_sql) !== TRUE) {
					$error = "Error deleting mail log record: " . $worm_conn->error;
				}
			} else {
				// store log data less than 48 hours old
				$mail_log[] = $row;
			}
		}
	}
}

?>