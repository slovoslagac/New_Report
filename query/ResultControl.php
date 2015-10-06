<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;


$sql0 = oci_parse($conn, 'select max(roundid) as round from telebet.match');

oci_define_by_name($sql0, 'ROUND', $round);
oci_execute($sql0);
oci_fetch($sql0);

$round2=$round-2;



$sql= oci_parse( $conn, '
select kolo, to_char(vreme, \'dd.mm.yyyy HH24:mi\') vreme, sifra, sport, takmicenje, domacin, gost, betrrez, mozzrez, igra, kladionica
from
(
select domacin, gost, k1.mecid, k1.igra, k1.rezultat betrrez, k2.rez mozzrez
from 
(select BMTI.TELEBET_MATCH_ID mecid, BMRT.MOZZART_NAZIV igra, score rezultat, BMRT.MOZZART_TYPE_ID rezid, BMTI.ROUND_ID, SPD.MOZZART_NAME domacin, SPG.MOZZART_NAME gost
from TELEBET.BETRADAR_MATCH_RESULT bmr, proske.mecevi_veze mv, PROSKE.BETRADAR_MOZZART_RESULT_TYPE BMRT, telebet.bet_match bm,TELEBET.BET_MATCH_TELEBET_INFO bmti, telebet.sp_participant spd, telebet.sp_participant spg
where BMR.EVENT_ID=mv.betrmec
and mv.dom=SPD.ID
and mv.gost=spg.id
and BMRT.BETRADAR_TYPE=BMR.RESULT_TYPE
and mozmec=BM.EVENT_ID
and BMTI.BET_MATCH_ID=BM.ID) k1,
(select matchid, resulttypeid rezid, home||\':\'||visitor rez
from TELEBET.RESULT) k2
where k1.mecid=k2.matchid
and k1.rezid=k2.rezid
and k1.rezultat<>k2.rez) a,
(select S.DESCRIPTION sport, SV.PARSERSTRING takmicenje, m.roundid kolo, M.MATCHNUMBER sifra, M.STARTTIME vreme , m.id, case when is_germania_match=1 then \'Germanija\' else \'Mozzart\' end kladionica  from telebet.match m ,telebet.competition c, TELEBET.STRINGVALUES sv, telebet.sport s where ROUNDID >='.$round2.' and c.id=M.COMPETITIONID and C.NAME=SV.ID and s.id=M.SPORTID ) b 
where a.mecid=b.id
order by  4, 5, 6');

oci_execute($sql);
$ResultControl = array();
while ($row = oci_fetch_array($sql)) {
	array_push($ResultControl, $row);
}

//print_r($ResultControl);
