<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="icon" href="../img/mozzart.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="../css/pripremaigraci.css">
		<title>Priprema igrača</title>
		
		<script type="text/javascript">
			$('#exportTable').DataTable( {
			    buttons: [
			        'copy', 'excel', 'pdf'
			    ]
			} );
			var table = $('#exportTable').DataTable();
			 
			new $.fn.dataTable.Buttons( table, {
			    buttons: [
			        'copy', 'excel', 'pdf'
			    ]
			} );

			$('#exportTable').DataTable( {
			    dom: 'Bfrtip',
			    buttons: [
			        'copy', 'excel', 'pdf'
			    ]
			} );

		</script>
	</head>
	<?php 
	

	
	
	
	
	$j=0;
	$def_sport='';
	$def_competition='';
	$def_fake_competition='';
	$def_days='';
	$def_season='';
	$fake_sport='';
	$season_name='';
	
	if (isset ( $_POST ["sport"] ) != "") {
		$def_sport=$_POST ["sport"];
		$def_competition=$_POST ["competition"];
		$def_fake_competition=$_POST ["competitionFake"];
		$def_days=$_POST ["days"];
		$def_season=$_POST ["season"];
	}
	
	
	
	$path = join(DIRECTORY_SEPARATOR, array('..','query', 'pripremaigraca.php'));
	include $path;
	$leagues=$LeagueList;
	$fakeLeagues=$LeagueFakeList;
	$mat=$Matches;
	
	switch ($def_sport) {
		case 55:
			$fake_sport='Košarka - igrači';
			break;
		case 54:
			$fake_sport='Rukomet - igrači';
			break;
			
			
	};
	
	switch ($def_season) {
		case 21:
			$season_name='2015/2016';
			break;
		case 20:
			$season_name='2015';
			break;
	}
	
	
	
	?>
	<body>
		<div id="container">
			<div id="helpmenu">
				<img alt="" src="../img/MozzartLogo.png">
			</div>
			<div id="header">
				<h1>Priprema ponude za igru poeni igrača</h1>
			</div>
			<div id="menu">
				<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
					<div class="selectdata">
						<ul>
							<li>
								<span>Sport : </span>
								<select name="sport">
									<option value="54" <?php echo ($def_sport == 54) ? "selected=\"selected\"" : ""; ?>>Rukomet igrači</option>
									<option value="55" <?php echo ($def_sport == 55) ? "selected=\"selected\"" : ""; ?>>Košarka igrači</option>
								</select>
							</li>
							<li>
								<span> takmičenje : </span>
									<select name="competition">
										<?php foreach($leagues as $l) {?>
										<option value="<?php echo $l[1]?>" <?php echo ($def_competition == $l[1]) ? "selected=\"selected\"" : ""; ?>><?php echo $l[0]?></option>	
										<?php }?>
									</select>
							</li>
							<li>
								<span> novo takmičenje: </span>
									<select name="competitionFake">
										<?php foreach($fakeLeagues as $l) {?>
										<option value="<?php echo $l[0]?>" <?php echo ($def_fake_competition == $l[0]) ? "selected=\"selected\"" : ""; ?>><?php echo ($l[3]==54) ? " Ruk : " : " Koš : ";echo $l[0]; ?></option>	
										<?php }?>
									</select>
							</li>
							<li>
								<span>za narednih : </span>
									<select name="days">
										<?php for($i=1;$i<=10;$i++) {?>
										<option value="<?php echo $i?>"><?php echo $i?></option>
										<?php }?>
									</select>
								<span>dana</span>
							</li>
							<li>
								<span>za sezonu : </span>
									<select name="season">
										<option value="20" <?php echo ($def_season == 20) ? "selected=\"selected\"" : ""; ?>>2015</option>
										<option value="21" <?php echo ($def_season == 21) ? "selected=\"selected\"" : ""; ?>>2015/2016</option>
									</select>
							</li>
							<li>
								<input type="Submit" value="Osveži">
							</li>
						</ul>
					</div>
				</form>	
			</div>
			<div id="match_data">
				<table id="exportTable">
					<tr class="table_header">
						<th>Dan</th>
						<th>Vreme</th>
						<th colspan="2">Igrač</th>
						<th>Kolo</th>
						<th>Takmičenje</th>
						<th>Sezona</th>
						<th>Sport</th>
						<th>Nivo</th>
						<th>Faza</th>
					</tr>
					<?php foreach ($mat as $m) {?>
					<tr class="row<?php echo($j++ & 1 )?>">
						<td><?php echo $m[0]?></td>
						<td><?php echo $m[1]?></td>
						<td><?php echo $m[2]?></td>
						<td></td>
						<td>1</td>
						<td><?php echo str_replace("  ", "&nbsp;&nbsp;", $def_fake_competition)?></td>
						<td><?php echo $season_name?></td>
						<td><?php echo $fake_sport?></td>
						<td></td>
						<td>slobodna</td>
					</tr>
					<?php }?>
				</table>
			</div>
		</div>
	</body>
</html>
