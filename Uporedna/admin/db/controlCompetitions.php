<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

if ($source_id > 0 ) {
    $sql = 'SELECT s.name AS source_name, sc.name competition,c.name mozzart_competition, cc.id conn_id, s.id source_id
FROM init_competition c, src_competition sc, conn_competition cc, import_source s
WHERE c.id = cc.init_competition_id
AND sc.id = cc.src_competition_id
AND sc.source_id = s.id
and sc.source_id = '.$source_id.'
ORDER BY 1,2';

} else {

    $sql = 'SELECT s.name AS source_name, sc.name competition,c.name mozzart_competition, cc.id conn_id, s.id source_id
FROM init_competition c, src_competition sc, conn_competition cc, import_source s
WHERE c.id = cc.init_competition_id
AND sc.id = cc.src_competition_id
AND sc.source_id = s.id
ORDER BY 1,2

';
};
$AllConnCmp = $conn -> prepare($sql);

$AllConnCmp -> execute();
$resultACC = $AllConnCmp -> fetchAll ( PDO::FETCH_ASSOC);



$conn = null;


// print_r($ShowCmp);
?>