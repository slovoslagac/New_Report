<!doctype html>
<html>
<?php
require_once(join(DIRECTORY_SEPARATOR, array('..', 'init.php')));;
$css = 'css/admin.css';
$naslov_short = "Admin";
$naslov = "Spajena takmičenja za odabranu kladionicu";
$kladionica_name = '';


include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));


$i = 1;
$data = array();
$indexes = array();
$changes = array();

$bookie = $_POST['source'];

// fetch data
$_post = $_POST;
if(!empty($_post['source_data'])) {
	foreach($_post['source_data'] as $index => $inv) {
		if($_post['mozz_match'][$index] == 0 ) {
			continue;
			}

		$indexes[] = $index;
		// echo $_post['di'][$index];


	}
}

if(empty($_POST['change_visitor'])) {

} else {

	$changes = $_POST['change_visitor'];
}
// print_r($indexes);

// collect data for DB inserts
foreach ($indexes as $index) {
	// temporary data
	$tmp = array();

	$source_data = explode("__", $_post['source_data'][$index]);

	$tmp['src_match'] = $source_data[0];
	$tmp['src_home_team_id'] = $source_data[1];
	$tmp['src_visitor_team_id'] = $source_data[2];
	$tmp['src_home_team_name'] = $source_data[3];
	$tmp['src_visitor_team_name'] = $source_data[4];


	$mozzart_data = explode("__", $_post['mozz_match'][$index]);

	$tmp['mozzart_match'] = $mozzart_data[0];
	$tmp['mozzart_home_team_id'] = $mozzart_data[1];
	$tmp['mozzart_visitor_team_id'] = $mozzart_data[2];
	$tmp['mozzart_home_team_name'] = $mozzart_data[3];
	$tmp['mozzart_visitor_team_name'] = $mozzart_data[4];

//	if($_post['change_visitor'] != "" ){
//		$tmp['home_visitor'] = 1;
//	} else {
//		$tmp['home_visitor'] = 0;
//	}
//	$tmp['home_visitor'] = (isset($_post['change_visitor'][$index]) == "on") ? 1 : 0;

//	echo $_post['change_visitor'][$index]."<br>";

	if(in_array($tmp['src_match'],$changes)){
		$tmp['home_visitor'] = 1;
	} else {
		$tmp['home_visitor'] = 0;
	}

	$data[] = $tmp;
}

 $conn = null;








?>
<body>
<div id="container">
	<?php $btn1 = 'admin.php';
	$btn2 = 'adminRedosled.php';
	$btn3 = 'adminSpajanjeTakmicenja.php';
	$btn4 = 'adminSpajanjeMeceva.php';
	$btn5 = 'adminKontrolaTakmicenja.php';
	include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php'))); ?>
	<div id="function_data">
		<table id="exportTable">
			<thead>

			<tr class="naslov">
				<td><?php echo $bookie ?></td>
				<td>Mozzart</td>
				<td>Obrnuto domaćinstvo</td>
			</tr>
			</thead>
			<?php
			include(join(DIRECTORY_SEPARATOR, array('included', 'mec_colgroup_table.php'))); ?>
			<tbody>
			<?php
			foreach ($data as $d1) { ?>
				<tr class="row<?php echo($i++ & 1) ?>">
					<td><?php echo ($d1['home_visitor'] == 0 ) ? $d1['src_home_team_name']." - ".$d1['src_visitor_team_name'] : $d1['src_visitor_team_name']." - ". $d1['src_home_team_name']?></td>
					<td><?php echo $d1['mozzart_home_team_name']." - ".$d1['mozzart_visitor_team_name'] ?></td>
					<td><?php echo ($d1['home_visitor'] == 1 ) ? "da" : "" ?></td>
				</tr>
			<?php } ?>

			</tbody>
		</table>
	</div>
</div>


</body>


</html>