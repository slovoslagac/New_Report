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

select * from init_subgame where mozzart_game_id in (1,3,130)



;

select * 
from conn_subgame cs, src_subgames ss
where cs.subgame_id in ( 1,2,3, 10, 225)
and cs.src_subgame_id = ss.id
and ss.source_id = 9

;

update conn_subgame cs, src_subgames ss, init_subgame isg set ss.position = isg.position
where cs.src_subgame_id = ss.id
and cs.subgame_id = isg.id
and ss.position is null
and isg.position is not null;

SelECT *from import_source







