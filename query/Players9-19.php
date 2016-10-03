<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;

$sport_array = array (2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76);

$sport_array = join(',', $sport_array);

If ($a != ''){

$sql= oci_parse( $conn, 'select k1.tim, k1.ime "9 karaktera", k2.ime "13 karaktera", s.description Sport, k1.sport sportid
from
(select ls.string ime, t.id, a. tim, a.sport
from
(
select max(ts.id) id, TS.PARSERSTRING tim, spp.sport_id sport
from telebet.sp_participant spp, TELEBET.STRINGVALUES ts
where sport_id in ('.$sport_array.')
and SPP.MOZZART_NAME=TS.PARSERSTRING
group by TS.PARSERSTRING, spp.sport_id) a, telebet.team t, telebet.languagestring ls
where a.id=t.name
and T.SHORTNAME_nine=LS.STRINGVALUESID
and LS.LANGUAGEID=1) k1,
(select ls.string ime, t.id, a. tim, T.SPORTID sport
from
(
select max(ts.id) id, TS.PARSERSTRING tim
from telebet.sp_participant spp, TELEBET.STRINGVALUES ts
where sport_id in ('.$sport_array.')
and SPP.TYPE_ID=2
and SPP.MOZZART_NAME=TS.PARSERSTRING
group by TS.PARSERSTRING) a, telebet.team t, telebet.languagestring ls
where a.id=t.name
and T.SHORTNAME_thirteen=LS.STRINGVALUESID
and LS.LANGUAGEID=1) k2, telebet.sp_sport s
where k1.id=k2.id
and k1.ime<>k2.ime
and k1.sport=k2.sport
and k1.sport=s.id
order by 5,4,1');

oci_execute($sql);
$Players = array();
while ($row = oci_fetch_array($sql)) {
	array_push($Players, $row);
}

} else {

$sql= oci_parse( $conn, 'select k1.tim, k1.ime "9 karaktera", k2.ime "13 karaktera", s.description Sport, k1.sport sportid
from
(select ls.string ime, t.id, a. tim, a.sport
from
(
select max(ts.id) id, TS.PARSERSTRING tim, spp.sport_id sport
from telebet.sp_participant spp, TELEBET.STRINGVALUES ts
where sport_id in ('.$sport_array.')
and SPP.MOZZART_NAME=TS.PARSERSTRING
group by TS.PARSERSTRING, spp.sport_id) a, telebet.team t, telebet.languagestring ls
where a.id=t.name
and T.SHORTNAME_nine=LS.STRINGVALUESID
and LS.LANGUAGEID=1) k1,
(select ls.string ime, t.id, a. tim, T.SPORTID sport
from
(
select max(ts.id) id, TS.PARSERSTRING tim
from telebet.sp_participant spp, TELEBET.STRINGVALUES ts
where sport_id in ('.$sport_array.')
and SPP.TYPE_ID=2
and SPP.MOZZART_NAME=TS.PARSERSTRING
group by TS.PARSERSTRING) a, telebet.team t, telebet.languagestring ls
where a.id=t.name
and T.SHORTNAME_thirteen=LS.STRINGVALUESID
and LS.LANGUAGEID=1) k2, telebet.sp_sport s
where k1.id=k2.id
and k1.ime<>k2.ime
and k1.sport=k2.sport
and k1.sport=s.id
order by 5,4,1');
	
oci_execute($sql);
$Players = array();
while ($row = oci_fetch_array($sql)) {
array_push($Players, $row);
}
}


//print_r($Players);

?>