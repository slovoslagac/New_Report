<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));

$MozCmp = $conn -> prepare("select distinct
  ic.id as competition_id,
  ic.name as competition_name
from
init_competition as ic
where ic.id in (select distinct competition_id from init_match where start_time > now() - interval \"4\" day and start_time < now() + interval \"10\" day)
and ic.id not in (select init_competition_id from conn_competition where src_competition_id in (select id from src_competition where source_id = '.$source_id.'))
order by 2");
$MozCmp -> execute();
$resultMZCMP = $MozCmp -> fetchAll ( PDO::FETCH_ASSOC);



?>