<?php
include_once ('../../../lib/simple_html_dom.php');
include_once ('te.php');
include_once ('../classes/xscoresMatch.php');
include_once ('../../conn/mysqlNewPDO.php');

$sport = 'hockey';
$season = '2018-2019';
$league = "belarus/extraliga";
$url = "https://www.xscores.com/$sport/leagueresults/$league/$season/r//";
$html = file_get_html($url);

$links = array();
$listofmatches = array();

foreach($html->find('[id="round"]') as $a) {
    foreach ($a->find('option') as $item) {
        array_push($links, array($item->value, $item->innertext));
    }
}

foreach ($links as $link) {
    $key = $link[0];
    $tmplist = getperioddata($key, $league, $sport, $season, $link[1]);
    foreach ($tmplist as $tmp) {
        array_push($listofmatches, $tmp);
    }
}

$del = 'truncate ulaz_new';
$del1 = 'truncate ulaz_results';
$del2 = 'truncate ulaz_details';
$prep = $conn->prepare($del);
$prep->execute();
$prep = $conn->prepare($del1);
$prep->execute();
$prep = $conn->prepare($del2);
$prep->execute();

foreach ($listofmatches as $item ){
    $newmatch = new xscoresMatch();
    $newmatch = $item;
    var_dump($newmatch);
    $newmatch->add_match();
    unset($newmatch);
}

$insert = 'call import_statistic_data';
$prep = $conn->prepare($insert);
$prep->execute();