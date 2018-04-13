<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="refresh" content="120">
	<title>Dule Verifikator</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/default.css">
	<link rel="stylesheet" type="text/css" href="../css/dule.css">
	<link rel="icon" href="../img/mozzart.ico" type="image/x-icon">
	
	</head>
	<?php 
	$data=array();
	$data1=array();
	$path = join(DIRECTORY_SEPARATOR, array('..','query', 'CompleteVerification.php'));
	include $path;
	$data=$allData;
	$data1=$NoOdds;
	?>
	<body>
		<?php if (empty($data)) {?>
		<table class="table table-striped">
			<h3>Trenutno nema mečeva koji čekaju verifikaciju.</h3>
		</table>
		
		<?php } else {?>
		<table class="table table-striped">
			<h3>Mečevi koji čekaju verifikaciju:</h3>
			<thead>
				<tr>
					<th>Kolo</th>
					<th>Datum</th>
					<th>Sifra</th>
					<th>Sport</th>
					<th>Takmicenje</th>
					<th>Domacin</th>
					<th>Gost</th>
					<th>Rezultat</th>
					<th>Kladionica</th>
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
					<th><?php echo $val[6]?></th>
					<th><?php echo $val[8]?></th>
					<th><?php echo $val[7]?></th>
				</tr>
				<?php }?>
			</tbody>
		</table>‚
		<?php }?>	
		<br>
		<br>
		<br>
		<?php if (empty($data1)) {?>
		<table class="table table-striped">
			<h3>Trenutno nema mečeva za koje nisu urađene kvote a počinju u narednih 12 sati.</h3>
		</table>
		
		<?php } else {?>
		<table class="table table-striped">
			<h3>Mečevi koji počinju u narednih 12 sati a kvote nisu urađene za aktuelno kolo:</h3>
			<thead>
				<tr>
					<th class="col-sm-3">Sport</th>
					<th class="col-sm-3">Takmičenje</th>
					<th class="col-sm-3">Vreme početka prvog meča</th>
					<th class="col-sm-3">Broj mečeva bez kvota</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data1 as $val) {?>
				<tr>
					<th><?php echo $val[0]?></th>
					<th><?php echo $val[1]?></th>
					<th><?php echo $val[2]?></th>
					<th><?php echo $val[3]?></th>
				</tr>
				<?php }?>

			</tbody>
		
		
		</table>
		<?php }?>
	</body>

</html>
