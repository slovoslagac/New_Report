<!DOCTYPE html>
<html>
	<head>
	<title>Izveštaj o KS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/ks.css">
	</head>
<?php 
ini_set('memory_limit', '1024M');
$x=0;

$allGames=array(
		array('KONACAN  ISHOD', 'Konačan ishod'),
		array('UKUPNO GOLOVA','Ukupno golova'),
		array('DUPLA SANSA','Dupla šansa'),
		array('PRVO POL.','Prvo poluvreme'),
		array('DRUGO POL.','Drugo poluvreme'),
		array('DUPLA POBEDA','Dupla pobeda'),
		array('Sigurna pobeda','Sigurna pobeda'),
		array('Hendikep pobeda','Hendikep pobeda'),
		array('VISE GOLOVA','Više golova'),
		array('POLUVREME-KRAJ','Poluvreme - kraj'),
		array('MOZZART SANSA','Mozzart šansa'),
		array('MOZZART KOMBINACIJE','Mozzart kombinacije'),
		array('UKUPNO  GOLOVA  I  POL','Ukupno golova I poluvreme'),
		array('UKUPNO  GOLOVA  II  POL','Ukupno golova II poluvreme'),
		array('TIM 1 DAJE GOL','Tim 1 daje gol'),
		array('TIM 2 DAJE GOL','Tim 2 daje gol'),
		array('TIM 1 PP','Tim 1 Prvo poluvreme'),
		array('TIM 2 PP','Tim 2 Prvo poluvreme'),
		array('TIM 1 DP','Tim 1 Drugo poluvreme'),
		array('TIM 2 DP','Tim 2 Drugo poluvreme'),
		array('OBA TIMA DAJU GOL','Oba tima daju gol'),
		array('TACAN REZULTAT','Tačan rezultat'),
		
);

$specSubgames = array(
		array('KONACAN  ISHOD','1','Konačan ishod 1'),
		array('KONACAN  ISHOD','X','Konačan ishod X'),
		array('KONACAN  ISHOD','2','Konačan ishod 2'),
		array('UKUPNO GOLOVA','0-2','Ukupno golova 0-2'),
		array('UKUPNO GOLOVA','3+','Ukupno golova 3+'),
		array('UKUPNO GOLOVA','4+','Ukupno golova 4+'),
);


$full_season=array();
$full_season_best_subgame=array();
$full_season_wors_subgame=array();

$last30_season=array();
$last30_best_subgame=array();
$last30_wors_subgame=array();

$last90_season=array();
$last90_best_subgame=array();
$last90_wors_subgame=array();

$seasons=array();

//Include data from JSON data files
$path = join(DIRECTORY_SEPARATOR, array('..','query', 'ksdata.php'));
$path1 = join(DIRECTORY_SEPARATOR, array('..','query', 'LeagueforKs.php'));
include $path;
include $path1;
$data=$selectleague;





$a='';
$league_season_def='';
$league_id=20;
$league_name = 'ENGLESKA  1';
$league_season = '2014/2015';
$league_type = 1;
$a=0;

if (isset ( $_GET ["league"] ) != "") {
	$a = $_GET ["league"];
	$league_id=$a;

}

if($a !=""){
	foreach ($data as $d){
		if($d['LEAGUE_ID']==$a){
			$league_name=$d['LEAGUE'];
			$league_season=$d['SEASON'];
			$league_season_def=$d['SEASON'];
			$league_type=$d['TYPE'];
		}
	}
} else {
	$sportname = '';
}

if (isset ( $_GET ["season"] ) != "") {
	$league_season = $_GET ["season"];
}

// gledam moguce sezone za datu ligu

foreach ($league_data as $l) {
	if ($l->liga_id == $league_id) {
		if((in_array($l->sezona, $seasons))){
			
		} else {
			array_push($seasons, $l->sezona);
		}
	}
}

//print_r($seasons);

if(in_array($league_season, $seasons)){
	
} else {
	$league_season=$league_season_def;
}

//Load data for season games. best subgames, worst subgames

if($league_type == 1) {

foreach ($league_data as $l){
	if($l->liga_id == $league_id && $l->sezona == $league_season){
	$full_season[]=$l;
}}
foreach ($season_best_subgames as $l){
		if($l->liga_id == $league_id && $l->sezona == $league_season){
			$full_season_best_subgame[]=$l;
	}}
	
} else {
foreach ($last365_games as $l){
	if($l->liga_id == $league_id){
		$full_season[]=$l;
	}}
foreach ($last365_subgames as $l){
	if($l->liga_id == $league_id) {
		$full_season_best_subgame[]=$l;
	}}

}	
	
	
$full_season_wors_subgame=$full_season_best_subgame;	
$sort=array();
foreach ($full_season_wors_subgame as $key => $row){
	$sort[$key]=$row -> ks;
}
array_multisort($sort, SORT_DESC, $full_season_wors_subgame);

//Load data for last 30 days games. best subgames, worst subgames

foreach ($last30_games as $l){
	if($l->liga_id == $league_id){
		$last30_season[]=$l;
	}}
foreach ($last30_subgames as $l){
	if($l->liga_id == $league_id){
		$last30_best_subgame[]=$l;
	}}
$last30_wors_subgame=$last30_best_subgame;	
$sort1=array();
foreach ($last30_wors_subgame as $key => $row){
	$sort1[$key]=$row -> ks;
}
array_multisort($sort1, SORT_DESC, $last30_wors_subgame);

//Load data for last 90 days games. best subgames, worst subgames

foreach ($last90_games as $l){
	if($l->liga_id == $league_id){
		$last90_season[]=$l;
	}}
foreach ($last90_subgames as $l){
	if($l->liga_id == $league_id){
		$last90_best_subgame[]=$l;
	}}
$last90_wors_subgame=$last90_best_subgame;
$sort2=array();
foreach ($last90_wors_subgame as $key => $row){
	$sort2[$key]=$row -> ks;
}
array_multisort($sort2, SORT_DESC, $last90_wors_subgame);

?>
	<body>
	<div id="naslov">
		<?php if($league_type==1) {?>
		<h3>Trenutno je prikazana statistika za ligu : <?php echo ucfirst(strtolower($league_name))?> u sezoni : <?php echo $league_season?></h3>
		<?php } else {?>
		<h3>Trenutno je prikazana statistika za ligu : <?php echo $league_name?></h3>
		<?php }?>
		<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		<p>
			<select type="text" name="league">
				<?php foreach ($data as $spor) { ?>
					
					<option value= "<?php echo $spor['LEAGUE_ID']?>" <?php if($spor['LEAGUE_ID']==$league_id) {echo 'selected="selected"';}?> ><?php echo ucfirst(strtolower($spor['LEAGUE_NICE']))?></option>
										
				<?php }?>
			
			</select>
			<?php if($league_type == 1) {?>
			<select type="text" name="season">
					<?php foreach ($seasons as $s) { if($s !=""){?>
						<option <?php if($s == $league_season) {echo 'selected="selected"';}?>><?php echo $s?></option>			
					<?php }}}?>
										
						
			</select>
		<input type="Submit" value="osvezi podatke za ligu"></p>
	</div>
	
<!-- Prvi segment cela sezona -->
	<div class="col-xs-4">
		<h4 class="sub-header">Cela sezona</h4>
<!-- Unapred definisane igre -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Igra</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php 
					 foreach ($allGames as $al)  { $game = $al[0]; $game_nice= $al[1];?>
            			<?php foreach ($full_season as $fl) { ?>
            				<?php if($fl-> igra == $game) {$ks = $fl->isplata/$fl->uplata;?>
            		<tr>
                		<td class="col-md-4"><?php echo $game_nice?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>
                			<?php }?>
                	    <?php }?>
                	<?php }?>
				</tbody>
			</table>
		</div>
<!-- Unapred definisane podigre igre -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Igra</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php 
					 foreach ($specSubgames as $al)  { $game = $al[0]; $subgame= $al[1]; $game_nice= $al[2];?>
            			<?php foreach ($full_season_best_subgame as $fl) { ?>
            				<?php if(($league_type == 1) ? $fl-> igra == $game  && $fl -> podigra == $subgame && $fl -> sezona == $league_season : $fl-> igra == $game  && $fl -> podigra == $subgame ) {$ks = $fl->isplata/$fl->uplata;?>
            		<tr class="<?php echo ($game." ".$subgame == 'KONACAN  ISHOD 1' || $game." ".$subgame  == 'UKUPNO GOLOVA 3+') ? 'bold' : ''?>" >
                		<td class="col-md-4" value="<?php echo $game." ".$subgame?>"><?php echo $game_nice?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>
                			<?php }?>
                	    <?php }?>
                	<?php } ?>
				</tbody>
			</table>
		</div>
<!-- 10 Najboljih podigara -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Najbolje podigre</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php  if(count($full_season_best_subgame)>0){$l=count($full_season_best_subgame);for ($x=0; ($l>9) ? $x<10 : $x < $l;$x++ )  {$ks= $full_season_best_subgame[$x]->ks;?>
					
            		<tr  class="<?php echo ($game." ".$subgame == 'KONACAN  ISHOD 1' || $game." ".$subgame  == 'UKUPNO GOLOVA 3+') ? 'bold' : ''?>" >
                		<td class="col-md-4"><?php echo $full_season_best_subgame[$x]->igra." ".$full_season_best_subgame[$x]->podigra?></td>
                		<td class="col-md-2"><?php echo number_format ($full_season_best_subgame[$x]->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($full_season_best_subgame[$x]->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>

                	<?php }}?>
				</tbody>
			</table>
		</div>
<!-- 10 Najgorih podigara -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Najgore podigre</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php  if(count($full_season_wors_subgame)>0){$l=count($full_season_wors_subgame);for ($x=0; ($l>9) ? $x<10 : $x < $l;$x++ )  {$ks= $full_season_wors_subgame[$x]->ks;?>
            		<tr  class="<?php echo ($game." ".$subgame == 'KONACAN  ISHOD 1' || $game." ".$subgame  == 'UKUPNO GOLOVA 3+') ? 'bold' : ''?>" >
                		<td class="col-md-4"><?php echo $full_season_wors_subgame[$x]->igra." ".$full_season_wors_subgame[$x]->podigra?></td>
                		<td class="col-md-2"><?php echo number_format ($full_season_wors_subgame[$x]->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($full_season_wors_subgame[$x]->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>

                	<?php }}?>
				</tbody>
			</table>
		</div>
	</div>	
<!-- Drugi segment poslednjih 90 dana -->
	<div class="col-xs-4">
		<h4 class="sub-header">Poslednjih 90 dana</h4>
<!-- Unapred definisane igre -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Igra</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php foreach ($allGames as $al)  { $game = $al[0]; $game_nice= $al[1];?>
            			<?php foreach ($last90_season as $fl) { ?>
            				<?php if($fl-> igra == $game) {$ks = $fl->isplata/$fl->uplata;?>
            		<tr class="test">
                		<td class="col-md-4"><?php echo $game_nice?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>
                			<?php }?>
                	    <?php }?>
                	<?php }?>
				</tbody>
			</table>
		</div>
<!-- Unapred definisane podigre igre -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Igra</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php foreach ($specSubgames as $al)  { $game = $al[0]; $subgame= $al[1]; $game_nice= $al[2];?>
            			<?php foreach ($last90_best_subgame as $fl) { ?>
            				<?php if($fl-> igra == $game  && $fl -> podigra == $subgame) {$ks = $fl->isplata/$fl->uplata;?>
            		<tr  class="<?php echo ($game." ".$subgame == 'KONACAN  ISHOD 1' || $game." ".$subgame  == 'UKUPNO GOLOVA 3+') ? 'bold' : ''?>" value="<?php echo $fl-> sezona?>" >
                		<td class="col-md-4"><?php echo $game_nice?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>
                			<?php }?>
                	    <?php }?>
                	<?php }?>
				</tbody>
			</table>
		</div>
<!-- 10 Najboljih podigara -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Najbolje podigre</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php  if(count($last90_best_subgame)>0){$l=count($last90_best_subgame);for ($x=0; ($l>9) ? $x<10 : $x < $l;$x++ )  {$ks= $last90_best_subgame[$x]->ks;?>
            		<tr  class="<?php echo ($game." ".$subgame == 'KONACAN  ISHOD 1' || $game." ".$subgame  == 'UKUPNO GOLOVA 3+') ? 'bold' : ''?>" >
                		<td class="col-md-4"><?php echo $last90_best_subgame[$x]->igra." ".$last90_best_subgame[$x]->podigra?></td>
                		<td class="col-md-2"><?php echo number_format ($last90_best_subgame[$x]->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($last90_best_subgame[$x]->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>

                	<?php }}?>
				</tbody>
			</table>
		</div>	
<!-- 10 Najgorih podigara -->	
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Najgore podigre</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php  if(count($last90_wors_subgame)>0){$l=count($last90_wors_subgame);for ($x=0; ($l>9) ? $x<10 : $x < $l;$x++ )  {$ks= $last90_wors_subgame[$x]->ks;?>
            		<tr class="<?php echo ($game." ".$subgame == 'KONACAN  ISHOD 1' || $game." ".$subgame  == 'UKUPNO GOLOVA 3+') ? 'bold' : ''?>" >
                		<td class="col-md-4"><?php echo $last90_wors_subgame[$x]->igra." ".$last90_wors_subgame[$x]->podigra?></td>
                		<td class="col-md-2"><?php echo number_format ($last90_wors_subgame[$x]->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($last90_wors_subgame[$x]->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>

                	<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
<!-- Treci segment poslednjih 30 dana -->
	<div class="col-xs-4">
		<h4 class="sub-header">Poslednjih 30 dana</h4>
<!-- Unapred definisane igre -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Igra</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php foreach ($allGames as $al)  { $game = $al[0]; $game_nice= $al[1];?>
            			<?php foreach ($last30_season as $fl) { ?>
            				<?php if($fl-> igra == $game) {$ks = $fl->isplata/$fl->uplata;?>
            		<tr class="test">
                		<td class="col-md-4"><?php echo $game_nice?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>
                			<?php }?>
                	    <?php }?>
                	<?php }?>
				</tbody>
			</table>
		</div>
<!-- Unapred definisane podigre igre -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Igra</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php foreach ($specSubgames as $al)  { $game = $al[0]; $subgame= $al[1]; $game_nice= $al[2];?>
            			<?php foreach ($last30_best_subgame as $fl) { ?>
            				<?php if($fl-> igra == $game  && $fl -> podigra == $subgame) {$ks = $fl->isplata/$fl->uplata;?>
            		<tr class="<?php echo ($game." ".$subgame == 'KONACAN  ISHOD 1' || $game." ".$subgame  == 'UKUPNO GOLOVA 3+') ? 'bold' : ''?>" >
                		<td class="col-md-4"><?php echo $game_nice?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($fl->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>
                			<?php }?>
                	    <?php }?>
                	<?php }?>
				</tbody>
			</table>
		</div>
<!-- 10 Najboljih podigara -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Najbolje podigre</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					
					<?php  if(count($last30_best_subgame)>0){$l=count($last30_best_subgame); for ($x=0; ($l>9) ? $x<10 : $x < $l;$x++ )  {$ks= $last30_best_subgame[$x]->ks;?>
            		<tr class="<?php echo ($game." ".$subgame == 'KONACAN  ISHOD 1' || $game." ".$subgame  == 'UKUPNO GOLOVA 3+') ? 'bold' : ''?>" >
                		<td class="col-md-4"><?php echo $last30_best_subgame[$x]->igra." ".$last30_best_subgame[$x]->podigra?></td>
                		<td class="col-md-2"><?php echo number_format ($last30_best_subgame[$x]->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($last30_best_subgame[$x]->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo ($ks != "") ? number_format($ks,2,  "," ,  "." ) : ""?></td>
                	</tr>

                	<?php }}?>
				</tbody>
			</table>
		</div>
<!-- 10 Najgorih podigara -->
		<div class="table-responsive">
			<table class="table table-striped">
        		<thead>
            		<tr>
                		<th class="col-md-4">Najgore podigre</th>
                		<th class="col-md-2">Uplata</th>
                		<th class="col-md-2">Zarada</th>
                		<th class="col-md-1">KS</th>

                	</tr>
				</thead>
				<tbody>
					<?php  if(count($last30_wors_subgame)>0){$l=count($last30_wors_subgame);for ($x=0; ($l>9) ? $x<10 : $x < $l;$x++ )  {$ks= $last30_wors_subgame[$x]->ks;?>
            		<tr  class="<?php echo ($game." ".$subgame == 'KONACAN  ISHOD 1' || $game." ".$subgame  == 'UKUPNO GOLOVA 3+') ? 'bold' : ''?>" >
                		<td class="col-md-4"><?php echo $last30_wors_subgame[$x]->igra." ".$last30_wors_subgame[$x]->podigra?></td>
                		<td class="col-md-2"><?php echo number_format ($last30_wors_subgame[$x]->uplata,2,  "," ,  "." )?></td>
                		<td class="col-md-2"><?php echo number_format ($last30_wors_subgame[$x]->zarada,2,  "," ,  "." )?></td>
                		<td class="<?php echo ($ks > 0.95) ? 'col-md-1red' : 'col-md-1'; ?>"><?php echo number_format($ks,2,  "," ,  "." )?></td>
                	</tr>

                	<?php }}?>
				</tbody>
			</table>
		</div>						
	</div>
	</body>
</html>
