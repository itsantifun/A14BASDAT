<?php

	$conn_string = "host=localhost port=5432 dbname=sisidang user=postgres password=flashbang";
	$conn = pg_connect($conn_string);
	
	//echo "test\n";
	// Check connection
	if (!$conn) {
		die("Connection failed: " . pg_last_error());
	}

	//$sql = "SET search_path TO sisidang";
	//$result = pg_query($conn, $sql);
	if (!$conn) {
		die("Error in SQL query: " . pg_last_error());
	} else {
		
	} 
	
	return $conn;

?>
