<!doctype html>
<html>
<?php 
$naslov_short="Uporedna lista";
$naslov="Naslovna strana uporedne liste";
$numBookmakers=9;
$percent=90;
$Data= array();
$league="";
$region="sr";

include(join(DIRECTORY_SEPARATOR, array('included', 'nas_header.php')));
include(join(DIRECTORY_SEPARATOR, array('query', 'basic_ponuda.php')));

$Data = $ShowMatches;

include(join(DIRECTORY_SEPARATOR, array('functions', 'fun_naslovna.php')));


if (isset ( $_GET["trziste"] ) != "") {
		$region=$_GET["trziste"] ;
	}


?>
	<body>
		<div id="container">
			<?php include(join(DIRECTORY_SEPARATOR, array('included', 'nas_menu.php')));?>
			<div id="match_data">
				<table id="exportTable">
					<?php include(join(DIRECTORY_SEPARATOR, array('included', 'nas_colgroup_table.php'))); 
					foreach ($Data as $d) {
						if ($d['takm']!=$league) { 
							$league=$d['takm']; $league_id=$d['ligaid'];$j=1;
							include(join(DIRECTORY_SEPARATOR, array('included', 'nas_naslov_tabele.php')));
							include(join(DIRECTORY_SEPARATOR, array('included', 'nas_podnaslov_tabele.php')));

						}
						$date= new DateTime($d['vreme']);$day=$date->format('m.d') ;$time=$date->format('H:i');
						$code=$d['sifra'];$home_team=$d['dom'];$visitor_team=$d['gost'];$fav=$d['fav'];
						include(join(DIRECTORY_SEPARATOR, array('included', 'nas_mecevi_tabele.php')));
						
					} ?>

				</table>
			</div>
		</div>
		<?php include(join(DIRECTORY_SEPARATOR, array('included', 'nas_footer.php'))); ?>
	</body>
</html>
