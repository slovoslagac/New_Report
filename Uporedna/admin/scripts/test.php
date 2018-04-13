<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.11.2016
 * Time: 10:21
 */
include '../../includes/Odds.php';

$source_id = 3;
$sport_id = 1;
$dataOdds = array();
//$matchArray = [9600297, 9600281];
$matchArray = [10973360];
foreach ($matchArray as $item) {
    $matchId = $item;

//    $matchId = 9600281;
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


include '../../conn/mysqlNewPDO.php';

$del = 'truncate ulaz_odds';

$prep = $conn->prepare($del);
$prep->execute();

echo "Uspesno ispraznjena tabela sa ulaznim kvotama <br>";

//var_dump($dataOdds);
//foreach ($dataOdds as $sod) {
//
//    $match = $sod->matchId;
//    $game = $sod->gameName;
//    $subgame = $sod->subgameName;
//    $handicap = $sod->gameHandicap;
//    $value = $sod->oddValue;
//    $sport = $sport_id;
//    $source = $source_id;
//
//
//    $query = '
//		INSERT INTO ulaz_odds (utk_id, odd_value, handicap, subgame, game, source, sport_id)
//		VALUES(:match, :value, :handicap, :subgame, :game, :source, :sport)';
//
//        $params = array(
//            'match' => $match,
//            'value' => $value,
//            'handicap' => $handicap,
//            'subgame' => $subgame,
//            'game' => $game,
//            'source' => $source,
//            'sport' => $sport
//        );
//
//        $prepare = $conn->prepare($query);
//        $prepare->execute($params);
//
//
//}

$text = '';

foreach ($dataOdds as $sod) {
    $match = $sod->matchId;
    $game = $sod->gameName;
    str_replace("'", '', $game);
    $subgame = $sod->subgameName;
    ($sod->gameHandicap == '*') ? $handicap = '\'\'' : $handicap = $sod->gameHandicap;
//    $handicap = $sod->gameHandicap;
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
}
$myfile = fopen("testfile.txt", "w");
fwrite($myfile, $text);
fclose($myfile);


$query = "INSERT INTO ulaz_odds (utk_id, odd_value, handicap, subgame, game, source, sport_id) VALUES$text";
$prepare = $conn->prepare($query);
$prepare->execute();

//echo $query;

//echo $text;
echo "Uspesno upisane kvote <br>";
//
//$con_game_ig = 'call spajanje_balkanbet';
//
//$prep = $conn->prepare($con_game_ig);
//$prep->execute();
//
//$conn = null;