<?php
	require("phpsqlajax_dbinfo.php");

	$dbc = mysqli_connect($host, $username, $password, $database)
				or die('Error connecting to MySQL server.');
			
	$date = $_GET['validation_date_year'] . "-" . $_GET['validation_date_month'] . "-" . $_GET['validation_date_day'];
	
	$query =  sprintf(
		"INSERT INTO tickets VALUES (%d, %f, %f, %d, '%s', '%s', %d)"
		,(int)$_GET['code']
		,(float)$_GET['latitude']
		,(float)$_GET['longitude']
		,mysql_real_escape_string($_GET['ticket_type'])
		,mysql_real_escape_string($date)
		,mysql_real_escape_string($_GET['validation_time'])
		,1
	);
		
	mysqli_query($dbc, $query) or die(mysqli_error($dbc));
	//mysqli_free_result($result);
		
	mysqli_close($dbc);
	
	header('Location: find_ticket.html');
?>