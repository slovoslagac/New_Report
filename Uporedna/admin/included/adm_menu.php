<div id="helpmenu">
	<a href="../../index.php"><img alt="" src="../../img/MozzartLogo.png"></a>
	<h1><?php echo $naslov?></h1>
</div>
<div id="menu">
	<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		<div id="part">
			<input type="submit" name="part" value="Redosled takmičenja" />
			<input type="submit" name="part" value="Spajanje takmičenja" />
			<input type="submit" name="part" value="Spajanje mečeva" />
		</div>
	</form>
</div>