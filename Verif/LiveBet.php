<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Najava za livebet</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script rel="" href="../css/livebet.css"></script>
<script type="text/javascript" src="../js/dataTables.min.js"></script>
<style type="text/css">
	.bs-example{
		margin: 20px;
	}
</style>
</head>
<?php 
$path = join(DIRECTORY_SEPARATOR, array('..','query', 'livebet.php'));
include $path;
$pathPBP = join(DIRECTORY_SEPARATOR, array('..','query', 'playbyplay.php'));
$pathPBPnew = join(DIRECTORY_SEPARATOR, array('..','query', 'playbyplaynew.php'));
include $pathPBP;
include $pathPBPnew;
$data=$livebetData;
$data1=$matchdata;
$data2=$matchdatapremium;
//array_multisort($data1,$data1[3],SORT_ASC,$data1[4],SORT_ASC);

?>
<body>
<div class="bs-example">
    <ul class="nav nav-tabs">
    	<li><a data-toggle="tab" href="#fudbal">Fudbal</a></li>
        <li><a data-toggle="tab" href="#kosarka">Košarka</a></li>
        <li><a data-toggle="tab" href="#hokej">Hokej</a></li>
        <li><a data-toggle="tab" href="#tenis">Tenis</a></li>
        <li><a data-toggle="tab" href="#odbojka">Odbojka</a></li>
        <li><a data-toggle="tab" href="#rukomet">Rukomet</a></li>
        <li><a data-toggle="tab" href=""></a></li>
        <li><a data-toggle="tab" href=""></a></li>
        <li><a data-toggle="tab" href=""></a></li>
        <li><a data-toggle="tab" href="#livebet">PlayByPlay</a></li>
		<li class="active"><a data-toggle="tab" href="#livebetpremium" style="color: red"><strong>Vicentije Premium</strong></a></li>
    </ul>
    <div class="tab-content">
        <div id="fudbal" class="tab-pane fade">
        	<table class="table table-striped">
        		<thead>
        			<tr>
        				<th>Dan</th>
        				<th>Cas</th>
        				<th>Sifra</th>
        				<th>Domacin</th>
        				<th>Gost</th>
        			</tr>
        		</thead>
        		<tbody>
        	<?php foreach($data as $dat){?>
        		<?php if ($dat['SPORT_ID'] == 1){?>
        			<tr>
        				<td><?php echo $dat['DAN']?></td>
        				<td><?php echo $dat['CAS']?></td>
        				<td></td>
        				<td><?php echo $dat['DOMACIN']?></td>
        				<td><?php echo $dat['GOST']?></td>
        			</tr>
        		<?php }?>
        	<?php }?>
        		</tbody>		
        	</table>    
        </div>
        <div id="kosarka" class="tab-pane fade">
        	<table class="table table-striped">
        		<tr>
        			<td>Dan</td>
        			<td>Cas</td>
        			<td>Sifra</td>
        			<td>Domacin</td>
        			<td>Gost</td>
        		</tr>
        	<?php foreach($data as $dat){?>
        		<?php if ($dat['SPORT_ID'] == 2){?>
        		<tr>
        			<td><?php echo $dat['DAN']?></td>
        			<td><?php echo $dat['CAS']?></td>
        			<td></td>
        			<td><?php echo $dat['DOMACIN']?></td>
        			<td><?php echo $dat['GOST']?></td>
        		</tr>
        		<?php }?>
        	<?php }?>		
        	</table>    
        </div>
        <div id="hokej" class="tab-pane fade">
        	<table class="table table-striped">
        		<tr>
        			<td>Dan</td>
        			<td>Cas</td>
        			<td>Sifra</td>
        			<td>Domacin</td>
        			<td>Gost</td>
        		</tr>
        	<?php foreach($data as $dat){?>
        		<?php if ($dat['SPORT_ID'] == 4){?>
        		<tr>
        			<td><?php echo $dat['DAN']?></td>
        			<td><?php echo $dat['CAS']?></td>
        			<td></td>
        			<td><?php echo $dat['DOMACIN']?></td>
        			<td><?php echo $dat['GOST']?></td>
        		</tr>
        		<?php }?>
        	<?php }?>		
        	</table>    
        </div>
        <div id="tenis" class="tab-pane fade">
        	<table class="table table-striped">
        		<tr>
        			<td>Dan</td>
        			<td>Cas</td>
        			<td>Sifra</td>
        			<td>Domacin</td>
        			<td>Gost</td>
        		</tr>
        	<?php foreach($data as $dat){?>
        		<?php if ($dat['SPORT_ID'] == 5){?>
        		<tr>
        			<td><?php echo $dat['DAN']?></td>
        			<td><?php echo $dat['CAS']?></td>
        			<td></td>
        			<td><?php echo $dat['DOMACIN']?></td>
        			<td><?php echo $dat['GOST']?></td>
        		</tr>
        		<?php }?>
        	<?php }?>		
        	</table>    
        </div>
        <div id="odbojka" class="tab-pane fade">
        	<table class="table table-striped">
        		<tr>
        			<td>Dan</td>
        			<td>Cas</td>
        			<td>Sifra</td>
        			<td>Domacin</td>
        			<td>Gost</td>
        		</tr>
        	<?php foreach($data as $dat){?>
        		<?php if ($dat['SPORT_ID'] == 6){?>
        		<tr>
        			<td><?php echo $dat['DAN']?></td>
        			<td><?php echo $dat['CAS']?></td>
        			<td></td>
        			<td><?php echo $dat['DOMACIN']?></td>
        			<td><?php echo $dat['GOST']?></td>
        		</tr>
        		<?php }?>
        	<?php }?>		
        	</table>    
        </div>
        <div id="rukomet" class="tab-pane fade">
        	<table class="table table-striped">
        		<tr>
        			<td>Dan</td>
        			<td>Cas</td>
        			<td>Sifra</td>
        			<td>Domacin</td>
        			<td>Gost</td>
        		</tr>
        	<?php foreach($data as $dat){?>
        		<?php if ($dat['SPORT_ID'] == 7){?>
        		<tr>
        			<td><?php echo $dat['DAN']?></td>
        			<td><?php echo $dat['CAS']?></td>
        			<td></td>
        			<td><?php echo $dat['DOMACIN']?></td>
        			<td><?php echo $dat['GOST']?></td>
        		</tr>
        		<?php }?>
        	<?php }?>		
        	</table>    
        </div>
        <div id="livebet" class="tab-pane fade">
        	<table class="table table-striped">
        		<thead>
        			<tr>
        				<th>Sport</th>
        				<th>Liga</th>
        				<th>datum</th>
        				<th>Vreme</th>
        				<th>Meč</th>
        			</tr>
        		</thead>
        		<tbody>
        	<?php foreach($data1 as $dat){?>
        			<tr>
        				<td><?php echo $dat['sport']?></td>
        				<td><?php echo $dat['league']?></td>
        				<td><?php echo $dat['date']?></td>
        				<td><?php echo $dat['time']?></td>
        				<td><?php echo $dat['match']?></td>
        			</tr>
        	<?php }?>	
        		</tbody>	
        	</table>    
        </div>
		<div id="livebetpremium" class="tab-pane fade in active">
			<table class="table table-striped">
				<thead>
				<tr>
					<th>Sport</th>
					<th>datum</th>
					<th>Vreme</th>
					<th>Meč</th>
					<th>Tip</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($data2 as $dat){ $date = new DateTime($dat['datetime']);
					if ($dat['vistype'] == 'premium') {
					?>
						<tr>
							<td><?php print_r($dat['sport'])?></td>
							<td><?php echo date_format($date, 'd.m.Y')?></td>
							<td><?php echo date_format($date, 'H:i')?></td>
							<td><?php echo $dat['match']?></td>
							<td><?php echo $dat['vistype']?></td>

						</tr>

				<?php } }?>
				</tbody>
			</table>
		</div>
    </div>
</div>
</body>
</html>    

<script>
$(document).ready(function(){
    $('#SortTable').dataTable();
    $('#SortTable1').dataTable();
});
</script>