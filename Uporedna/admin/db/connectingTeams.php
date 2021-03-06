<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));


$sql = 'select distinct a.competition_name, a.team_id, a.team_name, a.competition_id, a.sport_id
from
(
select distinct icn.country competition_name, sm.src_home_team_id team_id, st.name team_name, icn.id competition_id, sm.sport_id
from src_match sm, conn_competition cc, init_competition ic, init_country icn, src_team st
where st.id not in (select src_team_id from conn_team)
and sm.source_id = ' . $source_id . '
and icn.id = ic.country_id
and st.id = sm.src_home_team_id
and st.source_id = ' . $source_id . '
and sm.src_competition_id = cc.src_competition_id
and cc.init_competition_id = ic.id
union all
select distinct icn.country competition_name, sm.src_visitor_team_id team_id, st.name team_name, icn.id competition_id, sm.sport_id
from src_match sm, conn_competition cc, init_competition ic, init_country icn, src_team st
where st.id not in (select src_team_id from conn_team)
and sm.source_id = ' . $source_id . '
and icn.id = ic.country_id
and st.id = sm.src_visitor_team_id
and st.source_id = ' . $source_id . '
and sm.src_competition_id = cc.src_competition_id
and cc.init_competition_id = ic.id) a
order by 5, 1,3
';


//AND sm.start_time > now() - INTERVAL "4" DAY
//AND sm.start_time < now() + INTERVAL "8" DAY

// echo $sql;


$FindTeam = $conn->prepare($sql);
$FindTeam->execute();
$ShowTeam = $FindTeam->fetchAll(PDO::FETCH_ASSOC);


$conn = null;


// print_r($ShowMatch);
?>