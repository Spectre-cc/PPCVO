<?php
	// Create Connection
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	// Check Connection
	if(!$conn){
		// Connection Failed
		die("Connection Failed: ".mysqli_connect_error());
	}