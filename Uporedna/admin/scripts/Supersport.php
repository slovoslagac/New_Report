<!--<!DOCTYPE html>-->
<!---->
<!--<head>-->
<!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<!--</head>-->
<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.6.2016
 * Time: 10:26
 */

$url = 'http://localhost/test.json';
$source = 10;
$curr_match_data = array();
$curr_match_odds = array();
$sql;


$json = file_get_contents($url);
$json_data = json_decode($json);

foreach ($json_data as $dat) {

    print $dat;


}




?>


