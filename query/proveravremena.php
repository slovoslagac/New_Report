<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;

$sql0 = oci_parse($conn, 'select max(roundid) as round from telebet.match');

oci_define_by_name($sql0, 'ROUND', $round);
oci_execute($sql0);
oci_fetch($sql0);



$sql= oci_parse( $conn, 'select cl.id, to_char(CL.CHANGE_DATE, \'dd.mm.yyyy HH24:mi\'), CL.OLD_DATE, to_char(CL.NEW_DATE, \'dd.mm.yyyy HH24:mi\'), concat(concat(CBP.NAME,\' \'),CBP.LASTNAME) NAME, m.matchnumber, l1.string, l2.string, cl.change_date
from TELEBET.MATCH m, TELEBET.BET_MATCH_TELEBET_INFO bmti, TELEBET.BET_MATCH bm, TELEBET.SP_EVENT_CHANGE_DATE_LOG cl,TELEBET.CB_PERSONS cbp, telebet.team t1, telebet.languagestring l1, telebet.team t2, telebet.languagestring l2
where matchnumber in (\''.$selected_matchnumber.'\')
and roundid=\''.$selected_round.'\'
and M.IS_GERMANIA_MATCH=\''.$selected_kladionica.'\'
and BMTI.TELEBET_MATCH_ID=m.id
and BM.ID=BMTI.BET_MATCH_ID
and CL.EVENT_ID=BM.EVENT_ID
and CL.PERSON_ID=CBP.ID
and m.hometeamid = t1.id
and t1.name = l1.stringvaluesid
and l1.languageid=1
and m.visitorteamid = t2.id
and t2.name = l2.stringvaluesid
and l2.languageid=1
order by 9 desc');

oci_execute($sql);
$TimeChanged = array();
while ($row = oci_fetch_array($sql)) {
	array_push($TimeChanged, $row);
}

//print_r($TimeChanged);
