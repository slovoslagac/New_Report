select * from ulaz_odds;

select * from ulaz_new;

call import_data();

call import_data_game();


select * from import ;

delete
from src_odds where import_id = 8
and src_match_id not in (select id from src_match where src_match.source_id = 4);

select * from src_odds ;

update src_odds set offer = 1 where import_id in (8);

select id 
FROM src_odds
where import_id = 5
and src_match_id not in (select src_match_id from src_odds where import_id = 8);

update src_odds set offer = 1 
where import_id = 5 
and id in 
