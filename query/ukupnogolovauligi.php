<?php

$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;
$sql= oci_parse( $conn, "select c.takmicenje as takm, c.srpski as s1, c.hrvatski as h1, c.rumunski as r1, d.srpski as s2, d.hrvatski as h2, d.rumunski as r2
from
(
select a.takmicenje, srpski, hrvatski, rumunski
from
(select distinct P.MOZZART_NAME takmicenje
from TELEBET.SP_EVENT_PARTICIPANT ep, TELEBET.SP_PARTICIPANT p
where EP.PARTICIPANT_ID=p.id
and EP.EVENT_ID in (select id from telebet.sp_event where sport_id= 56 and date_time > sysdate - 1 and date_time < sysdate + 7)) a,
(select SV.PARSERSTRING takmicenje, ls.string srpski , ls1.string hrvatski , ls2.string rumunski
from TELEBET.TEAM t, TELEBET.STRINGVALUES sv, TELEBET.LANGUAGESTRING ls, TELEBET.LANGUAGESTRING ls1, TELEBET.LANGUAGESTRING ls2
where T.SPORTID = 56
and sv.id=T.NAME
and sv.id=LS.STRINGVALUESID
and LS.LANGUAGEID=1
and sv.id=LS1.STRINGVALUESID
and LS1.LANGUAGEID=6
and sv.id=LS2.STRINGVALUESID
and LS2.LANGUAGEID=3) b
where a.takmicenje = b.takmicenje) c
left outer join 
(select SV.PARSERSTRING takmicenje, ls.string srpski , ls1.string hrvatski, ls2.string rumunski
from TELEBET.COMPETITION c, TELEBET.STRINGVALUES sv, TELEBET.LANGUAGESTRING ls, TELEBET.LANGUAGESTRING ls1, TELEBET.LANGUAGESTRING ls2
where c.name=sv.id
and C.SPORTID=1
and sv.id=LS.STRINGVALUESID
and LS.LANGUAGEID=1
and sv.id=LS1.STRINGVALUESID
and LS1.LANGUAGEID=6
and sv.id=LS2.STRINGVALUESID
and LS2.LANGUAGEID=3) d on d.takmicenje=c.takmicenje
order by 1");

oci_execute($sql);
$totalgoalData = array();
while ($row = oci_fetch_array($sql)) {
	array_push($totalgoalData, $row);
}

oci_close($conn);

//print_r($totalgoalData);

$search = array ('^');
$repl = array ('&Ccaron;');

$totalgoalData1 = str_replace($search, $repl, $totalgoalData);
//console(print_r($totalgoalData));