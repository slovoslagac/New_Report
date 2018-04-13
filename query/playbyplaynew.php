<!DOCTYPE html>
<html>
<head>
<title>Lige</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/osnova.css">
</head>
<?php
$url='http://www.mozzart.performgroup.com/streaming/eventList?days=3&version=5&showVisType=true';
$xml=file_get_contents($url);
$data = simplexml_load_string($xml) ;
//print_r($data);
$matchdatapremium = array();
foreach ($data as $d){
	$tmp = array();
	$tmp['sport']=$d['contentType'];
    $tmp['league']=$d['rightsName'];
    $tmp['datetime']=$d['startDateTime'];
    $tmp['time']=$d['startTime'];
    $tmp['vistype']=$d['visType'];
    $match=$d['description'];  $val=explode('<',$matchval=substr($match, strpos($match, ":") + 1)); $matchval= str_replace(" v "," - ", $val[0]) ;
    $tmp['match']=$matchval;
    $sport = $d['description']; $val1=explode(':',$sport) ;
    $tmp['sport']=$val1[0];
    $matchdatapremium[]=$tmp;
	
	
}

//print_r($matchdata);

//foreach ($matchdata as $item) {
//    if ($item['vistype'] == 'premium'){
//    echo $item['datetime'].'&nbsp&nbsp&nbsp'.$item['match'].' '. $item['vistype']."<br>" ;
//}}

?>