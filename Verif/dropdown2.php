<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
<?php
$chosen_league_id="";
//Include data from JSON data files
$path = join(DIRECTORY_SEPARATOR, array('..','query', 'LeagueforKs.php'));
include $path;
$leaguesel=$selectleague;



//print_r($leaguesel);
?>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" metod="get" >
			<input type="hidden" >
			<select name="chosen" >
				<option value="0">Izaberi ligu</option>
				<?php foreach ($leaguesel as $le) {$league_id=$le['LEAGUE_ID']; $league = $le['LEAGUE'];?>
				<option value="<?php echo $league_id?>"><?php echo $league."".$league_id?></option>
				<?php }?>
			</select>
			<input type="submit" value="Pošalji"/>

<?php 
if(isset($_GET['submit']))
{
	$chosen_league_id= $_GET['chosen'];
} else {
	echo 1;
}		
?>
		<p><?php echo $chosen_league_id?></p>
		</form>
	</body>
</html>