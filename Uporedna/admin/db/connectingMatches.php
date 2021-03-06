<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));

$source_array = array(2,3,4,5,6,7,9,11,13);

if(in_array($source_id, $source_array)) {
$sql = 'SELECT DISTINCT ic.name competition_name, st.name home_name, st1.name visitor_name, sm.id match_id, ic.id competition_id, st.id home_id, st1.id visitor_id
FROM src_match sm, conn_competition cc, init_competition ic, src_team st, src_team st1
WHERE sm.src_competition_id = cc.src_competition_id
AND cc.init_competition_id = ic.id
AND sm.id NOT IN (SELECT src_match_id FROM conn_match)
AND sm.src_home_team_id = st.id
AND ic.position = 1
AND sm.src_visitor_team_id = st1.id
AND sm.source_id= ' . $source_id . '
AND sm.start_time > now() - INTERVAL "3" DAY
AND sm.start_time < now() + INTERVAL "7" DAY
ORDER BY sm.source_id, ic.name, st.name
';
}
else {
    $sql = 'SELECT DISTINCT ic.name competition_name, st.name home_name, st1.name visitor_name, sm.id match_id, ic.id competition_id, st.id home_id, st1.id visitor_id
FROM src_match sm, conn_competition cc, init_competition ic, src_team st, src_team st1
WHERE sm.src_competition_id = cc.src_competition_id
AND cc.init_competition_id = ic.id
AND sm.id NOT IN (SELECT src_match_id FROM conn_match)
AND sm.src_home_team_id = st.id
AND ic.position = 1
AND sm.src_visitor_team_id = st1.id
AND sm.source_id= ' . $source_id . '
ORDER BY sm.source_id, ic.name, st.name
';
}
//AND sm.start_time > now() - INTERVAL "4" DAY
//AND sm.start_time < now() + INTERVAL "8" DAY

// echo $sql;


$FindMatch = $conn->prepare($sql);
$FindMatch->execute();
$ShowMatch = $FindMatch->fetchAll(PDO::FETCH_ASSOC);


$conn = null;


// print_r($ShowMatch);
?>