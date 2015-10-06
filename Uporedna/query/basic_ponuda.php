<?php
include(join(DIRECTORY_SEPARATOR, array('..','conn', 'mysqlPDO.php')));

$SelMatc = $conn -> prepare("
	select a.vreme, 
	a.sifra, a.takm, 
	a.dom, 
	a.gost, 
	a.ki11, 
	a.ki12, 
	a.ki13, 
	p.ki_1 as ki21, 
	p.ki_x as k22, 
	p.ki_2 as k23
from
(
select u.vreme vreme, u.sifra sifra, l.ime_lepo takm, d.ime_lepo dom, g.ime_lepo gost, m.ki_1 ki11, m.ki_x ki12, m.ki_2 ki13, u.id
from utakmica u, tim d, tim g, liga l , mozzart3 m
where u.kolo = (select max(kolo) from utakmica)
and u.liga_id=l.id
and u.domacin_id=d.id
and u.gost_id=g.id
and m.utakmica_id=u.id
and l.ime_mozzart like 'KVALIFIK%' ) a
left join planetwin3 p on p.utakmica_id=a.id
order by a.takm, a.sifra");
$SelMatc -> execute();
$ShowMatches = $SelMatc -> fetchAll ( PDO::FETCH_ASSOC);

//print_r($ShowMatches);

?>