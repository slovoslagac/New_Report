<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;

If ($a != ''){

$sql= oci_parse( $conn, 'select k1.tim, k1.ime "9 karaktera", k2.ime "13 karaktera", s.description Sport, k1.sport sportid
from
(select ls.string ime, t.id, a. tim, a.sport
from
(
select max(ts.id) id, TS.PARSERSTRING tim, spp.sport_id sport
from telebet.sp_participant spp, TELEBET.STRINGVALUES ts
where sport_id in (55,54,59,60,61,62,63,64,3)
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
where sport_id in (55,54,59,60,61,62,63,64,3)
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
where sport_id in (55,54,59,60,61,62,63,64,3)
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
where sport_id in (55,54,59,60,61,62,63,64,3)
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