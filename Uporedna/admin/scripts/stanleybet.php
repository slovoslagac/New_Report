<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 15.6.2018.
 * Time: 15:11
 */

$url = 'https://api.aws.kambicdn.com/offering/api/v3/sbro/listView/football.json?lang=en_GB&market=RO&client_id=2&channel_id=1&ncid=1534495457832&categoryGroup=ALL&displayDefault=true&category=match';
//$url = 'https://api.aws.kambicdn.com/offering/api/v3/sbro/listView/football.json?lang=en_US&market=RO&client_id=2&channel_id=1&categoryGroup=COMBINED&displayDefault=true&category=match';
$data = json_decode(file_get_contents($url));
$allmatches = array();

foreach ($data->events as $item) {
    $matchdata = $item->event;
    $matchodds = $item->betOffers;
    $matches = array();

    if ($matchdata->type == "ET_MATCH") {
        $hometeam = $matchdata->homeName;
        $awayteam = $matchdata->awayName;
        $competition = $matchdata->group;
        foreach ($matchodds as $itemodd) {
            $currentmatchodds = $itemodd->outcomes;

            foreach ($currentmatchodds as $newitem) {
                $ki1 ;$kix;$ki2;
                switch ($newitem->type) {
                    case "OT_ONE":
                        $ki1 = $newitem->odds/1000;
                        break;
                    case "OT_CROSS":
                        $kix = $newitem->odds/1000;
                        break;
                    case "OT_TWO":
                        $ki2 = $newitem->odds/1000;
                        break;
                }
            }

        }
//        if($ki1 != "") {
//            echo $ki1, ' ', $kix, ' ', $ki2, ' ', $nd, ' ', $tp, ' ', "$item->RegionName $item->CompetitionName", ' ', $item->Competitor1, '-', $item->Competitor1, ' ', $item->EventName, '<br>';
        $matches["id"] = $matchdata->id;
        $matches["home_team"] = $hometeam;
        $matches["away_team"] = $awayteam;
        $matches["date"] = $matchdata->prematchEnd;
        $matches["competition_name"] = $competition ;
        $matches["ki1"] = $ki1;
        $matches["kiX"] = $kix;
        $matches["ki2"] = $ki2;


        array_push($allmatches, $matches);
//        }



    }
//        echo "$hometeam - $awayteam $ki1 $kix $ki2 <br>";



}

include 'conn/mysqlAdminPDOold.php';
//echo "Brisem tabelu <br>";

$del = 'DELETE FROM stenlybetro3';

$prep = $conn->prepare($del);
$prep->execute();

//echo "Upisujem meceve <br>";

foreach ($allmatches as $d) {

    $home_team = $d['home_team'];
    $away_team = $d['away_team'];
    $league = $d['competition_name'];
    $ki1 = $d['ki1'];
    $kix = $d['kiX'];
    $ki2 = $d['ki2'];





    $query = 'INSERT INTO
		stenlybetro3 (domacin, gost, liga, ki_1, ki_x, ki_2)
		VALUES
		(:home_team, :visitor_team, :league, :ki1, :kix, :ki2)';

    $params = array(
        'home_team' => $home_team,
        'visitor_team' => $away_team,
        'league' => $league,
        'ki1' => $ki1,
        'kix' => $kix,
        'ki2' => $ki2,
    );

    $prepare = $conn->prepare($query);
    $prepare->execute($params);


}

//echo "Pozvezujem utakmice <br>";

$con_game_ig = 'call spajanje_stenlybetro';

$prep = $conn->prepare($con_game_ig);
$prep->execute();

$conn = null;

//var_dump($allmatches);

echo "Zavrsio sam caoo!!!";