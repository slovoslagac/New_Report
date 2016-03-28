<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="icon" href="../img/mozzart.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="../css/promenekvota.css">
		<title>Promene kvota</title>
	</head>
	<?php 
	$sport=1;
	$option = 1;
	$header = 1;
	$vreme = 12;
	$data_val = 1;



	if (isset ( $_POST ["sport"] ) != "") {
		$sport=$_POST ["sport"];
		$vreme=$_POST ["vreme"];
		switch ($sport) {
			case '1':
				$header=1;
				$data_val=1;
				$option=1;
				break;
			case '2':
				$header=2;
				$data_val=1;
				$option=2;
				break;
			case '4':
				$header=3;
				$data_val=2;
				$option=4;
				break;
			case '5':
				$header=4;
				$data_val=2;
				$option=5;
				break;
			case '7':
				$header=2;
				$data_val=1;
				$option=2;
				break;
			case '6':
				$header=5;
				$data_val=2;
				$option=6;
				break;
			case '10':
				$header=6;
				$data_val=2;
				$option=6;
				break;
			default:
				# code...
				break;
		}

	}

	$j=0;
	$path = join(DIRECTORY_SEPARATOR, array('..','query', 'promKvota.php'));
	include $path;
	$data=$PromKv;
	
	$f = array("\\","]","@","[","^");
	$r = array("Đ","Ć","Ž","Š","Č");

	$verif = array('79'=>'Bojan Ćubović','80'=>'Miloš Gutić','81'=>'Vladimir Subotić','389'=>'Branislav Despotov','448'=>'Damjan Cvijanović','494'=>'Dejan Kocić','596'=>'Dragutin Štefika','1708'=>'Vladimir Gavrilović','3352'=>'Bojan Vićentijević','3479'=>'Miloš Radojković','3716'=>'Dušan Latković','3884'=>'Aleksandar Belenzada','6692'=>'Stefan Dončevski','6693'=>'Dušan Majkić','8932'=>'Nebojša Rašić');

	
	$prevod = array ('12' =>'12 sati', '18'=>'18 sati', '24'=>'24 sata', '36'=>'36 sati', '48'=>'48 sati', '72'=>'72 sata');
	$sport_p = array ('1'=>'fudbala', '2'=>'košarke', '4'=>'hokeja', '5'=>'tenisa', '6'=>'odbojke', '7'=>'rukometa', '10'=>'ragbija');
	?>
	<body>
		<div id="container">
			<div id="helpmenu">
				<a href="../index.php"><img alt="" src="../img/MozzartLogo.png"></a>
				<h1>Istorija promene kvota <?php echo $sport_p[$sport]?> u poslednjih <?php echo $prevod[$vreme]?></h1>
			</div>
			<div id="header">
				<a href="../Teletext/index.php"><input type="Submit" value="Teletext"></a>
				<a href="index.php"><input type="Submit" value="Verifikacija"></a>
				<a href="../Podrska/index.php"><input type="Submit" value="Tenička podrška"></a>
			</div>
			<div id="menu">
				<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
					<div class="selectdata">
						<ul>
							<li>
								<select name="sport">
									<option value="1" <?php echo ($sport == 1) ? "selected=\"selected\"" : ""; ?>>Fudbal</option>
									<option value="2" <?php echo ($sport == 2) ? "selected=\"selected\"" : ""; ?>>Košarka</option>
									<option value="4" <?php echo ($sport == 4) ? "selected=\"selected\"" : ""; ?>>Hokej</option>
									<option value="5" <?php echo ($sport == 5) ? "selected=\"selected\"" : ""; ?>>Tenis</option>
									<option value="6" <?php echo ($sport == 6) ? "selected=\"selected\"" : ""; ?>>Odbojka</option>
									<option value="7" <?php echo ($sport == 7) ? "selected=\"selected\"" : ""; ?>>Rukomet</option>
								</select>
							</li>
							<li>
								<select name="vreme">
									<option value="12" <?php echo ($vreme == 12) ? "selected=\"selected\"" : ""; ?>>12</option>
									<option value="18" <?php echo ($vreme == 18) ? "selected=\"selected\"" : ""; ?>>18</option>
									<option value="24" <?php echo ($vreme == 24) ? "selected=\"selected\"" : ""; ?>>24</option>
									<option value="36" <?php echo ($vreme == 36) ? "selected=\"selected\"" : ""; ?>>36</option>
									<option value="48" <?php echo ($vreme == 48) ? "selected=\"selected\"" : ""; ?>>48</option>
									<option value="72" <?php echo ($vreme == 72) ? "selected=\"selected\"" : ""; ?>>72</option>
								</select>
							</li>
							<li>
								<input type="Submit" value="Osveži" accesskey="x" >
							</li>
						</ul>
					</form>
				</div>
			</div>
			<div id="match_data">
				<table id="exportTable">
					
					<?php 
					include(join(DIRECTORY_SEPARATOR, array('..','included', 'promKvotaHeaderTable.php')));

					include(join(DIRECTORY_SEPARATOR, array('..','included', 'promKvotaDataTable.php')));
					?>
				</table>
			</div>
		</div>
	</body>
</html>
