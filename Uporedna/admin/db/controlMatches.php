<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

if ($source_id > 0 ) {

    $sql = 'select ims.name as source_name, ic.name as competition_name , it.name as mozzart_home_team_name, it1.name as mozzart_visitor_team_name, st.name as src_home_team_name, st1.name as src_visitor_team_name, cm.id as cmp_id
from conn_match cm, init_match im, src_match sm, init_team it, init_team it1, import_source ims, init_competition ic, src_team st, src_team st1
where im.event_id = cm.init_match_id
and sm.id = cm.src_match_id
and im.home_team_id = it.id
and im.visitor_team_id = it1.id
and sm.source_id = ims.id
and im.competition_id = ic.id
and sm.src_home_team_id = st.id
and sm.src_visitor_team_id = st1.id
and ims.id = '.$source_id.'
and im.start_time > now() - interval "12" day
and im.start_time < now() + interval "10" day
order by ims.name, ic.name, it.name

';

} else {

    $sql = 'select ims.name as source_name, ic.name as competition_name , it.name as mozzart_home_team_name, it1.name as mozzart_visitor_team_name, st.name as src_home_team_name, st1.name as src_visitor_team_name, cm.id as cmp_id
from conn_match cm, init_match im, src_match sm, init_team it, init_team it1, import_source ims, init_competition ic, src_team st, src_team st1
where im.event_id = cm.init_match_id
and sm.id = cm.src_match_id
and im.home_team_id = it.id
and im.visitor_team_id = it1.id
and sm.source_id = ims.id
and im.competition_id = ic.id
and sm.src_home_team_id = st.id
and sm.src_visitor_team_id = st1.id
and im.start_time > now() - interval "12" day
and im.start_time < now() + interval "10" day
order by ims.name, ic.name, it.name

';
};
$AllConnMatch = $conn -> prepare($sql);

$AllConnMatch -> execute();
$resultMac = $AllConnMatch -> fetchAll ( PDO::FETCH_ASSOC);



$conn = null;


// print_r($ShowCmp);
?>