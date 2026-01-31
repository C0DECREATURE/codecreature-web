<?php

// Include database connection file
require_once "connect.php";

function getUsername($id) {
	global $users_conn;
	$sql = "SELECT username FROM users WHERE id = ".$id;
	// Execute the SQL query
	$result = $users_conn->query($sql);

	// Process the result set
	if ($result->num_rows > 0) {
		// Output data of each row
		while($row = $result->fetch_assoc()) {
			return $row["username"];
		}
	} else {
		echo "User #".$id;
	}
}

?>