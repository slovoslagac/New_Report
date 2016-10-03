<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));


    $sql = "SELECT DISTINCT it.name team_name, ic.country_id competition_id, it.id team_id
            FROM init_team it, init_team_competition itc, init_competition ic
            WHERE it.id = itc.team_id

            and itc.competition_id = ic.id
            ORDER BY 2,1";


//            and it.id not in (select distinct init_team_id from conn_team ct, src_team st where ct.src_team_id = st.id and st.source_id = $source_id)
$MozTeam = $conn -> prepare($sql);
$MozTeam -> execute();
$ShowMozTeam = $MozTeam -> fetchAll ( PDO::FETCH_ASSOC);



?>