<?php
include(join(DIRECTORY_SEPARATOR, array('..','conn', 'mysqlAdminPDO.php')));

class match {
	public $utk;
	public $dime;

	public function homeid($utk) {
		return $dime;
	}
}

$sql = 'select u.id utk, u.liga_id ligaid, d.id did, d.ime_lepo dime, g.id gid, g.ime_lepo gime
from utakmica u, tim d, tim g
where u.kolo = (select max(kolo) from utakmica)
and u.domacin_id=d.id
and u.gost_id=g.id
and u.liga_id in (1,36)
order by 2,4';

$FindMozzMatch = $conn ->prepare($sql);
$FindMozzMatch -> execute();
$ShowMozzMatch = $FindMozzMatch -> fetchAll(PDO::FETCH_CLASS,"match");

$conn = null;


var_dump($ShowMozzMatch);

echo "<br>";

echo homeid('328765');

?>