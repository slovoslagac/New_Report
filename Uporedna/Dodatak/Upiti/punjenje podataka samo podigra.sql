DROP PROCEDURE IF EXISTS Uporedna_new.import_data;
CREATE PROCEDURE Uporedna_new.`import_data`()
begin
insert into src_competition (competition_id, name, source_id)
select distinct liga_id, liga, source
from ulaz_new
where (liga_id, liga, source) not in (select competition_id, name, source_id from src_competition);
insert into src_team ( name, team_id, source_id )
select distinct name, team_id, source
from
(
select dom name, dom_id team_id, source
from ulaz_new
where (dom, dom_id, source) not in (select name, team_id, source_id from src_team)
union all
select gost name, gost_id team_id, source
from ulaz_new
where (gost, gost_id, source) not in (select name, team_id, source_id from src_team)) a
;
insert into src_match ( start_time, name, match_id, src_home_team_id, src_visitor_team_id, src_competition_id, source_id, sport_id )
select distinct un.starttime,un.utakmica, un.utk_id, st.id, st1.id, sc.id, source, 1  
from ulaz_new un, src_competition sc, src_team st, src_team st1
where sc.competition_id = un.liga_id
and un.dom_id = st.team_id
and un.gost_id = st1.team_id;
select distinct game, subgame, source 
from ulaz_odds
where (game, subgame, source) not in (select game, subgame, source from src_games);
insert into src_games (game, subgame, source_id)
select distinct game, subgame, source 
from ulaz_odds
where (game, subgame, source) not in (select game, subgame, source from src_games);
insert into import (source_id) select max(source) from ulaz_odds;
insert into src_odds ( src_match_id, src_subgame_id, value, handicap, import_id)
select distinct sm.id, sg.id, uo.odd_value, uo.handicap, (select max(id) from import where source_id=(select max(source) from ulaz_odds))
from ulaz_odds uo, src_match sm, src_subgames sg
where uo.utk_id = sm.match_id
and uo.subgame = sg.subgame
and uo.source = sg.source_id
ON DUPLICATE KEY UPDATE src_match_id=src_match_id;
end;