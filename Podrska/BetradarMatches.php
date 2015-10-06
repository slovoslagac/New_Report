<!DOCTYPE html>
<html>
<head>
<!--  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
<meta charset="ISO-8859-1">
<meta http-equiv="refresh" content="240">
<title>Priprema ponude</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../css/prevodi.css">
</head>
<?php
$path = join(DIRECTORY_SEPARATOR, array('..','query', 'BetradarMatchesPrepare.php'));
include $path;
$data=$PreparedMathces;
?>
<body>
<div class="bs-example">
	<table class="table table-striped">
		
        	<?php $curtakm='';$cursport=''; foreach($data as $dat){$sport=$dat['SPORTID'];
        			if($cursport!=$sport){
        				$cursport=$sport;
        				$takm=$dat['COMP'];

        			
        			
        	?>
        	        <thead>
			<tr>
				<th>Takmi&ccaron;enje</th>
				<th>Datum</th>
        		<th>Domaćin</th>
        		<th>Gost</th>
        	</tr>
		</thead>
        	
        	
        	<?php 
        	if($curtakm!=$takm){	
				$curtakm=$takm	        		
        	?>

        
        	<?php  ?>
        <tbody>	
			<tr>
				<div class="col-md-2"> 
        			<td><?php echo $takm?></td>
        			<td><?php echo $dat['STARTTIME']?></td>
        			<td><?php echo $dat['HTM']?></td>
        			<td><?php echo $dat['VTM']?></td>
        				
        		</div>
        	</tr>	
        	
        	
        	<?php      }   }	}?>
        	</tbody>		
        	</table>  
        	
</div>
</body>
</html>
