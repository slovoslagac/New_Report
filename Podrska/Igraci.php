<!DOCTYPE html>
<html>
<head>
<!--  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
<meta charset="ISO-8859-1">
	<link rel="stylesheet" type="text/css" href="../css/Igraci.css">
<title>Prevodi igrača</title>
</head>
<?php
$a = '';
$selected_sport='';
$def_sport=1000;

$path = join(DIRECTORY_SEPARATOR, array('..','query', 'Players9-19.php'));
include $path;
$data=$Players;



if (!empty($data)) {

if (isset ( $_GET ["sport"] ) != "") {
	$a = $_GET ["sport"];
	$selected_sport=$a;
}

$sports=array();

$i=0;
$sports2=array();

echo '<br />';



foreach ($data as $s) {
	foreach ($sports as $s1) {
		array_push($sports2, $s1[0]);
	};
	
	if(!in_array($s['SPORTID'],$sports2)){
			array_push($sports,array($s['SPORTID'], $s['SPORT']));	
		} else {
			$i++;
			;	
		}	
	$sports2=array();
}



foreach ($sports as $s1) {
	if ($s1[0] < $def_sport) {
		$def_sport=$s1[0];
	}
};

if($selected_sport == ''){
	$selected_sport=$def_sport;
}




//print_r($data);
?>
<body>

<table style="width:70%;float:left;margin-left:15%" float=center id=t border=5px text-align=center align=center cellpadding=3 BORDERCOLOR=black>

		<tr bgcolor=#64A1F6>
			<th><h1>Imena koja treba popraviti</h1></th>
		</tr>
		
		
		<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		
		
		<tr bgcolor=#64A1F6 align=center>
			<th>
				<div id="naslov">
					sport : <select type="text" name="sport">
						<?php foreach ($sports as $ss) {?>
						<option value="<?php echo $ss[0]?>" select="<?php echo ($ss[0]==$selected_sport) ? 'selected' : ''?>"><?php echo $ss[1]?></option>
						<?php }?>
						</select>
					<input type="Submit" value="osvezi podatke"> 
				</div>
			</th> 
		</tr>
		
		
		</form>
		
			

<table style="width:70%;float:left;margin-left:15%" id=t border=5px; text-align=center; align=center; cellpadding=3 BORDERCOLOR=black>
<tbody>
	<tr bgcolor=#64A1F6 align=center>
				<td class="head"><h3>Ime</h3></td>
				<td class="head"><h3>Ime od 9 karaktera</h3></td>
				<td class="head"><h3>Ime od 13 karaktera</h3></td>				
				<td class="head"><h3>Sport</h3></td>
	</tr>
	
<?php

foreach($data as $dat){
	if($dat[4]==$selected_sport) {        			
   			
        			
        	
	
?>	

	<tr align=center>
			<td><?php echo $dat[0] ?></td>
			<td><?php echo $dat[1] ?></td>
			<td><?php echo $dat[2] ?></td>
			<td><?php echo $dat[3] ?></td>

	</tr>
  
 <?php 

} }
 
 
 ?>
	
</tbody>

</table>

</table>
</body>

<?php } else {?>
<body>

<h1 class="comment">Bili ste bas super sredili ste sve prevode :)</h1>

</body>

<?php }?>
</html>