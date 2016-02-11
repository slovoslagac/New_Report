<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

$NonMatchCmp = $conn -> prepare('select s.name, sc.name,c.name, cc.id
from init_competition c, src_competition sc, conn_competition cc, import_source s
where c.id = cc.init_competition_id
and sc.id = cc.src_competition_id
and sc.source_id = s.id
order by 1,2
limit 20
');

$NonMatchCmp -> execute();
$resultNMCMP = $NonMatchCmp -> fetchAll ( PDO::FETCH_ASSOC);



$conn = null;


// print_r($ShowCmp);
?>