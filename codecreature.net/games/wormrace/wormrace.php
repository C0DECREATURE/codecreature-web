<?php
	// total number of worms
	$numWorms = 6;
	
	// create (if not exist) and open worm database
	$db = new SQLite3( "wormrace.db" );
	
	
	/********************** QUERIES / UPDATES **********************/
	
	// ACCESS DATA VALUES FOR CURRENT ACCESS SESSION
	// get current time in seconds since the Unix Epoch
	$time = time();
	// number of database queries made during the current session
	$queries = 0;
	// number of database updates made during the current session
	$updates = 0;
	
	// maximum allowed db updates per hour
	$maxUpdates = 4850; // 000webhost limit: 5000
	// total updates in the past hour
	$totalUpdates = 0;
	// maximum allowed db updates per hour
	$maxQueries = 12000; // 000webhost limit: 15000
	// total updates in the past hour
	$totalQueries = 0;
	
	// create (if not exist) access data TABLE
	// this stores data on how many read and write requests the database receives
	// idNum assigns integer ids to each column afterwards
	// date is the date/time associated with that access in seconds since the Unix Epoch
	// queries is the number of queries made during that access
	// updates is the number of updates made during that access
	/* COMMENTED TO REDUCE UPDATE COUNT - make sure to manually create table
	$updates += 1;
	$db->exec( "
		CREATE TABLE IF NOT EXISTS accessData
		(
			date			INTEGER,
			queries			INTEGER,
			updates			INTEGER
		);
	" );
	*/
	
	// get the table data (all rows/columns)
	$queries += 1;
	$result = $db->query( "SELECT * FROM accessData" );
	// for each row in the queries/updates table
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		// if row is less than an hour old
		if ( $row["date"] > ($time - 3600) ) {
			// add the updates from the row
			$totalUpdates += $row["updates"];
			// add the queries from the row
			$totalQueries += $row["updates"];
		}
    }
	
	// if the updates so far exeed set limits
	if ( $totalUpdates >= $maxUpdates || $totalQueries >= $maxQueries ) {
		echo "LIMIT";
	}
	// if the updates don't exceed limits
	else {
		
		// delete access data over an hour old
		$updates += 1;
		$db->exec( "
			DELETE FROM accessData
			WHERE date < " . ($time - 3600) . ";
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
		$updates += 1;
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
			$queries += 1;
			$result = $db->query( "SELECT idNum FROM worms WHERE idNum=" . $wormId );
			$row = $result->fetchArray();
			// if it does not exist
			if( $row == false )
			{
				$updates += 1;
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
			$queries += 1;
			$result = $db->query( "SELECT * FROM worms WHERE idNum=" . $wormId );
			$row = $result->fetchArray();
			
			// Set name if given
			if( isset( $_GET[ "name" ] ) ) {
				$row[ "name" ] = $_GET[ "name" ];
			}
			
			// Add item if set
			if( isset( $_GET[ "item" ] ) )
			{
				$item = $_GET[ "item" ];
				
				$row[ $item . "Count" ] = $row[ $item . "Count" ] + 1;
				
				$updates += 1;
				$db->exec( "
					UPDATE worms
					SET
						" . $item . "Count=" . $row[ $item . "Count" ] . "
					WHERE
						idNum=" . $wormId . ";"
				);
			}
			
			// Add movement if given
			if( isset( $_GET[ "movement" ] ) )
			{
				// value to add to worm movement
				$movement = $_GET[ "movement" ];
				
				// if current movement is negative, reset to zero
				if ( $row[ "movement" ] < 0 ) { $row[ "movement" ] = 0; }
				
				// add
				$row[ "movement" ] += $movement;
				
				// if new movement is negative, reset to zero
				if ( $row[ "movement" ] < 0 ) { $row[ "movement" ] = 0; }
			}
			
			// Add health if given
			if( isset( $_GET[ "health" ] ) )
			{
				// value to add to worm health
				$health = $_GET[ "health" ];
				
				// if current health falls outside range, fix it
				if ( $row[ "health" ] < 0 ) { $row[ "health" ] = 0; }
				elseif ( $row[ "health" ] >= 4 ) { $row[ "health" ] = 4; }
				
				// add
				$row[ "health" ] = $row[ "health" ] + $health;
				
				// if new health falls outside range, fix it
				if ( $row[ "health" ] < 0 ) { $row[ "health" ] = 0; }
				elseif ( $row[ "health" ] >= 4 ) { $row[ "health" ] = 4; }
			}
			
			// UPDATE WORM ROW
			// breaks if i remove it from the "if" statement
			if( isset( $_GET[ "wormId" ] ) )
			{	
				$updates += 1;
				$db->exec( "
					UPDATE worms
					SET
						movement=" . $row[ "movement" ] . "
					WHERE
						idNum=" . $wormId . ";"
				);
				
				$updates += 1;
				$db->exec( "
					UPDATE worms
					SET
						health=" . $row[ "health" ] . "
					WHERE
						idNum=" . $wormId . ";"
				);
			}
			
			// this next bit doesn't work and idk why
			// intended to replace the previous updates section
			/*
			$updates += 1;
			$db->exec( "
				UPDATE worms
				SET
					name=" . $row[ "name" ] . ",
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
		
		// OUTPUT WORM DATA FOR ALL WORMS
		// get the table data (all rows/columns)
		$queries += 1;
		$result = $db->query( "SELECT * FROM worms" );
		$output = '';
		// for each row in the worms table
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			// add the data from the row as a string separated by commas
			$output = $output .
				$row[ "idNum" ] . "," . $row[ "name" ] . "," . $row[ "movement" ] . "," . $row[ "health" ] . "," .
				$row[ "appleCount" ] . "," . $row[ "drinkCount" ] . "," . $row[ "poisonCount" ] . "," . $row[ "healCount" ] . ",";
		}
		$output = rtrim($output, ",");
		echo $output;
		
		// INSERT ACCESS DATA ROW FOR CURRENT SESSION
		// this breaks loading and idk why
		$updates += 1;
		$db->exec( "
			INSERT INTO accessData 
			(
				date,
				queries,
				updates
			) 
			VALUES
			(
				" . $time . ",
				" . $queries . ",
				" . $updates . "
			)"
		);
	}
?>