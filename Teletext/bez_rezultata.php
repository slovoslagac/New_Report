<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<meta http-equiv="refresh" content="240">
	<title>Bez rezultata</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/default.css">
	<link rel="stylesheet" type="text/css" href="../css/dule.css">
	<link rel="icon" href="../img/mozzart.ico" type="image/x-icon">
	
	</head>
	<?php 
	$data=array();
	$path = join(DIRECTORY_SEPARATOR, array('..','query', 'NoResults.php'));
	include $path;
	$data=$NoResults;
    $lotoData = $LotoResults;
	?>
	<body>
		<nav class="navbar navbar-inverse">
    		<h2>Mečevi bez rezultata</h2>
    		<a href="../index.php" class="btn btn-info" role="">Home</a>
    		<a href="index.php" class="btn btn-info" role="#">Teletext</a>
			<a href="../Podrska/index.php" class="btn btn-info" role="#">Tenička podrška</a>
			<a href="../Verif/index.php" class="btn btn-info" role="#">Verifikacija</a>
		</nav>


        <h2 class="text-center"> Loto rezultati</h2>
        <div class="container">
        <table class="table table-striped">
			</br>
			<thead>
				<tr>
					<th>Igra</th>
					<th>ID izvlačenja</th>
					<th>Vreme izvlačenja</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($lotoData as $val) {  $date = $val[2];?>
				<tr>
					<th><?php echo $val[0]?></th>
					<th><?php echo $val[1]?></th>
					<th><?php echo $date ?></th>
				</tr>
				<?php }?>
			</tbody>
		</table>
			<br>
			<?php include ('testLoto.php')?>
        </div>
        <br>
        <h2 class="text-center"> Ostali rezultati</h2>
		<table class="table table-striped">
			</br>
			<thead>
				<tr>
					<th>Kolo</th>
					<th>Datum</th>
					<th>Sifra</th>
					<th>Sport</th>
					<th>Takmičenje</th>
					<th>Domaćin</th>
					<th>Gost</th>
					<th>Kladionica</th>
					<th>Tip rezultat</th>
				</tr>
			</thead>
			<tbody>
				<?php $subgames = array(54,55,56,57); foreach ($data as $val) {
					if ($val[3] == 'Snooker' and in_array($val[9], $subgames)) {} else {
					?>
				<tr>
					<th><?php echo $val[0]?></th>
					<th><?php echo $val[1]?></th>
					<th><?php echo $val[2]?></th>
					<th><?php echo $val[3]?></th>
					<th><?php echo $val[4]?></th>
					<th><?php echo $val[5]?></th>
					<th><?php echo $val[6]?></th>
					<th><?php echo $val[7]?></th>
					<th id="<?php echo $val[9]?>"><?php echo $val[8]?></th>
				</tr>
				<?php } }?>
			</tbody>
		</table>
		
		

	</body>

</html>
