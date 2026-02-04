<?php
 
// include database connection file
require_once "connect.php";
// include worm functions file
require_once "worm-functions.php";

// fetch worm data
getAllData();
getFeedLogData();

// empty variables for storing data
$feed_err = "";

// processing feed data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$item = $worm = $worm_id = "";
	
	$can_feed_err = $reference = $type ="";
	// check if user is authorized to feed yet
	if ($logged_in) {
		$reference = $_SESSION["id"];
		$type = "user_id";
		$can_feed_err = "Too many recent feed actions from your account!<br>Try again in a few minutes.";
	} else {
		$reference = $_SERVER['REMOTE_ADDR'];
		$type = "IP_address";
		$can_feed_err = "Too many recent feed actions from your IP address!<br>Try again in a few minutes, or <a href='/user/login'>sign in</a>.";
	}
	if (!userCanFeed($reference,$type)) { $feed_err = $can_feed_err; }
	
	// Check if item name is empty or invalid
	if( empty(trim($_POST["item"])) ){
		$feed_err = "<strong>Error</strong>: No item name submitted.";
	} else if ( !array_key_exists(trim($_POST["item"]), $items)) {
		$feed_err = 'Error: Item name "'.trim($_POST["item"]).'" not recognized.';
	} else{
		$item_name = trim($_POST["item"]);
		// get data for submitted worm as an array
		$item = $items[$item_name];
	}
	
	// Check if worm ID is empty or invalid
	$worm_id = trim($_POST["worm-id"]);
	if( !isset($worm_id) ) {
		$feed_err = "<strong>Error</strong>: No worm ID provided.";
	} else if ( !array_key_exists((int)$_POST["worm-id"], $worms)) {
		$feed_err = 'Error: Worm ID "'.(int)$_POST["worm-id"].'"not recognized.';
	} else {
		$worm_id = (int)$_POST["worm-id"];
		// get data for submitted worm as an array
		$worm = $worms[$worm_id];
	}
	
	// if no errors, feed the worm
	if(empty($feed_err)){
		$item_count_col = $item_name."_count";
		// prep update statement
		$sql = "UPDATE worms SET ".$item_count_col." = ?, progress = ?, health = ? WHERE id = ?";
		
		if ($stmt = mysqli_prepare($worm_conn, $sql)) {
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "iiii", $param_item_count, $param_progress, $param_health, $param_id);
			$param_item_count = $worm[$item_count_col] + 1;
			$param_progress = max($worm["progress"] + ( $item["progress"] * $item["progress_effect_".$worm["health"]] ), 0);
			$param_health = max($worm["health"] + ( $item["health"] * $item["health_effect_".$worm["health"]] ), 0);
			$param_id = $worm_id;
			
			// attempt to execute final feeding statement
			if(mysqli_stmt_execute($stmt)){
				$_SESSION["last_feed"] = time();
				$_SESSION["last_cooldown"] = $item["cooldown"];
				logFeeding($worm_id,$item_name);
				// redirect to racetrack page
				header("location: ".$worm_race_path."racetrack");
			} else{
				$feed_err = "<strong>Error</strong>: Could not access worm database.<br>Try again later.";
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
	}
}

function logFeeding($worm,$item) {
	global $worm_conn; global $logged_in; global $items;
	
	$sql = "INSERT INTO feed_log (user_id, IP_address, worm, item) VALUES (?, ?, ?, ?)";
	if($stmt = mysqli_prepare($worm_conn, $sql)){
		// bind variables to statement as parameters
		mysqli_stmt_bind_param($stmt, "isis", $param_user_id, $param_ip, $param_worm, $param_item);
		$param_user_id = $logged_in ? $_SESSION["id"] : NULL;
		$param_ip = $_SERVER['REMOTE_ADDR'];
		$param_worm = $worm;
		$param_item = $item;
		
		// attempt to execute prepared statement
		if(!mysqli_stmt_execute($stmt)){
			$feed_err = "<strong>Error</strong>: Could not access feeding database.<br>Try again later.";
		}
		
		// Close statement
		mysqli_stmt_close($stmt);
	}
	
	// if a user is logged in, update their personal log
	$err_userDB_access = "<strong>Error</strong>: Could not access user log.<br>Try again later.";
	if ($logged_in) {
		// check if user already has worm data row. if yes, update existing row. if no, create new row
		$worm_row = 'worm_'.(int)$worm;
		// prepare statement
		$sql = "SELECT ".$worm_row." FROM user_data where user_id = ?";
		if($stmt = mysqli_prepare($worm_conn, $sql)){
			// bind variables to statement as parameters
			mysqli_stmt_bind_param($stmt, "i", $param_user_id);
			$param_user_id = $_SESSION["id"];
			// attempt to execute prepared statement
			if(!mysqli_stmt_execute($stmt)){
				$feed_err = $err_userDB_access;
			} else {
				$stmt_result = $stmt->get_result();
				// array of user's feed history for this worm
				$arr = "";
				// if there is a row for this user
				if ( $stmt_result->num_rows == 1 ) {
					// get the data
					$row = $stmt_result->fetch_assoc();
					if (isset($row[$worm_row])) { $arr = get_object_vars(json_decode($row[$worm_row])); }
				} else {
					// insert a row for the user
					$sql_insert = "INSERT INTO user_data (user_id, username) VALUES (?, ?)";
					if ($stmt = mysqli_prepare($worm_conn, $sql_insert)) {
						// bind variables to statement as parameters
						mysqli_stmt_bind_param($stmt, "is", $param_user_id, $param_username);
						$param_user_id = $_SESSION["id"];
						$param_username = $_SESSION["username"];
						if(!mysqli_stmt_execute($stmt)){
							$feed_err = "<strong>Error</strong>: Could not create user data.<br>Try again later.";
						}
					}
				}
				// if there is no existing array for the worm in the user's row, make one
				if (empty($arr) || count($arr) == 0) {
					$arr = [];
					$arr["total_help"] = 0;
					$arr["total_hurt"] = 0;
					// if user row inserted successfully, prepare an empty array to use for the worm
					foreach(array_keys($items) as $key){ $arr[$key] = 0; }
				}
				// now that a user row and worm array exists
				// update the worm feed data
				if (empty($feed_err)) {
					// ensure the needed array values are set
					if (!isset($arr[$item])) { $arr[$item] = 0; }
					if (!isset($arr["total_help"])) { $arr["total_help"] = 0; }
					if (!isset($arr["total_hurt"])) { $arr["total_hurt"] = 0; }
					// add to the appropriate counts
					$arr[$item] += 1;
					if ($item == "poison") { $arr["total_hurt"] += 1;
					} else { $arr["total_help"] += 1; }
					// json encode the array and add to this user's data
					$arr = json_encode($arr);
					$sql_update = "UPDATE user_data SET ".$worm_row."='".$arr."' WHERE user_id=?";
					if ($stmt = mysqli_prepare($worm_conn, $sql_update)) {
						// bind variables to statement as parameters
						mysqli_stmt_bind_param($stmt, "i", $param_user_id);
						$param_user_id = $_SESSION["id"];
						if(!mysqli_stmt_execute($stmt)){
							$feed_err = "<strong>Error</strong>: Could not update user data.<br>Try again later.";
						}
					}
				}
			}
		} else { // if statement prep failed
			$feed_err = $err_userDB_access;
		}
	}
}

?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>worm racetrack</title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="../favicon.ico">
		
		<!--fonts-->
		<script>fonts.load('YetR','Super Comic');</script>
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js"></script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--worm race game stylesheet-->
		<link href="style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--loading page stylesheet-->
		<link href="loading.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>
		<!-- menu & navigation -->
		<?php include 'menu.php'; ?>
		
		
		<main id="content-wrapper">
			<!--main page header-->
			<?php include 'header.php'; ?>
			
			<!-- contains all worm content -->
			<div id="content">
				<?php include "loading.php" ?>
			</div>
			
			<!--main page footer-->
			<?php include 'footer.php'; ?>
		</main>
		
		<!--worm race updates-->
		<?php include 'updates.php'; ?>
		
		<script>
			// put the correct svg in each .svg-icon element
			defaultSvgIcons.load();
		</script>
		
	</body>
</html>