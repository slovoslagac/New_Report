<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="refresh" content="60">
	<title>Kontrola termina</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/default.css">
	<link rel="icon" href="../img/mozzart.ico" type="image/x-icon">
	
	</head>
	<?php 
	$data=array();
	$path = join(DIRECTORY_SEPARATOR, array('..','query', 'DateTimeControl.php'));
	include $path;
	$data=$DateTimeControl;
	?>
	<body>
		<nav class="navbar navbar-inverse">
    		<h2>Kontrola termina</h2>
    		<a href="../index.php" class="btn btn-info" role="">Home</a>
    		<a href="index.php" class="btn btn-info" role="#">Teletext</a>
			<a href="../Podrska/index.php" class="btn btn-info" role="#">Tenička podrška</a>
			<a href="../Verif/index.php" class="btn btn-info" role="#">Verifikacija</a>
		</nav>
		<table class="table table-striped">
			</br>
			<thead>
				<tr>
					<th>Sport</th>
					<th>Takmičenje</th>
					<th>Domaćin</th>
					<th>Gost</th>
					<th>Vreme Mozzart</th>
					<th>Vreme Betradar</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $val) {?>
				<tr>
					<th><?php echo $val[0]?></th>
					<th><?php echo $val[1]?></th>
					<th><?php echo $val[2]?></th>
					<th><?php echo $val[3]?></th>
					<th><?php echo $val[4]?></th>
					<th><?php echo $val[5]?></th>
				</tr>
				<?php }?>
			</tbody>
		</table>
		
		

	</body>

</html>
