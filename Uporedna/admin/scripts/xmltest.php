<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.3.2016
 * Time: 12:42
 */

function get_matches($url)
{

    $curr_url = $url;
    $xmlMatchData = file_get_contents($curr_url);
    $curr_data = json_decode($xmlMatchData);
    $data = array();

    foreach ($curr_data->Matches as $match) {
        $home_team_name = $match->HomeCompetitorName;
        $home_team_id = strtolower(str_replace(" ", "_", $home_team_name));
        $visitor_team_name = $match->AwayCompetitorName;
        $visitor_team_id = strtolower(str_replace(" ", "_", $visitor_team_name));
        $match_code = $match->Id;
        $match_start_time = $match->MatchStartDate;


        echo $match_start_time . " - " . $match_code . " - " . $home_team_name . " - " . $home_team_id . " - " . $visitor_team_name . " - " . $visitor_team_id . "<br>";
    }
}