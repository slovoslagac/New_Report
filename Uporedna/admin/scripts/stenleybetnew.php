<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 15.6.2018.
 * Time: 11:56
 */
require_once('/conn/mysqlAdminPDOold.php');
require_once('/classes/stenleymatch.php');

$url = 'https://api.aws.kambicdn.com/offering/api/v2/sbro/group.json?lang=en_GB&market=RO&client_id=2';
$data = json_decode(file_get_contents($url))->group->groups;
$allmatches = array();
$allleagues;
$alllinks = array();

foreach ($data as $items) {
    if ($items->name == "Football") {
        $allleagues = $items->groups;
        break;
    }
}
foreach ($allleagues as $item) {
    $string = '';
    if (array_key_exists('groups', $item)) {
        $tmpname = $item->termKey;
        $tmpleagues = $item->groups;
        foreach ($tmpleagues as $tmpi) {
            $string = $tmpname . '/' . $tmpi->termKey;
            array_push($alllinks, $string);
        }
    } else {
        $string = $item->termKey;
        array_push($alllinks, $string);
    }
}
$del = 'DELETE FROM stenlybetro3';
$prep = $conn->prepare($del);
$prep->execute();

foreach ($alllinks as $link) {
    sleep(1);
    $url = "https://api.aws.kambicdn.com/offering/api/v3/sbro/listView/football/$link.json?lang=en_GB&market=RO&client_id=2&channel_id=1&categoryGroup=COMBINED&displayDefault=true";
    $data = json_decode(file_get_contents($url))->events;
    $allmatches = array();
    foreach ($data as $item) {
        $details = $item->event;
        $oddsdetails = $item->betOffers;
        if ($oddsdetails != null && property_exists($details, 'awayName')) {
            $tmpMatch = new stanleymatch();
            $tmpMatch->setAttr('hometeam', $details->homeName);
            $tmpMatch->setAttr('awayteam', $details->awayName);
            foreach ($oddsdetails as $oddsitem) {
                $oddsvalues = $oddsitem->outcomes;
                foreach ($oddsvalues as $valueitem) {
                    if ($valueitem->type == "OT_OVER" or $valueitem->type == "OT_UNDER") {
                        if($valueitem->line == '2500') {
                            $tmpMatch->setAttr($valueitem->type, $valueitem->odds / 1000);
                        }
                    } else {
                        $tmpMatch->setAttr($valueitem->type, $valueitem->odds / 1000);
                    }
                }
            }
            array_push($allmatches, $tmpMatch);
            unset($tmpMatch);
        }
    }
//echo "Upisujem meceve <br>";
    foreach ($allmatches as $item) {
        $match = new stanleymatch();
        $match = $item;
        if ($match->OT_ONE > 0) {
            $match->insertMatch();
        }
    };
}

echo "Pozvezujem utakmice <br>";
$con_game_ig = 'call spajanje_stenlybetro';
$prep = $conn->prepare($con_game_ig);
$prep->execute();
$conn = null;

//var_dump($allmatches);
echo "Zavrsio sam caoo!!!";