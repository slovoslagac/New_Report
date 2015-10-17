<!doctype html>
<html>
<?php 
require_once(join(DIRECTORY_SEPARATOR, array('..','init.php')));;
$css='css/admin.css';
$naslov_short="Admin";
$naslov="Naslovna strana admin dela";
$kladionica_name='';

include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));

?>
	<body>
		<div id="container">
	 		<?php $btn1='admin.php';$btn2='adminRedosled.php';$btn3='adminSpajanjeTakmicenja.php';$btn4='adminSpajanjeMeceva.php';
	 		include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php')));?> 
			<div id="function_data">
				
			</div>
			<?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
		</div>
	</body>
</html>