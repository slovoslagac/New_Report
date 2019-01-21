<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 28.11.2016
 * Time: 16:37
 */


include '../../includes/Odds.php';
include '../../includes/Match.php';

$source_id = 3;
$sport_id = 1;
$dataOdds = array();

function getName($id, $array, $categoryName)
{
    $currentObject = $array->$id;

    $currentName = $currentObject->$categoryName;

    return $currentName;
}

$date = new DateTime();
$start_new = $date->format("Y-m-d");
$end_date = new DateTime();
$end_date->modify('+6 day');
$end_new = $end_date->format("Y-m-d");

//echo "$startDate - $end_date<br>";

$startDate = "$start_new ";
$endDate = "$end_new+23:59:59";
//$endDate = 'invalid+date';

echo "$start_new - $end_new \n";
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
    $allMatches = array();
    $allData = $json_data->matches;
    foreach ($allData as $item) {
        $matchId = $item->matchId;
        $matchName = $item->matchName;
        $matchBets = $item->matchBets;
        $matchTournamentID = $item->idTournament;
        $matchCategorieID = $item->idCategory;
        $teams = $item->matchTeams;
        foreach ($teams as $t) {
            if ($t->matchTeamType == 1) {
                $homeTeam = $t->teamName;
                $homeTeamId = $t->idTeam;
            } elseif ($t->matchTeamType == 2) {
                $visitorTeam = $t->teamName;
                $visitorTeamId = $t->idTeam;
            }
        }


        $micro_date = $item->matchDateTime;
        $date_array = explode(" ", $micro_date / 1000);
        $matchDate = date("Y-m-d H:i:s", $date_array[0]);
        $matchName = "$homeTeam - $visitorTeam";
        $tournamentName = getName($matchCategorieID, $allCategorie, 'categoryName') . '-' . getName($matchTournamentID, $allTournaments, 'tournamentName');


        $currentMatch = new Match($tournamentName,$matchTournamentID,$homeTeam,$homeTeamId,$visitorTeam,$visitorTeamId,$matchName,$matchId,$source_id,$sport_id,$matchDate);
        array_push($allMatches, $currentMatch);


//        Skidam kvote za mec;
        $urlMatch = "https://sportbook-platform-api.neosoft.ba/prematchOffer/getMatch?dataFormat=%7B%22default%22:%22object%22,%22sports%22:%22object%22,%22categories%22:%22object%22,%22tournaments%22:%22object%22,%22matches%22:%22array%22,%22betGroups%22:%22array%22%7D&dataShrink=false&language=%7B%22default%22:%22sr-Latn%22,%22tournaments%22:%22en%22%7D&params=%7B%22id_match%22:%22$matchId%22,%22delivery_platform%22:%22Web%22,%22company_uuid%22:%224f54c6aa-82a9-475d-bf0e-dc02ded89225%22%7D";
        $jsonMatch = file_get_contents($urlMatch);
        $data = array();

        if ($jsonMatch !== false) {
            $match_data = json_decode($jsonMatch);
            $allOdds = $match_data->matchBets;
            foreach ($allOdds as $allOdd) {
                $odds = array();
                $gameName = $allOdd->betName;
                $gameHandicap = $allOdd->matchBetSpecialValue;
                $allSubgames = $allOdd->matchBetOutcomes;
                foreach ($allSubgames as $asg) {
                    $subgameName = $asg->providerBetOutcomeId;
                    $subgameOdd = $asg->matchBetOutcomeOddValue;
                    $tmpOdd = new Odds($gameName, $subgameName, $gameHandicap, $subgameOdd, $matchId);
                    array_push($dataOdds, $tmpOdd);


                }
            }
        }


    }


}

include '../../conn/mysqlNewPDO.php';

$del = 'truncate ulaz_new';

$prep = $conn->prepare($del);
$prep->execute();

echo "Uspesno ispraznjena tabela sa ulaznim mecevima \n";


$del = 'truncate ulaz_odds';

$prep = $conn->prepare($del);
$prep->execute();

echo "Uspesno ispraznjena tabela sa ulaznim kvotama \n";

foreach($allMatches as $am) {
    $am->add_match();
}

echo "Uspesno su upisani svi mecevi \n";


$text = '';
$i = 1;
$statementArray = array();

foreach ($dataOdds as $sod) {
    if ($i == 1) {

    } elseif ($i > 9000){
        $i = 1;
        array_push($statementArray, $text);
        $text = '';
    }
        $match = $sod->matchId;
        $game = $sod->gameName;
        $subgame = $sod->subgameName;
        ($sod->gameHandicap == '*') ? $handicap = '' : $handicap = $sod->gameHandicap;
        ($handicap == '')? $subgame = "$sod->subgameName" : $subgame = "$sod->subgameName ($handicap)";
        $value = $sod->oddValue;
        $sport = $sport_id;
        $source = $source_id;
        if ($game != 'Strelac Na Meču' and $game != 'Strelac Prvog Gola Na Meču' and $game != 'Strelac Poslednjeg Gola Na Meču') {
            if (empty($text)) {
                $text = $text . "($match, $value, '$handicap', '$subgame', \"$game\", $source, $sport)";
            } else {
                $text = $text . ",($match, $value, '$handicap', '$subgame', \"$game\", $source, $sport)";
            }
        }

        $i++;

}

foreach($statementArray as $t) {
    $query = "INSERT INTO ulaz_odds (utk_id, odd_value, handicap, subgame, game, source, sport_id) VALUES$t";
    $prepare = $conn->prepare($query);
    $prepare->execute();
}
//echo $query;
echo "Uspesno upisane kvote \n";

$import_data = 'call import_data_game()';
$import = $conn->prepare($import_data);
$import->execute();

echo "Importovani podaci\n";

echo "Zavrsio sam";