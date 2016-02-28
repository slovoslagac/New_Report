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


	if(in_array($tmp['src_match'],$changes)){
		$tmp['home_visitor'] = 1;
	} else {
		$tmp['home_visitor'] = 0;
	}

	$data[] = $tmp;
}

include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));

foreach ($data as $d) {

	$homeVisitor = $d['home_visitor'];
    $mozzartMatchId = $d['mozzart_match'];
    $mozzartHomeTeamID = $d['mozzart_home_team_id'];
    $mozzartVisitorTeamID = $d['mozzart_visitor_team_id'];
	$srcMatchId = $d['src_match'];
    $srcHomeTeamID = $d['src_home_team_id'];
    $srcVisitorTeamID = $d['src_visitor_team_id'];


	$query = '
INSERT INTO
conn_match (init_match_id, src_match_id, home_visitor)
VALUES
(:init_match_id, :src_match_id,:home_visitor)
ON DUPLICATE KEY UPDATE init_match_id=:init_match_id;
';

	$params = array(
		'init_match_id' => $mozzartMatchId,
		'src_match_id' => $srcMatchId,
        'home_visitor' => $homeVisitor
	);

	$prepare = $conn->prepare($query);
	$prepare->execute($params);

    $sql = "insert into conn_team ( init_team_id, src_team_id ) values ";

    if ($homeVisitor == 0) {
        $sql .= "(". $mozzartHomeTeamID . ",". $srcHomeTeamID . "),(". $mozzartVisitorTeamID . ",". $srcVisitorTeamID . ") ON DUPLICATE KEY UPDATE init_team_id=init_team_id";
    } else {
        $sql .= "(". $mozzartHomeTeamID . ",". $srcVisitorTeamID . "),(". $mozzartVisitorTeamID . ",". $srcHomeTeamID . ") ON DUPLICATE KEY UPDATE init_team_id=init_team_id";
    }

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
				<td>Obrnuto domaćinstvo</td>
			</tr>
			</thead>
			<?php
			include(join(DIRECTORY_SEPARATOR, array('included', 'mec_colgroup_table.php'))); ?>
			<tbody>
			<?php
			foreach ($data as $d1) { ?>
				<tr class="row<?php echo($i++ & 1) ?>">
					<td><?php echo $d1['mozzart_home_team_name']." - ".$d1['mozzart_visitor_team_name'] ?></td>
					<td><?php echo ($d1['home_visitor'] == 0 ) ? $d1['src_home_team_name']." - ".$d1['src_visitor_team_name'] : $d1['src_visitor_team_name']." - ". $d1['src_home_team_name']?></td>
					<td><?php echo ($d1['home_visitor'] == 1 ) ? "da" : "" ?></td>
				</tr>
			<?php } ?>

			</tbody>
		</table>
	</div>
</div>


</body>


</html>