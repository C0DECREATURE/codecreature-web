<?php
	// display errors
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	// total number of worms
	$numWorms = 6;
	
	// create (if not exist) and open worm database
	$db = new SQLite3( "wormrace.db" );
	
	// maximum number of simultaneous users from one IP address
	$ipUserLimit = 4;
	
	// user's IP address
	$ipAddress = $_SERVER['REMOTE_ADDR'];
	
	// server's current Unix time
	$time = time();
	
	// cooldown to log for this feeding
	$cooldown = 0;
	
	/********************** FEEDING LOG TABLE **********************/
	
	// create (if not exist) feed log TABLE
	// this stores data on recent worm feedings
	
	// time = the server's Unix time for that access
	// worm = the worm that was fed
	// item = the name of the item that was fed
	// item = cooldown (in seconds) for the item that was fed
	// ipAddress = the IP address that made the request
	
	/* COMMENTED TO REDUCE UPDATE COUNT - make sure to manually create table
	
	$db->exec("
			CREATE TABLE "feedLog" (
				"time"			INTEGER,
				"worm"			INTEGER,
				"item"			TEXT,
				"cooldown"	INTEGER,
				"ipAddress"	INTEGER
			);
	");
	
	*/
	
	// get the feedLog table data (all rows/columns)
	$feedLogData = $db->query( "SELECT * FROM feedLog" );
	// accumulated cooldown time from this IP address in the last hour
	$ipCooldownTime = 0;
	// for each row in the feed log table
	while ($row = $feedLogData->fetchArray(SQLITE3_ASSOC)) {
		// if row is from the last hour and the IP address matches the user
		if (
			$row["time"] < ($time - 3600)
			&& $row["ipAddress"] == $ipAddress
		) {
			$ipCooldownTime += $row["cooldown"];
		}
	}
	
	// if the accumulated cooldown in the last hour exceeds the limits
	if ( $ipCooldownTime > ($ipUserLimit * 3600) ) {
		echo "LIMIT";
	}
	// if the IP address hasn't exceeded the limit, proceed with request
	else {
		// delete data over 24 hours old
		$db->exec( "
			DELETE FROM feedLog
			WHERE time < " . ($time - 86400) . ";
		" );
		
		/**************************** WORMS ****************************/
		
		// create (if not exist) worm table
		// wormId is the unique id number for each worm
		// name = name of worm
		// movement = distance traveled on track
		// health = current health
		// appleCount = total apples consumed
		// drinkCount = total drinks consumed
		// poisonCount = total poisons consumed
		// healCount = total heals consumed
		/* COMMENTED TO REDUCE UPDATE COUNT - make sure to manually create table
		$db->exec( "
			CREATE TABLE IF NOT EXISTS worms
			(
				idNum			INTEGER PRIMARY KEY NOT NULL,
				name			TEXT,
				movement		INTEGER,
				health			INTEGER,
				appleCount		INTEGER,
				drinkCount		INTEGER,
				poisonCount		INTEGER,
				healCount		INTEGER
			);
		" );
		*/
		
		// if wormId is set
		if( isset( $_GET[ "wormId" ] ) )
		{
			$wormId = (int)$_GET[ "wormId" ];
			
			// Insert (if not exist) the row for the worm
			// get worm row column 1
			$result = $db->query( "SELECT idNum FROM worms WHERE idNum=" . $wormId );
			$row = $result->fetchArray();
			// if it does not exist
			if( $row == false )
			{
				// insert the row
				$db->exec( "
					INSERT INTO worms 
					(
						idNum,
						name,
						movement,
						health,
						appleCount,
						drinkCount,
						poisonCount,
						healCount
					) 
					VALUES
					(
						" . $wormId . ",
						'no name',
						'0',
						'2',
						'0',
						'0',
						'0',
						'0'
					);"
				);
			}
			
			// Retrieve the worm's row
			// select all columns
			$result = $db->query( "SELECT * FROM worms WHERE idNum=" . $wormId );
			$row = $result->fetchArray();
			
			// Set name if given
			if( isset( $_GET[ "name" ] ) ) {
				$row[ "name" ] = $_GET[ "name" ];
			}
			
			// If item is given, feed the item to the worm
			if( isset( $_GET[ "item" ] ) )
			{
				$item = $_GET[ "item" ];
				
				// add one to this item's count in the worm's row
				$row[ $item . "Count" ] = $row[ $item . "Count" ] + 1;
				
				$db->exec( "
					UPDATE worms
					SET
						" . $item . "Count=" . $row[ $item . "Count" ] . "
					WHERE
						idNum=" . $wormId . ";"
				);
				
				// Retrieve the item's row, select all columns
				$itemResult = $db->query( "SELECT * FROM items WHERE name=" . $item );
				$itemRow = $result->fetchArray();
				
				// update cooldown to log for this feeding
				$cooldown = $itemRow["cooldown"];
				
				/////////////////////////////////////////////////////////////////////
				// MOVEMENT
				// get item's movement value to add to worm movwmwnt
				$movement = $itemRow["movement"];
				// get movement effect array
				$movementEffect = explode(',', $itemRow["movementEffect"]);
				// if the item has a valid movement effect entry for the current worm health,
				// modify the movement value using that effect
				if ($movementEffect[$row["health"]]) { $movement = $movement * $movementEffect[$row["health"]]; }
				
				// if current movement is negative, reset to zero
				if ( $row[ "movement" ] < 0 ) { $row[ "movement" ] = 0; }
				// add
				$row[ "movement" ] += $movement;
				// if new movement is negative, reset to zero
				if ( $row[ "movement" ] < 0 ) { $row[ "movement" ] = 0; }
				
				/////////////////////////////////////////////////////////////////////
				// HEALTH
				// get item's health value to add to worm health
				$health = $itemRow["health"];
				// get health effect array
				$healthEffect = explode(',', $itemRow["healthEffect"]);
				// if the item has a valid health effect entry for the current worm health,
				// modify the health value using that effect
				if ($healthEffect[$row["health"]]) { $health = $health * $healthEffect[$row["health"]]; }
				
				// if current worm health falls outside range, fix it
				if ( $row[ "health" ] < 0 ) { $row[ "health" ] = 0; }
				elseif ( $row[ "health" ] >= 4 ) { $row[ "health" ] = 4; }
				// add
				$row[ "health" ] = $row[ "health" ] + $health;
				// if new worm health falls outside range, fix it
				if ( $row[ "health" ] < 0 ) { $row[ "health" ] = 0; }
				elseif ( $row[ "health" ] >= 4 ) { $row[ "health" ] = 4; }
			}
			
			/////////////////////////////////////////////////////////////////////
			// UPDATE WORM ROW
			if( isset( $_GET[ "wormId" ] ) )
			{
				$db->exec( "
					UPDATE worms
					SET
						movement=" . $row[ "movement" ] . "
					WHERE
						idNum=" . $wormId . ";"
				);
				
				$db->exec( "
					UPDATE worms
					SET
						health=" . $row[ "health" ] . "
					WHERE
						idNum=" . $wormId . ";"
				);
				
				
				/////////////////////////////////////////////////////////////////////
				// INSERT ACCESS DATA ROW FOR CURRENT SESSION
				$db->exec( "
					INSERT INTO feedLog 
					(
						time,
						worm,
						item,
						cooldown,
						ipAddress
					) 
					VALUES
					(
						" . $time . ",
						" . $wormId . ",
						" . $item . ",
						" . $cooldown . ",
						" . $ipAddress . "
					)"
				);
			}
			
			// this next bit doesn't work and idk why
			// intended to replace the previous updates section
			/*
			$db->exec( "
				UPDATE worms
				SET
					movement=" . $row[ "movement" ] . ",
					health=" . $row[ "health" ] . ",
					appleCount=" . $row[ "appleCount" ] . ",
					drinkCount=" . $row[ "drinkCount" ] . ",
					poisonCount=" . $row[ "poisonCount" ] . ",
					healCount=" . $row[ "healCount" ] . "
				WHERE
					idNum=" . $wormId . ";"
			);
			*/
		}
		
		/////////////////////////////////////////////////////////////////////
		// OUTPUT DATA FOR ALL WORMS AND ITEMS
		$output = '';
		
		// get the worm table data (all rows/columns)
		$result = $db->query( "SELECT * FROM worms" );
		// for each row in the worms table
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			// add the data from the row as a string separated by commas
			$output = $output .
				$row[ "idNum" ] . "," . $row[ "name" ] . "," . $row[ "movement" ] . "," . $row[ "health" ] . "," .
				$row[ "appleCount" ] . "," . $row[ "drinkCount" ] . "," . $row[ "poisonCount" ] . "," . $row[ "healCount" ] . ";";
		}
		// add a semicolon to divide worm section from items section
		$output = $output . "ITEMS";
		// for each row in the items table
		$itemResult = $db->query( "SELECT * FROM items" );
		while ($iRow = $itemResult->fetchArray(SQLITE3_ASSOC)) {
			// add the data from the row as a string separated by commas
			$output = $output .
				$iRow["name"] . "," . $iRow["movement"] . "," . $iRow["movementEffect"] . "," .
				$iRow["health"] . "," . $iRow["healthEffect"] . "," . $iRow["cooldown"] . ";";
		}
		// send the output string
		echo $output;
	}
?>