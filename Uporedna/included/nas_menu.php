<div id="helpmenu">
	<a href="../index.php"><img alt="" src="../img/MozzartLogo.png"></a>
</div>
<div id="header">
	<h1><?php echo $naslov?></h1>
</div>
<div id="menu">
	<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		<div id="trziste" name="trziste">
			<button value="1">Srbija</button>
			<button value="2">Rumunija</button>
			<input type="Submit" value="Osveži">
		</div>
	</form>
</div>