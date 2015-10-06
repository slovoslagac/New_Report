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
$no_cmp = array (4954,6063,6549,6551,6552,565,1162);

$path = join(DIRECTORY_SEPARATOR, array('..','query', 'ukupnogolovauligi.php'));
$path1 = join(DIRECTORY_SEPARATOR, array('..','query', 'NoFlags.php'));
$path2 = join(DIRECTORY_SEPARATOR, array('..','query', 'DoubleMatches.php'));
include $path;
include $path1;
include $path2;
$data=$totalgoalData1;
$flagsdata=$NoFlagData;
$dm=$DoubleMatches;
$search = array ('^');
$repl = array ('&Ccaron;');
?>
<body>
<div class="bs-example">
    <ul class="nav nav-tabs">
    	<li><a data-toggle="tab" href="#gol_liga">Ukupno golova u ligi</a></li>
    	<li><a data-toggle="tab" href="#bez_zastavice">Bez zastavica</a></li>
    	<li class="active"><a data-toggle="tab" href="#doublematches">Duplirani Mecevi</a></li>
    </ul>
    <div class="tab-content">
        <div id="gol_liga"  class="tab-pane fade"  >
        	<table class="table table-striped">
        	<thead>
        		<tr>
        			<th>Naziv</th>
        			<th colspan="3">Ukupno poena u takmi&ccaron;enju</th>
        			<th colspan="3">Fudbal</th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr>
        			<div class="col-md-2"> 
        				<td></td>
        			</div>
        			<div class="col-md-5">
        				<td>Srpski</td>
        				<td>Hrvatski</td>
        				<td>Rumunski</td>
        			</div>
        			<div class="col-md-5">
        				<td>Srpski</td>
        				<td>Hrvatski</td>
        				<td>Rumunski</td>
        			</div>
        		</tr>

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
        </div>
        <div id="bez_zastavice" class="tab-pane fade" >
        	<table class="table table-striped">
        	
        	<?php $sport=""; foreach($flagsdata as $fld) {
        		 if($fld['SPORT_NAME']!=$sport and ! in_array($fld['CMP_ID'],$no_cmp)){
					$sport=	$fld['SPORT_NAME'];	?>
			<thead>
        		<tr>
        			<th colspan="4"><?php echo $sport?></th>
        		</tr>
        		<tr>
        			<td class="col-md-2"></td>
        			<td class="col-md-4">Zemlja</td>
        			<td class="col-md-4">Naziv</td>
        			<td class="col-md-2"></td>
        		</tr>
        	</thead>
			<tbody>
        	<?php }?>
        	
        	
        		<tr>
        		<?php 
        				if (! in_array($fld['CMP_ID'],$no_cmp)) {?>
        			<td></td>
        			<td><?php echo $fld['COUNTRY_NAME']?></td>
        			<td value="<?php echo $fld['CMP_ID']?>"><?php echo $fld['NAME']?></td>
        			<td></td>

        		<?php }?>
          		</tr>      		

        	<?php }?>
        	</tbody>
        	</table>    
        </div>
        <div id="doublematches" class="tab-pane fade in active">
        	<table class="table table-striped">
        	
        	<?php $sport=""; foreach($dm as $fld) {
        		 if($fld['SPORT']!=$sport ){
					$sport=	$fld['SPORT'];	?>
			<thead>
        		<tr>
        			<th colspan="4"><?php echo $sport?></th>
        		</tr>
        		<tr>
        			<td class="col-md-3">Takmičenje</td>
        			<td class="col-md-3">Vreme</td>
        			<td class="col-md-3">Domaćin</td>
        			<td class="col-md-3">Gost</td>
        		</tr>
        	</thead>
			<tbody>
        	<?php }?>
        	
        	
        		<tr>
        			<td><?php echo $fld['TAKMICENJE']?></td>
        			<td><?php echo $fld['VREME']?></td>
        			<td><?php echo $fld['DOMACIN']?></td>
        			<td><?php echo $fld['GOST']?></td>
				</tr>      		

        	<?php }?>
        	</tbody>
        	</table>    
        </div>
        
</div>
</body>
</html>                                		