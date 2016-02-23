<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 23.2.2016
 * Time: 15:21
 */

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
AND co.telebet_current_id IN (2139351)
and ins.mozzart_game_id in (1,3,141)
and ins.mozzart_subgame_id in (1,3,4,15)
order by 1,4, 5,6';

$statement = $conn->prepare($sql);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
//$json = json_encode($data);


//echo $json;

echo $data;