<!doctype html>
<html>
<?php 

require_once(join(DIRECTORY_SEPARATOR, array('..','init.php')));;
// $ico='../../img/mozzart.ico';
$css='css/admin.css';
$naslov_short="Admin";
$naslov="Definisanje redosleda takmičenja u uporednoj listi";
include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));

//Part connected with this page

$i=0;

$data = array();

include(join(DIRECTORY_SEPARATOR, array('db', 'leaguesPosition.php')));
$j=1;
$data=$ShowCmp;





?>
	<body>
		<div id="container">
	 		<?php $btn1='admin.php';$btn2='adminRedosled.php';$btn3='adminSpajanjeTakmicenja.php';$btn4='adminSpajanjeMeceva.php';
	 		include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php')));?> 
			<div id="match_data" class="size60">
				<form method="post" action="db/savePositions.php">
					<table id="exportTable">
						<input type="submit" value="Sačuvaj" accesskey="x" />	
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
