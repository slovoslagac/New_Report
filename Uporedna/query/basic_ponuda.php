<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlPDO.php')));


$sql='';

switch ($region) {
	case "Srbija":
		if ($prikaz == 'da') {
		include("offer_srbija_full.php");
		break;
	} else {
		include("offer_srbija.php");
		break;
	}
	case "Rumunija":
		if ($prikaz == 'da') {
		include("offer_rumunija_full.php");
		break;
	} else {
		include("offer_rumunija.php");
		break;
	}
	default:
		include("offer_srbija_full.php");
		break;

}

$SelMatc = $conn -> prepare($sql);
$SelMatc -> execute();
$ShowMatches = $SelMatc -> fetchAll ( PDO::FETCH_ASSOC);

// print_r($ShowMatches);

// foreach ($ShowMatches as $d) {
// 	print_r($d)."<br>";
// }

?>