insert into conn_match (init_match_id, src_match_id, home_visitor )
select im.event_id, sm.id, 0
from init_match im, conn_team ct, conn_team ct1, src_match sm, conn_competition cc
where im.home_team_id = ct.init_team_id
and im.visitor_team_id = ct1.init_team_id
and sm.src_home_team_id = ct.src_team_id
and sm.src_visitor_team_id = ct1.src_team_id
and cc.init_competition_id = im.competition_id
and sm.src_competition_id = cc.src_competition_id
and (im.event_id, sm.id) not in (select cm1.init_match_id, cm1.src_match_id from conn_match cm1)
on DUPLICATE KEY update init_match_id= init_match_id
;


select * from conn_match where home_visitor is null;

update conn_match set home_visitor = 0 where home_visitor is null;

select * from src_match where source_id = 6;

select * from init_subgame where mozzart_game_id in (1,3,130

;

select * 
from conn_subgame cs, src_subgames ss
where cs.subgame_id in ( 1,2,3, 10, 225)
and cs.src_subgame_id = ss.id
and ss.source_id = 6

;

select g.sifra, so.value, so1.value, so2.value, so3.value, so4.value
from
(
select i.match_number sifra, cm.src_match_id as game_code
from init_current_offer i, conn_match cm
where i.event_id = cm.init_match_id
and i.list_type_id = 4
and cm.src_match_id in (select id FROM src_match where src_match.source_id = 6) ) g
left join src_current_odds so on g.game_code = so.src_match_id and so.src_subgame_id = 1837
left join src_current_odds so1 on g.game_code = so1.src_match_id and so1.src_subgame_id = 1839
left join src_current_odds so2 on g.game_code = so2.src_match_id and so2.src_subgame_id = 1838
left join src_current_odds so3 on g.game_code = so3.src_match_id and so3.src_subgame_id = 37
left join src_current_odds so4 on g.game_code = so4.src_match_id and so4.src_subgame_id = 126
order by 1







