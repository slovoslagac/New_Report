<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));
// $kladionica_name='balkanbet';

$sql = 'select id, ime_lepo, position from liga where ime_lepo <> "" order by position desc, ime_lepo';

// echo $sql;


$FindCmp = $conn -> prepare($sql);
$FindCmp -> execute();
$ShowCmp = $FindCmp -> fetchAll ( PDO::FETCH_ASSOC);

$conn = null;


// print_r($ShowCmp);
?>