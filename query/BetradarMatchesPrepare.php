<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;

$sql= oci_parse( $conn, 'select m.kat kat, m.comp comp, m.starttime starttime, t1.mozzart_name ht, t2.mozzart_name vt, m.sportid sportid, m.home_team htm, m.visitor_team vtm, m.sport sport_eng, m.sport_srb sport_srb
from
(
select distinct BCG.NAME kat, BTO.NAME comp, BE.START_TIME starttime, max(BT.NAME) home_team, max(BT1.NAME) visitor_team, BT.SUPER_ID home_team_id, BT1.SUPER_ID visitor_team_id, BE.SPORT_ID sportid, BRS.BETRADAR_NAME sport, BRS.NAME sport_srb
from TELEBET.BETRADAR_EVENT be, TELEBET.BETRADAR_COMPETITOR bc, TELEBET.BETRADAR_COMPETITOR bc1, TELEBET.BETRADAR_TEAM bt, TELEBET.BETRADAR_TEAM bt1, TELEBET.BETRADAR_TOURNAMENT bto, TELEBET.BETRADAR_CATEGORY bcg, TELEBET.BETRADAR_SPORT brs
where BE.ID=BC.EVENT_ID
and BC.COMPETITOR_TYPE=\'HOME\'
and BE.ID=BC1.EVENT_ID
and BC1.COMPETITOR_TYPE=\'AWAY\'
and BC.TEAM_ID=BT.super_ID
and BC1.TEAM_ID=BT1.super_ID
and BE.TOURNAMENT_ID=BTO.ID
and BCG.ID=BE.CATEGORY_ID
and BRS.ID = BE.SPORT_ID
and start_time > sysdate
and start_time < sysdate + interval \'10\' day
group by BTO.NAME , BE.START_TIME , BT.SUPER_ID , BT1.SUPER_ID , BE.SPORT_ID,BCG.NAME , BRS.BETRADAR_NAME, BRS.NAME
) m
left join 
(
select BMT.BETRADAR_SUPER_ID superId, SPP.MOZZART_NAME, SPP.SPORT_ID
from TELEBET.BETRADAR_MOZZART_TEAM bmt, TELEBET.SP_PARTICIPANT spp
where BMT.SPORT_ID=SPP.SPORT_ID
and BMT.MOZZART_TEAM_NAME=SPP.MOZZART_NAME
) t1 on m.home_team_id=t1.superId
left join 
(
select BMT.BETRADAR_SUPER_ID superId, SPP.MOZZART_NAME, SPP.SPORT_ID
from TELEBET.BETRADAR_MOZZART_TEAM bmt, TELEBET.SP_PARTICIPANT spp
where BMT.SPORT_ID=SPP.SPORT_ID
and BMT.MOZZART_TEAM_NAME=SPP.MOZZART_NAME
) t2 on m.visitor_team_id=t2.superId
order by 6,1,2,3,4');

oci_execute($sql);
$PreparedMathces = array();
while ($row = oci_fetch_array($sql)) {
	array_push($PreparedMathces, $row);
}




//print_r($PreparedMathces);

