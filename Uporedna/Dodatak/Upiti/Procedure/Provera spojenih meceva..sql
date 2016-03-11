select *
from init_current_offer ico
where ico.list_type_id = 4


;
select mozz.start, mozz.cmp, mozz.ht, mozz.vt, 
  case when socc.smi is not null then 1 else 0 end so,
  case when bbet.smi is not null then 1 else 0 end bb,
  case when pinn.smi is not null then 1 else 0 end pn,
  case when pwin.smi is not null then 1 else 0 end pw
from 
(
select im.start_time start, ic.name cmp, t1.name ht, t2.name vt, im.event_id code
from init_match im, init_team t1, init_team t2, init_competition ic
where im.event_id in (select event_id from init_current_offer ico where ico.list_type_id = 4 and ico.special_type = 0)
and im.home_team_id = t1.id
and im.visitor_team_id = t2.id
and ic.id = im.competition_id ) mozz
left join (select cm.init_match_id, cm.src_match_id smi from conn_match cm, src_match sm where cm.src_match_id = sm.id and sm.source_id = 2) socc on mozz.code = socc.init_match_id
left join (select cm.init_match_id, cm.src_match_id smi from conn_match cm, src_match sm where cm.src_match_id = sm.id and sm.source_id = 3) bbet on mozz.code = bbet.init_match_id
left join (select cm.init_match_id, cm.src_match_id smi from conn_match cm, src_match sm where cm.src_match_id = sm.id and sm.source_id = 4) pinn on mozz.code = pinn.init_match_id
left join (select cm.init_match_id, cm.src_match_id smi from conn_match cm, src_match sm where cm.src_match_id = sm.id and sm.source_id = 5) pwin on mozz.code = pwin.init_match_id
order by 2,1,3


;

select * from conn_match cm, src_match sm where cm.src_match_id = sm.id and sm.source_id = 2
