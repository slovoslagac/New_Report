<?php
$servername = "192.168.0.122";
$username = "mozzart";
$password = "mozzart2011";

try {
	$conn = new PDO("mysql:host=$servername;dbname=kvote", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "Connected successfully";
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}
?>