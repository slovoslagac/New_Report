<!doctype html>
<html>
<?php 
$naslov_short="Admin";
$naslov="Naslovna strana admin dela";


include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));






?>
	<body>
		<div id="container">
	 		<?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php')));?> 
			<div id="match_data"></div>
		
			<?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
		</div>
	</body>
</html>