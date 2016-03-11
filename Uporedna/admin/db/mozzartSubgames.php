<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));


$sql ="select id, game_name, subgame_name
from init_subgame
where id not in (select cs.subgame_id from conn_subgame cs, src_subgames ss where cs.src_subgame_id = ss.id and ss.source_id =$source_id)
order by mozzart_game_id, mozzart_subgame_id"
    ;

$MozSubgame = $conn -> prepare($sql);


$MozSubgame -> execute();
$resultMSBG = $MozSubgame -> fetchAll ( PDO::FETCH_ASSOC);


//print_r($resultMSBG);
?>