<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

if ($source_id > 0 ) {

    $sql = 'select s.name as source_name, it.name as mozzart_team_name, st.name as src_team_name, ct.id as conn_id
from init_team it, conn_team ct, src_team st, import_source s
where it.id = ct.init_team_id
and st.id = ct.src_team_id
and st.source_id = s.id
and st.source_id = '.$source_id.'
order by s.name, it.name
';

} else {

    $sql = 'select s.name as source_name, it.name as mozzart_team_name, st.name as src_team_name, ct.id as conn_id
from init_team it, conn_team ct, src_team st, import_source s
where it.id = ct.init_team_id
and st.id = ct.src_team_id
and st.source_id = s.id
order by s.name, it.name
';
};
$AllConnTeam = $conn -> prepare($sql);

$AllConnTeam -> execute();
$resultACT = $AllConnTeam -> fetchAll ( PDO::FETCH_ASSOC);



$conn = null;


// print_r($ShowCmp);
?>