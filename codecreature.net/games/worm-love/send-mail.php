<?php
// include shipping functions
require_once "functions.php";

$sender_effect = 3;
$recipient_effect = 1;

// response to return as JSON
$response = [];

if (!$mailboxOpen) {
	echo "Mailboxes are closed! Come back February 1st - February 13th.";
// process data when form is submitted
} else if($_SERVER["REQUEST_METHOD"] === "POST") {
	
	// validate sender
	if (!isset($_POST["sender"])) $response["error"] = "Must include a sender.";
	else {
		$sender = (int)trim($_POST["sender"]);
		if ($sender < 0 || $sender > count($worms) - 1) $response["error"] = "Invalid sender worm!";
	}
	
	if (empty($response["error"])) {
		// validate recipient
		if (!isset($_POST["recipient"])) $response["error"] = "Must include a recipient.";
		else {
			$recipient = (int)trim($_POST["recipient"]);
			if ($recipient < 0 || $recipient > count($worms) - 1) $response["error"] = "Invalid recipient worm!";
		}
	}
	
	if (empty($response["error"])) {
		// validate relationship type
		if (empty($_POST["type"])) $response["error"] = "Must include a relationship type.";
		else if (!array_key_exists(trim($_POST["type"]),$relationship_types)) $response["error"] = "Invalid relationship type!";
		else $type = trim($_POST["type"]);
	}
	
	if (empty($response["error"])) $response["error"] = sendMailError();
	
	if (empty($response["error"])) {
		
		$param_pairing = $sender."_to_".$recipient;
		// update value for SENDER's feelings
		$sql = "INSERT INTO valentines_letters ( pairing , $type )
							VALUES ( '$param_pairing' , $sender_effect )
							ON DUPLICATE KEY UPDATE $type = $type + $sender_effect;";
		if (!mysqli_query($worm_conn,$sql) ) {
			$response["error"] = "Could not access database.<br>Try again later.";
		} else {
			// update value for RECIPIENT's feelings
			$param_pairing = $recipient."_to_".$sender;
			$sql = "INSERT INTO valentines_letters ( pairing , $type )
								VALUES ( '$param_pairing' , $recipient_effect )
								ON DUPLICATE KEY UPDATE $type = $type + $recipient_effect;";
			if (!mysqli_query($worm_conn,$sql) ) {
				$response["error"] = "Could not access database.<br>Try again later.";
			} else {
				$sql = "INSERT INTO valentines_mail_log (user_id, IP_address, date, sender, recipient, type)
								VALUES (?, ?, ?, $sender, $recipient, '$type')";
				if($stmt = mysqli_prepare($worm_conn, $sql)){
					// bind variables to statement as parameters
					mysqli_stmt_bind_param($stmt, "isi", $param_user_id, $param_ip, $param_date);
					$param_user_id = $logged_in ? $_SESSION["id"] : NULL;
					$param_ip = $_SERVER['REMOTE_ADDR'];
					$param_date = time();
					
					// attempt to execute prepared statement
					if(!mysqli_stmt_execute($stmt)){
						$response["error"] = "Could not access mail database.<br>Try again later.";
					}
					
					// Close statement
					mysqli_stmt_close($stmt);
				}
				
				// if everything went well, prep the response
				if (empty($response["error"])) {
					$response["sent"] = true;
					$response["sender"] = $worms[$sender]["name"];
					$response["recipient"] = $sender == $recipient ? "themself" : $worms[$recipient]["name"];
					$emoji = "<img class='emoji' src='".getRelationshipIcon($type)."' alt=''>";
					$response["type"] = "$emoji <strong>".$relationship_types[$type]["letter_name"]."</strong> $emoji";
				}
			}
		}
	}
	
	echo json_encode($response);
}



?> 