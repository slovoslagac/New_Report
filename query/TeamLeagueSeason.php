<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;

If ($a != ''){

$sql= oci_parse( $conn, 'select distinct S.DESCRIPTION SPORT, S.ID, C.MOZZART_NAME COMPETITION, P.MOZZART_NAME TEAM, SE.ORIGINAL_NAME SEASON, SE.ID, P.TRANSFERMARKT_ID TMID
from TELEBET.SP_EVENT e, TELEBET.SP_EVENT_PARTICIPANT ep, TELEBET.SP_PARTICIPANT p, TELEBET.SP_COMpetition c, TELEBET.SP_SPORT s, TELEBET.SP_SEASON se
where E.ID=EP.EVENT_ID
and E.COMPETITION_ID=C.ID
and E.SPORT_ID=s.id
and EP.PARTICIPANT_ID=P.ID
and E.SEASON_ID=SE.ID
and P.MOZZART_NAME=\''.$a.'\'
and s.id=\''.$c.'\'
order by 2,3,6');

oci_execute($sql);
$TeamLeagueSeason = array();
while ($row = oci_fetch_array($sql)) {
	array_push($TeamLeagueSeason, $row);
}

} else {

$sql= oci_parse( $conn, 'select distinct S.DESCRIPTION SPORT, S.ID, C.MOZZART_NAME COMPETITION, P.MOZZART_NAME TEAM, SE.ORIGINAL_NAME SEASON, SE.ID, P.TRANSFERMARKT_ID TMID
from TELEBET.SP_EVENT e, TELEBET.SP_EVENT_PARTICIPANT ep, TELEBET.SP_PARTICIPANT p, TELEBET.SP_COMpetition c, TELEBET.SP_SPORT s, TELEBET.SP_SEASON se
where E.ID=EP.EVENT_ID
and E.COMPETITION_ID=C.ID
and E.SPORT_ID=s.id
and EP.PARTICIPANT_ID=P.ID
and E.SEASON_ID=SE.ID
and P.TRANSFERMARKT_ID=\''.$b.'\'
and s.id=\''.$c.'\'
order by 2,3,6');
	
oci_execute($sql);
$TeamLeagueSeason = array();
while ($row = oci_fetch_array($sql)) {
array_push($TeamLeagueSeason, $row);
}
}


//print_r($TeamLeagueSeason);

?>