select sm.season_id, sm.src_competition_id, count(*)
from src_match_result smr, src_match sm
where smr.match_id = sm.id
group by season_id, sm.src_competition_id
order by 2 desc, 1 desc
;

select ss.name, sm.src_competition_id, count(*)
from src_match_detail smd, src_match sm,src_seasons ss
where smd.match_id = sm.id
and sm.season_id = ss.id 
group by ss.name, sm.src_competition_id
order by 2 desc, 1 desc
;

select ss.name, ic.name , count(*)
from src_match sm, conn_competition cc, init_competition ic, src_seasons ss
where sm.source_id = 11
and sm.src_competition_id = cc.src_competition_id
and ic.id = cc.init_competition_id
and sm.season_id = ss.id
group by sm.season_id, ic.name
order by cc.src_competition_id desc, 1 desc

;

select ic.name , count(*)
from src_match sm, conn_competition cc, init_competition ic
where sm.source_id = 11
and sm.src_competition_id = cc.src_competition_id
and ic.id = cc.init_competition_id
group by ic.name
order by 1

;

select ss.name, ic.name , sm.round_id, count(*)
from src_match sm, conn_competition cc, init_competition ic, src_seasons ss
where sm.source_id = 11
and sm.src_competition_id = cc.src_competition_id
and ic.id = cc.init_competition_id
and sm.season_id = ss.id
and ss.name = '2016-2017'
and ic.name = 'SRBIJA  1'
group by sm.season_id, ic.name, sm.round_id
order by cc.src_competition_id desc, 1 desc, 3

;