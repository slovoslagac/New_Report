<?php
require_once('/conn/mysqlAdminPDOold.php');

$competitionAll = array();
$eventsAll = array();

$url = 'https://www.pinnbet.com/apiprematch/events/F';
$detailUrl = 'https://www.pinnbet.com/apiprematch/bundle/offer';


$jsonEvents = file_get_contents($url);
$events = json_decode($jsonEvents);

$jsonDetails = file_get_contents($detailUrl);
$details = json_decode($jsonDetails);

foreach ($details->sports as $sportitems) {
    $sport = $sportitems->sportName;
    $countries = $sportitems->countries;
    foreach ($countries as $countriesitem) {
        $country = $countriesitem->countryName;
        $competitions = $countriesitem->competitions;
        foreach ($competitions as $item) {
            $competition = $item->competitionName;
            $competitionId = $item->competitionId;
            $competitionAll[$competitionId] = array($competition, $country, $sport);
        }
    }
}


foreach ($events as $eventitem) {
    $homeTeam = null;
    $awayTeam = null;
    $ki1 = null;
    $ki2 = null;
    $kix = null;
    $ug02 = null;
    $ug3v = null;
    $tgg3v = null;
    $tgg = null;
    $tmpArray = array();
    $homeTeam = $eventitem->homeTeamName;
    $awayTeam = $eventitem->awayTeamName;
    $cmpid = $eventitem->competitionId;
    $cmpname = $competitionAll[$cmpid][0];
    $odds = $eventitem->selections;
    foreach ($odds as $oddsitem) {
        switch ($oddsitem->selectionCode) {
            case "k1":
                $ki1 = $oddsitem->odds;
                break;
            case "kx":
                $kix = $oddsitem->odds;
                break;
            case "k2":
                $ki2 = $oddsitem->odds;
                break;
            case "ug02":
                $ug02 = $oddsitem->odds;
                break;
            case "ug3v":
                $ug3v = $oddsitem->odds;
                break;
            case "tgg":
                $tgg = $oddsitem->odds;
                break;
            case "tgg3v":
                $tgg3v = $oddsitem->odds;
                break;
        }


    }

    $tmpArray[0] = $homeTeam;
    $tmpArray[1] = $awayTeam;
    $tmpArray[2] = $ki1;
    $tmpArray[3] = $kix;
    $tmpArray[4] = $ki2;
    $tmpArray[5] = $ug02;
    $tmpArray[6] = $ug3v;
    $tmpArray[7] = $tgg;
    $tmpArray[8] = $tgg3v;
    $tmpArray[9] = $cmpname;

    array_push($eventsAll, $tmpArray);
    unset($tmpArray,$homeTeam, $awayTeam, $ki1, $kix, $ki2, $ug02, $ug3v, $tgg, $tgg3v, $cmpname, $cmpid);
//    echo "$homeTeam, $awayTeam, $ki1, $kix, $ki2, $ug02, $ug3v, $tgg, $tgg3v - $cmpname - $cmpid<br>";
}



$del = 'DELETE FROM Pinbet';

$prep = $conn->prepare($del);
$prep->execute();

foreach ($eventsAll as $d) {

    $home_team = $d[0];
    $away_team = $d[1];
    $league = $d[9];
    $ki1 = $d[2];
    $kix = $d[3];
    $ki2 = $d[4];
    $ug02 = $d[5];
    $ug3p = $d[6];
    $gg = $d[7];

    if ($league != 'Maxbet bonus tip Fudbal') {
        $query = '
		INSERT INTO
		Pinbet (domacin, gost, liga, ki_1, ki_x, ki_2, ug02, ug3p, gg)
		VALUES
		(:home_team, :visitor_team, :league, :ki1, :kix, :ki2, :ug02, :ug3p, :gg)';

        $params = array(
            'home_team' => $home_team,
            'visitor_team' => $away_team,
            'league' => $league,
            'ki1' => $ki1,
            'kix' => $kix,
            'ki2' => $ki2,
            'ug02' => $ug02,
            'ug3p' => $ug3p,
            'gg' => $gg
        );

        $prepare = $conn->prepare($query);
        $prepare->execute($params);
    }

}


$con_game_ig = 'call spajanje_pinbet';

$prep = $conn->prepare($con_game_ig);
$prep->execute();

$conn = null;


foreach ($eventsAll as $val) {
    echo $val[9] . " " . $val[0] . " " . $val[1] . " " . $val[2] . " " . $val[3] . " " . $val[4] . " " . $val[5] . " " . $val[6] . " " . $val[7] . "<br>";
}

echo 'sve je skinuto';
