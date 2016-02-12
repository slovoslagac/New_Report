<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));


$sql = 'SELECT distinct ic.name competition_name, st.name home_name, st1.name visitor_name, sm.id match_id, ic.id competition_id, st.id home_id, st1.id visitor_id
FROM src_match sm, conn_competition cc, init_competition ic, src_team st, src_team st1
WHERE sm.src_competition_id = cc.src_competition_id
AND cc.init_competition_id = ic.id
AND sm.id NOT IN (SELECT sm.src_match_id FROM conn_matches)
AND sm.src_home_team_id = st.id
AND sm.src_visitor_team_id = st1.id
AND sm.source_id= ' . $source_id . '
AND sm.start_time > now() - INTERVAL "10" DAY
AND sm.start_time < now() + INTERVAL "7" DAY
order by sm.source_id, ic.name, st.name
';

// echo $sql;


$FindMatch = $conn->prepare($sql);
$FindMatch->execute();
$ShowMatch = $FindMatch->fetchAll(PDO::FETCH_ASSOC);


$conn = null;


// print_r($ShowMatch);
?>