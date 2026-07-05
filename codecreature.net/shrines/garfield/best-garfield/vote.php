<?php

// include database connection file
require_once $_SERVER['DOCUMENT_ROOT']."/codefiles/poll-connect.php";
// include list of best garfield options
require_once $_SERVER['DOCUMENT_ROOT']."/shrines/garfield/best-garfield/options.php";

// Check if name is empty or invalid
$error = "";
$name = "";
$pollData = [];
if(empty($_REQUEST["name"])){
	$error = "Please make a selection first!";
}
else {
	$name = trim($_REQUEST["name"]);
}
if (!in_array(trim($_REQUEST["name"]), $garfields)) {
	$error = "Invalid Garfield selection!";
} else {
	$name = trim($_REQUEST["name"]);
	$votedFor = !empty($_COOKIE["bestGarfieldVoted"]) ? json_decode($_COOKIE["bestGarfieldVoted"],true) : [];
	$alreadyVoted = in_array($name, $votedFor);
	if (!$alreadyVoted) {
		// add one vote for this option , or create a row for it if one doesn't exist
		$sql = "INSERT INTO best_garfield (name, votes)
							VALUES ( ? , 1 )
							ON DUPLICATE KEY UPDATE votes = votes + 1";
		if($stmt = mysqli_prepare($poll_conn, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $name);
			if(mysqli_stmt_execute($stmt)) {
				// store that user has voted for this garfield
				$votedFor[] = $name;
				$json = json_encode($votedFor);
				setcookie("bestGarfieldVoted", $json);
			} else {
				$error = "Could not submit vote. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}
}

// get poll data
$sql = "SELECT * FROM best_garfield";
if ($result = mysqli_query($poll_conn,$sql)) {
	while($row = mysqli_fetch_object($result)) {
		$row = get_object_vars($row);
		$pollData[$row["name"]] = $row["votes"];
	}
} else {
	$error = "Could not load poll data. Please try again later.";
}

if (empty($error)) {
	$name = str_replace(" ","-",$name);
	header("Location: /best-garfield/vote/$name");
} else {
	echo "<script>alert('ERROR: $error');</script>";
	?>
	<script>window.location = '/best-garfield';</script>;
	<?php
}
?>