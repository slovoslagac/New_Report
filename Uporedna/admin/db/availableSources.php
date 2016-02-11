<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));


$ConnSource = $conn -> prepare('select id, name from import_source where foreign_source = 1');

$ConnSource -> execute();
$resultSources = $ConnSource -> fetchAll ( PDO::FETCH_ASSOC);



$conn = null;


// print_r($ShowCmp);
?>