<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));


$sql = 'select distinct
  im.event_id as mozz_match_id,
  im.competition_id as mozz_cmp_id,
  ith.name as mozz_home_team_name,
  ith.id as mozz_home_team_id,
  itv.name as mozz_visitor_team_name,
  itv.id as mozz_visitor_team_id
from
  init_match as im
inner join
  init_team as ith
on
  (im.home_team_id = ith.id)
inner join
  init_team as itv
on
  (im.visitor_team_id = itv.id)
where im.start_time > now() - interval "4" day
and im.start_time < now() + interval "8" day
and im.competition_id in (select init_competition_id from conn_competition c)
order by 2,3
';

// echo $sql;


$MozzMatch = $conn->prepare($sql);
$MozzMatch->execute();
$ShowMozzMatch = $MozzMatch->fetchAll(PDO::FETCH_ASSOC);


$conn = null;


// print_r($ShowMatch);
?>