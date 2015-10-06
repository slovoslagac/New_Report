<!DOCTYPE html>
<html>
<head>
<!--  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
<meta charset="ISO-8859-1">
	<link rel="stylesheet" type="text/css" href="../css/vreme.css">
<title>Promena termina</title>
</head>
<?php
$a = '';
$b = '';
$def_matchnumber='';
$def_kladionica_id='';
$def_round='';
$selected_round='';
$selected_kladionica='';
$selected_matchnumber='';

$data=array();

$path = join(DIRECTORY_SEPARATOR, array('..','query', 'proveravremena.php'));
include $path;
$data=$TimeChanged;


if (isset ( $_GET ["matchnumber"] ) != "") {
		if(is_array($_GET ["matchnumber"])) {
			
		} else {
		$a = $_GET ["matchnumber"];
		$selected_matchnumber=$a;
		$def_matchnumber=$selected_matchnumber;
} } else {
	$selected_matchnumber=$def_matchnumber;
}


if(isset($_GET["round"]) != "") {
	$selected_round=$_GET["round"];
}

if (isset ($_GET ["kladionica"]) != "") {
	$selected_kladionica=$_GET ["kladionica"];
} else {
	$selected_kladionica=$def_kladionica_id;
}

$klad = array (
	array(0,'Mozzart'),
	array(1,'Germanija')	
);

$path = join(DIRECTORY_SEPARATOR, array('..','query', 'proveravremena.php'));
include $path;
$data=$TimeChanged;

//print_r($data);
?>
<body>

<table style="width:70%;float:left;margin-left:15%" float=center id=t border=5px text-align=center align=center cellpadding=3 BORDERCOLOR=black>

		<tr bgcolor=#64A1F6>
			<th><h1>Provera promena termina mečeva</h1></th>
		</tr>
		
		
		<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		
		
		<tr bgcolor=#64A1F6 align=center>
			<th>
				<div id="naslov">
					kladionica : <select type="text" name="kladionica" class="kladionica">
						<?php foreach ($klad as $kl) {?>
						<option value="<?php echo $kl[0]?>" <?php if($kl[0]==$selected_kladionica) {echo 'selected="selected"';}?>><?php echo $kl[1]?></option>
						
						<?php }?>
						</select>
					kolo : <select type="text" name="round" class="round">
						<?php for ($i=$round;$i>$round-10;$i--) {?>
						<option value="<?php echo $i?>" <?php if($i==$selected_round) {echo 'selected="selected"';}?>><?php echo $i?></option>
						
						<?php }?>
						</select>
						sifra meča : <input type="text" name="matchnumber" value="<?php if($selected_matchnumber != '') { echo $selected_matchnumber;}?>">
					<input type="Submit" value="osvezi podatke"> 
				</div>
			</th> 
		</tr>
		
		
		</form>
		
			<th bgcolor=#64A1F6 align=center> Prikazani su podaci za po takmičenju i sezonama. </th>

<table style="width:70%;float:left;margin-left:15%" id=t border=5px; text-align=center; align=center; cellpadding=3 BORDERCOLOR=black>
<tbody>
	<tr bgcolor=#64A1F6 align=center>
				<td class="head"><h3>Šifra meča</h3></td>
				<td class="head"><h3>Meč</h3></td>
				<td class="head"><h3>Vreme promene</h3></td>
				<td class="head"><h3>Vreme meča</h3></td>				
				<td class="head"><h3>Promenu izvršio</h3></td>
	</tr>
	
<?php

foreach($data as $dat){
        			
   			
        			
        	
	
?>	

	<tr align=center>
			<td><?php echo $dat[5] ?></td>
			<td><?php echo $dat[6].' - '.$dat[7] ?></td>
			<td><?php echo $dat[1] ?></td>
			<td><?php echo $dat[3] ?></td>
			<td><?php echo $dat[4] ?></td>
	</tr>
  
 <?php 

} 
 
 
 ?>
	
</tbody>

</table>

</table>
</body>
</html>