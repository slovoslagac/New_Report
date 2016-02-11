<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

$NonMatchCmp = $conn -> prepare('select
  c.id as cmp_id,
  c.name as cmp_name,
  s.id as src_id,
  s.name as src_name
from
  src_competition as c
inner join
  import_source as s
on
  c.source_id=s.id
where c.id not in (select src_competition_id from conn_competition)
and s.id = '.$source_id.'
order by src_name, cmp_name asc
limit 10
');

$NonMatchCmp -> execute();
$resultNMCMP = $NonMatchCmp -> fetchAll ( PDO::FETCH_ASSOC);



$conn = null;


// print_r($ShowCmp);
?>