<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;

$sqls = oci_parse($conn, 'select id ID, description SPORT
 from telebet.sp_sport');

oci_execute($sqls);
$Sports = array();
while ($row = oci_fetch_array($sqls)) {
	array_push($Sports, $row);
}

if ($b==1){

$sql= oci_parse( $conn, 'select b.des PARSE, b.sport, b.ime NAME, case when b.lang=1 then \'Srpski\' else \'Engleski\' end LANGUAGE, a.sportn SPORTN
from
(
select LS.STRING ime, count(*) "broj ponavljanja", ls.languageid lang, ss.id sport, SS.DESCRIPTION sportn
from telebet.sp_participant p, TELEBET.STRINGVALUES s, TELEBET.LANGUAGESTRING ls, TELEBET.SP_SPORT ss
where  P.SPORT_ID=ss.id
and p.type_id in (1,2)
and P.MOZZART_NAME=S.PARSERSTRING
and P.SPORT_ID=S.PARSERSTRINGTYPE
and S.ID=LS.STRINGVALUESID
and LS.LANGUAGEID in (1,2)
and ss.id = \''.$a.'\'
group by LS.STRING, ls.languageid, ss.id, SS.DESCRIPTION
having count(*)>1) a,
(select LS.STRING ime, LS.LANGUAGEID lang, SV.PARSERSTRING des, SV.PARSERSTRINGTYPE sport
from TELEBET.LANGUAGESTRING ls, TELEBET.STRINGVALUES sv
where LS.STRINGVALUESID=sv.id
and SV.PARSERSTRINGTYPE > 0
) b
where a.ime=b.ime
and a.lang=b.lang
and a.sport=b.sport
order by 4,2,3'); 

} else {

	$sql= oci_parse( $conn, 'select b.des PARSE, b.sport, b.ime NAME, case when b.lang=1 then \'Srpski\' else \'Engleski\' end LANGUAGE, a.sportn SPORTN
from
(
select LS.STRING ime, count(*) "broj ponavljanja", ls.languageid lang, ss.id sport, SS.DESCRIPTION sportn
from telebet.sp_participant p, TELEBET.STRINGVALUES s, TELEBET.LANGUAGESTRING ls, TELEBET.SP_SPORT ss
where  P.SPORT_ID=ss.id
and p.type_id in (1,2)
and P.MOZZART_NAME=S.PARSERSTRING
and P.SPORT_ID=S.PARSERSTRINGTYPE
and S.ID=LS.STRINGVALUESID
and LS.LANGUAGEID in (1,2)
group by LS.STRING, ls.languageid, ss.id, SS.DESCRIPTION
having count(*)>1) a,
(select LS.STRING ime, LS.LANGUAGEID lang, SV.PARSERSTRING des, SV.PARSERSTRINGTYPE sport
from TELEBET.LANGUAGESTRING ls, TELEBET.STRINGVALUES sv
where LS.STRINGVALUESID=sv.id
and SV.PARSERSTRINGTYPE > 0
) b
where a.ime=b.ime
and a.lang=b.lang
and a.sport=b.sport
order by 4,2,3');	
	
}

oci_execute($sql);
$DoubledPlayers = array();
while ($row = oci_fetch_array($sql)) {
	array_push($DoubledPlayers, $row);
}



oci_close($conn);

//print_r($allData);

//print_r($Sports);