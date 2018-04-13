<?php
header('Content-Type: charset=UTF-8');

$servername = "192.168.0.170";
$username = "proske";
$password = "proske21";

$conn = oci_connect($username, $password,'192.168.0.170:1521/csdb');
if (!$conn) {
	$e = oci_error();
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}


?>