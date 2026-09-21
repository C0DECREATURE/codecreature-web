<?php
// include database connection file
require_once "connect.php";

// set default timezone
date_default_timezone_set('America/New_York');

// path for worm race images
$worm_race_path = "/games/worm-race/";
$image_path = $worm_race_path."images/";

// include season actions file
require_once "season.php";

// include users connection data
require_once $_SERVER['DOCUMENT_ROOT']."/games/worm-common/users.php";
// include get username by id function
require_once $_SERVER['DOCUMENT_ROOT']."/user/database.php";

// worm data arrays
$worms = [];
$items = [];
$feed_log = [];
$loading = $load_err = "";

// special event variables
$yesterday = (new DateTime('yesterday'))->format('m-d');
$tomorrow = (new DateTime('tomorrow'))->format('m-d');
$cur_holiday = "none";
$birthday_worm = "";

// start = first day of event
// end = last day of event
$holidays = [];

function getAllData() {
	$loading = true;
	checkHolidays();
	getWormData();
	getWormAwards();
	$loading = false;
}

// check if it is currently a holiday event
function checkHolidays() {
	global $worm_conn; global $holidays; global $cur_holiday;
	// fetch holiday data
	$sql = "SELECT * FROM holidays;";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		while($row = mysqli_fetch_object($result)) {
			$arr = get_object_vars($row);
			$holidays[$arr["name"]] = $arr;
		}
	}
	// get current timestamp and year
	$time = time();
	$year = date('Y');
	// check each holiday
	foreach ($holidays as $h) {
		$start = strtotime($year."-".$h["start"]." 00:00:00");
		$end = strtotime($year."-".$h["end"]."11:59:59.999");
		// if the current time is within the holiday, register that it is current and start in database if needed
		if ($time > $start && $time < $end) {
			$cur_holiday = $h["name"];
			if (!$h["started"]) startHoliday($h["name"]);
		// if holiday is over, make sure it's ended in database
		} else if ($h["started"]) endHoliday($h["name"]);
	}
}

function startHoliday($name) {
	global $worm_conn; global $cur_holiday;
	$cur_holiday = $name;
	$sql = "UPDATE holidays SET started = 1, worm_0 = 0, worm_1 = 0, worm_2 = 0, worm_3 = 0, worm_4 = 0, worm_5 = 0 WHERE name = '$name';";
	if (!mysqli_query($worm_conn,$sql) ) {}
}

function endHoliday($name) {
	global $worm_conn;
	$sql = "UPDATE holidays SET started = 0 WHERE name = '$name';";
	if (!mysqli_query($worm_conn,$sql) ) {}
}

// get all worm data, insert into $worms array
function getWormData() {
	global $worm_conn; global $worms; global $active_season; global $load_err;
	global $users_conn;
	global $image_path;
	global $yesterday; global $tomorrow; global $cur_holiday; global $birthday_worm;
	
	$win_counts = [];
	// get all worm data
	$sql = "SELECT * FROM worms;";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		// go through each worm row, assign to variables
		while($row = mysqli_fetch_object($result)) {
			$arr = get_object_vars($row);
			// convert awards to array
			$arr["awards"] =  json_decode($arr["awards"], true);
			// convert win counts to array
			$arr["win_counts"] = json_decode($arr["win_counts"],false);
			// save the total value of trophies earned for this worm
			$win_counts[$arr["id"]] = 0;
			foreach ($arr["win_counts"] as $key => $value) { $win_counts[$arr["id"]] += $key * $value; }
			// assign the array to the worm
			$worms[] = $arr;
		}
		
		asort($win_counts);
		
		for ($i = 0; $i < count($worms); $i++) {
			// insert current race season's worm data
			foreach ($active_season["worms"][$i] as $key => $value) {
				$worms[$i][$key] = $value;
			}
			// assign overall trophy
			$worms[$i]["overall_trophy"] = array_search($i, array_keys($win_counts)) + 1;
			// modified holiday path for worm images
			$holiday_path = "";
			// if not leap year, adjust feb 29th
			if ($worms[$i]["birthday"] == "02-29" && date("L") == 0) $worms[$i]["birthday"] = "02-28";
			// check for birthdays
			if (
				$worms[$i]["birthday"] == date("m-d")
				|| $worms[$i]["birthday"] == $yesterday
				|| $worms[$i]["birthday"] == $tomorrow
			) {
				$cur_holiday = "birthday";
				$birthday_worm = $i;
				$holiday_path = "birthday/";
			} else $worms[$i]["is_birthday"] = false;
			// get worm image
			if ($cur_holiday != "none" && $cur_holiday != "birthday") $holiday_path = "$cur_holiday/";
			$worms[$i]["image"] = $image_path.$holiday_path.$worms[$i]["color"].".png";
			//if (!file_exists($_SERVER['DOCUMENT_ROOT'].$worms[$i]["image"])) $worms[$i]["image"] = $image_path.$worms[$i]["color"].".png";
		}
		
		// get item data
		// needs to be done after worms because of birthday check
		getItemData();
	} else {
		$load_err = "Could not fetch worm data. Try again later.";
	}
}

function getWormAwards() {
	global $worms; global $active_season; global $users_conn; global $items; global $holidays;
	
	for ($i = 0; $i < count($worms); $i++) {
		// get users with this worm as their icon
		$sql = "SELECT COUNT(icon) as count
							FROM users
							WHERE icon = 'worm_". $worms[$i]["color"] ."';";
		if ( $result = mysqli_query($users_conn,$sql) ) {
			// store the result in the worm objects
			$row = $result->fetch_assoc();
			$worms[$i]['kins'] = $row['count'];
		} else { $load_err = "Could not fetch user data. Try again later."; }
	}
	
	if ($active_season["name"] != "all_time" && $active_season["name"] != "alpha") {
		// find winning and losing progress of previous season
		$prevSeason = getPrevSeason($season = $active_season);
		$prev_season_worms = [];
		$prev_lowest_progress = '';
		$prev_highest_progress = '';
		for ($i = 0; $i < count($worms); $i++) {
			$w = json_decode($prevSeason["worm_".$i],true);
			if (empty($prev_lowest_progress) || $w["progress"] < $prev_lowest_progress) { $prev_lowest_progress = $w["progress"]; }
			if (empty($prev_highest_progress) || $w["progress"] > $prev_highest_progress) { $prev_highest_progress = $w["progress"]; }
			$prev_season_worms[] = ["id" => $i, "progress" => $w["progress"]];
		}
	}
	
	// find highest kin, highest items, highest best day progress
	$highest_icons = 0; // number of users with worm as their icon
	$highest_apple_percent = 0; // highest percent of apples
	$highest_drink_percent = 0; // highest percent of energy drinks
	$highest_poison_percent = 0; // highest percent of poisons
	$highest_heal_percent = 0; // highest percent of health potions
	$highest_best_day = 0; // highest progress in a single day
	$highest_holiday = []; // highest all time counts for each holiday item set
	for ($i = 0; $i < count($worms); $i++) {
		if (!empty($worms[$i]['kins']) && $worms[$i]['kins'] > $highest_icons) {
			$highest_icons = $worms[$i]['kins'];
		}
		if (!empty($worms[$i]['best_day']) && $worms[$i]['best_day'] > $highest_best_day) {
			$highest_best_day = $worms[$i]['best_day'];
		}
		if ($worms[$i]['progress'] > 0) {
			$worms[$i]["apple_percent"] = $worms[$i]['apple_count'] / $worms[$i]['progress'];
			if ($worms[$i]["apple_percent"] > $highest_apple_percent) { $highest_apple_percent = $worms[$i]["apple_percent"]; }
			$worms[$i]["drink_percent"] = $worms[$i]['drink_count'] / $worms[$i]['progress'];
			if ($worms[$i]["drink_percent"] > $highest_drink_percent) { $highest_drink_percent = $worms[$i]["drink_percent"]; }
			$worms[$i]["poison_percent"] = $worms[$i]['poison_count'] / $worms[$i]['progress'];
			if ($worms[$i]["poison_percent"] > $highest_poison_percent) { $highest_poison_percent = $worms[$i]["poison_percent"]; }
			$worms[$i]["heal_percent"] = $worms[$i]['heal_count'] / $worms[$i]['progress'];
			if ($worms[$i]["heal_percent"] > $highest_heal_percent) { $highest_heal_percent = $worms[$i]["heal_percent"]; }
		}
		// check if this worm has the highest number of holiday items for any holidays
		foreach ($holidays as $h) {
			if (empty($highest_holiday[$h["name"]]) || $h["worm_$i"] > $highest_holiday[$h["name"]]) {
				$highest_holiday[$h["name"]] = $h["worm_$i"];
			}
		}
	}
	// assign awards
	for ($i = 0; $i < count($worms); $i++) {
		// apples award
		if (!empty($worms[$i]["apple_percent"]) && $worms[$i]["apple_percent"] == $highest_apple_percent) {
			$worms[$i]['awards'][] = 'Certified Organic';
		}
		// drinks award
		if (!empty($worms[$i]["drink_percent"]) && $worms[$i]["drink_percent"] == $highest_drink_percent) {
			$worms[$i]['awards'][] = 'Caffeine Addict';
		}
		// poisons award
		if (!empty($worms[$i]["poison_percent"]) && $worms[$i]["poison_percent"] == $highest_poison_percent) {
			$worms[$i]['awards'][] = 'Most Despised';
		}
		// health potions award
		if (!empty($worms[$i]["heal_percent"]) && $worms[$i]["heal_percent"] == $highest_heal_percent) {
			$worms[$i]['awards'][] = 'Private Insurance';
		}
		if ($active_season["name"] != "all_time" && $active_season["name"] != "alpha") {
			// underdog and reigning champion award
			if ($prev_season_worms[$i]['progress'] == $prev_lowest_progress) {
				$worms[$i]['awards'][] = 'Underdog';
			} else if (!empty($prev_season_worms[$i]['progress']) && $prev_season_worms[$i]['progress'] == $prev_highest_progress) {
				$worms[$i]['awards'][] = 'Reigning Champion';
			}
		}
		// best day award
		if (!empty($worms[$i]['best_day']) && $worms[$i]['best_day'] == $highest_best_day) {
			$worms[$i]['awards'][] = 'Sprint Master';
		}
		// icons award
		if (!empty($worms[$i]['kins']) && $worms[$i]['kins'] == $highest_icons) {
			$worms[$i]['awards'][] = 'Most Kinnable';
		}
		// holiday awards
		foreach ($holidays as $h) {
			if (!empty($highest_holiday[$h["name"]]) && !empty($h["worm_$i"]) && $h["worm_$i"] == $highest_holiday[$h["name"]]) {
				$worms[$i]['awards'][] = $h["award"];
			}
		}
	}
}

// get all item data, insert into $items array
function getItemData() {
	global $worm_conn; global $items; global $loading; global $load_err; global $image_path;
	global $worms; global $cur_holiday; global $birthday_worm;
	
	// get all worm data
	$sql = "SELECT * FROM items ORDER BY display_order";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		// go through each worm row, assign to variables
		while($row = mysqli_fetch_object($result)) {
			$row = get_object_vars($row);
			// find out if this item is active today based on current holiday
			$row["holidays"] = json_decode($row["holidays"],true);
			if (in_array($cur_holiday,$row["holidays"])) $row["active_today"] = true;
			else $row["active_today"] = false;
			// set icon image path
			if ($row["name"] == "cake" && $row["active_today"]) {
				$wName = $worms[$birthday_worm]["name"];
				$possessive = str_ends_with($wName,"s") ? "'" : "'s";
				$row["display_name"] = "$wName$possessive ".$row["display_name"];
				$row["icon"] = $image_path."birthday/".$row["name"].$birthday_worm.".png";
				$row["background"] = $worms[$birthday_worm]["color_medium"];
			} else {
				$row["icon"] = $image_path."items/".$row["name"].".png";
			}
			// add item to array
			$items[$row["name"]] = $row;
			if ($cur_holiday == "fools" && $row["name"] == "dirt") {
				$items["dirt2"] = $row; $items["dirt3"] = $row; $items["dirt4"] = $row;
			}
		}
	} else {
		$load_err = "Could not fetch item data. Try again later.";
	}
}

// get feed log data, insert into $worms array
function getFeedLogData() {
	global $worm_conn; global $worms; global $loading; global $load_err; global $feed_log;
	// get all feed log data
	$sql = "SELECT * FROM feed_log";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		// go through each worm row, assign to variables
		while($row = mysqli_fetch_object($result)) {
			$row = get_object_vars($row);
			
			if ( $row['date'] < (time() - 172800) ) {
				// delete log data older than 48 hours
				$del_sql = "DELETE FROM feed_log WHERE id=".$row['id'];
				if ($worm_conn->query($del_sql) !== TRUE) {
					$load_err = "Error deleting feed log record: " . $worm_conn->error;
				}
			} else {
				// store log data less than 1 day old
				$feed_log[] = $row;
			}
		}
	} else {
		$load_err = "Could not fetch feed log data. Try again later.";
	}
}

// get feed log data in a displayable format
function getFeedLogDisplay() {
	global $worms; global $items; global $feed_log;
	
	// get all feed log data
	if ( count($feed_log) == 0 ) {
		getFeedLogData();
	}
	if (empty($feed_log)) {
		echo '<div class="log-notice">No recent activity!</div>';
	} else {
		// display the list of users and feedings
		for ($i = count($feed_log) - 1; $i >= max(0, count($feed_log) - 10); $i-- ) {
			$l = $feed_log[$i];
			$worm = $worms[(int)$l["worm"]];
			$item = $items[$l["item"]]["display_name"];
			$isAnonymous = $l["user_id"] == NULL || getUserGamePrivacy($l["user_id"]) == "private";
			$user = $isAnonymous ? "Someone" : getUsername($l["user_id"]);
			$user_type = $isAnonymous ? "anonymous" : "registered";
			$linkTag = $isAnonymous ? "<span" : "<a href='/u/$user'";
			$linkTagEnd = $isAnonymous ? "</span>" : "</a>";
			echo '<div class="feed-log-item">'.$linkTag.' class="user '.$user_type.'">'.$user.$linkTagEnd.' fed
						<span class="worm" style="
							color: var(--'.$worm["color_dark"].');
						">'.$worm["name"].'</span>
						a <span class="item">'.$item.'</span></div>';
		}
	}
}

// get season fans in a displayable format
function getSeasonFansDisplay($season) {
	if (empty($season["users"])) {
		echo '<div class="log-notice">No signed in user activity!</div>';
	} else {
		echo '<div class="log-subtitle">'.$season["display_name"].'</div>';
		// display the list of users and feedings
		$i = 1;
		foreach ($season["users"] as $id => $count) {
			if (getUserGamePrivacy(intval($id)) == "public") {
				$un = getUsername(intval($id));
				echo '<div class="leaderboard-entry">
								<span class="rank">#'.$i.'</span>
								<span class="user">'.$un.'</span>
								<span class="count">'.$count.'</span>
							</div>';
				$i += 1;
				if ($i > 10) break;
			}
		}
	}
}

// returns boolean, whether user or ip is allowed to feed again
function userCanFeed($reference,$type) {
	global $items; global $feed_log;
	
	$max_users = 1.25; // maximum users for this user type
	if ($type == "IP_address") { $max_users = 2; }
	
	// get all feed log data if not already fetched
	if ( count($feed_log) == 0 ) { getFeedLogData(); }
	
	// time period to check, in seconds
	$time_period = 300;
	// accumulated cooldown time in the last 10 minutes
	$cooldown_accumulated = 0;
	
	for ($i = count($feed_log) - 1; $i >= 0; $i--) {
		$row = $feed_log[$i];
		// if the row matches the user data provided
		// if validating against IP address only, don't check IP of logged in users
		if (
			$row[$type] == $reference &&
			($type == "user_id" || $row["user_id"] == NULL)
		) {
			if ( $row['date'] > (time() - $time_period) ) {
				$cooldown_accumulated += (int)$items[$row["item"]]["cooldown"];
			} else {
				break; // if we have reached results older than the time period, break for loop
			}
		}
	}
	if ($cooldown_accumulated > ($time_period * $max_users)) { return false;
	} else { return true; }
}

// fetch the leaderboard for worm with id = $worm
$leaderboard_err = $helper_table = $hurter_table = "";
function getWormLeaderboard($worm) {
	global $leaderboard_err; global $worm_conn; global $helper_table; global $hurter_table;
	$worm_row = "worm_".$worm;
	// get all user logs for this worm
	$sql = "SELECT user_id, ".$worm_row." FROM user_data";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		$helpers = [];
		$hurters = [];
		// current user's username, if logged in
		$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
		// go through each user
		while($row = mysqli_fetch_object($result)) {
			$row = get_object_vars($row);
			if (!empty($row[$worm_row])) {
				if (getUserGamePrivacy($row["user_id"]) == "public") {
					$username = getUsername($row["user_id"]);
					
					$actions = json_decode($row[$worm_row]);
					$actions = get_object_vars(json_decode($row[$worm_row]));
					if ($actions["total_help"] > 0) {
						$helpers[] = [
							"username" => $username,
							"count" => $actions["total_help"]
						];
					}
					if ($actions["total_hurt"] > 0) {
						$hurters[] = [
							"username" => $username,
							"count" => $actions["total_hurt"]
						];
					}
				}
			}
		}
		
		$leaderboard_table_limit = 6;
		
		// convert array into columns
		$users  = array_column($helpers, 'username');
		$counts  = array_column($helpers, 'count');
		// Sort the data with volume descending, edition ascending
		// Add $data as the last parameter, to sort by the common key
		array_multisort($counts, SORT_DESC, $users, SORT_ASC, $helpers);
		// output the top helpers as a table
		$helper_table = "<div class='table'>";
		for ($i = 0; $i < $leaderboard_table_limit; $i++) {
			$display_count = $i + 1;
			if ($i < count($helpers)) {
				$action_count = $counts[$i];
				if ($action_count >= 1000) {
					if ($action_count >= 10000) {
						if ($action_count >= 100000) {
							// 100,000+
							$action_count = round($action_count / 10000, 0) . "k";
						} else {
							// 10,000 - 10,999
							$action_count = round($action_count / 1000, 1) . "k";
						}
					} else {
						// 1,000 - 1,999
						$action_count = round($action_count / 1000, 2) . "k";
					}
				}
				$helper_table = $helper_table."<div class='row'><span><small>#</small>".$display_count."</span><span>".$users[$i]."</span><span>".$action_count."</span></div>";
			} else {
				$helper_table = $helper_table."<div class='row' style='visibility:hidden;'><span><small>#</small>".$display_count."</span><span></span><span></span></div>";
			}
		}
		$helper_table = $helper_table."</div>";
		
		// convert array into columns
		$users  = array_column($hurters, 'username');
		$counts  = array_column($hurters, 'count');
		// Sort the data with volume descending, edition ascending
		// Add $data as the last parameter, to sort by the common key
		array_multisort($counts, SORT_DESC, $users, SORT_ASC, $hurters);
		// output the top hurters as a table
		$hurter_table = "<div class='table'>";
		for ($i = 0; $i < $leaderboard_table_limit; $i++) {
			$display_count = $i + 1;
			if ($i < count($hurters)) {
				$hurter_table = $hurter_table."<div class='row'><span><small>#</small>".$display_count."</span><span>".$users[$i]."</span><span>".$counts[$i]."</span></div>";
			} else {
				$hurter_table = $hurter_table."<div class='row' style='visibility:hidden;'><span><small>#</small>".$display_count."</span><span></span><span></span></div>";
			}
		}
		$hurter_table = $hurter_table."</div>";
	} else {
		$leaderboard_err = "<strong>Error:</strong> Could not load worm leaderboard.";
	}
}

function getUserWormLeaderboard($worm) {
	global $worm_conn; global $logged_in; global $items;
	$worm_row = "worm_".$worm;
	$user_table = '<span class="log-in">Log in to view your stats!</span>';
	if ($logged_in) {
		$user_table = "No user data found for this worm!";
		// get user's data for this worm
		$sql = "SELECT ".$worm_row." FROM user_data WHERE user_id = ?";
		if($stmt = mysqli_prepare($worm_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $user_id);
			$user_id = $_SESSION["id"];
			// attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// store result
				mysqli_stmt_store_result($stmt);
				// if there is one row for the user
				if(mysqli_stmt_num_rows($stmt) == 1){  
					// bind result variables
					mysqli_stmt_bind_result($stmt, $result);
          if(mysqli_stmt_fetch($stmt)){
						if (!empty($result)) {
							$actions = json_decode($result);
							$actions = get_object_vars($actions);
							$user_table = "";
							foreach ($items as $item) {
								if (!isset($actions[$item["name"]])) $actions[$item["name"]] = 0;
								if ($item["active_today"]) {
									$user_table =
										$user_table.
										'<span class="item">
												<span class="icon" style="background-image: url('.$item["icon"].');"></span>'
												.$actions[$item["name"]].' <span class="sr-only">'.$item["display_name"].'s</span>
										</span> ';
								}
							}
						}
					}
				}
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
	echo $user_table;
}
?>