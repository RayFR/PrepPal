<?php
// Student & ID: sazidun sami hossain mohammed (240160816)
// Role: database + backend
// File: connectdb.php
// Description: Connects the database with the backend logic.
// Date: Nov 2025
$db_host = 'localhost';
$db_name = 'preppal';
$username = 'root';
$password = '';

try {
	$db = new PDO("mysql:dbname=$db_name;host=$db_host", $username, $password); 
	#$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
	echo("Failed to connect to the database.<br>");
	echo($ex->getMessage());
	exit;
}
?>