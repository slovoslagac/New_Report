DROP PROCEDURE IF EXISTS Uporedna_new.mozzart_current_odds;
CREATE PROCEDURE Uporedna_new.`mozzart_current_odds`()
begin
delete from current_init_odds where event_id in ( select distinct event_id from init_odds);
delete from current_init_odds where event_id not in (select event_id from init_odds where round_id in (select max(round_id) from init_odds));
insert into current_init_odds( match_number, event_id, list_type, ki1, kix, ki2, ug3p )
select distinct o1.match_number, o1.event_id, o1.list_type, o1.value, o2.value, o3.value, o4.value
from init_odds o1, init_odds o2, init_odds o3, init_odds o4
where o1.game_id=1
and o1.subgame_id=1
and o1.round_id = (select max(round_id) from init_odds where init_odds.list_type=4)
and o2.game_id=1
and o2.subgame_id=2
and o3.game_id=1
and o3.subgame_id=3
and o4.game_id=3
and o4.subgame_id=4
and o1.event_id = o2.event_id
and o1.list_type = o2.list_type
and o1.event_id = o3.event_id
and o1.list_type = o3.list_type
and o1.event_id = o4.event_id
and o1.list_type = o4.list_type;
end;
