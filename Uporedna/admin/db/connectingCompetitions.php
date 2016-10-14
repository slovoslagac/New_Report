<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

if ($cmp_src == 0) {
    $sql = "select
  c.id as cmp_id,
  c.name as cmp_name,
  s.id as src_id,
  s.name as src_name,
  c.sport_id as sport_id
from
  src_competition as c
inner join
  import_source as s
on
  c.source_id=s.id
where s.id = $source_id
and c.id not in (select src_competition_id from conn_competition)
order by sport_id, src_name, cmp_name asc";
} else {
    $sql ="select
  c.id as cmp_id,
  c.name as cmp_name,
  s.id as src_id,
  s.name as src_name,
  c.sport_id as sport_id
from
  src_competition as c
inner join
  import_source as s
on
  c.source_id=s.id
where s.id = $source_id
order by sport_id, src_name, cmp_name asc";
}
$NonMatchCmp = $conn -> prepare($sql);

$NonMatchCmp -> execute();
$resultNMCMP = $NonMatchCmp -> fetchAll ( PDO::FETCH_ASSOC);


//and c.id not in (select src_competition_id from conn_competition)
$conn = null;


// print_r($ShowCmp);
?>