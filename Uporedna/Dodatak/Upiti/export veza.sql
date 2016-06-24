select ic.id, ic.sport_id, sc.name, sc.competition_id
from init_competition ic, conn_competition cc, src_competition sc
where ic.id = cc.init_competition_id
and cc.src_competition_id = sc.id
and sc.source_id = 2;



select it.id, it.sport_id, st.name, st.team_id
from init_team it, conn_team ct, src_team st
where it.id = ct.init_team_id 
and ct.src_team_id = st.id
and st.source_id = 2

;

select ins.mozzart_game_id, ins.mozzart_subgame_id, ss.game, ss.subgame
from init_subgame ins, conn_subgame cs, src_subgames ss
where ins.id = cs.subgame_id
and cs.src_subgame_id = ss.id
and ss.source_id = 10