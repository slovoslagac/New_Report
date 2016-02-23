select *
from init_match im, conn_team ct, conn_team ct1, src_match sm, conn_competition cc
where im.home_team_id = ct.init_team_id
and im.visitor_team_id = ct1.init_team_id
and sm.src_home_team_id = ct.src_team_id
and sm.src_visitor_team_id = ct1.src_team_id
and cc.init_competition_id = im.competition_id
and sm.src_competition_id = cc.src_competition_id
and sm.id not in (select src_match_id from conn_match cm1);





