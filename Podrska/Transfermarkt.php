<!doctype html>
<html>
	<head>
		<meta charset="ISO-8859-1">
		<link rel="icon" href="../img/mozzart.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="../css/transfermarkt.css">
		<title>Transfermarkt</title>
	</head>
	<?php 
	$path = join(DIRECTORY_SEPARATOR, array('..','query', 'transfermarkt.php'));
	include $path;
	$data=$tmDouble;
	
	
	?>
	<body>
		<div id="container">
			<div id="helpmenu">
				<a href="../index.php"><img alt="" src="../img/MozzartLogo.png"></a>
			</div>
			<div id="header">
				<h1>Pregled dupliranih veza sa transfermakrtom</h1>
			</div>
			<div id="menu">
				<div id="center">
					<ul>
						<li>
							<a href="../Teletext/index.php">Teletext</a>
						</li>
						<li>
							<a href="../Podrska/index.php">Tehnička podrška</a>
						</li>
						<li>
							<a href="../Verif/index.php">Verifikacija</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="match_data">
				<table id="exportTable">
					<tr class="table_header">
						<th>Sport</th>
						<th>Mozzart name</th>
						<th>Transfermarkt id</th>
						<th>Transfermarkt name</th>
					</tr>
					<?php foreach ($data as $m) {?>
					<tr class="row<?php echo($j++ & 1 )?>">
						<td><?php echo $m[0]?></td>
						<td><?php echo $m[1]?></td>
						<td><?php echo $m[2]?></td>
						<td><?php echo $m[3]?></td>
					</tr>
					<?php }?>
				</table>
			</div>
		</div>
	</body>
</html>
