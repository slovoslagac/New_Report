<?php

$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;
$sql= oci_parse( $conn, "select sport_id, competition_id, sport, competition, min_start, max_start, ss.original_name
from
(
select a.sport_id, competition_id, S.DESCRIPTION sport, C.MOZZART_NAME competition, min(to_char(start_date,'mm.dd')) min_start, max(to_char(start_date,'mm.dd')) max_start, max(a.season_id) season_id
from
(
select sport_id, competition_id, season_id, min(date_time) start_date
from telebet.sp_event spe
where competition_id not in (select distinct competition_id from telebet.sp_event where season_id in (select id from telebet.sp_season where original_name in (to_char(sysdate,'YYYY'),concat(concat(to_char(sysdate,'YYYY'),'/'),to_char(to_number(to_char(sysdate,'YYYY')+1))))))
group by sport_id, competition_id, season_id) a, TELEBET.SP_COMPETITION c, telebet.sp_sport s
where a.sport_id=s.id
and a.competition_id=c.id
group by a.sport_id, competition_id, S.DESCRIPTION, C.MOZZART_NAME) b, telebet.sp_season ss
where b.season_id=ss.id
order by 1,2");

oci_execute($sql);
$NewSeasonData = array();
while ($row = oci_fetch_array($sql)) {
	array_push($NewSeasonData, $row);
}

oci_close($conn);

//print_r($livebetData);