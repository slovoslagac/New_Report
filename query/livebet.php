<?php

$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;
$sql= oci_parse( $conn, "select 
		d.dan_srp_t dan,
		b.cas as cas, 
		b.domacin as domacin, 
		b.gost as gost, 
		b.sport as sport_id, 
		b.string as sport, 
		b.id, 
		datum
from
(
select  replace(to_char(match_date, 'd'), ' ')  dan,to_char(match_date, 'hh24:mi') cas, domacin,gost, a.sport, ls.string, s.id, match_date datum
from
(
select lm.id, match_date, bmtd.tim domacin, bmtg.tim gost, BMTG.sport,
  row_number () over ( order by BMTG.sport, match_date) red
from livebet.livebet_matches lm, (select BMT.BETRADAR_SUPER_ID  br_id, BMT.BETRADAR_TEAM_NAME be_name , SPP.MOZZART_NAME tim, SPP.SPORT_ID sport
from TELEBET.BETRADAR_MOZZART_TEAM bmt, TELEBET.SP_PARTICIPANT spp
where lower(BMT.MOZZART_TEAM_NAME)=lower(SPP.MOZZART_NAME)
and BMT.SPORT_ID=SPP.SPORT_ID) bmtd,
(select BMT.BETRADAR_SUPER_ID  br_id, BMT.BETRADAR_TEAM_NAME be_name , SPP.MOZZART_NAME tim, SPP.SPORT_ID sport
from TELEBET.BETRADAR_MOZZART_TEAM bmt, TELEBET.SP_PARTICIPANT spp
where lower(BMT.MOZZART_TEAM_NAME)=lower(SPP.MOZZART_NAME)
and BMT.SPORT_ID=SPP.SPORT_ID) bmtg
where LM.HOME_TEAM_ID=bmtd.br_id
and LM.away_TEAM_ID=bmtg.br_id
and concat(to_char(match_date,'yyyymmdd'),to_char(match_date,'hh24mi')) >=concat(to_char(sysdate,
 'yyyymmdd'),'0800')
and match_date < sysdate + interval '48' hour
and LM.ID not in (select match_id from livebet.livebet_tracking_matches)
order by sport_id, match_date) a, telebet.sp_sport s, telebet.languagestring ls
where a.sport=s.id
and LS.LANGUAGEID=1
and S.NAME=LS.STRINGVALUESID
and a.sport in (1,2,4,5,6,7)
order by match_date) b, dani d
where to_char(b.dan)=to_char(d.num)
order by sport, datum");

oci_execute($sql);
$livebetData = array();
while ($row = oci_fetch_array($sql)) {
	array_push($livebetData, $row);
}

oci_close($conn);

//print_r($livebetData);