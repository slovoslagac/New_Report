<?php 
$maxOdds = array();
foreach ($Data as $row) {
	//featch favorite
	$fav = $row['fav'];
	$gameId = $row['sifra'];
	
	// get max odd
	$columnNames = array();
		for($p=1; $p<=$numBookmakers; $p++){
			$v1 = 'ki' . $fav.$p;
			$columnNames[]=$v1;
	}	
		//print_r($columnNames);
	
	$maxOdd = 0;
	foreach ($columnNames as $columnName)	{

		$maxOdd = 	((double) $row[$columnName] > (double) $maxOdd) ? $row[$columnName]  : $maxOdd;
	}		
	$maxOdds[$gameId] = (double) $maxOdd;


}

$maxTG = array();
foreach ($Data as $row) {
	//featch favorite
	$gameId = $row['sifra'];

	// get max odd
	$columnNames = array();
	for($p=1; $p<=$numBookmakers; $p++){
		$v1 = 'ug1'.$p;
		$columnNames[]=$v1;
	}
	//print_r($columnNames);

	$maxOdd = 0;
	foreach ($columnNames as $columnName)	{

		$maxOdd = 	((double) $row[$columnName] > (double) $maxOdd) ? $row[$columnName]  : $maxOdd;
	}
	$maxTG[$gameId] = (double) $maxOdd;
}



?>
