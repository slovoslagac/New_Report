<!doctype html>
<html>
<?php 
$naslov_short="Uporedna lista";
$naslov="Naslovna strana uporedne liste";
$numBookmakers=2;
$percent=73;
$j=1;
$Data= array();
$league="";

include(join(DIRECTORY_SEPARATOR, array('included', 'nas_header.php')));
include(join(DIRECTORY_SEPARATOR, array('query', 'basic_ponuda.php')));

$Data = $ShowMatches;



?>
	<body>
		<div id="container">
			<div id="helpmenu"><a href="../index.php">
				<img alt="" src="../img/MozzartLogo.png"></a>
			</div>
			<div id="header">
				<h1><?php echo $naslov?></h1>
			</div>
			<div id="menu">
				
			</div>
			<div id="match_data">
				<table id="exportTable">
					<?php include(join(DIRECTORY_SEPARATOR, array('included', 'nas_colgroup_table.php'))); 
					foreach ($Data as $d) {
						if ($d['takm']!=$league) { 
							$league=$d['takm']; $league_id=$d['ligaid'];
							include('included/nas_naslov_tabele.php');
							include('included/nas_podnaslov_tabele.php');

							?>




						<?php	}
						
					} ?>

				</table>
			</div>
		</div>
	</body>
</html>
