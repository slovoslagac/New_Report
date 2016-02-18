<?php include(join(DIRECTORY_SEPARATOR, array('nas_helpmenu.php')));?>
<div id="menu">
	<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		<div id="trziste" name="trziste">
			<input type="submit" name="trziste" value="Srbija" />
			<input type="submit" name="trziste" value="Rumunija" />
			<p> bez odigranih :</p> 
			<input type="checkbox" name="prikaz" <?php echo ($prikaz == "da") ? '' : 'checked' ?> />
		</div>
	</form>
</div>