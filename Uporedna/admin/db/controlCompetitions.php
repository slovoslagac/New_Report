<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

$AllConnCmp = $conn -> prepare('select s.name as source_name, sc.name competition,c.name mozzart_competition, cc.id conn_id, s.id source_id
from init_competition c, src_competition sc, conn_competition cc, import_source s
where c.id = cc.init_competition_id
and sc.id = cc.src_competition_id
and sc.source_id = s.id
order by 1,2

');

$AllConnCmp -> execute();
$resultACC = $AllConnCmp -> fetchAll ( PDO::FETCH_ASSOC);



$conn = null;


// print_r($ShowCmp);
?>