<?php

$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;
$sql= oci_parse( $conn, "select to_char(e.date_time,'DD.MM.YYYY HH24:MI') as vreme, 
        P1.MOZZART_NAME as domacin, 
        P2.MOZZART_NAME as gost, 
        C.MOZZART_NAME as takmicenje, 
        S.description as sport
from telebet.sp_event e, TELEBET.SP_EVENT_PARTICIPANT ep1, TELEBET.SP_PARTICIPANT p1, TELEBET.SP_EVENT_PARTICIPANT ep2, TELEBET.SP_PARTICIPANT p2, TELEBET.SP_COMPETITION c ,TELEBET.SP_SPORT s,
(select e.date_time vreme, ep1.participant_id dom_id, ep2.participant_id gost_id
from telebet.sp_event e, TELEBET.SP_EVENT_PARTICIPANT ep1, TELEBET.SP_EVENT_PARTICIPANT ep2
where EP1.EVENT_ID=e.id
and EP2.EVENT_ID=e.id
and e.date_time > sysdate - interval '4' day
and e.date_time < sysdate + interval '4' day
and E.SPORT_ID not in (3)
) n
where E.SPORT_ID=s.id
and E.COMPETITION_ID=C.ID
and EP1.EVENT_ID=e.id
and EP1.HOME_VISITOR=1
and P1.ID=EP1.PARTICIPANT_ID
and EP2.EVENT_ID=e.id
and EP2.HOME_VISITOR=2
and P2.ID=EP2.PARTICIPANT_ID
and e.date_time > sysdate - interval '3' day
and e.date_time < sysdate + interval '4' day
and ep1.participant_id=n.dom_id
and ep2.participant_id=n.gost_id
and abs(to_number(e.date_time-n.vreme)) < case when e.sport_id = 5 then 2 else 0.65 end
group by e.date_time, P1.MOZZART_NAME, P2.MOZZART_NAME, C.MOZZART_NAME, S.description
having count(*)>1
order by 5,4,2,3,1");

oci_execute($sql);
$DoubleMatches = array();
while ($row = oci_fetch_array($sql)) {
	array_push($DoubleMatches, $row);
}

oci_close($conn);

//print_r($totalgoalData);

//console(print_r($totalgoalData));