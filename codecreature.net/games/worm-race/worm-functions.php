<?php
// include database connection file
require_once "connect.php";

// include user database connection file
include $_SERVER['DOCUMENT_ROOT']."/user/database.php";

// Initialize the session if not already started
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) { session_start(); }
// Store whether a user is logged in
$logged_in = false;
if ( isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true ) {
	$logged_in = true;
}

// set default timezone
date_default_timezone_set('America/New_York');

// path for worm race images
$worm_race_path = "/games/worm-race/";
$image_path = $worm_race_path."images/";

// worm data arrays
$worms = array();
$items = array();
$feed_log = array();
$loading = $load_err = "";

function getAllData() {
	$loading = true;
	getWormData();
	getItemData();
	$loading = false;
}

// get all worm data, insert into $worms array
function getWormData() {
	global $worm_conn; global $worms; global $loading; global $load_err;
	
	// get all worm data
	$sql = "SELECT * FROM worms";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		// go through each worm row, assign to variables
		while($row = mysqli_fetch_object($result)) {
			$worms[] = get_object_vars($row);
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
	// display the list of users and feedings
	for ($i = count($feed_log) - 1; $i >= max(0, count($feed_log) - 10); $i-- ) {
		$l = $feed_log[$i];
		$worm = $worms[(int)$l["worm"]];
		$item = $items[$l["item"]]["display_name"];
		$user = $l["user_id"] == NULL ? "Someone" : getUsername($l["user_id"]);
		$user_type = $l["user_id"] == NULL ? "anonymous" : "registered";
		echo '<div class="feed-log-item"><span class="user '.$user_type.'">'.$user.'</span> fed
					<span class="worm" style="
						color: var(--'.$worm["color_dark"].');
					">'.$worm["name"].'</span>
					a <span class="item">'.$item.'</span></div>';
	}
}

// returns boolean, whether user or ip is allowed to feed again
function userCanFeed($reference,$type) {
	global $items; global $feed_log;
	
	$max_users = 1; // maximum users for this user type
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
	$sql = "SELECT username, ".$worm_row." FROM user_data";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		$helpers = [];
		$hurters = [];
		// current user's username, if logged in
		$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
		// go through each user
		while($row = mysqli_fetch_object($result)) {
			$row = get_object_vars($row);
			if (!empty($row[$worm_row])) {
				$actions = json_decode($row[$worm_row]);
				$actions = get_object_vars(json_decode($row[$worm_row]));
				if ($actions["total_help"] > 0) {
					$helpers[] = [
						"username" => $row["username"],
						"count" => $actions["total_help"]
					];
				}
				if ($actions["total_hurt"] > 0) {
					$hurters[] = [
						"username" => $row["username"],
						"count" => $actions["total_hurt"]
					];
				}
			}
		}
		
		// convert array into columns
		$users  = array_column($helpers, 'username');
		$counts  = array_column($helpers, 'count');
		// Sort the data with volume descending, edition ascending
		// Add $data as the last parameter, to sort by the common key
		array_multisort($counts, SORT_DESC, $users, SORT_ASC, $helpers);
		// output the top helpers as a table
		$helper_table = "<div class='table'>";
		for ($i = 0; $i < 5; $i++) {
			$display_count = $i + 1;
			if ($i < count($helpers)) {
				$helper_table = $helper_table."<div class='row'><span>#".$display_count."</span><span>".$users[$i]."</span><span>".$counts[$i]."</span></div>";
			} else {
				$helper_table = $helper_table."<div class='row'><span>#".$display_count."</span><span></span><span></span></div>";
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
		for ($i = 0; $i < 5; $i++) {
			$display_count = $i + 1;
			if ($i < count($hurters)) {
				$hurter_table = $hurter_table."<div class='row'><span>#".$display_count."</span><span>".$users[$i]."</span><span>".$counts[$i]."</span></div>";
			} else {
				$hurter_table = $hurter_table."<div class='row'><span>#".$display_count."</span><span></span><span></span></div>";
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

<script>
	let canFeed = true;

	// enable/disable feed button based on current conditions
	function updateFeedButton(color) {
		let form = document.getElementById(color);
		let btn = form.querySelector('.feed-button');
		
		// check if an item is selected
		let itemSelected = false;
		let itemInputs = form.querySelectorAll('.item-input');
		for (let i = 0; i < itemInputs.length; i++) {
			if (itemInputs[i].checked) itemSelected = true;
		}
		
		let hovertext = btn.querySelector('.tooltip-text');
		// if item has been selected and cooldown is over
		if ( itemSelected && canFeed ) {
			btn.classList.remove('tooltip');
			hovertext.innerHTML = '';
			btn.disabled = false;
		}
		// else disable button
		else {
			btn.classList.add('tooltip');
			btn.disabled = true;
			if ( !canFeed ) hovertext.innerHTML = 'too soon to feed again!';
			else if ( !itemSelected ) hovertext.innerHTML = 'select an item first';
		}
	}
	// update all feed buttons
	function updateFeedButtons() {
		let forms = document.getElementsByClassName('worm-details')
		for (let i = 0; i < forms.length; i++) {
			updateFeedButton(forms[i].id);
		}
	}
	
	function openDetailBox(id) {
		// update the URL (no refresh)
		let newUrl = new URL(window.location.href);
		newUrl.pathname = newUrl.pathname.replaceAll('/racetrack','');
		newUrl.hash = '#' + id;
		if (window.location.pathname.includes('/racetrack')) window.location = newUrl;
		else window.history.pushState({}, "", newUrl);
		// display appropriate tabs
		let tabs = document.getElementsByClassName('tab');
		for (let i = 0; i < tabs.length; i++) {
			if (tabs[i].id == id) { tabs[i].classList.add('show'); }
			else { tabs[i].classList.remove('show'); }
		}
		hideFans(id);
	}
	
	// functions to hide or show a worm's leaderboard section
	function hideFans(wormColor) {
		let detailBox = document.getElementById(wormColor);
		// show main sections
		let mainTabSections = detailBox.getElementsByClassName('main-worm-tab');
		for (let i = 0; i < mainTabSections.length; i++) mainTabSections[i].classList.remove('hidden');
		// hide leaderboard
		document.getElementById(wormColor+'-fans').classList.add('hidden');
		// change button text
		detailBox.querySelector('.leaderboard-button').innerHTML = 'fans';
	}
	function showFans(wormColor) {
		let detailBox = document.getElementById(wormColor);
		// hide main sections
		let mainTabSections = detailBox.getElementsByClassName('main-worm-tab');
		for (let i = 0; i < mainTabSections.length; i++) mainTabSections[i].classList.add('hidden');
		// hide leaderboard
		document.getElementById(wormColor+'-fans').classList.remove('hidden');
		// change button text
		detailBox.querySelector('.leaderboard-button').innerHTML = 'worm';
	}
	function toggleFans(wormColor) {
		let fans = document.getElementById(wormColor+'-fans');
		if (fans.classList.contains('hidden')) { showFans(wormColor); }
		else { hideFans(wormColor); }
	}
	
	// update the URL (no refresh) based on search params
	// intended to convert old links to valid new ones
	function updateUrl() {
		let wormParam = new URLSearchParams(window.location.search).get("worm");
		// if url parameters includes a value for worm and that result is a valid worm, open that worm
		if (wormParam) {
			let hash = "";
			
			// DEBUG: failed to do this with php, maybe try again later. clunky style for now
			if (wormParam == "0") hash = "#pink";
			else if (wormParam == "1") hash = "#orange";
			else if (wormParam == "2") hash = "#yellow";
			else if (wormParam == "3") hash = "#green";
			else if (wormParam == "4") hash = "#blue";
			else if (wormParam == "5") hash = "#purple";
			if (hash != "") {
				let newUrl = new URL(window.location.href);
				newUrl.search = "";
				newUrl.hash = hash;
				history.replaceState(null, null, newUrl);
			}
		}
	}
	
</script>