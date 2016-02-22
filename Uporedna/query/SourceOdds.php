<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlNewPDO.php')));


$sql = 'SELECT co.telebet_current_id AS id, so.value AS odd, so.handicap AS handicap, i.source_id AS source, ins.mozzart_game_id AS game_id, ins.mozzart_subgame_id AS subgame_id
FROM src_odds so, conn_match cm, init_current_offer co, import i, conn_subgame cs, init_subgame ins
WHERE so.src_match_id = cm.src_match_id
AND cm.init_match_id = co.event_id
AND so.offer = 1
AND so.src_subgame_id = cs.src_subgame_id
AND cs.subgame_id = ins.id
AND so.import_id = i.id
AND co.list_type_id = 4
AND co.telebet_current_id IN ';
//$sql1 = 'SELECT co.telebet_current_id AS id, CASE WHEN so.value > so1.value THEN so1.value ELSE so.value END AS odd, so2.value as odd3p, i.id
//FROM init_current_offer co, conn_match cm, src_odds so, import i, conn_subgame cs, conn_subgame cs1, src_odds so1, conn_subgame cs2, src_odds so2
//WHERE co.event_id = cm.init_match_id
//AND cm.src_match_id = so.src_match_id
//AND so.offer = 1
//AND so.import_id = i.id
//AND cs.src_subgame_id = so.src_subgame_id
//AND cs.subgame_id IN (1)
//AND cm.src_match_id = so1.src_match_id
//AND cs1.src_subgame_id = so1.src_subgame_id
//AND cs1.subgame_id IN (3)
//AND so.import_id = so2.import_id
//AND cm.src_match_id = so2.src_match_id
//AND cs2.src_subgame_id = so2.src_subgame_id
//AND cs2.subgame_id IN (10)
//AND so.import_id = so1.import_id
//AND co.telebet_current_id IN';

$tm = join(',', $tmp_matches);
$tg = join(',', $tmp_games);
$tsg = join(',', $tmp_subgames);

$sql .= '(' . $tm . ') ';
//$sql1 .= '(' . $tm . ') ';
$sql .= ' and ins.mozzart_game_id in (' . $tg . ')';
$sql .= ' and ins.mozzart_subgame_id in (' . $tsg . ')';
$sql .= ' order by 1,4, 5,6';

//echo $sql;


$Odds = $conn->prepare($sql);
//$FavOdds = $conn->prepare($sql1);

$Odds->execute();
$SourceOdds = $Odds->fetchAll(PDO::FETCH_ASSOC);


//$FavOdds->execute();
//$FavoriteOdds = $FavOdds->fetchAll(PDO::FETCH_ASSOC);
$conn = null;
// print_r($SourceOdds);

// foreach ($ShowMatches as $d) {
// 	print_r($d)."<br>";
// }

?>