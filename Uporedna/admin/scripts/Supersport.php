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

$url = 'https://www.supersport.hr/tecajna/v1/380901_1466757802.json';
$source = 10;
$curr_match_data = array();
$curr_match_odds = array();
$sql;


    $curr_url = $url;
    $xmlMatchData = file_get_contents($curr_url);
    $curr_data = json_decode($xmlMatchData);
    print $curr_data->;

?>


