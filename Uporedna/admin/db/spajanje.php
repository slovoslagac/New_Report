<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

$sql = 'call spajanje_'.$kladionica_name;

// echo $sql;


$SelMatc = $conn -> prepare($sql);
$SelMatc -> execute();
$conn = null;



?>

