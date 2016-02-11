<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

$sql = 'select id, name, position from init_competition order by position desc, name';

// echo $sql;


$FindCmp = $conn -> prepare($sql);
$FindCmp -> execute();
$ShowCmp = $FindCmp -> fetchAll ( PDO::FETCH_ASSOC);

$conn = null;


// print_r($ShowCmp);
?>