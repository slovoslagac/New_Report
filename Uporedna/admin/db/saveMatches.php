<!doctype html>
<html>
<?php
require_once(join(DIRECTORY_SEPARATOR, array('..','..','init.php')));;
// $ico='../../../img/mozzart.ico';
$css='../css/admin.css';
$naslov_short="Admin";
$naslov="Uspešno su promenjene pozicije takmičenja";
include(join(DIRECTORY_SEPARATOR, array('..','included', 'adm_header.php')));
$data = array();
$indexes = array();
$j=1;

// fetch data
$_post = $_POST;
if(!empty($_post['league_name'])) {
	foreach($_post['league_name'] as $index => $inv) {
		if ($_post['cmp_new_position'][$index] != $_post['cmp_position'][$index]) {
			if($_post['cmp_new_position'][$index] == 0 ) {
			continue;
			}

			$indexes[] = $index;
		}
	}
}

// print_r($indexes);



$conn = null;

// print_r($data);

?>

</html>