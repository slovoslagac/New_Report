<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 15.6.2018.
 * Time: 11:56
 */

$date = new DateTime();
$start_new = $date->format("Y-m-d");
$end_date = new DateTime();
$end_date->modify('+ 2 day');
$end_new = $end_date->format("Y-m-d");

//echo "$start_new - $end_new <br>";

$url = "https://sport.efortuna.ro/en/pariuri-fotbal";
$json = file_get_contents($url);
$json_decoded = json_decode($json);
$allmatches = array();

print_r($json);