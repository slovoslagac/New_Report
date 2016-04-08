<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 6.4.2016
 * Time: 11:45
 */

$url = 'https://www.soccerbet.rs/api/Filter/GetFilterConfiguration?TimeFilterId=7';
$source = 10;
$curr_match_data = array();
$curr_match_odds = array();
$sql;

function get_matches($url, $cmp_id, $cmp_name)
{

    $curr_url = $url;
    $xmlMatchData = file_get_contents($curr_url);
    $curr_data = json_decode($xmlMatchData);
    global $curr_match_data;
    $replace_strings = array(" ","(",")",".");
    $new_strings = array("_","","","");

    foreach ($curr_data->Matches as $match) {
        $tmp_data = array();
        $home_team_name = $match->HomeCompetitorName;
        $home_team_id = strtolower(str_replace($replace_strings, $new_strings, $home_team_name));
        $visitor_team_name = $match->AwayCompetitorName;
        $visitor_team_id = strtolower(str_replace($replace_strings, $new_strings, $visitor_team_name));
        $match_code = $match->Id;
        $match_start_time = $match->MatchStartDate;
        $tmp_data['time'] = $match_start_time;
        $tmp_data['code'] = $match_code;
        $tmp_data['home_team'] = $home_team_name;
        $tmp_data['home_team_id'] = $home_team_id;
        $tmp_data['visitor_team'] = $visitor_team_name;
        $tmp_data['visitor_team_id'] = $visitor_team_id;
        $tmp_data['cmp_id'] = $cmp_id;
        $tmp_data['cmp_name'] = $cmp_name;
        $curr_match_data[] = $tmp_data;
    }


}

function get_match_odds($code)
{

    $curr_url = "https://www.soccerbet.rs/api/Bet/GetAllMatchBets?Id=$code";
    $xmlMatchData = file_get_contents($curr_url);
    $curr_data = json_decode($xmlMatchData);
    global $curr_match_odds;
    foreach ($curr_data as $cd) {
        foreach ($cd->BetGames as $bgm) {
            foreach ($bgm->BetGameOutcomes as $bgo) {
                $tmp_odds = array();
                $tmp_odds['bet_game'] = $bgo->Bet->BetGameName;
                $tmp_odds['bet_subgame'] = $bgo->Bet->BetGameOutcomeName;
                $tmp_odds['odd_value'] = $bgo->Bet->BetOdds;
                $tmp_odds['code'] = $code;
                $curr_match_odds[] = $tmp_odds;

            }
        }
    }



}

echo date('d.m.Y H:i:s')." Skidam takmičenja <br>";

$xmldata = file_get_contents($url);
$data = json_decode($xmldata);

$connUrl = join(DIRECTORY_SEPARATOR, array('..','conn', 'mysqlAdminPDO.php'));
include($connUrl);

$trncSql ='truncate ulaz_new; truncate ulaz_odds;';

$delete = $conn -> prepare($trncSql);
$delete -> execute();

$conn = null;


$competitions = array();

foreach ($data->SportVMs as $sports) {
    if ($sports->Id == 1) {
        foreach ($sports->CountryVMs as $cmpc) {
            foreach ($cmpc->CompetitionVMs as $cmp) {
                $tmp = array();
                $tmp ['cmp_id'] = $cmp->Id;
                $tmp['cmp_name'] = $cmp->Name;

                array_push($competitions,$tmp);
            }
        }
    }
}

echo date('d.m.Y H:i:s')." Skidam mečeve <br>";

foreach($competitions as $c) {
    $curr_cmp_id = $c['cmp_id'];
    $curr_cmp_name =  $c['cmp_name'];
    $curr_url = "https://www.soccerbet.rs/api/Match/GetFilteredScheduledMatches?ItemsPerPage=50&CurrentPage=1&SortOrderFilterId=1&TimeFilterId=7&CompetitionIds=$curr_cmp_id";
    get_matches($curr_url,$curr_cmp_id,$curr_cmp_name);

}

$numMatches = sizeof($curr_match_data);

echo date('d.m.Y H:i:s')." Skinuo sam $numMatches mečeva <br>";

echo date('d.m.Y H:i:s')." Skidam kvote <br>";

foreach ($curr_match_data as $m) {
//    print_r($m);
    $matchId = $m['code'];
    get_match_odds($matchId);
//    echo "<br />";
}



$tmpOdds = fopen("Odds.txt", "w");

foreach ($curr_match_odds as $d) {

    $betGame = $d['bet_game'];
    $betSubgame = $d['bet_subgame'];
    $OddValue = $d['odd_value'];
    $code = $d['code'];


    fwrite($tmpOdds, $code . ";" . $OddValue . ";;" . $betSubgame . ";" . $betGame . ";" . $source . "\n");


}

fclose($tmpOdds);






//Upis mečeva u bazu

$tmpMatches = fopen("Matches.txt", "w");

foreach ($curr_match_data as $d) {

    $homeTeam = $d['home_team'];
    $homeTeamId = $d['home_team_id'];
    $visitorTeam = $d['visitor_team'];
    $visitorTeamId = $d['visitor_team_id'];
    $matchTime = $d['time'];
    $cmpName = $d['cmp_name'];
    $cmpId = $d['cmp_id'];
    $matchName = $d['home_team']." - ".$d['visitor_team'];
    $matchId = $d['code'];

    fwrite($tmpMatches, $matchTime. ";" .$cmpId. ";" .$cmpName. ";" .$matchId. ";" .$matchName. ";" .$homeTeamId. ";" .$homeTeam. ";" .$visitorTeamId. ";" .$visitorTeam. ";" . $source . "\n");

}

fclose($tmpMatches);

echo date('d.m.Y H:i:s')." Upisujem mečeve <br>";

$db = mysqli_init();
$db->real_connect("192.168.180.124", "proske", "proske1989", "Uporedna_new");

$db->query("LOAD DATA LOCAL INFILE 'Matches.txt' INTO TABLE ulaz_new FIELDS TERMINATED BY ';' SET timestamp = CURRENT_TIMESTAMP ;");

echo date('d.m.Y H:i:s')." Upisujem kvote <br>";

$db = mysqli_init();
$db->real_connect("192.168.180.124", "proske", "proske1989", "Uporedna_new");

$db->query("LOAD DATA LOCAL INFILE 'Odds.txt' INTO TABLE ulaz_odds FIELDS TERMINATED BY ';' SET timestamp = CURRENT_TIMESTAMP ;");

echo date('d.m.Y H:i:s')." Gotovo <br>";

