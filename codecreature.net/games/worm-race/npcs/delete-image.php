<?php

// load the worm data into $worm
require_once $_SERVER['DOCUMENT_ROOT']."/games/worm-race/npcs/get-worm.php";

// process when form is submitted
if($worm["canEdit"] && isset($_GET["image"])){
	unset($worm["gallery"][$_GET["image"]]);
	$json = json_encode($worm["gallery"]);
	
	$sql = "UPDATE fan_worms SET gallery = ? WHERE id = ? ;";
	if($stmt = mysqli_prepare($worm_conn, $sql)){
		// Bind variables to the prepared statement as parameters
		mysqli_stmt_bind_param($stmt, "si", $json, $worm["id"]);
		
		// Attempt to execute the prepared statement
		if(!mysqli_stmt_execute($stmt)) echo "Oops! Something went wrong. Please try again later.";
		
		// Close statement
		mysqli_stmt_close($stmt);
	}
	
	header('Location: /fan-worms/worm/'.$worm["id"]."/edit");
}

?>