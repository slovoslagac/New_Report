<?php

$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;
$sql= oci_parse( $conn, "select mozzart_name as name, sport_id as sport, country_id as country, SS.DESCRIPTION as sport_name, LS.STRING as country_name, C.ID as cmp_id
from TELEBET.SP_COMPETITION c, telebet.sp_sport ss, TELEBET.CB_COUNTRIES cc, TELEBET.LANGUAGESTRING ls
where length(flag_icon) < 5
and ss.id=C.SPORT_ID
and CC.ID=C.COUNTRY_ID
and cc.name=LS.STRINGVALUESID
and LS.LANGUAGEID=1
order by ss.id, ls.string");

oci_execute($sql);
$NoFlagData = array();
while ($row = oci_fetch_array($sql)) {
	array_push($NoFlagData, $row);
}

oci_close($conn);

//print_r($NoFlagData);

//console(print_r($totalgoalData));