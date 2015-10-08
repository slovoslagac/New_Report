<div id="helpmenu">
	<a href="../index.php"><img alt="" src="../img/MozzartLogo.png"></a>
	<h1><?php echo $naslov?></h1>
</div>
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