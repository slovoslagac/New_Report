<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 20.8.2018.
 * Time: 13:38
 */
require_once('../conn/mysqlAdminPDOold.php');
require_once('../classes/stenleymatch.php');

$link = 'europa_league_qual_';
$url = "https://api.aws.kambicdn.com/offering/api/v3/sbro/listView/football/$link.json?lang=en_GB&market=RO&client_id=2&channel_id=1&categoryGroup=COMBINED&displayDefault=true";
$data = json_decode(file_get_contents($url))->events;
$allmatches = array();

foreach ($data as $item) {
    $details = $item->event;
    $oddsdetails = $item->betOffers;
    if ($oddsdetails != null) {
        $tmpMatch = new stanleymatch();
        $tmpMatch->setAttr('hometeam', $details->homeName);
        $tmpMatch->setAttr('awayteam', $details->awayName);
        foreach ($oddsdetails as $oddsitem) {
            $oddsvalues = $oddsitem->outcomes;
            foreach ($oddsvalues as $valueitem) {
                $tmpMatch->setAttr($valueitem->type, $valueitem->odds / 1000);
            }
        }
        array_push($allmatches, $tmpMatch);
        unset($tmpMatch);
    }
}

foreach ($allmatches as $item) {
    $match = new stanleymatch();
    $match = $item;
    $match->insertMatch();
    var_dump($match);
};

