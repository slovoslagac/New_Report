<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=EE8MSWIN1250">
	</head>
	<body>



<?php
header('Content-Type: charset=EE8MSWIN1250');



$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske1.php'));
include $path;


$sql= oci_parse( $conn, 'select to_char(k1.vreme, \'mm/dd/yyyy\') datum,  to_char(k1.vreme, \'hh24.MI\') vreme, k2.igrac, k2.sport, k2.tim
from 
(select  a.vreme vreme, p.MOZZART_NAME tim, p.ID sifra
from telebet.sp_event_participant ep, telebet.sp_participant p,
(select e.ID event_id, e.DATE_TIME vreme
from telebet.sp_event e
where competition_id =103
and trunc(e.date_time) >= trunc(sysdate-4)
and trunc(e.date_time) <= trunc(sysdate+3)) a
where a.event_id=ep.EVENT_ID
and ep.event_id in 
(select e.id
from telebet.sp_event e
where competition_id =103
and trunc(e.date_time) >= trunc(sysdate-4)
and trunc(e.date_time) <= trunc(sysdate+3))
and ep.PARTICIPANT_ID=p.ID) k1,
(select p.mozzart_name igrac, pt.MOZZART_NAME tim, pt.id sifra, SS.DESCRIPTION sport
from telebet.sp_participant p ,telebet.sp_team_member tm ,telebet.sp_team_member_team tmt,
  telebet.sp_team t, telebet.sp_participant pt, telebet.sp_sport ss
where p.type_id=2
and p.sport_id=55
and SS.ID=P.SPORT_ID
and p.ID=tm.PARTICIPANT_ID
and tm.ID=tmt.TEAM_MEMBER_ID
and t.ID=tmt.TEAM_ID
and tmt.ACTIVE=1
and pt.ID in (select participant_id from telebet.sp_participant_competition where competition_id=103 and season_id in (21))
and t.PARTICIPANT_ID=pt.ID) k2
where k1.sifra=k2.sifra
order by 1,2,3,4') ;

oci_execute($sql);
$TimeChanged = array();
while ($row = oci_fetch_array($sql)) {
	array_push($TimeChanged, $row);
}



foreach($TimeChanged as $t) {
	//echo htmlentities($t[2], ENT_IGNORE,"UTF-8")."<br>";
	echo $t[2]." ".$t[3]."<br>";
}

?>
	</body>
</html>