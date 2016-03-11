<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

if ($source_id > 0 ) {
    $sql = "select cs.id as id, concat(isg.game_name,' ', isg.subgame_name) as mozz_subgame, case when ss.game <> ''  then concat(ss.game,' ',ss.subgame) else ss.subgame end as src_subgame, s.name AS source_name
from conn_subgame cs, src_subgames ss, init_subgame isg, import_source s
where cs.src_subgame_id = ss.id
and cs.subgame_id = isg.id
AND ss.source_id = s.id
and ss.source_id = $source_id
order by ss.source_id, isg.mozzart_game_id, isg.mozzart_subgame_id";

} else {

    $sql = 'select cs.id as id, concat(isg.game_name,\' \', isg.subgame_name) as mozz_subgame, case when ss.game <> \'\'  then concat(ss.game,\' \',ss.subgame) else ss.subgame end as src_subgame, s.name AS source_name
from conn_subgame cs, src_subgames ss, init_subgame isg, import_source s
where cs.src_subgame_id = ss.id
and cs.subgame_id = isg.id
AND ss.source_id = s.id
order by ss.source_id, isg.mozzart_game_id, isg.mozzart_subgame_id
';
};

$AllConnSubg = $conn -> prepare($sql);

$AllConnSubg-> execute();
$resultSBG = $AllConnSubg -> fetchAll ( PDO::FETCH_ASSOC);



$conn = null;


// print_r($ShowCmp);
?>