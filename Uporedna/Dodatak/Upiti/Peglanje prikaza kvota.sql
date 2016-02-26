select * from ulaz_odds;

select * from ulaz_new;

call import_data();

call import_data_game();


select * from import where source_id = 5 ;

select *
from src_odds where import_id =17
and src_match_id not in (select id from src_match where src_match.source_id = 5);

select * from src_odds ;

update src_odds set offer = 0 where import_id in (7,11);


select count(*), import_id, offer
from src_odds
group by import_id, offer

;

select count(*), import_id, offer
from src_odds
group by import_id, offer

;
select id 
FROM src_odds
where import_id = 17
and src_match_id not in (select src_match_id from src_odds where offer = 1 and import_id in (2));

update src_odds set offer = 1 
where import_id = 11 
and id in 
