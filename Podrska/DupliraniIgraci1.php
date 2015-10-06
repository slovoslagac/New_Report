<!DOCTYPE html>
<html>
<head>
<!--  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
<meta charset="ISO-8859-1">

<title>Duplirani igrači</title>


</head>
<?php
$a = 5;
$b = '';


if (isset ( $_GET ["sport"] ) != "") {
	$a = $_GET ["sport"];
}

If ($a > 0) {
	$a = $a;
	$b = 1;
} else {
	$b = 2;
}



$path = join(DIRECTORY_SEPARATOR, array('..','query', 'DoubledPlayers.php'));
include $path;
$data=$DoubledPlayers;
$data1=$Sports;

if($a !=""){
	foreach ($data1 as $d){
		if($d['ID']==$a){
			$sportname=$d['SPORT'];
		}
	}
} else {
	$sportname = '';
}


?>
<body>

<table style="width:70%;float:left;margin-left:15%" float=center id=t border=5px text-align=center align=center cellpadding=3 BORDERCOLOR=black>
	<tr bgcolor=#64A1F6>
		<th><h1>Provera dupliranih prevoda timova i igrača</h1></th>
	</tr>
		
	<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		<tr bgcolor=#64A1F6 align=center>
			<th>Sport : 
				<select type="text" name="sport">
					<option value= "0" <?php if(0==$a) {echo 'selected="selected"';}?> >Sve</option>
					
					<?php foreach ($data1 as $spor) { ?>
					
					<option value= "<?php echo $spor['ID']?>" <?php if($spor['ID']==$a) {echo 'selected="selected"';}?> ><?php echo $spor['SPORT']?></option>
										
					<?php }?>
				</select>
				<input type="Submit" value="osvezi podatke"> 
			</th> 
		</br>
			
		</tr>
		</form>
		<th bgcolor=#64A1F6 align=center>
			<?php if ($b==2) {
			echo 'Trenutno su prikazani duplirani prevodi igrača i timova u svim sportovima za srpski i engleski jezik';
			} else {
			echo 'Trenutno su prikazani duplirani prevodi igrača i timova u sportu ',$sportname,' za srpski i engleski jezik';
			}
			?>
		</th>
			
	<table style="width:70%;float:left;margin-left:15%" id=t border=5px; text-align=center; align=center; cellpadding=3 BORDERCOLOR=black>
		<tbody>
			<tr bgcolor=#64A1F6 align=center>
				<td class="head"><h3>Parserstring</h3></td>
				<td class="head"><h3>Prevod</h3></td>
				<td class="head"><h3>Jezik</h3></td>				
				<td class="head"><h3>Sport</h3></td>
			</tr>
	
<?php foreach($data as $dat){ ?>	
			<tr align=center>
				<td><?php echo $dat['PARSE']?></td>
        		<td><?php echo $dat['NAME']?></td>
        		<td><?php echo $dat['LANGUAGE']?></td>
        		<td><?php echo $dat['SPORTN']?></td>
			</tr>
  
<?php } ?>
	
		</tbody>
	</table>
</html>
