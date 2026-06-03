<?php
 
// include database connection file
require_once "connect.php";

// set default timezone
date_default_timezone_set('America/New_York');

// name and month data for each season
$seasons = [
	[
		"name" => "spring",
		"months" => ['03','04','05']
	],
	[
		"name" => "summer",
		"months" => ['06','07','08']
	],
	[
		"name" => "fall",
		"months" => ['09','10','11']
	],
	[
		"name" => "winter",
		"months" => ['12','01','02']
	]
];

// get names of all seasons in the database
$seasons_list = [];
$sql = "SELECT name, display_name FROM race ORDER BY end_time DESC, id ASC;";
if ( $result = mysqli_query($worm_conn,$sql) ) {
	while($row = mysqli_fetch_object($result)) {
		$row = get_object_vars($row);
		$seasons_list[] = $row;
	}
} else { echo "ERROR: Could not get season names."; }

// get the data for the season with the given name
// optionally specify display_name and end_time to be used if new season row needs to be created
function getSeason($name,$display_name="",$end_time='NULL') {
	global $seasons; global $worm_conn;
	
	if (empty($display_name)) $display_name = $name;
	
	// create a new season row if one doesn't already exist for this season
	$sql = "INSERT IGNORE INTO race (name, display_name, end_time) VALUE ('".$name."','".$display_name."','".$end_time."');";
	if($stmt = mysqli_prepare($worm_conn, $sql)){
		if(!mysqli_stmt_execute($stmt)){ echo "ERROR: Could not create new season row."; }
		mysqli_stmt_close($stmt);
	}
	
	$s = [];
	
	// create a new season row if one doesn't already exist for this season
	$sql = "SELECT * FROM race WHERE name = '".$name."';";
	if ( $result = mysqli_query($worm_conn,$sql) ) {
		while($row = mysqli_fetch_object($result)) {
			$row = get_object_vars($row);
			foreach ($row as $key => $value) {
				$s[$key] = $value;
			}
		}
	} else {
		$load_err = "Could not fetch race data. Try again later.";
	}
	
	// decode users json array
	$s["users"] = json_decode($s["users"],true);
	
	// get all worm data for this season, put in $s["worms"] array
	for ($i = 0; $i < 6; $i++) {
		$s["worms"][$i] = json_decode($s["worm_".$i],true);
	}
	
	// update season ongoing status
	$s["ongoing"] = seasonIsOngoing($s);
	
	return $s;
}

// get the data for the automatically generated season based on the year and month
// $database = whether to create/update a mySql table for this season. default is true
function getSeasonByDate($year,$month,$database = true) {
	global $seasons; global $worm_conn;
	
	foreach($seasons as $key => $value) {
		if (in_array($month, $value["months"])) {
			$s = $value;
			$s["key"] = $key;
			$s["month"] = $month;
		}
	}
	// get the correct year
	// given year, or last year if it's the Jan/Feb part of the winter season
	if ($s["name"] == "winter" && $s["month"] != "12") {
		$s["year"] = intval($year) - 1;
	} else {
		$s["year"] = $year;
	}
	
	// mysql row name for this season
	$s["row_name"] = $s["year"]."_".$s["name"];
	
	// text display name for this season
	$s["display_name"] = ucfirst($s["name"])." ".$s["year"];
	
	// get the time when this season will end
	$next_season_year = $s["month"] == "12" ? intval($s["year"]) + 1 : $s["year"];
	$next_season_month = $s["key"] == count($seasons) - 1 ? $seasons[0]["months"][0] : $seasons[$s["key"] + 1]["months"][0];
	$s["end_time"] = $next_season_year."-".$next_season_month."-01 00:00:00";
	
	return getSeason($s["row_name"],$s["display_name"],$s["end_time"]);
}

// get the data for the current season
function getCurSeason() {
	$month = date("m");
	$year = date("Y");
	if(intval($year) >= 2026 && intval($month) >= 6) {
		return getSeasonByDate($year,$month);
	} else {
		return getSeason('beta');
	}
}

// get the data for the previous season
function getPrevSeason($season) {
	global $seasons_list;
	
	foreach($seasons_list as $key => $value) {
		if ($season["name"] == $value["name"]) {
			return getSeason($seasons_list[$key + 1]["name"]);
		}
	}
}

// update ongoing status of given season
function seasonIsOngoing($season) {
	global $worm_conn;
	
	$ongoing = $season["ongoing"] ? "true" : "false";
	
	// if season has ended and hasn't been processed yet
	if ($season["ongoing"] == true && !empty($season["end_time"]) && getSeasonTimeRemaining($season) <= 0) {
		$ongoing = 'false';
		// save ongoing status in the database
		$sql = "UPDATE race SET ongoing = ".$ongoing." WHERE name = '".$season["name"]."';";
		if($stmt = mysqli_prepare($worm_conn, $sql)){
			if(!mysqli_stmt_execute($stmt)){ echo "ERROR: Could not update race ongoing status."; }
			mysqli_stmt_close($stmt);
		}
		
		// get existing worm win data
		$win_counts = [];
		$sql = "SELECT win_counts FROM worms;";
		if ( $result = mysqli_query($worm_conn,$sql) ) {
			while($row = mysqli_fetch_object($result)) {
				$row = get_object_vars($row);
				$win_counts[] = json_decode($row["win_counts"]);
			}
		} else { echo "Could not fetch worm trophy data"; }
		
		// get the winning progress for the season being processed
		$season_worms = [];
		$highest_progress = 0;
		for ($i = 0; $i < count($win_counts); $i++) {
			$w = json_decode($season["worm_".$i],true);
			if ($w["progress"] > $highest_progress) { $highest_progress = $w["progress"]; }
			$season_worms[] = ["id" => $i, "progress" => $w["progress"]];
		}
		
		// get the losing progress of the season BEFORE the season being processed
		$prevSeason = getPrevSeason($season = $season);
		$prev_season_worms = [];
		$lowest_progress = '';
		for ($i = 0; $i < count($win_counts); $i++) {
			$w = json_decode($prevSeason["worm_".$i],true);
			if (empty($lowest_progress) || $w["progress"] < $lowest_progress) { $lowest_progress = $w["progress"]; }
			$prev_season_worms[] = ["id" => $i, "progress" => $w["progress"]];
		}
		
		// get existing worm awards array
		$all_awards = [];
		$sql = "SELECT awards FROM worms;";
		if ($result = mysqli_query($worm_conn,$sql)) {
			while($row = mysqli_fetch_object($result)) {
				$row = get_object_vars($row);
				$all_awards[] = json_decode($row["awards"],true);
			}
		} else { echo "ERROR: Could not get stored worm awards."; }
		
		// assign underdog award
		for ($i = 0; $i < count($win_counts); $i++) {
			if (
				$prev_season_worms[$i]["progress"] == $lowest_progress
				&& $season_worms[$i]["progress"] == $highest_progress
			) {
				if(!in_array('Underdog',$all_awards[$i])) $all_awards[$i][] = "Underdog";
			} else {
				$all_awards[$i] = array_diff($all_awards[$i], array('Underdog'));
			}
			
			echo "WORM #".$i."<br>";
			echo "prev progress: ".$prev_season_worms[$i]["progress"]."<br>";
			echo "cur progress: ".$season_worms[$i]["progress"]."<br>";
			echo "awards: " . json_encode($all_awards[$i]) ."<br><hr>";
			
			$sql = "UPDATE worms
								SET win_counts = '" . json_encode($win_counts[$i]) . "',
										awards = '" . json_encode($all_awards[$i]) . "'
								WHERE id = $i";
			if($stmt = mysqli_prepare($worm_conn, $sql)) {
				if(!mysqli_stmt_execute($stmt)){ echo "ERROR: Could not update worm trophies."; }
				mysqli_stmt_close($stmt);
			}
			
			if (
				$season_worms[$i]["progress"] == $highest_progress
				&& $prev_season_worms[$i]["progress"] == $lowest_progress
			) {
				
			}
		}
		
		// sort the winner rankings in descending order
		function prog_sort($a, $b) {
			return $a["progress"] < $b["progress"];
		}
		usort($season_worms,"prog_sort");
		
		for ($i = 0; $i < count($season_worms); $i++) {
			$season_worms[$i]["place"] = 0;
			if ($i > 0) {
				for ($j = 0; $j < count($season_worms); $j++) {
					if ($season_worms[$j]["progress"] > $season_worms[$i]["progress"]) {
						$season_worms[$i]["place"] = $season_worms[$j]["place"] + 1;
					} else {
						break;
					}
				}
			}
			$win_counts[intval($season_worms[$i]["id"])][intval($season_worms[$i]["place"])] += 1;
		}
		// update the trophy counts for the worm
		for ($i = 0; $i < count($win_counts); $i++) {
			$sql = "UPDATE worms SET win_counts = '" . json_encode($win_counts[$i]) . "' WHERE id = $i";
			if($stmt = mysqli_prepare($worm_conn, $sql)) {
				if(!mysqli_stmt_execute($stmt)){ echo "ERROR: Could not update worm trophies."; }
				mysqli_stmt_close($stmt);
			}
		}
		
	} // if season is ongoing
	else if ($season["ongoing"] == false && !empty($season["end_time"]) && getSeasonTimeRemaining($season) > 0) {
		$ongoing = 'true';
		// save ongoing status in the database
		$sql = "UPDATE race SET ongoing = ".$ongoing." WHERE name = '".$season["name"]."';";
		if($stmt = mysqli_prepare($worm_conn, $sql)){
			if(!mysqli_stmt_execute($stmt)){ echo "ERROR: Could not update race ongoing status."; }
			mysqli_stmt_close($stmt);
		}
	}
	
	return $ongoing;
}

// returns the time remaining until end of given season
function getSeasonTimeRemaining($season) {
	return strtotime($season["end_time"]) - time();
}

$cur_season = getCurSeason();
$active_season = $cur_season;

?>

<script>
	var seasonCountdownTimeout;
	function startSeasonCountdown(seconds) {
		clearSeasonCountdown();
		document.getElementById('season-countdown').innerHTML = formatSeasonCountdownTime(seconds);
		// run every second
		seasonCountdownTimeout = setTimeout(function() {
			startSeasonCountdown(seconds - 1);
		}, 1000);
	}
	function clearSeasonCountdown() {
		clearTimeout(seasonCountdownTimeout);
	}
	// return string - formated time display text for season countdown
	function formatSeasonCountdownTime(seconds) {
		if (seconds <= 0) {
			return "ENDED";
		} else {
			let time = getTimeBreakdown(seconds);
			let str = "ENDS IN ";
			if (time.days > 0) { str += time.days + " days"; }
			// if less than one day remains
			else {
				let h = time.hours < 10 ? "0" + time.hours : time.hours;
				let m = time.minutes < 10 ? "0" + time.minutes : time.minutes;
				let s = time.seconds < 10 ? "0" + time.seconds : time.seconds;
				str += h + ":" + m + ":" + s;
			}
			return str;
		}
	}
	// returns object representing the time
	// object properties: (integers) days, hours, minutes, seconds
	function getTimeBreakdown(seconds) {
		// convert the seconds into days
		let days = Math.floor(seconds / 86400);
		// convert remaining seconds into hours
		seconds -= days * 86400;
		let hours = Math.floor(seconds / 3600);
		// convert remaining seconds into minutes
		seconds -= hours * 3600;
		let minutes = Math.floor(seconds / 60);
		// get remaining seconds
		seconds -= minutes * 60;
		// return object containing all times
		return {
			days: days,
			hours: hours,
			minutes: minutes,
			seconds: seconds
		}
	}
</script>