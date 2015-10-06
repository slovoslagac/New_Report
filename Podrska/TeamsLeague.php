<!DOCTYPE html>
<html>
<head>
<!--  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
<meta charset="ISO-8859-1">
<meta http-equiv="refresh" content="240">
<title>Kontrola timova</title>
</head>
<?php
$a = '';
$b = '';
$c = '';


if (isset ( $_GET ["name"] ) != "") {
	$a = $_GET ["name"];
}



if (isset ( $_GET ["tmid"] ) != "") {
	$b = $_GET ["tmid"];
}


If ($a != "") {
	$a = $a;
	
} elseif ($b != ""){
	$a='';
	$b=abs($b);
} else {
	$a = 'BORAC ^.';
}



if (isset ( $_GET ["sport"] ) != "") {
	$c = $_GET ["sport"];
}

If ($c != "") {
	$c = $c;
} else {
	$c = 1;
}

switch ($c) {
	case 1:
		$d='Fudbal';
		break;
	case 2:
		$d='Košarka';
		break;
	case 4:
		$d='Hokej';
		break;
	case 5:
		$d='Tenis';
		break;
	case 6:
		$d='Odbojka';
		break;
	case 7:
		$d='Rukomet';
		break;
	case 9:
		$d='Vaterpolo';
		break;
	default:
		$d='';
}



$path = join(DIRECTORY_SEPARATOR, array('..','query', 'TeamLeagueSeason.php'));
include $path;
$data=$TeamLeagueSeason;

//print_r($data);
?>
<body>

<table style="width:70%;float:left;margin-left:15%" float=center id=t border=5px text-align=center align=center cellpadding=3 BORDERCOLOR=black>

		<tr bgcolor=#64A1F6>
			<th><h1>Provera pripadnosti tima takmicenjima</h1></th>
		</tr>
		
		
		<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		
		<tr bgcolor=#64A1F6 align=center>
			<th>sport : <select type="text" name="sport">
						<option value= "1">Fudbal</option>
						<option value= "2">Košarka</option>
						<option value= "4">Hokej</option>
						<option value= "5">Tenis</option>
						<option value= "6">Odbojka</option>
						<option value= "7">Rukomet</option>
						<option value= "9">Vaterpolo</option>
						</select>
						team : <input type="text" name="name"> 
						tm_id : <input type="number" name="tmid">
			<input type="Submit" value="osvezi podatke"> </th> </br>
			
		</tr>
		</form>
		
			<th bgcolor=#64A1F6 align=center> Prikazani su podaci za <?php echo $a ?> u sportu <?php echo $d ?> po takmicenju i sezonama. </th>

<table style="width:70%;float:left;margin-left:15%" id=t border=5px; text-align=center; align=center; cellpadding=3 BORDERCOLOR=black>
<tbody>
	<tr bgcolor=#64A1F6 align=center>
				<td class="head"><h3>Sport</h3></td>
				<td class="head"><h3>Takmicenje</h3></td>
				<td class="head"><h3>Tim</h3></td>				
				<td class="head"><h3>Sezona</h3></td>
				<td class="head"><h3>Transfermarkt ID</h3></td>
	</tr>
	
<?php

foreach($data as $dat){
        			
   			
        			
        	
	
?>	

	<tr align=center>
			<td><?php echo $dat[0] ?></td>
			<td><?php echo $dat[2] ?></td>
			<td><?php echo $dat[3] ?></td>
			<td><?php echo $dat[4] ?></td>
			<td><?php echo $dat[6] ?></td>
	</tr>
  
 <?php 

} 
 
 
 ?>
	
</tbody>

</table>

</table>
</body>
</html>