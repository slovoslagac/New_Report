<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 28.11.2016
 * Time: 16:37
 */

function getName ($id,$array,$categoryName){
    $currentObject = $array->$id;

    $currentName = $currentObject->$categoryName;

    return $currentName;
}

$date = new DateTime();
$start_new = $date->format("Y-m-d");
$end_date = new DateTime();
$end_date->modify('+ 7 day');
$end_new = $end_date->format("Y-m-d");

//echo "$startDate - $end_date<br>";

$startDate = "$start_new+00:00:00";
$endDate = "$end_new+23:59:59";
//$endDate = 'invalid+date';

echo "$start_new - $end_new<br>";
$url = "https://sportbook-platform-api.neosoft.ba/prematchOffer/getMatches?dataFormat=%7B%22default%22:%22object%22,%22sports%22:%22object%22,%22categories%22:%22object%22,%22tournaments%22:%22object%22,%22matches%22:%22array%22,%22betGroups%22:%22array%22%7D&dataShrink=false&language=%7B%22default%22:%22sr-Latn%22,%22tournaments%22:%22en%22%7D&params=%7B%22id_sport%22:%224ac43657-d99c-4e45-a16e-807d3dedafe1%22,%22start_date%22:%22$startDate%22,%22end_date%22:%22$endDate%22,%22bet_count%22:3,%22include_meta%22:true,%22delivery_platform%22:%22Web%22,%22company_uuid%22:%224f54c6aa-82a9-475d-bf0e-dc02ded89225%22%7D";
$json = file_get_contents($url);
$data = array();

$TournamentUrl = "https://sportbook-platform-api.neosoft.ba/prematchOffer/getTournaments?dataFormat=%7B%22default%22:%22object%22,%22sports%22:%22object%22,%22categories%22:%22object%22,%22tournaments%22:%22object%22,%22matches%22:%22array%22,%22betGroups%22:%22array%22%7D&dataShrink=false&language=%7B%22default%22:%22sr-Latn%22,%22tournaments%22:%22en%22%7D&params=%7B%22id_sport%22:%224ac43657-d99c-4e45-a16e-807d3dedafe1%22,%22start_date%22:%22$startDate%22,%22end_date%22:%22$endDate%22,%22bet_count%22:3,%22include_meta%22:true,%22delivery_platform%22:%22Web%22,%22company_uuid%22:%224f54c6aa-82a9-475d-bf0e-dc02ded89225%22%7D";
$jsonTournament = file_get_contents($TournamentUrl);
$jsonTournamentData = json_decode($jsonTournament);
$allTournaments = $jsonTournamentData->tournaments;


$CategorieUrl = "https://sportbook-platform-api.neosoft.ba/prematchOffer/getCategories?dataFormat=%7B%22default%22:%22object%22,%22sports%22:%22object%22,%22categories%22:%22object%22,%22tournaments%22:%22object%22,%22matches%22:%22array%22,%22betGroups%22:%22array%22%7D&dataShrink=false&language=%7B%22default%22:%22sr-Latn%22,%22tournaments%22:%22en%22%7D&params=%7B%22id_sport%22:%224ac43657-d99c-4e45-a16e-807d3dedafe1%22,%22start_date%22:%22$startDate%22,%22end_date%22:%22$endDate%22,%22bet_count%22:3,%22include_meta%22:true,%22delivery_platform%22:%22Web%22,%22company_uuid%22:%224f54c6aa-82a9-475d-bf0e-dc02ded89225%22%7D";

$jsonCategorie = file_get_contents($CategorieUrl);
$CategorieData = json_decode($jsonCategorie);
$allCategorie = $CategorieData->categories;


if ($json !== false) {
    $json_data = json_decode($json);
    $data = array();
    $allData = $json_data->matches;
    foreach ($allData as $item) {
        $matches = array();
        $matchId = $item->matchId;
        $matchName = $item->matchName;
        $matchBets = $item->matchBets;
        $matchTournamentID = $item->idTournament;
        $mathcCategorieID = $item->idCategory;
        $teams = $item->matchTeams;
        foreach ($teams as $t) {
            if ($t->matchTeamType == 1) {
                $homeTeam = $t->teamName;
            } elseif ($t->matchTeamType == 2) {
                $visitorTeam = $t->teamName;
            }
        }


        $micro_date = $item->matchDateTime;
        $date_array = explode(" ", $micro_date / 1000);
        $matchDate = date("Y-m-d H:i:s", $date_array[0]);


        $matches["id"] = $matchId;
        $matches["home_team"] = $homeTeam;
        $matches["away_team"] = $visitorTeam;
        $matches["date"] = $matchDate;
        $matches["competition_name"] = getName($matchTournamentID, $allTournaments,'tournamentName') ;
        $matches["categorie_name"] = getName($mathcCategorieID, $allCategorie,'categoryName');
        $matches["ki1"] = 0;
        $matches["kiX"] = 0;
        $matches["ki2"] = 0;
        $matches["ugUnder"] = 0;
        $matches["ugOver"] = 0;
        $matches["ggYes"] = 0;
//        echo "$matchDate, $matchId, $matchTournament, $homeTeam - $visitorTeam, + $matchName ";
        foreach ($matchBets as $mb) {
            if ($mb->matchBetPosition == 1 and $mb->betName == "Konačan Ishod") {

                $kiOdss = $mb->matchBetOutcomes;
                foreach ($kiOdss as $ki) {
                    $subgame = "ki" . $ki->providerBetOutcomeId;
                    $value = $ki->matchBetOutcomeOddValue;
//                    echo "$subgame - $value / ";
                    $matches[$subgame] = $value;
                }

            }

            if ($mb->matchBetPosition == 2 and $mb->betName == "Ukupno Golova") {
                $ugOdss = $mb->matchBetOutcomes;
                foreach ($ugOdss as $ug) {
                    $subgame = "ug" . $ug->providerBetOutcomeId;
                    $value = $ug->matchBetOutcomeOddValue;
//                    echo "$subgame - $value / ";
                    $matches[$subgame] = $value;
                }

            }
            if ($mb->matchBetPosition == 3 and $mb->betName == "Oba Tima Daju Gol") {
                $ggOdss = $mb->matchBetOutcomes;
                foreach ($ggOdss as $gg) {
                    $subgame = "gg" . $gg->providerBetOutcomeId;
                    $value = $gg->matchBetOutcomeOddValue;
//                    echo "$subgame - $value / ";
                    $matches[$subgame] = $value;

                }

            }

        }


        array_push($data, $matches);
    }


}


//foreach ($data as $val) {
//    echo $val["categorie_name"]."-". $val["competition_name"] . " " . $val["home_team"] . " " . $val["away_team"] ."<br>";
//}

include 'conn/mysqlAdminPDOold.php';

$del = 'DELETE FROM balkanbet3';

$prep = $conn->prepare($del);
$prep->execute();

foreach ($data as $d) {

    $home_team = $d['home_team'];
    $away_team = $d['away_team'];
    $league = $d['competition_name'];
    $ki1 = $d['ki1'];
    $kix = $d['kiX'];
    $ki2 = $d['ki2'];
    $ug02 = $d['ugUnder'];
    $ug3p = $d['ugOver'];
    $gg = $d['ggYes'];



        $query = '
		INSERT INTO
		balkanbet3 (domacin, gost, liga, ki_1, ki_x, ki_2, ug02, ug3p, gg)
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

$con_game_ig = 'call spajanje_balkanbet';

$prep = $conn->prepare($con_game_ig);
$prep->execute();

$conn = null;

echo "Zavrsio sam";