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

// adjusted ratio for sender vs receiver effect
$receiverRatio = .2;

// mail sending history
$mail_log = [];
$mail_frequency = 300; // how often user can send a letter, in seconds

$mailboxOpen = date("m") == 2 && (date("d") < 14 || (date("d") == 14 && date("H") < 9));
if (!empty($_SESSION["id"]) && ($_SESSION["user_authorization"] == "admin" || $_SESSION["user_authorization"] == "mod") && !empty($_GET["preview"])) {
	$mailboxOpen = true;
}
$nextOpen = $mailboxOpen ? "now!" : (date("m") == 1 ? "February 1st, ".date("Y") : "February 1st, ".(date("Y")+1));

$possessive_pronouns = ["their","his","her","its"];
$self_pronouns = ["themself","himself","herself","itself","wormself"];

$feelings = [];
$mutual_relationships = [];
$one_sided_relationships = [];
$self_relationships = [];

// NOTE: these should be listed in order of PRIORITY
$relationship_types = [
	"love" => [
		"display_name" => "romantic",
		"letter_name" => "Valentine",
		"one-sided" => "worm1 has a crush on worm2!",
		"self" => "worm1 is in love with themself!",
		"icon" => "heart.svg",
	],
	/*
	"queerplatonic" => [
		"display_name" => "queerplatonic",
		"letter_name" => "declaration of queerplatonic affection",
		"one-sided" => "worm1 wants to be QPPs with worm2!",
		"self" => "worm1 is in a queerplatonic relationship with themself!",
		"icon" => "heart_green.svg",
	],
	*/
	"friend" => [
		"display_name" => "friendship",
		"letter_name" => "PALentine",
		"one-sided" => "worm1 wants to be friends with worm2!",
		"self" => "worm1 is their own best friend!",
		"icon" => "star.svg",
	],
	"hate" => [
		"display_name" => "hatred",
		"letter_name" => "hate letter",
		"one-sided" => "worm1 hates worm2!",
		"self" => "worm1 hates themself!",
		"icon" => "broken_heart.svg",
	],
	"business" => [
		"display_name" => "business",
		"letter_name" => "business proposal",
		"mutual" => "worm1 and worm2 are business partners!",
		"one-sided" => "worm1 wants to do business with worm2!",
		"self" => "worm1 is self-employed!",
		"icon" => "kitty_cool.svg",
	],
	"rival" => [
		"display_name" => "rivalry",
		"letter_name" => "RIVALentine",
		"one-sided" => "worm1 wants to be worm2's rival!",
		"self" => "worm1 is their own biggest competition!",
		"icon" => "sword.svg",
	],
	"neutral" => [
		"display_name" => "apathy",
		"letter_name" => "boring letter",
		"mutual" => "worm1 and worm2 feel nothing about each other!",
		"one-sided" => "worm1 feels nothing about worm2!",
		"self" => "worm1 feels nothing about themself!",
		"icon" => "heart_white.svg",
	],
];
// array of modifying feelings and how they have to feel it to count
// 1 = at least one worm feels
// 2 = both worms feel
// 3 = both worms have it as TOP feeling
// ordered by priority
$combinations = [
	"friend" => ["hate"=>1,"love"=>2,"friend"=>3,"rival"=>2,"neutral"=>1],
	"love" => ["hate"=>1,"neutral"=>1,"love"=>3],
	"hate" => ["hate"=>3,"rival"=>2,"business"=>2,"neutral"=>1],
	"rival" => ["business"=>2,"rival"=>3,"neutral"=>1],
	"business" => ["business"=>3,"neutral"=>1],
	"neutral" => ["neutral"=>3],
];
// text for feeling combinations
$mutual_relationship_text = [
	"friend" => [
		"none"=>"worm1&worm2 are friends",
		"friend"=>"worm1&worm2 are bffs!",
		"love"=>"worm1&worm2 are friends with benefits",
		"hate"=>"worm1&worm2 are in a toxic friendship",
		"rival"=>"worm1&worm2 are friendly rivals",
		"neutral"=>"worm1&worm2 are casual friends",
	],
	"love" => [
		"none"=>"worm1&worm2 are dating",
		"love"=>"worm1&worm2 are in love!",
		"hate"=>"worm1&worm2 are in a toxic romance",
		"rival"=>"worm1&worm2 are in a romantic rivalry",
		"neutral"=>"worm1&worm2 are casually dating",
	],
	"hate" => [
		"none"=>"worm1&worm2 hate each other",
		"hate"=>"worm1&worm2 despise each other",
		"rival"=>"worm1&worm2 are archenemies!",
		"business"=>"worm1&worm2 are scamming each other",
		"neutral"=>"worm1&worm2 dislike each other",
	],
	"rival" => [
		"none"=>"worm1&worm2 are rivals",
		"rival"=>"worm1&worm2 are serious rivals",
		"business"=>"worm1&worm2 are business rivals",
		"neutral"=>"worm1&worm2 are casually competing",
	],
	"business" => [
		"none"=>"worm1&worm2 are working together",
		"business"=>"worm1&worm2 are business partners",
		"neutral"=>"worm1&worm2 do occasional business",
	],
	"neutral" => [
		"neutral"=>"worm1&worm2 are bored by each other",
	],
];
// text for feeling combinations
$one_sided_text = [
	"friend" => [
		"none"=>"worm1 wants to be friends with worm2",
		"friend"=>"worm1 wants to be bffs with worm2",
		"love"=>"worm1 wants to be worm2's friend with benefits",
		"hate"=>"",
		"rival"=>"worm1 wants to be friendly rivals with worm2",
		"neutral"=>"worm1 kind of wants to be friends with worm2",
	],
	"love" => [
		"none"=>"worm1 has an unrequited crush on worm2",
		"love"=>"worm1 is head over tail for worm2",
		"hate"=>"worm1 is stalking worm2",
		"rival"=>"worm1 wants a romantic rivalry with worm2",
		"neutral"=>"worm1 thinks worm2 is cute",
	],
	"hate" => [
		"none"=>"worm1 hates worm2",
		"hate"=>"worm1 despises worm2",
		"rival"=>"worm1 wants to be worm2's nemesis",
		"business"=>"worm1 is trying to scam worm2",
		"neutral"=>"worm1 doesn't like worm2",
	],
	"rival" => [
		"none"=>"worm1 wants to be rivals with worm2",
		"rival"=>"worm1 is really intimidated by worm2",
		"business"=>"worm1 is jealous of worm2's business",
		"neutral"=>"worm1 wants to compete with worm2",
	],
	"business" => [
		"none"=>"worm1 wants to work with worm2",
		"business"=>"worm1 wants to start a business with worm2",
		"neutral"=>"worm1 is considering working with worm2",
	],
	"neutral" => [
		"neutral"=>"worm1 thinks worm2 is boring",
	],
	2 => [
		"hate,hate" => "worm1 wants to kill worm2",
		"friend,hate" => "worm1 wants to eat worm2",
		"love,love" => "worm1 thinks worm2 looks delicious",
	],
];

$mail_received = [];
$mail_values = [];

/*
$sql = "SELECT * FROM relationships;";
if ( $result = mysqli_query($worm_conn,$sql) ) {
	// go through each worm row, assign to variables
	while($row = mysqli_fetch_object($result)) {
		$row = get_object_vars($row);
		// get how this worm feels about each other worm
		$arr = [];
		foreach ($row as $key => $value) {
			if ($key != "worm_id") $arr[(int)str_replace("worm_","",$key)] = json_decode($value);
		}
		// add that worm's feelings
		$feelings[(int)$row["worm_id"]] = $arr;
	}
}
*/

// returns the top feeling of given worm $subject about worm $object
function topFeeling($subject,$object) {
	global $feelings;
	$arr = $feelings[$subject][$object];
	return gettype($arr) == "array" && count($arr) > 0 ? $arr[0] : NULL;
}
// whether the given worms have the same primary feeling
function sharedTop($w1,$w2) {
	return topFeeling($w1,$w2) == topFeeling($w2,$w1);
}
// whether the given worms share a given feeling $f (whether top feeling or not)
function mutualFeeling($w1,$w2,$f) {
	global $feelings;
	return in_array($f,$feelings[$w1][$w2]) && in_array($f,$feelings[$w2][$w1]);
}
// whether the worm $subject has the given feeling $f about worm $object
function hasFeeling($subject,$object,$f) {
	global $feelings;
	return in_array($f,$feelings[$subject][$object]);
}
// whether the worm $subject has ONLY one-sided feelings about worm $object
function allOneSided($subject,$object) {
	global $feelings;
	$fArr = $feelings[$subject][$object];
	foreach ($feelings[$subject][$object] as $f) if (mutualFeeling($subject,$object,$f)) return false;
	else return true;
}
// calculate relationships between all worms
function storeRelationships() {
	global $worms; global $feelings; global $combinations; global $mutual_relationship_text;
	global $mutual_relationships; global $one_sided_relationships; global $self_relationships;
	for ($w1 = 0; $w1 < count($worms); $w1++) {
		for ($w2 = 0; $w2 < count($worms); $w2++) {
			$r = "";
			// internal relationships
			if ($w1 == $w2) {
				$self_relationships[$w1] = topFeeling($w1,$w2);
			// relationships between worms
			} else {
				// check relationships
				foreach ($mutual_relationship_text as $f => $arr) {
					// if worm 1 has that feeling for worm 2
					if (hasFeeling($w1,$w2,$f)) {
						// ONE-SIDED
						if (hasFeeling($w1,$w2,$f) && !mutualFeeling($w1,$w2,$f)) {
							// special exception for one-sided hate with mutual business
							// DEBUG: this is causing mutual hate-business even if it shouldn't be there
							if ($f == "hate" && mutualFeeling($w1,$w2,"business")) $r = ["hate","business"];
							// if the worm has a second feeling that is also one-sided
							if (count($feelings[$w1][$w2]) > 1) {
								if (topFeeling($w1,$w2) == $f) {
									if (allOneSided($w1,$w2)) $r = [$f,$feelings[$w1][$w2][1]];
									else $r = [$f,$f];
								} else if (allOneSided($w1,$w2)) $r = [$f,$feelings[$w1][$w2][0]];
							}
							if (empty($r)) $r = [$f,"none"];
							sort($r);
							if (!in_array([$w1,$w2,$r],$one_sided_relationships)) $one_sided_relationships[] = [$w1,$w2,$r];
						// MUTUAL and feeling has combo information
						} else if (!empty($combinations[$f])) {
							// check for modifiers that affect if either worm feels it
							foreach ($combinations[$f] as $f2 => $type) {
								if (
									($type == 3 && topFeeling($w1,$w2) == $f && topFeeling($w2,$w1) == $f)
									|| ($type == 2 && hasFeeling($w1,$w2,$f2) && hasFeeling($w2,$w1,$f2))
									|| ($type == 1 && (hasFeeling($w1,$w2,$f2) || hasFeeling($w2,$w1,$f2)))
								) {
									$r = [$f,$f2];
									break;
								}
							}
							// if no valid modifiers, just a simple feeling
							if (empty($r)) $r = [$f,"none"];
							// if the relationship hasn't already been logged in the other direction, add it
							sort($r);
							if (
								!in_array([$w2,$w1,$r],$mutual_relationships)
								&& !in_array([$w1,$w2,$r],$mutual_relationships)
							) $mutual_relationships[] = [$w1,$w2,$r];
						}
					}
				}
			}
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

// log counts of mail sent this year, if needed close mailbox and update relationships
function countMail() {
	global $worm_conn; global $worms; global $relationship_types; global $mail_received;
	global $mail_values; global $receiverRatio;
	
	foreach ($worms as $w) {
		$mail_received[$w["id"]] = [];
		$mail_values[$w["id"]] = [];
		foreach ($relationship_types as $rName => $r) $mail_received[$w["id"]][$rName] = 0;
		foreach ($worms as $w2) {
			$mail_values[$w["id"]][$w2["id"]] = [];
			foreach ($relationship_types as $rName => $r) $mail_values[$w["id"]][$w2["id"]][$rName] = 0;
		}
	}
	// get all rows
	$sql = "SELECT * FROM valentines_letters";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		// go through each row, assign to variables
		while($row = mysqli_fetch_object($result)) {
			$row = get_object_vars($row);
			
			$sender = substr($row["pairing"],0,1);
			$recipient = substr($row["pairing"],-1);
			
			foreach ($row as $type => $count) {
				if (array_key_exists($type,$relationship_types)) {
					$mail_received[$recipient][$type] += $count;
					$mail_values[$sender][$recipient][$type] += $count;
					$mail_values[$recipient][$sender][$type] += $count * $receiverRatio;
				}
			}
		}
	}
}

// process inbox results to update relationships
function processInbox() {
	global $worm_conn; global $worms; global $mail_values; global $feelings;
	
	
	for ($w1 = 0; $w1 < count($worms); $w1++) {
		for ($w2 = 0; $w2 < count($worms); $w2++) {
			$feelings[$w1][$w2] = [];
		}
	}
	
	foreach ($mail_values as $subject => $arr) {
		foreach ($arr as $object => $rArr) {
			$highest = "";
			$highestCount = 0;
			while (max($rArr) > $highestCount * 0.67 && count($feelings[$subject][$object]) < 2) {
				$highestCount = max($rArr);
				$highest = array_search($highestCount,$rArr);
				unset($rArr[$highest]);
				$feelings[$subject][$object][] = $highest;
			}
		}
	}
	
	// prepare relationships database update
	$sql = "INSERT INTO relationships (worm_id, worm_0, worm_1, worm_2, worm_3, worm_4, worm_5) VALUES ";
	for ($w1 = 0; $w1 < count($worms); $w1++) {
		$sql .= "($w1, ";
		for ($w2 = 0; $w2 < count($worms); $w2++) {
			$sql .= "'".json_encode($feelings[$w1][$w2])."'";
			if ($w2 < count($worms) - 1) $sql .= ", ";
		}
		$sql .= ")";
		if ($w1 < count($worms) - 1) $sql .= ", ";
	}
	$sql .= " ON DUPLICATE KEY UPDATE
							worm_0=VALUES(worm_0),
							worm_1=VALUES(worm_1),
							worm_2=VALUES(worm_2),
							worm_3=VALUES(worm_3),
							worm_4=VALUES(worm_4),
							worm_5=VALUES(worm_5)";
	// update the database
	if (!$worm_conn->query($sql)) {
		echo "Error updating relationships: " . $worm_conn->error;
	}
}

countMail();
processInbox();

// calculate relationships based on data
storeRelationships();
?>