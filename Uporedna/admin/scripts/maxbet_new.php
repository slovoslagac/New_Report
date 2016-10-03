<?php

$url = 'http://www.maxbet.rs/ibet/offer/sportsAndLeagues/-1.json';
$json = file_get_contents($url);
if ($json !== false) {
    $json_data = json_decode($json);


    $leagues_skip = array(116811, 132141, 131939, 133808, 133806, 133807, 133809, 132140, 134111);
    $leagues = array();
    $data = array();
    foreach ($json_data as $dat) {
        if ($dat->name == 'Fudbal') {
            echo $dat->name . "<br>";
            foreach ($dat->leagues as $key) {
                array_push($leagues, array($key->betLeagueId, $key->name));

            }
        }

    }

    foreach ($leagues as $key) {
        $league_id = $key[0];
        $league_name = $key[1];
        if (in_array($league_id, $leagues_skip)) {
        } else {
            $url = 'http://www.maxbet.rs/ibet/offer/league/' . $league_id . '/0/0/false.json';
            $json = file_get_contents($url);
            if ($json !== false) {
                $json_data = json_decode($json);


                foreach ($json_data->matchList as $match) {
                    $matches = array();
                    $matches["id"] = $match->id;
                    $matches["home_team"] = $match->home;
                    $matches["away_team"] = $match->away;
                    $matches["league"] = $league_name;

                    foreach ($match->odBetPickGroups as $odds) {
                        switch ($odds->id) {
                            case 70:
                                foreach ($odds->tipTypes as $values) {
                                    switch ($values->tipType) {
                                        case "KI_1":
                                            $matches["ki1"] = $values->value;
                                            break;
                                        case "KI_X":
                                            $matches["kix"] = $values->value;
                                            break;
                                        case "KI_2":
                                            $matches["ki2"] = $values->value;
                                            break;
                                    }
                                };
                                break;
                            case 980:
                                foreach ($odds->tipTypes as $values) {
                                    switch ($values->tipType) {
                                        case "G0_2":
                                            $matches["ug02"] = $values->value;
                                            break;
                                        case "G3_PLUS":
                                            $matches["ug3p"] = $values->value;
                                            break;
                                        default:
                                            break;
                                    }
                                };
                                break;

                            case 982:
                                foreach ($odds->tipTypes as $values) {
                                    switch ($values->tipType) {
                                        case "GGG":
                                            $matches["GG"] = $values->value;
                                            break;
                                        default:
                                            break;
                                    }
                                };
                                break;
                            default:
                                break;
                        }

                    }
                    array_push($data, $matches);
                }
            }

        }

    }
}


//Upis u bazu
include 'conn/mysqlAdminPDOold.php';

$del = 'DELETE FROM maxbet3';

$prep = $conn->prepare($del);
$prep->execute();

foreach ($data as $d) {

    $home_team = $d['home_team'];
    $away_team = $d['away_team'];
    $league = $d['league'];
    $ki1 = $d['ki1'];
    $kix = $d['kix'];
    $ki2 = $d['ki2'];
    $ug02 = $d['ug02'];
    $ug3p = $d['ug3p'];
    $gg = $d['GG'];


    $query = '
		INSERT INTO
		maxbet3 (domacin, gost, liga, ki_1, ki_x, ki_2, ug02, ug3p, gg)
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

$con_game_ig = 'call spajanje_maxbet';

$prep = $conn->prepare($con_game_ig);
$prep->execute();

$conn = null;


foreach ($data as $val) {
    echo $val["league"] . " " . $val["home_team"] . " " . $val["away_team"] . " " . $val["ki1"] . " " . $val["kix"] . " " . $val["ki2"] . " " . $val["ug02"] . " " . $val["ug3p"] . " " . $val["GG"] . "<br>";
}

echo 'sve je skinuto';

?>
