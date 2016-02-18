<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));

$MozCmp = $conn -> prepare('SELECT DISTINCT
  ic.id AS competition_id,
  ic.name AS competition_name
FROM
init_competition AS ic
WHERE ic.id IN (SELECT DISTINCT competition_id FROM init_match WHERE start_time > now() - INTERVAL "4" DAY AND start_time < now() + INTERVAL "8" DAY)
AND ic.id NOT IN (SELECT DISTINCT cc.init_competition_id
FROM conn_competition cc, src_competition sc
WHERE cc.src_competition_id = sc.id
AND sc.source_id = 2)
ORDER BY 2');
$MozCmp -> execute();
$resultMZCMP = $MozCmp -> fetchAll ( PDO::FETCH_ASSOC);



?>