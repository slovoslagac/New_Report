insert into src_current_odds (src_match_id, src_subgame_id, value, handicap, source_id)
select distinct src_match_id, src_subgame_id, value, handicap, i.source_id
from src_odds so, import i
where so.import_id = i.id
and so.import_id = 66
and (so.src_match_id, i.source_id) not in (select distinct src_match_id, source_id from src_current_odds)
on DUPLICATE KEY update src_match_id=so.src_match_id
;

call import_data();

call import_data_game();

select * from import order by id desc;
;
delete from src_current_odds where src_match_id in (select src_match_id from src_odds where src_odds.import_id > 45)

;

select count(*) from src_current_odds where source_id = 2

;
select * from src_odds where import_id = 28;

select count(*) from src_odds where import_id = 25;

select count(*) from ulaz_odds;

select distinct source, `timestamp` from ulaz_odds;

select distinct source, `timestamp`  from ulaz_new;



SELECT table_name, table_rows, data_length, index_length, 
round(((data_length + index_length) / 1024 / 1024),2) "Size in MB"
FROM information_schema.TABLES where table_schema = "Uporedna_new"
order by 5 desc
;

select id 
from src_team where name like '%:';
