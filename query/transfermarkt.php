<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;

$sql= oci_parse( $conn, "select S.DESCRIPTION, P1.MOZZART_NAME, P1.TRANSFERMARKT_ID, P1.TRANSFERMARKT_ID, s.id
from TELEBET.SP_PARTICIPANT p1, telebet.sp_sport s,
(
select p.transfermarkt_id
from TELEBET.SP_PARTICIPANT p
where P.TRANSFERMARKT_ID is not null
and P.TYPE_ID=1
group by p.transfermarkt_id
having count(*)>1) p2
where P1.TRANSFERMARKT_ID=P2.TRANSFERMARKT_ID
and P1.TYPE_ID=1
and P1.SPORT_ID=s.id
order by s.id, P1.TRANSFERMARKT_ID");

oci_execute($sql);
$tmDouble = array();
while ($row = oci_fetch_array($sql)) {
	array_push($tmDouble, $row);
}




oci_close($conn);

//print_r($NoFlagData);

//console(print_r($totalgoalData));