<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));


if ($cmp == 0) {
    $sql = "SELECT DISTINCT
  ic.id AS competition_id,
  ic.name AS competition_name
FROM
init_competition AS ic
WHERE ic.id IN (SELECT DISTINCT competition_id FROM init_match WHERE start_time > now() - INTERVAL '4' DAY AND start_time < now() + INTERVAL '30' DAY)
AND ic.id NOT IN (SELECT DISTINCT cc.init_competition_id
FROM conn_competition cc, src_competition sc
WHERE cc.src_competition_id = sc.id
AND sc.source_id = $source_id)
union ALL
SELECT DISTINCT
  ic1.id AS competition_id,
  ic1.name AS competition_name
FROM
init_competition ic1
where id = 9999999
ORDER BY 2";
} else if ($source_id = 11) {
    $sql = "SELECT DISTINCT
  ic.id AS competition_id,
  ic.name AS competition_name
FROM
init_competition AS ic
union ALL
SELECT DISTINCT
  ic1.id AS competition_id,
  ic1.name AS competition_name
FROM
init_competition ic1
where id = 9999999
ORDER BY 2";
}
else {
    $sql = "SELECT DISTINCT
  ic.id AS competition_id,
  ic.name AS competition_name
FROM
init_competition AS ic
WHERE ic.id IN (SELECT DISTINCT competition_id FROM init_match WHERE start_time > now() - INTERVAL '4' DAY AND start_time < now() + INTERVAL '30' DAY)
union ALL
SELECT DISTINCT
  ic1.id AS competition_id,
  ic1.name AS competition_name
FROM
init_competition ic1
where id = 9999999
ORDER BY 2";
}




$MozCmp = $conn -> prepare($sql);
$MozCmp -> execute();
$resultMZCMP = $MozCmp -> fetchAll ( PDO::FETCH_ASSOC);



?>