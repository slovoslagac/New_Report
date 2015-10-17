<!doctype html>
<html>
<?php 
require_once(join(DIRECTORY_SEPARATOR, array('..','init.php')));;
$css='css/admin.css';
$naslov_short="Admin";
$naslov="Povezivanje mečeva";
$kladionica="";
include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));



$i=0;

$data = array();

include(join(DIRECTORY_SEPARATOR, array('db', 'connectingMatches.php')));
$j=1;

?>
	<body>
		<div id="container">
	 		<?php $btn1='admin.php';$btn2='adminRedosled.php';$btn3='adminSpajanjeTakmicenja.php';$btn4='adminSpajanjeMeceva.php';
	 		include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php')));?> 
			<div id="match_data" class="size80">
				<form method="post" action="db/saveMatches.php">
					<table id="exportTable">
						<input type="submit" value="Sačuvaj" accesskey="x" />	
						<?php 
						include(join(DIRECTORY_SEPARATOR, array('included', 'mec_colgroup_table.php')));
						include(join(DIRECTORY_SEPARATOR, array('included', 'mec_table_header.php')));
						foreach ($ShowMatch as $d) { 
							include(join(DIRECTORY_SEPARATOR,array('included', 'mec_connecting_matches.php')));
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
