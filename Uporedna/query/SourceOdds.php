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
$sql1 = 'select *from init_current_odds
where level = 1
and id IN';

$sql2 = 'select *from init_current_odds
where level = 0
and id IN';

$tm = join(',', $tmp_matches);
$tg = join(',', $tmp_games);
$tsg = join(',', $tmp_subgames);

$sql .= '(' . $tm . ') ';
$sql .= ' and ins.mozzart_game_id in (' . $tg . ')';
$sql .= ' and ins.mozzart_subgame_id in (' . $tsg . ')';
$sql .= ' order by 1,4, 5,6';

$sql2 .= '(' . $tm . ') ';
$sql2 .= ' and game_id in (' . $tg . ')';
$sql2 .= ' and subgame_id in (' . $tsg . ')';
$sql2 .= ' order by 1,2, 3';



$sql1 .= '(' . $tm . ') ';
//echo $sql;


$Odds = $conn->prepare($sql);
$FavOdds = $conn->prepare($sql1);
$StartOdds = $conn->prepare($sql2);

$Odds->execute();
$SourceOdds = $Odds->fetchAll(PDO::FETCH_ASSOC);


$FavOdds->execute();
$FavoriteOdds = $FavOdds->fetchAll(PDO::FETCH_ASSOC);

$StartOdds->execute();
$StartingOdds = $StartOdds->fetchAll(PDO::FETCH_ASSOC);
$conn = null;
// print_r($SourceOdds);

// foreach ($ShowMatches as $d) {
// 	print_r($d)."<br>";
// }

?>