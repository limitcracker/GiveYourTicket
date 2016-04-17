<?php

require("phpsqlajax_dbinfo.php"); 

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node); 

// Opens a connection to a MySQL server

$connection=mysql_connect ($host, $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());} 

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
} 

// Select all the rows in the markers table
date_default_timezone_set('Europe/Athens');
//$currentDate = date('Y-m-d H:i:s');

$query = sprintf("SELECT * FROM `tickets` WHERE (CURDATE() - date_in < 1) AND (TIMEDIFF(CURTIME(),time_in) < 1.5*60*60)");
//$query = sprintf("SELECT * FROM `ticket` WHERE DATEDIFF(CURDATE(),print_date) < 2 OR TIMEDIFF(CURTIME(),print_time) < 12)");
	
$result = mysql_query($query);
if (!$result) {  
  die('Invalid query: ' . mysql_error());
} 

header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){  
  // ADD TO XML DOCUMENT NODE  
  $node = $dom->createElement("marker");  
  $newnode = $parnode->appendChild($node);   

  $newnode->setAttribute("lat", $row['lat']);  
  $newnode->setAttribute("lng", $row['lng']);  
  $newnode->setAttribute("type", $row['type']);
} 

echo $dom->saveXML();

?>
