<?php
ini_set('memory_limit', '512M');
$path = join(DIRECTORY_SEPARATOR,array('..','conn', 'OracleProske.php'));
include $path;
$sql= oci_parse( $conn, 'select  
        id_lige_tb as league_id, 
        tip as type, 
        sezona as season, 
        liga as league,
		liga_lepo as league_nice
from PROSKE.STAT_LIGE_O
where id_lige_tb > 0
and tip in (0,1)
order by 5'); 

oci_execute($sql);
$selectleague = array();
while ($row = oci_fetch_array($sql)) {
	array_push($selectleague, $row);
}

oci_close($conn);

//print_r($selectleague);