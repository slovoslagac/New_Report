insert into conn_match (init_match_id, src_match_id)
select im.event_id, sm.id
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





