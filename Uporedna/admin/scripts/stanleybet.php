<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 8.1.2018
 * Time: 09:09
 */

$url = 'https://api.stanleybet.ro/content/v1/events/by-node/0/0/z60ro/*/0/main/*/0/1000/';
$data = json_decode(file_get_contents($url));
$allmatches = array();


foreach ($data as $item) {
    $ki1 = ''; $kix = ''; $ki2 = ''; $nd =''; $tp ='';
    $matches = array();
    if ($item->Type == "R" && $item->RegionName != 'stanley') {
        $oddsArray = $item->Markets;
        foreach ($oddsArray as $odds) {
            switch ($odds->TypeId) {
                case "30000":
                    $suboddsgroup = $odds->Selections;
                    foreach ($suboddsgroup as $subodds) {
                        switch ($subodds->ExternalCode) {
                            case "1":
                                $ki1 = $subodds->Price;
                                break;
                            case "X":
                                $kix = $subodds->Price;
                                break;
                            case "2":
                                $ki2 = $subodds->Price;
                                break;
                        }
                    }
                    break;
                case "30018";
                    $suboddsgroup = $odds->Selections;
                    foreach ($suboddsgroup as $subodds) {
                        switch ($subodds->ExternalCode) {
                            case "1":
                                $nd = $subodds->Price;
                                break;
                            case "2":
                                $tp = $subodds->Price;
                                break;
                        }
                    }
            }
        }
        if($ki1 != "") {
//            echo $ki1, ' ', $kix, ' ', $ki2, ' ', $nd, ' ', $tp, ' ', "$item->RegionName $item->CompetitionName", ' ', $item->Competitor1, '-', $item->Competitor1, ' ', $item->EventName, '<br>';
            $matches["id"] = $item->EventId;
            $matches["home_team"] = $item->Competitor1;
            $matches["away_team"] = $item->Competitor2;
            $matches["date"] = $item->StartTime;
            $matches["competition_name"] = $item->RegionName.'-'.$item->CompetitionName ;
            $matches["categorie_name"] = $item->RegionName;
            $matches["ki1"] = $ki1;
            $matches["kiX"] = $kix;
            $matches["ki2"] = $ki2;
            $matches["ugUnder"] = $nd;
            $matches["ugOver"] = $tp;

            array_push($allmatches, $matches);
        }
    }


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
    $ug02 = $d['ugUnder'];
    $ug3p = $d['ugOver'];




    $query = '
		INSERT INTO
		stenlybetro3 (domacin, gost, liga, ki_1, ki_x, ki_2, ug02, ug3p)
		VALUES
		(:home_team, :visitor_team, :league, :ki1, :kix, :ki2, :ug02, :ug3p)';

    $params = array(
        'home_team' => $home_team,
        'visitor_team' => $away_team,
        'league' => $league,
        'ki1' => $ki1,
        'kix' => $kix,
        'ki2' => $ki2,
        'ug02' => $ug02,
        'ug3p' => $ug3p,
    );

    $prepare = $conn->prepare($query);
    $prepare->execute($params);


}

//echo "Pozvezujem utakmice <br>";

$con_game_ig = 'call spajanje_stenlybetro';

$prep = $conn->prepare($con_game_ig);
$prep->execute();

$conn = null;

echo "Zavrsio sam caoo!!!";