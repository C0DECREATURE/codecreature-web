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

function getAllData() {
	$loading = true;
	getWormData();
	getItemData();
	$loading = false;
}

// get all worm data, insert into $worms array
function getWormData() {
	global $worm_conn; global $worms; global $active_season; global $load_err;
	
	// get all worm data
	$sql = "SELECT * FROM worms";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		// go through each worm row, assign to variables
		while($row = mysqli_fetch_object($result)) {
			$worms[] = get_object_vars($row);
		}
		// also insert current race season's worm data
		for ($i = 0; $i < count($worms); $i++) {
			foreach ($active_season["worms"][$i] as $key => $value) {
				$worms[$i][$key] = $value;
			}
		}
	} else {
		$load_err = "Could not fetch worm data. Try again later.";
	}
}

// get all item data, insert into $items array
function getItemData() {
	global $worm_conn; global $items; global $loading; global $load_err; global $image_path;
	
	// get all worm data
	$sql = "SELECT * FROM items";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		// go through each worm row, assign to variables
		while($row = mysqli_fetch_object($result)) {
			$row = get_object_vars($row);
			$row["icon"] = $image_path.$row["name"].".png";
			$items[$row["name"]] = $row;
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
			
			if ( $row['date'] < (time() - 86400) ) {
				// delete log data older than 1 day
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
			$user = ($l["user_id"] == NULL || getUserGamePrivacy($l["user_id"]) == "private") ? "Someone" : getUsername($l["user_id"]);
			$user_type = $l["user_id"] == NULL ? "anonymous" : "registered";
			echo '<div class="feed-log-item"><span class="user '.$user_type.'">'.$user.'</span> fed
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
		
		$leaderboard_table_limit = 5;
		
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
	global $worm_conn; global $logged_in;
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
							$user_table = '
								<span class="apple item">'.$actions["apple"].' <span class="sr-only">apples</span></span>
								<span class="drink item">'.$actions["drink"].' <span class="sr-only">battery juices</span></span>
								<span class="heal item">'.$actions["heal"].' <span class="sr-only">heart potions</span></span>
								<span class="poison item">'.$actions["poison"].' <span class="sr-only">poisons</span></span>
							';
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