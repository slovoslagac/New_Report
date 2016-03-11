<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));


$sql = "select id, game, subgame
from src_subgames
where id not in ( select src_subgame_id from conn_subgame)
and source_id = $source_id
order by 2, 3
";

//AND sm.start_time > now() - INTERVAL "4" DAY
//AND sm.start_time < now() + INTERVAL "8" DAY

// echo $sql;


$FindSubgames = $conn->prepare($sql);
$FindSubgames->execute();
$ShowSubgames = $FindSubgames->fetchAll(PDO::FETCH_ASSOC);


$conn = null;


// print_r($ShowSubgames);
?>