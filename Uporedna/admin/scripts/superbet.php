<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 15.6.2018.
 * Time: 11:56
 */

$date = new DateTime();
$start_new = $date->format("Y-m-d");
$end_date = new DateTime();
$end_date->modify('+ 7 day');
$end_new = $end_date->format("Y-m-d");

//echo "$start_new - $end_new <br>";

$url = "https://offer.superbet.ro/offer/getOfferByDate?controller=offer&method=getOfferByDate&currentStatus=active&compression=1&startDate=$start_new+09%3A57%3A27&endDate=$end_new+07%3A00%3A00&offerState=prematch";
$json = file_get_contents($url);
$json_decoded = json_decode($json);
$allmatches = array();

foreach ($json_decoded->data as $item) {
    if ($item->si == 5) {

        $match = $item->mn;
        $date = $item->md;
        $sport = $item->si;
        $competition = $item->tn2;
//    var_dump($item);
        $odds = $item->odds;

        $match_details = explode("·", $match);
        $hometeam = $match_details[0];
        $awayteam = $match_details[1];

        foreach ($odds as $itemnew) {
            switch ($itemnew->oc) {
                case "11" :
                    $ki1 = $itemnew->ov;
                    break;
                case "10" :
                    $kix = $itemnew->ov;
                    break;
                case "12" :
                    $ki2 = $itemnew->ov;
                    break;
                case "0-2" :
                    $nd = $itemnew->ov;
                    break;
                case "3+" :
                    $tp = $itemnew->ov;
                    break;
                case "711" :
                    $gg = $itemnew->ov;
                    break;
                case "713" :
                    $ggtp = $itemnew->ov;
                    break;
            }
        }

//        echo "$sport - $date - $match - $hometeam - $awayteam, $ki1, $kix, $ki2, $nd, $tp, $gg, $ggtp <br>";

        $matches["home_team"] = $hometeam;
        $matches["away_team"] = $awayteam;
        $matches["date"] = $date;
        $matches["competition_name"] = $competition;
        $matches["ki1"] = $ki1;
        $matches["kiX"] = $kix;
        $matches["ki2"] = $ki2;
        $matches["ugUnder"] = $nd;
        $matches["ugOver"] = $tp;
        $matches["gg"] = $gg;
        $matches["ggtp"] = $ggtp;


        array_push($allmatches, $matches);

    }
}

include 'conn/mysqlAdminPDOold.php';
//echo "Brisem tabelu <br>";

$del = 'DELETE FROM superbetro3';

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
    $gg = $d['gg'];
    $gg3p = $d['ggtp'];




    $query = '
		INSERT INTO
		superbetro3 (domacin, gost, liga, ki_1, ki_x, ki_2, ug02, ug3p, gg, gg3p)
		VALUES
		(:home_team, :visitor_team, :league, :ki1, :kix, :ki2, :ug02, :ug3p, :gg, :ggtp)';

    $params = array(
        'home_team' => $home_team,
        'visitor_team' => $away_team,
        'league' => $league,
        'ki1' => $ki1,
        'kix' => $kix,
        'ki2' => $ki2,
        'ug02' => $ug02,
        'ug3p' => $ug3p,
        'gg' => $gg,
        'ggtp' => $gg3p,
    );

    $prepare = $conn->prepare($query);
    $prepare->execute($params);


}

//echo "Pozvezujem utakmice <br>";

$con_game_ig = 'call spajanje_superbetro';

$prep = $conn->prepare($con_game_ig);
$prep->execute();

$conn = null;

echo "Zavrsio sam caoo!!!";