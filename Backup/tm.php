<!DOCTYPE html>
<html lang="en">
	<head>
		<!--  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
		<meta charset="ISO-8859-1">
		<meta http-equiv="refresh" content="240">
		<title>Kontrola prevoda</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../css/prevodi.css">
	</head>
<?php 
$path = join(DIRECTORY_SEPARATOR, array('..','query', 'transfermarkt.php'));
include $path;
$data=$tmDouble;
?>
	<body>
	<table class="table table-striped">
        	<thead>
        		<tr>
        			<th>Naziv</th>
        			<th colspan="3">Ukupno poena u takmi&ccaron;enju</th>
        			<th colspan="3">Fudbal</th>
        		</tr>
        	</thead>
        	<tbody>
        		

        	<?php foreach($data as $dat){?>
        		<tr>
        			<div class="col-md-2"> 
        				<td><?php echo $dat['TAKM']?></td>
        			</div>
        			<div class="col-md-5">
        				<td class="<?php echo ($dat['S2'] !="" && strtoupper($dat['S1']) != $dat['S2']) ? 'red' : ''; ?>"><?php echo str_replace($search, $repl, $dat['S1'])?></td>
        				<td class="<?php echo ($dat['H2'] !="" && strtoupper($dat['H1']) != $dat['H2']) ? 'red' : ''; ?>"><?php echo $dat['H1']?></td>
        				<td class="<?php echo ($dat['R2'] !="" && strtoupper($dat['R1']) != $dat['R2']) ? 'red' : ''; ?>"><?php echo $dat['R1']?></td>
        			</div>
        			<div class="col-md-5">
        				<td><?php echo str_replace($search, $repl, $dat['S2'])?></td>
        				<td><?php echo $dat['H2']?></td>
        				<td><?php echo $dat['R2']?></td>
        			</div>
        		</tr>
        	<?php }?>
        	</tbody>		
        	</table>    
	</body>
</html>