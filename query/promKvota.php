<?php
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;

switch ($option) {
	case '1':
		$sql= oci_parse( $conn, 'select b.sport sport, b.domacin dom, b.gost gost, b.match_number sifra, 
			p.value kv1, p1.value kv2, p2.value kv3, p3.value kv4 ,p4.value kv5, p5.value kv6, 
			to_char(b.last_change_time, \'dd.mm.yyyy HH24:mi\') time, b.last_changed_by change, b.last_change_time, 
			p.odd_id kvs1, p1.odd_id kvs2, p2.odd_id kvs3, p3.odd_id kvs4, p4.odd_id kvs5, p5.odd_id kvs6
		from
		(
		select distinct SS.DESCRIPTION sport, bm.ID bmid , pd.MOZZART_NAME domacin, pg.MOZZART_NAME gost, bm.MATCH_NUMBER, b1.last_changed_by, b1.last_change_time
		from telebet.sp_event_participant epd, telebet.sp_event_participant epg, telebet.sp_participant pd, telebet.sp_participant pg, telebet.bet_match bm, telebet.sp_event e, TELEBET.SP_SPORT ss,PROSKE.change_odd1 b1
		where epd.PARTICIPANT_ID=pd.ID
		and E.SPORT_ID=ss.id
		and epd.HOME_VISITOR=1
		and epg.PARTICIPANT_ID=pg.ID
		and epg.HOME_VISITOR=2
		and epd.EVENT_ID=epg.EVENT_ID
		and bm.EVENT_ID=epd.EVENT_ID
		and bm.LIST_TYPE_ID=4
		and bm.special_type = 0
		and epd.EVENT_ID=e.id
		and BM.ID = b1.match_id
		and b1.game_id * 1000 + b1.subgame_id in (1001,1002,1003,3003,3004,13001)
		and b1.last_change_time > sysdate - \''.$vreme.'\'/24
		and e.SPORT_ID = \''.$sport.'\'
		and E.DATE_TIME > sysdate - 1) b
		left join PROSKE.change_odd1 p on b.bmid=p.match_id and p.last_changed_by=b.last_changed_by and p.last_change_time=b.last_change_time  and p.game_id = 1  and p.subgame_id = 1
		left join PROSKE.change_odd1 p1 on b.bmid=p1.match_id and p1.last_changed_by=b.last_changed_by and p1.last_change_time=b.last_change_time  and p1.game_id=1 and p1.subgame_id = 2
		left join PROSKE.change_odd1 p2 on b.bmid=p2.match_id and p2.last_changed_by=b.last_changed_by and p2.last_change_time=b.last_change_time  and p2.game_id=1 and p2.subgame_id = 3
		left join PROSKE.change_odd1 p3 on b.bmid=p3.match_id and p3.last_changed_by=b.last_changed_by and p3.last_change_time=b.last_change_time  and p3.game_id=3 and p3.subgame_id = 3
		left join PROSKE.change_odd1 p4 on b.bmid=p4.match_id and p4.last_changed_by=b.last_changed_by and p4.last_change_time=b.last_change_time  and p4.game_id=3 and p4.subgame_id = 4
		left join PROSKE.change_odd1 p5 on b.bmid=p5.match_id and p5.last_changed_by=b.last_changed_by and p5.last_change_time=b.last_change_time  and p5.game_id=130 and p5.subgame_id = 1
		order by b.last_change_time desc
		');

		break;
	case '2':
		$sql= oci_parse( $conn, 'select b.sport sport, b.domacin dom, b.gost gost, b.match_number sifra, 
			p.value kv1, p.special_odds_value kv2, p1.value kv3, p2.value kv4 ,p2.special_odds_value kv5, p3.value kv6, 
			to_char(b.last_change_time, \'dd.mm.yyyy HH24:mi\') time, b.last_changed_by change, b.last_change_time, 
			p.odd_id kvs1, p.odd_id kvs2, p1.odd_id kvs3, p2.odd_id kvs4, p2.odd_id kvs5, p3.odd_id kvs6
		from
		(
		select distinct SS.DESCRIPTION sport, bm.ID bmid , pd.MOZZART_NAME domacin, pg.MOZZART_NAME gost, bm.MATCH_NUMBER, b1.last_changed_by, b1.last_change_time
		from telebet.sp_event_participant epd, telebet.sp_event_participant epg, telebet.sp_participant pd, telebet.sp_participant pg, telebet.bet_match bm, telebet.sp_event e, TELEBET.SP_SPORT ss,PROSKE.change_odd1 b1
		where epd.PARTICIPANT_ID=pd.ID
		and E.SPORT_ID=ss.id
		and epd.HOME_VISITOR=1
		and epg.PARTICIPANT_ID=pg.ID
		and epg.HOME_VISITOR=2
		and epd.EVENT_ID=epg.EVENT_ID
		and bm.EVENT_ID=epd.EVENT_ID
		and bm.LIST_TYPE_ID=4
		and bm.special_type = 0
		and epd.EVENT_ID=e.id
		and BM.ID = b1.match_id
		and b1.game_id * 1000 + b1.subgame_id in (1001,1003,27001,27003)
		and b1.last_change_time > sysdate - \''.$vreme.'\'/24
		and e.SPORT_ID = \''.$sport.'\'
		and E.DATE_TIME > sysdate - 1) b
		left join PROSKE.change_odd1 p on b.bmid=p.match_id and p.last_changed_by=b.last_changed_by and p.last_change_time=b.last_change_time  and p.game_id = 1  and p.subgame_id = 1
		left join PROSKE.change_odd1 p1 on b.bmid=p1.match_id and p1.last_changed_by=b.last_changed_by and p1.last_change_time=b.last_change_time  and p1.game_id=1 and p1.subgame_id = 3
		left join PROSKE.change_odd1 p2 on b.bmid=p2.match_id and p2.last_changed_by=b.last_changed_by and p2.last_change_time=b.last_change_time  and p2.game_id=27 and p2.subgame_id = 1
		left join PROSKE.change_odd1 p3 on b.bmid=p3.match_id and p3.last_changed_by=b.last_changed_by and p3.last_change_time=b.last_change_time  and p3.game_id=27 and p3.subgame_id = 3
		order by b.last_change_time desc
		');

		break;
	case '4':
		$sql= oci_parse( $conn, 'select b.sport sport, b.domacin dom, b.gost gost, b.match_number sifra, 
			p.value kv1, p1.value kv2, p2.value kv3, p3.value kv4 ,p4.value kv5, 
			to_char(b.last_change_time, \'dd.mm.yyyy HH24:mi\') time, b.last_changed_by change, b.last_change_time, 
			p.odd_id kvs1, p1.odd_id kvs1, p2.odd_id kvs3, p3.odd_id kvs4, p4.odd_id kvs5
        from
        (
        select distinct SS.DESCRIPTION sport, bm.ID bmid , pd.MOZZART_NAME domacin, pg.MOZZART_NAME gost, bm.MATCH_NUMBER, b1.last_changed_by, b1.last_change_time
        from telebet.sp_event_participant epd, telebet.sp_event_participant epg, telebet.sp_participant pd, telebet.sp_participant pg, telebet.bet_match bm, telebet.sp_event e, TELEBET.SP_SPORT ss,PROSKE.change_odd1 b1
        where epd.PARTICIPANT_ID=pd.ID
        and E.SPORT_ID=ss.id
        and epd.HOME_VISITOR=1
        and epg.PARTICIPANT_ID=pg.ID
        and epg.HOME_VISITOR=2
        and epd.EVENT_ID=epg.EVENT_ID
        and bm.EVENT_ID=epd.EVENT_ID
        and bm.LIST_TYPE_ID=4
        and bm.special_type = 0
        and epd.EVENT_ID=e.id
        and BM.ID = b1.match_id
        and b1.game_id * 1000 + b1.subgame_id in (17001,17002,17003,3017,3023)
       	and b1.last_change_time > sysdate - \''.$vreme.'\'/24
        and e.SPORT_ID = \''.$sport.'\'
        and E.DATE_TIME > sysdate - 1) b
        left join PROSKE.change_odd1 p on b.bmid=p.match_id and p.last_changed_by=b.last_changed_by and p.last_change_time=b.last_change_time  and p.game_id = 17  and p.subgame_id = 1
        left join PROSKE.change_odd1 p1 on b.bmid=p1.match_id and p1.last_changed_by=b.last_changed_by and p1.last_change_time=b.last_change_time  and p1.game_id=17 and p1.subgame_id = 2
        left join PROSKE.change_odd1 p2 on b.bmid=p2.match_id and p2.last_changed_by=b.last_changed_by and p2.last_change_time=b.last_change_time  and p2.game_id=17 and p2.subgame_id = 3
        left join PROSKE.change_odd1 p3 on b.bmid=p3.match_id and p3.last_changed_by=b.last_changed_by and p3.last_change_time=b.last_change_time  and p3.game_id=3 and p3.subgame_id = 17
        left join PROSKE.change_odd1 p4 on b.bmid=p4.match_id and p4.last_changed_by=b.last_changed_by and p4.last_change_time=b.last_change_time  and p4.game_id=3 and p4.subgame_id = 23
        order by b.last_change_time desc');

		break;
	case '5':
		$sql= oci_parse( $conn, 'select b.sport sport, b.domacin dom, b.gost gost, b.match_number sifra, 
			p.value kv1, p1.value kv2, p2.value kv3, p2.special_odds_value kv4 ,p3.value kv5, 
			to_char(b.last_change_time, \'dd.mm.yyyy HH24:mi\') time, b.last_changed_by change, b.last_change_time, 
			p.odd_id kvs1, p1.odd_id kvs1, p2.odd_id kvs3, p2.odd_id kvs4, p3.odd_id kvs5
        from
        (
        select distinct SS.DESCRIPTION sport, bm.ID bmid , pd.MOZZART_NAME domacin, pg.MOZZART_NAME gost, bm.MATCH_NUMBER, b1.last_changed_by, b1.last_change_time
        from telebet.sp_event_participant epd, telebet.sp_event_participant epg, telebet.sp_participant pd, telebet.sp_participant pg, telebet.bet_match bm, telebet.sp_event e, TELEBET.SP_SPORT ss,PROSKE.change_odd1 b1
        where epd.PARTICIPANT_ID=pd.ID
        and E.SPORT_ID=ss.id
        and epd.HOME_VISITOR=1
        and epg.PARTICIPANT_ID=pg.ID
        and epg.HOME_VISITOR=2
        and epd.EVENT_ID=epg.EVENT_ID
        and bm.EVENT_ID=epd.EVENT_ID
        and bm.LIST_TYPE_ID=4
        and bm.special_type = 0
        and epd.EVENT_ID=e.id
        and BM.ID = b1.match_id
        and b1.game_id * 1000 + b1.subgame_id in (1001,1003,87001,87003)
       	and b1.last_change_time > sysdate - \''.$vreme.'\'/24
        and e.SPORT_ID = \''.$sport.'\'
        and E.DATE_TIME > sysdate - 1) b
        left join PROSKE.change_odd1 p on b.bmid=p.match_id and p.last_changed_by=b.last_changed_by and p.last_change_time=b.last_change_time  and p.game_id = 1  and p.subgame_id = 1
        left join PROSKE.change_odd1 p1 on b.bmid=p1.match_id and p1.last_changed_by=b.last_changed_by and p1.last_change_time=b.last_change_time  and p1.game_id=1 and p1.subgame_id = 3
        left join PROSKE.change_odd1 p2 on b.bmid=p2.match_id and p2.last_changed_by=b.last_changed_by and p2.last_change_time=b.last_change_time  and p2.game_id=87 and p2.subgame_id = 1
        left join PROSKE.change_odd1 p3 on b.bmid=p3.match_id and p3.last_changed_by=b.last_changed_by and p3.last_change_time=b.last_change_time  and p3.game_id=87 and p3.subgame_id = 3

        order by b.last_change_time desc');

		break;
	case '6':
		$sql= oci_parse( $conn, 'select b.sport sport, b.domacin dom, b.gost gost, b.match_number sifra, 
			p.value kv1, p.special_odds_value kv2, p1.value kv3, p2.value kv4 ,p3.value kv5, 
			to_char(b.last_change_time, \'dd.mm.yyyy HH24:mi\') time, b.last_changed_by change, b.last_change_time, 
			p.odd_id kvs1, p1.odd_id kvs1, p2.odd_id kvs3, p2.odd_id kvs4, p3.odd_id kvs5
        from
        (
        select distinct SS.DESCRIPTION sport, bm.ID bmid , pd.MOZZART_NAME domacin, pg.MOZZART_NAME gost, bm.MATCH_NUMBER, b1.last_changed_by, b1.last_change_time
        from telebet.sp_event_participant epd, telebet.sp_event_participant epg, telebet.sp_participant pd, telebet.sp_participant pg, telebet.bet_match bm, telebet.sp_event e, TELEBET.SP_SPORT ss,PROSKE.change_odd1 b1
        where epd.PARTICIPANT_ID=pd.ID
        and E.SPORT_ID=ss.id
        and epd.HOME_VISITOR=1
        and epg.PARTICIPANT_ID=pg.ID
        and epg.HOME_VISITOR=2
        and epd.EVENT_ID=epg.EVENT_ID
        and bm.EVENT_ID=epd.EVENT_ID
        and bm.LIST_TYPE_ID=4
        and bm.special_type = 0
        and epd.EVENT_ID=e.id
        and BM.ID = b1.match_id
        and b1.game_id * 1000 + b1.subgame_id in (1001,1003,17001,17003)
       	and b1.last_change_time > sysdate - \''.$vreme.'\'/24
        and e.SPORT_ID = \''.$sport.'\'
        and E.DATE_TIME > sysdate - 1) b
        left join PROSKE.change_odd1 p on b.bmid=p.match_id and p.last_changed_by=b.last_changed_by and p.last_change_time=b.last_change_time  and p.game_id = 1  and p.subgame_id = 1
        left join PROSKE.change_odd1 p1 on b.bmid=p1.match_id and p1.last_changed_by=b.last_changed_by and p1.last_change_time=b.last_change_time  and p1.game_id=1 and p1.subgame_id = 3
        left join PROSKE.change_odd1 p2 on b.bmid=p2.match_id and p2.last_changed_by=b.last_changed_by and p2.last_change_time=b.last_change_time  and p2.game_id=17 and p2.subgame_id = 1
        left join PROSKE.change_odd1 p3 on b.bmid=p3.match_id and p3.last_changed_by=b.last_changed_by and p3.last_change_time=b.last_change_time  and p3.game_id=17 and p3.subgame_id = 3

        order by b.last_change_time desc');

		break;
	default:
		$sql = oci_parse( $conn, '');
		break;
}

if ($sql) {

oci_execute($sql);
$PromKv = array();
while ($row = oci_fetch_array($sql)) {
	array_push($PromKv, $row);
}

}


oci_close($conn);

//print_r($NoFlagData);

//console(print_r($totalgoalData));