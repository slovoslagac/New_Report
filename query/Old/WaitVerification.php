<?php

$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;
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
		where m.roundid>=(select max(roundid)-3 from telebet.match)
		and r.roundid>=(select max(roundid)-3 from telebet.match)
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
		and R.RESULTTYPEID in (select rezultat from (select J.RESULT_TYPE_ID rezultat, mo.matchid from TELEBET.MATCHODD mo, jovicasabic.GAME_RESULT_TYPES j where mo.roundid>=(select max(roundid)-3 from telebet.match) and MO.BETTINGGAMEID =J.BETTING_GAME_ID ) a where a.matchid=r.matchid)
		and r.resulttypeid not in (3,37)
		order by 8 desc, 1, 4, 5, 2,3 '); 

oci_execute($sql);
$allData = array();
while ($row = oci_fetch_array($sql)) {
	array_push($allData, $row);
}

oci_close($conn);

//print_r($allData);