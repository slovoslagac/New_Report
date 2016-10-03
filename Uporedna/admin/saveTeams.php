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
if(!empty($_post['source_team'])) {
	foreach($_post['source_team'] as $index => $inv) {
		if($_post['mozz_team'][$index] == 0 ) {
			continue;
			}

		$indexes[] = $index;
		// echo $_post['di'][$index];


	}
}

//if(empty($_POST['change_visitor'])) {
//
//} else {
//
//	$changes = $_POST['change_visitor'];
//}
// print_r($indexes);

// collect data for DB inserts
foreach ($indexes as $index) {
	// temporary data
	$tmp = array();

	$source_team = explode("__", $_post['source_team'][$index]);

	$tmp['src_team_id'] = $source_team[0];
	$tmp['src_team_name'] = $source_team[1];


	$mozzart_data = explode("__", $_post['mozz_team'][$index]);

	$tmp['mozzart_team_id'] = $mozzart_data[0];
	$tmp['mozzart_team_name'] = $mozzart_data[1];



//	if(in_array($tmp['src_match'],$changes)){
//		$tmp['home_visitor'] = 1;
//	} else {
//		$tmp['home_visitor'] = 0;
//	}

	$data[] = $tmp;
}

include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));

foreach ($data as $d) {


    $mozzartTeamID = $d['mozzart_team_id'];


    $srcTeamID = $d['src_team_id'];




    $sql = "insert into conn_team ( init_team_id, src_team_id ) values ";


        $sql .= "(". $mozzartTeamID . ",". $srcTeamID . ") ON DUPLICATE KEY UPDATE init_team_id=init_team_id";


    $prepare = $conn->prepare($sql);
    $prepare->execute();

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
		<table id="exportTable" class="size60">
			<thead>

			<tr class="title">
				<td>Mozzart</td>
				<td><?php echo $bookie ?></td>
			</tr>
			</thead>
			<?php
			include(join(DIRECTORY_SEPARATOR, array('included', 'mec_colgroup_table.php'))); ?>
			<tbody>
			<?php
			foreach ($data as $d1) { ?>
				<tr class="row<?php echo($i++ & 1) ?>">
					<td><?php echo $d1['mozzart_team_name']?></td>
					<td><?php echo $d1['src_team_name']?></td>
				</tr>
			<?php } ?>

			</tbody>
		</table>
	</div>
</div>


</body>


</html>