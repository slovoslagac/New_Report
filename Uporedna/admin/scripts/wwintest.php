<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.3.2016
 * Time: 12:42
 */

$url = 'https://wwin.com/sports/';

function get_matches($url)
{

    $curr_url = $url;
    $xmlMatchData = file_get_contents($curr_url);
    $curr_data = json_decode($xmlMatchData);



//        echo $match_start_time . " - " . $match_code . " - " . $home_team_name . " - " . $home_team_id . " - " . $visitor_team_name . " - " . $visitor_team_id . "<br>";
    echo $xmlMatchData;
}

get_matches($url);