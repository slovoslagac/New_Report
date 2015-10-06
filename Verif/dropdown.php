<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	</head>
<?php
//Include data from JSON data files
$path = join(DIRECTORY_SEPARATOR, array('..','query', 'LeagueforKs.php'));
include $path;
$leaguesel=$selectleague;


//print_r($leaguesel);
?>
	<body>
		<div class="container">
			<h2>Izveštaj ok stanju ks-a</h2>
            <div class="dropdown">
       			<button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Lige
        		<span class="caret"></span></button>
       			<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
       				<?php foreach ($leaguesel as $le) {$league_id=$le['LEAGUE_ID']; $league = $le['LEAGUE'];?>
       				<li id="<?php echo $league_id?>"><a href="dropdown.php"><?php echo $league?></a></li>
          			<?php }?>
        		</ul>
      		</div>
    	</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
</html>