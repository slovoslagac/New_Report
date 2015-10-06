<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;


$sql= oci_parse( $conn, 'select SPS.DESCRIPTION, SPC.MOZZART_NAME, d.mozzart_name, g.mozzart_name, to_char(k1.vreme, \'dd.mm.yyyy HH24:mi\') mozvreme, to_char(k2.vreme, \'dd.mm.yyyy HH24:mi\') betrvreme
from
(
select E.ID id, E.DATE_TIME vreme, E.COMPETITION_ID cid, e.sport_id sid
from TELEBET.SP_EVENT e
where E.DATE_TIME>sysdate
and E.DATE_TIME<sysdate +interval \'3\' day
) k1,
(select mv.mozmec id, BE.START_TIME vreme, mv.dom, mv.gost
from TELEBET.BETRADAR_EVENT be, mecevi_veze mv
where BE.ID=mv.betrmec
and to_number(to_char(start_time, \'HH24\'))>0) k2, telebet.sp_competition spc, telebet.sp_sport sps, TELEBET.SP_PARTICIPANT d, TELEBET.SP_PARTICIPANT g
where k1.id=k2.id
and k1.vreme<>k2.vreme
and k1.cid=SPC.ID
and k1.sid=SPS.ID
and k2.dom=d.id
and k2.gost=g.id
order by 1,2,5');

oci_execute($sql);
$DateTimeControl = array();
while ($row = oci_fetch_array($sql)) {
	array_push($DateTimeControl, $row);
}

//print_r($DateTimeControl);
