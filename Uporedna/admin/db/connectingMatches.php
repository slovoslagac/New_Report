<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

$sql = 'select liga, domacin, gost 
from maxbet3
where liga in (\'ENGLAND Premier League\',\'England Championship\')
order by liga, domacin, gost';

// echo $sql;


$FindMatch = $conn -> prepare($sql);
$FindMatch -> execute();
$ShowMatch = $FindMatch -> fetchAll ( PDO::FETCH_ASSOC);



$sql1 = 'select id, ime_lepo 
from liga
where ime_lepo <> ""
and id in (1,36)
and id in (select distinct liga_id from utakmica where kolo = (select max(kolo) from utakmica))
order by 2';


$FindCmp = $conn -> prepare($sql1);
$FindCmp -> execute();
$ShowMozzCmp = $FindCmp -> fetchAll( PDO::FETCH_ASSOC);



$sql2 = 'select u.id utk, u.liga_id ligaid, d.id did, d.ime_lepo dime, g.id gid, g.ime_lepo gime
from utakmica u, tim d, tim g
where u.kolo = (select max(kolo) from utakmica)
and u.domacin_id=d.id
and u.gost_id=g.id
and u.liga_id in (1,36)
order by 2,4';

$FindMozzMatch = $conn ->prepare($sql2);
$FindMozzMatch -> execute();
$ShowMozzMatch = $FindMozzMatch -> fetchAll(PDO::FETCH_ASSOC);



$conn = null;


// print_r($ShowCmp);
?>