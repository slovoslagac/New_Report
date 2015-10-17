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
if(!empty($_post['cmp_id'])) {
	foreach($_post['cmp_id'] as $index => $inv) {
		if ($_post['cmp_new_position'][$index] != $_post['cmp_position'][$index]) {
			if($_post['cmp_new_position'][$index] == 0 ) {
			continue;
			}

			$indexes[] = $index;
		}
	}
}

// print_r($indexes);


foreach($indexes as $index) {
	// temporary data
	$tmp = array();
	$tmp['cmp_id'] = $_post['cmp_id'][$index];
	$tmp['cmp_name'] = $_post['cmp_name'][$index];
	$tmp['cmp_position'] = $_post['cmp_position'][$index];
	$tmp['cmp_new_position'] = $_post['cmp_new_position'][$index];
	


	$data[] = $tmp;
}


include(join(DIRECTORY_SEPARATOR, array('..','conn', 'mysqlAdminPDO.php')));

foreach ($data as $d) {

	$competitionId =$d['cmp_id'];
	$competitionPosition = $d['cmp_new_position'];



	$query = ' update liga set position = (:position)
	where id = (:id)';

	$params = array(
			'position' => $competitionPosition,
			'id' => $competitionId
	);

	$prepare = $conn->prepare($query);
	$prepare->execute($params);


}
$conn = null;

// print_r($data);

?>
	<body>
		<div id="container">
			<?php $btn1='../admin.php';$btn2='../adminRedosled.php';$btn3='../adminSpajanjeTakmicenja.php';$btn4='../adminSpajanjeMeceva.php';
	 		include(join(DIRECTORY_SEPARATOR, array('..','included', 'adm_menu.php')));?> 
			<div id="match_data">

					<table id="exportTable">
						<?php 
						include(join(DIRECTORY_SEPARATOR, array('..','included', 'red_colgroup_table.php')));
						?>
						<tr class="table_header">
							<th>Takmičenje</th>
							<th>Stara pozicija</th>
							<th>Nova pozicija</th>
						</tr>
						<?php 
						foreach ($data as $d) { ?>
							<tr class="table_matches row<?php echo($j++ & 1 )?>">
								<td><?php echo $d['cmp_name']?></td>
								<td><?php echo $d['cmp_position']?></td>
								<td><?php echo $d['cmp_new_position']?></td>
							</tr>
							
							
							<?php
							
						} 
						?>
					</table>
				

			</div>

			<?php include(join(DIRECTORY_SEPARATOR, array('..','included', 'adm_footer.php'))); ?>
		</div>
	
	</body>
</html>
