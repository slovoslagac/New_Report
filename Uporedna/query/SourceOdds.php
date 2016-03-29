<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlNewPDO.php')));


$sql = 'SELECT co.telebet_current_id AS id, so.value AS odd, so.handicap AS handicap, so.source_id AS source, ins.mozzart_game_id AS game_id, ins.mozzart_subgame_id AS subgame_id
FROM src_current_odds so, conn_match cm, init_current_offer co, conn_subgame cs, init_subgame ins
WHERE so.src_match_id = cm.src_match_id
AND cm.init_match_id = co.event_id
AND so.src_subgame_id = cs.src_subgame_id
AND cs.subgame_id = ins.id
and cm.home_visitor = 0
AND co.list_type_id = 4
AND co.telebet_current_id IN ';

$sql1 = 'select *from init_current_odds
where level = 1
and id IN';

$sql2 = 'select *from init_current_odds
where level = 0
and id IN';

$sql3 = 'select telebet_current_id as code, special_type as value
from init_current_offer
where list_type_id = 4
and telebet_current_id IN
';

$selectBusinessUnites = "select id, name from init_business_units";

if($currency_id <> "") {$selectCurrencies = "select mid_value from init_currencies where currency_id = $currency_id and date_format(date(validity_date),'%d.%m.%Y') = '$currency_date'";}

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


$sql3 .= '(' . $tm . ') ';



$sql1 .= '(' . $tm . ') ';
//echo $sql;



$Odds = $conn->prepare($sql);
$FavOdds = $conn->prepare($sql1);
$StartOdds = $conn->prepare($sql2);
$tmpOdds = $conn->prepare($sql3);
$tmpBU = $conn->prepare($selectBusinessUnites);
$tmpCu = $conn->prepare($selectCurrencies);

$Odds->execute();
$SourceOdds = $Odds->fetchAll(PDO::FETCH_ASSOC);


$FavOdds->execute();
$FavoriteOdds = $FavOdds->fetchAll(PDO::FETCH_ASSOC);

$StartOdds->execute();
$StartingOdds = $StartOdds->fetchAll(PDO::FETCH_ASSOC);

$tmpOdds->execute();
$oddtype = array();
while($row = $tmpOdds->fetch(PDO::FETCH_ASSOC)){
    $oddtype[$row['code']] = $row['value'];
}

$tmpBU->execute();
$businessUnits = array();
while($row = $tmpBU ->fetch(PDO::FETCH_ASSOC)){
    $businessUnits[$row['id']] = $row['name'];
}

$tmpCu ->execute();
$currencyValue = $tmpCu->fetchColumn();



$conn = null;




//print_r($oddtype);

// foreach ($oddtype as $d) {
// 	print_r($d)."<br>";
//     echo($d)."<br>";
// }

?>