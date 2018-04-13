<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;


$sql0 = oci_parse($conn, 'select max(roundid) as round from telebet.match');

oci_define_by_name($sql0, 'ROUND', $round);
oci_execute($sql0);
oci_fetch($sql0);

$round3=$round-3;
$round2=$round-2;
$round1=$round-1;
//echo $round;



$sql= oci_parse( $conn, '
		select
		M.ROUNDID kolo,
		to_char(M.STARTTIME, \'dd.mm.yyyy HH24:mi\') as datum,
		M.MATCHNUMBER sifra,
		LSS.STRING sport,
		LSC.STRING takmicenje,
		LSD.STRING domacin,
		LSG.STRING gost,
		case when M.IS_GERMANIA_MATCH=1 then \'Germanija\' else \'Mozzart\' end kladionica,
		LSRT.STRING rezultat
 from telebet.match m, TELEBET.RESULT r, telebet.team td, telebet.team tg, telebet.languagestring lsd, telebet.languagestring lsg, TELEBET.COMPETITION c, telebet.languagestring lsc ,telebet.sport s, telebet.languagestring lss, TELEBET.RESULTTYPES rt, TELEBET.LANGUAGESTRING lsrt
		where m.roundid>='.$round3.'
		and r.roundid>='.$round3.'
		and m.starttime > sysdate - interval \'10\' hour
		and M.HOMETEAMID=TD.ID
		and M.VISITORTEAMID=TG.ID
		and TG.NAME=LSG.STRINGVALUESID
		and LSG.LANGUAGEID=1
		and TD.NAME=LSD.STRINGVALUESID
		and LSD.LANGUAGEID=1
		and M.COMPETITIONID=C.ID
		and C.NAME=LSC.STRINGVALUESID
		and LSC.LANGUAGEID=1
		and M.SPORTID=s.id
		and s.name=LSS.STRINGVALUESID
		and LSS.LANGUAGEID =1
		and RT.ID=R.RESULTTYPEID
		and RT.NAME=LSRT.STRINGVALUESID
		and LSRT.LANGUAGEID=1
		and R.MATCHID=M.ID
		and R.VERIFIED=2
		and m.status = (case when m.sportid=1 and m.status=2 then 2 else case when m.sportid=1 and m.status=4 then 4 else 4 end end)
		and R.RESULTTYPEID in (select rezultat from (select J.RESULT_TYPE_ID rezultat, mo.matchid from TELEBET.MATCHODD mo, proske.GAME_RESULT_TYPES j where mo.roundid in ('.$round.', '.$round1.', '.$round2.', '.$round3.') and MO.BETTINGGAMEID =J.BETTING_GAME_ID ) a where a.matchid=r.matchid)
		and r.resulttypeid not in (3,37)
		order by 8 desc, 1, 4, 5, 2,3 ');

oci_execute($sql);
$allData = array();
while ($row = oci_fetch_array($sql)) {
	array_push($allData, $row);
}


$sql1= oci_parse( $conn, '
		select 
        S.DESCRIPTION,
        C.MOZZART_NAME,
        to_char(min(e.date_time),\'dd.mm.yyyy HH24:mi\') as datum,
        count(*)
from TELEBET.SP_EVENT e, TELEBET.SP_COMPETITION c, TELEBET.SP_SPORT s
where E.COMPETITION_ID=C.ID
and E.SPORT_ID = S.ID
and E.DATE_TIME> sysdate
and E.DATE_TIME< sysdate + interval \'12\' hour
and e.id not in (select event_id from TELEBET.BET_match bm where list_type_id = 4)
group by S.DESCRIPTION, C.MOZZART_NAME
order by 3 ');

oci_execute($sql1);
$NoOdds = array();
while ($row1 = oci_fetch_array($sql1)) {
	array_push($NoOdds, $row1);
}

oci_close($conn);

//print_r($allData);

//print_r($NoOdds);