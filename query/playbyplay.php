<!DOCTYPE html>
<html>
<head>
<title>Lige</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/osnova.css">
</head>
<?php
$url='http://www.mozzart.performgroup.com/streaming/eventList?version=3&days=2';
$xml=file_get_contents($url);
$data = simplexml_load_string($xml) ;
//print_r($data);
$matchdata = array();
foreach ($data as $d){
	$tmp = array();
	$tmp['sport']=$d['contentType'];
    $tmp['league']=$d['rightsName'];
    $tmp['date']=$d['startDate'];
    $tmp['time']=$d['startTime'];
    $match=$d['description'];  $val=explode('<',$matchval=substr($match, strpos($match, ":") + 1)); $matchval= str_replace(" v "," - ", $val[0]) ;
    $tmp['match']=$matchval;

    $matchdata[]=$tmp;
	
	
}

//print_r($matchdatapremium);

?>