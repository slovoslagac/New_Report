<?php

$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;
$sql= oci_parse( $conn, '
		select 
		S.DESCRIPTION, 
		C.MOZZART_NAME, 
		to_char(min(e.date_time), \'dd.mm.yyyy HH24:mi\') as datum, 
		count(*)
from TELEBET.BET_MATCH bm, TELEBET.SP_EVENT e, TELEBET.SP_COMPETITION c, TELEBET.SP_SPORT s
where BM.EVENT_ID=e.id
and E.COMPETITION_ID=C.ID
and E.SPORT_ID = S.ID
and BM.LIST_TYPE_ID = 4
and E.DATE_TIME> sysdate
and E.DATE_TIME< sysdate + interval \'12\' hour
and special_type = 0 
and BM.ID not in (select bet_match_id from telebet.bet_match_telebet_info where round_id = (select max(id) from telebet.round))
group by S.DESCRIPTION, C.MOZZART_NAME
order by 3'); 

oci_execute($sql);
$NoOdds = array();
while ($row = oci_fetch_array($sql)) {
	array_push($NoOdds, $row);
}

oci_close($conn);

//print_r($NoOdds);