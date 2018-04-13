<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.11.2017
 * Time: 11:11
 */

include('../classes/match.php');
include '../conn/mysqlPDO.php';

$del = 'DELETE FROM soccer3';
$prep = $conn->prepare($del);
$prep->execute();


$url = "https://www.soccerbet.rs/api/Prematch/GetCompetitionFilter?timeFrameOption=4";
$html = json_decode(file_get_contents($url));

$urlmasterdata = 'https://www.soccerbet.rs/api/MasterData/GetMasterData';
$masterdata = json_decode(file_get_contents($urlmasterdata));
$listofcompetitions = array();
foreach ($masterdata->CompetitionsData->Competitions as $master) {
    $tmpid = $master->Id;
    $tmpname = $master->Name;
    if ($master->SportId == 1) {
        $listofcompetitions[$tmpid] = $tmpname;
    }
}


$listofmatches = array();
$subgamesid = array(5000 => "ki1", 5001 => "kix", 5002 => "ki2", 5118 => "tp", 5350 => "gg");


foreach ($html as $data) {
    $competitionid = $data->CompetitionId;
    if (array_key_exists($competitionid, $listofcompetitions)) {
        $competitionurl = "https://www.soccerbet.rs/api/Prematch/GetCompetitionMatches?competitionId=$competitionid&timeFrameOption=4";
        $matchdata = json_decode(file_get_contents($competitionurl));

        foreach ($matchdata as $item) {
            $currentmatch = new match();
            if ($item->SportId == 1) {
                $tmpbets = $item->FavouriteBets;
                $currentmatch->setattribute('hometeam', $item->HomeCompetitorName);
                $currentmatch->setattribute('awayteam', $item->AwayCompetitorName);
                $currentmatch->setattribute('league', $listofcompetitions[$competitionid]);


                foreach ($tmpbets as $detail) {
                    if (array_key_exists($detail->BetGameOutcomeId, $subgamesid)) {
                        $currentmatch->setattribute($subgamesid[$detail->BetGameOutcomeId], $detail->Odds);
                    }
                }

            }
            $currentmatch->addmatch();
            $listofmatches[] = $currentmatch;
            unset($currentmatch);
        }

    }

}

