<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;


$sql0 = oci_parse($conn, 'select max(roundid) as round from telebet.match');

oci_define_by_name($sql0, 'ROUND', $round);
oci_execute($sql0);
oci_fetch($sql0);

$round2=$round-2;



$sql= oci_parse( $conn, "select k2.kolo, to_char(k2.datum, 'dd.mm.yyyy HH24:mi') datum, k2.sifra, k2.sport, k2.takmicenje, k2.domacin, k2. gost, k2.kladionica, k1.igra, k1.rezultat
from
(SELECT /*+ USE_HASH(B,J,BMW,MOV) */  DISTINCT bmw.match_id mec,
       b.igra,
       J.RESULT_TYPE_ID rezultat
  FROM TELEBET.MATCHODDVALUE mov,
       TELEBET.BET_MATCHODD_WINSTATUS bmw,
       jovicasabic.GAME_RESULT_TYPES j,
       (SELECT RT.ID rezultat,
               ls.string igra
          FROM TELEBET.RESULTTYPES rt,
               TELEBET.LANGUAGESTRING ls
         WHERE RT.NAME = LS.STRINGVALUESID
           AND LS.LANGUAGEID = 1) b
 WHERE mov.roundid >= $round2
   AND BMW.ROUND_ID >= $round2
   AND BMW.BETTING_GAME_ID = J.BETTING_GAME_ID
   AND MOV.MATCHID = BMW.MATCH_ID
   AND MOV.BETTINGGAMEID = BMW.BETTING_GAME_ID
   AND MOV.BETTINGSUBGAMEID = BMW.BETTING_SUBGAME_ID
   AND BMW.WINSTATUS = 0
   AND MOV.ODD IS NOT NULL
   AND b.rezultat = J.RESULT_TYPE_ID) k1,
(select M.ROUNDID kolo, M.STARTTIME datum, M.MATCHNUMBER sifra, LSS.STRING sport, LSC.STRING takmicenje, LSD.STRING domacin, LSG.STRING gost,
        case when M.IS_GERMANIA_MATCH=1 then 'Germanija' else 'Mozzart' end kladionica, M.ID mec
from telebet.match m, telebet.team td, telebet.team tg, telebet.languagestring lsd, telebet.languagestring lsg, TELEBET.COMPETITION c, telebet.languagestring lsc ,telebet.sport s, telebet.languagestring lss
where M.ROUNDID>=$round2
and m.status not in (4,99)
and m.sportid not in (13)
and M.postponed is null
and M.STARTTIME < sysdate - interval '2' hour
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
and LSS.LANGUAGEID =1) k2
where k1.mec=k2.mec
and k1.rezultat not in (select resulttypeid from telebet.result r where k1.mec=r.matchid and r.roundid>=1571)
order by 8 desc, 1, 4,5,2,3, 9");

oci_execute($sql);
$NoResults = array();
while ($row = oci_fetch_array($sql)) {
	array_push($NoResults, $row);
}


$loto = oci_parse ($conn, "select distinct ls.STRING , e.id,  to_char(e.DATEOF, 'dd.mm.yyyy HH24:mi')
from TELEBET.BET_LOTO_EVENTS e, TELEBET.BET_LOTO_GAME g, TELEBET.LANGUAGESTRING ls, TELEBET.BET_LOTO_OFFER o 
where o.LOTO_EVENT_ID = e.id and e.GAME_ID = g.id and g.NAME = ls.STRINGVALUESID and ls.LANGUAGEID = 1 and e.DATEOF < sysdate and e.RESULT_STRING is null and e.DATEOF > sysdate - 2 order by 1, 3");

oci_execute($loto);
$LotoResults = array();
while ($row = oci_fetch_array($loto)) {
	array_push($LotoResults, $row);
}

//print_r($LotoResults);