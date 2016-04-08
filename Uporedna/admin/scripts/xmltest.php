<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.3.2016
 * Time: 12:42
 */

function get_matches($url, $cmp_id, $cmp_name, $conn,$source)
{

    $curr_url = $url;
    $xmlMatchData = file_get_contents($curr_url);
    $curr_data = json_decode($xmlMatchData);
    $curr_match_data = array();
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


    foreach ($curr_match_data as $m) {
        print_r($m);
        echo "<br />";
    }

    $connUrl = join(DIRECTORY_SEPARATOR, array('..', 'conn', 'mysqlAdminPDO.php'));
    include($connUrl);

    foreach ($curr_match_data as $d) {
        $homeTeam = $d['home_team'];
        $homeTeamId = $d['home_team_id'];
        $visitorTeam = $d['visitor_team'];
        $visitorTeamId = $d['visitor_team_id'];
        $matchTime = $d['time'];
        $cmpName = $cmp_name;
        $cmpId = $cmp_id;
        $matchName = $d['home_team']." - ".$d['visitor_team'];
        $matchId = $d['code'];

        $sql = 'INSERT INTO ulaz_new (starttime,dom, dom_id, gost, gost_id, liga, liga_id, source, utakmica, utk_id)
        VALUES(:srcMatchTime,:srcHomeTeam, :srcHomeTeamId,:srcVisitorTeam, :srcVisitorTeamId, :srcLiga, :srcLigaId, :srcSourceId, :srcMatchName, :srcMatchId);';

        $parameters = array(
            'srcHomeTeam' => $homeTeam,
            'srcMatchTime' => $matchTime,
            'srcHomeTeamId' => $homeTeamId,
            'srcVisitorTeam' => $visitorTeam,
            'srcVisitorTeamId' => $visitorTeamId,
            'srcLiga' => $cmpName,
            'srcLigaId' => $cmpId,
            'srcSourceId' => $source,
            'srcMatchName' => $matchName,
            'srcMatchId' => $matchId
        );

        $prepare = $conn->prepare($sql);
        $prepare->execute($parameters);

        get_match_odds($matchId, $source);
    }

    $conn = null;

}

