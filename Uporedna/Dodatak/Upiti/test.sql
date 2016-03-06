select * from src_match where id = 19733;


select cm.init_match_id, max(sm.id), sm.source_id
from conn_match cm, src_match sm
where cm.src_match_id = sm.id
group by cm.init_match_id, sm.source_id
having count(*)>1

;

select max(sm.id)
from conn_match cm, src_match sm
where cm.src_match_id = sm.id
group by cm.init_match_id, sm.source_id
having count(*)>1

;

delete from src_current_odds
where src_match_id in 
('18803', '18628', '18641', '18793', '18794', '18795', '10647', '18615', '20633', '20625', '19626', '17454', '8342', '18668', '18667', '19670', '19578', '18459', '19579', '19603', '19605', '19602', '19604', '19600', '19601', '19573', '5098', '18801', '18802', '11823', '19671', '19672', '17400', '19738', '19739', '19740', '19678', '19376', '19584', '19583', '19585', '18692', '18680', '19652', '19653', '19434', '19570', '19632', '19633', '5687', '9760', '19586', '19590', '19588', '19587', '19589', '19592', '19591', '16502', '19619', '18408', '19599', '20242', '20238')