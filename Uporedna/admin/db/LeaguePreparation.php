<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

$resultLSM = array();
$resultLMR = array();

$cmp ="select distinct ic.name mozzart, ic.id id
from src_competition sc, conn_competition cc, init_competition ic
where cc.src_competition_id = sc.id
and cc.init_competition_id = ic.id
and sc.source_id = 11
order by 1
";

$leagues = $conn -> prepare($cmp);
$leagues -> execute();
$resultL = $leagues -> fetchAll(PDO::FETCH_ASSOC);

$sqlSeasons = "select id, name
from src_seasons
order by name desc
";

$seasons = $conn ->prepare($sqlSeasons);
$seasons -> execute();
$resultS = $seasons -> fetchAll(PDO::FETCH_ASSOC);


if ($competition_id > 0 ) {
    $season_array = join(',', $season_id);
//    print_r($season_array);
    $sql = "select DATE_FORMAT(sm.start_time, '%m/%d/%Y') date, DATE_FORMAT(sm.start_time, '%H.%i') time,ith.mozzart hometeam, ita.mozzart awayteam, sm.round_id as round, ic.mozzart competition, ss.name as season
from src_match sm, init_competition ic, conn_competition cc, init_team ith, conn_team cth, init_team ita, conn_team cta, src_seasons ss
where sm.src_competition_id = cc.src_competition_id
and cc.init_competition_id = ic.id
and sm.src_home_team_id = cth.src_team_id
and cth.init_team_id = ith.id
and sm.src_visitor_team_id = cta.src_team_id
and cta.init_team_id = ita.id
and sm.season_id = ss.id
and ic.id = $competition_id
and sm.source_id = $source_id
and sm.season_id in ($season_array)
";

//    $sql = "select DATE_FORMAT(sm.start_time, '%m/%d/%Y') date, DATE_FORMAT(sm.start_time, '%H.%i') time,ith.mozzart hometeam, ita.mozzart awayteam, sm.round_id as round, ic.mozzart competition, ss.name as season from src_match sm, init_competition ic, conn_competition cc, init_team ith, conn_team cth, init_team ita, conn_team cta, src_seasons ss where sm.src_competition_id = cc.src_competition_id and cc.init_competition_id = ic.id and sm.src_home_team_id = cth.src_team_id and cth.init_team_id = ith.id and sm.src_visitor_team_id = cta.src_team_id and cta.init_team_id = ita.id and sm.season_id = ss.id and ic.id = 275 and sm.source_id = 11 and sm.season_id in (6,13) "
;

//    echo $sql;
;
    $sqlResult = "select DATE_FORMAT(sm.start_time, '%m/%d/%Y') date, DATE_FORMAT(sm.start_time, '%H.%i') time,ith.mozzart hometeam, ita.mozzart awayteam, sm.round_id as round, smr.value as result, smr.result_type_id as resulttype
from src_match sm, conn_competition cc, init_team ith, conn_team cth, init_team ita, conn_team cta, src_match_result smr
where sm.src_competition_id = cc.src_competition_id
and sm.id = smr.match_id
and sm.src_home_team_id = cth.src_team_id
and cth.init_team_id = ith.id
and sm.src_visitor_team_id = cta.src_team_id
and cta.init_team_id = ita.id
and cc.init_competition_id = $competition_id
and sm.source_id = $source_id
and sm.season_id in ($season_array)
";


$LeagueSeason = $conn -> prepare($sql);
$LeagueSeason  -> execute();
$resultLSM = $LeagueSeason  -> fetchAll ( PDO::FETCH_ASSOC);

$LeagueResult = $conn -> prepare($sqlResult);
$LeagueResult  -> execute();
$resultLMR = $LeagueResult -> fetchAll ( PDO::FETCH_ASSOC);

}

$conn = null;


// print_r($ShowCmp);
?>