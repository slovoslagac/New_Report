<?php
//Definisanje izvora podatka
ini_set('memory_limit', '512M');


$url = join(DIRECTORY_SEPARATOR, array('..','json', 'out1.json'));
$url1 = join(DIRECTORY_SEPARATOR, array('..','json', 'out3.json'));
$url2 = join(DIRECTORY_SEPARATOR, array('..','json', 'P30games.json'));
$url3 = join(DIRECTORY_SEPARATOR, array('..','json', 'P30subgames.json'));
$url4 = join(DIRECTORY_SEPARATOR, array('..','json', 'P90games.json'));
$url5 = join(DIRECTORY_SEPARATOR, array('..','json', 'P90subgames.json'));
$url6 = join(DIRECTORY_SEPARATOR, array('..','json', 'P365games.json'));
$url7 = join(DIRECTORY_SEPARATOR, array('..','json', 'P365subgames.json'));


//Dohvatanje podataka za igre za poslednju sezonu
$json = file_get_contents($url);
$json_data = json_decode($json);
$league_data = array();
foreach ($json_data as $js){
	foreach ($js as $j){
		$league_data[] = $j;
	}
}

//Dohvatanje podataka za podigre poslednju sezonu

$json1 = file_get_contents($url1);
$json_data1 = json_decode($json1);
$season_best_subgames = array();
foreach ($json_data1 as $js){
	foreach ($js as $j){
		$season_best_subgames[] = $j;
	}
}

//Dohvatanje podataka za igre poslednjih 30 dana

$json2 = file_get_contents($url2);
$json_data2 = json_decode($json2);
$last30_games = array();
foreach ($json_data2 as $js){
	foreach ($js as $j){
		$last30_games[] = $j;
	}
}

//Dohvatanje podataka za podigre poslednjih 30 dana

$json3 = file_get_contents($url3);
$json_data3 = json_decode($json3);
$last30_subgames = array();
foreach ($json_data3 as $js){
	foreach ($js as $j){
		$last30_subgames[] = $j;
	}
}


//Dohvatanje podataka za igre poslednjih 90 dana

$json4 = file_get_contents($url4);
$json_data4 = json_decode($json4);
$last90_games = array();
foreach ($json_data4 as $js){
	foreach ($js as $j){
		$last90_games[] = $j;
	}
}

//Dohvatanje podataka za podigre poslednjih 90 dana

$json5 = file_get_contents($url5);
$json_data5 = json_decode($json5);
$last90_subgames = array();
foreach ($json_data5 as $js){
	foreach ($js as $j){
		$last90_subgames[] = $j;
	}
}

//Dohvatanje podataka za igre poslednjih 90 dana

$json6 = file_get_contents($url6);
$json_data6 = json_decode($json6);
$last365_games = array();
foreach ($json_data6 as $js){
	foreach ($js as $j){
		$last365_games[] = $j;
	}
}

//Dohvatanje podataka za podigre poslednjih 90 dana

$json7 = file_get_contents($url7);
$json_data7 = json_decode($json7);
$last365_subgames = array();
foreach ($json_data7 as $js){
	foreach ($js as $j){
		$last365_subgames[] = $j;
	}
}

?>