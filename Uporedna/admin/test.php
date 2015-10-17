<!doctype html>
<html>
<?php 

require_once(join(DIRECTORY_SEPARATOR, array('..','init.php')));;
// $ico='../../img/mozzart.ico';
$css='css/admin.css';
$naslov_short="Admin";
$naslov="Naslovna strana admin dela";
include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));



//Part connected with this page

$i=0;

$kladionica_name='';
$data = array();

include(join(DIRECTORY_SEPARATOR, array('db', 'leaguesPosition.php')));







?>

<?php

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


print_r($data);




?>



	<body>
		<div id="container">
	 		<?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php')));?> 
			<div id="match_data">
				<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
					<table id="exportTable">
						<input type="submit" value="Sačuvaj" />	
						<?php 
						include(join(DIRECTORY_SEPARATOR, array('included', 'red_colgroup_table.php')));
						include(join(DIRECTORY_SEPARATOR, array('included', 'red_Table_Header.php')));
						foreach ($ShowCmp as $d) { 
							include(join(DIRECTORY_SEPARATOR,array('included', 'red_table_matches.php')));
							?>
							
							<?php
							$i++;
						} 
						?>
					</table>
				
				</form>
			</div>

			<?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
		</div>
	
	</body>
</html>


