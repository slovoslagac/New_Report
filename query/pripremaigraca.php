<?php
// header('Content-Type: charset=ISO-8859-1');
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske1.php'));
include $path;




$sql= oci_parse( $conn, 'select mozzart_name, c.id, s.description
from telebet.sp_competition c,telebet.sp_sport s
where c.SPORT_ID=s.id
and s.id in (2,7)
order by 3,1');

oci_execute($sql);
$LeagueList = array();
while ($row = oci_fetch_array($sql)) {
	array_push($LeagueList, $row);
}

$sql1= oci_parse( $conn, 'select mozzart_name, c.id, s.description, S.ID
from telebet.sp_competition c,telebet.sp_sport s
where c.SPORT_ID=s.id
and s.id in (54,55)
order by 3,1');

oci_execute($sql1);
$LeagueFakeList = array();
while ($row = oci_fetch_array($sql1)) {
	array_push($LeagueFakeList, $row);
}

/*$def_sport=55;
$def_competition=7351;
$def_fake_competition='EVROPSKO PRVENSTVO - IGRA^I';
$def_days=1;
$def_season=20;*/

//convert(k2.igrac ,\'US7ASCII\',\'EE8MSWIN1250\')

$sql2= oci_parse( $conn, 'select to_char(k1.vreme, \'mm/dd/yyyy\') datum,  to_char(k1.vreme, \'hh24.MI\') vreme, k2.igrac, k2.sport, k2.tim
from 
(select  a.vreme vreme, p.MOZZART_NAME tim, p.ID sifra
from telebet.sp_event_participant ep, telebet.sp_participant p,
(select e.ID event_id, e.DATE_TIME vreme
from telebet.sp_event e
where competition_id =\''.$def_competition.'\'
and trunc(e.date_time) >= trunc(sysdate)
and trunc(e.date_time) <= trunc(sysdate+\''.$def_days.'\')) a
where a.event_id=ep.EVENT_ID
and ep.event_id in 
(select e.id
from telebet.sp_event e
where competition_id =\''.$def_competition.'\'
and trunc(e.date_time) >= trunc(sysdate)
and trunc(e.date_time) <= trunc(sysdate+\''.$def_days.'\'))
and ep.PARTICIPANT_ID=p.ID) k1,
(select p.mozzart_name igrac, pt.MOZZART_NAME tim, pt.id sifra, SS.DESCRIPTION sport
from telebet.sp_participant p ,telebet.sp_team_member tm ,telebet.sp_team_member_team tmt,
  telebet.sp_team t, telebet.sp_participant pt, telebet.sp_sport ss
where p.type_id=2
and p.sport_id=\''.$def_sport.'\'
and SS.ID=P.SPORT_ID
and p.ID=tm.PARTICIPANT_ID
and tm.ID=tmt.TEAM_MEMBER_ID
and t.ID=tmt.TEAM_ID
and tmt.ACTIVE=1
and pt.ID in (select participant_id from telebet.sp_participant_competition where competition_id=\''.$def_competition.'\' and season_id = \''.$def_season.'\')
and t.PARTICIPANT_ID=pt.ID) k2
where k1.sifra=k2.sifra
order by 1,2,5,3');


oci_execute($sql2);
$Matches = array();
while ($row = oci_fetch_array($sql2)) {
	array_push($Matches, $row);
}

/*function replace($data){
	$invalid = array('Grc'=>'Gr&#269;',
			'Š'=>'&#352;', 'š'=>'&#353;'
		);
	$data = str_replace(array_replace($invalid), array_values($invalid), $data);
	
	return $data;
}



print_r($Matches);


echo str_replace('Grc','Gr&#269;',$Matches[0][2]);*/
