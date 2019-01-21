<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 17.7.2018.
 * Time: 14:24
 */

include('../classes/match.php');

$url = "https://www.soccerbet.rs/api/Prematch/GetCompetitionFilter?timeFrameOption=4";
$html = json_decode(file_get_contents($url));


//var_dump($html);

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

foreach ($html as $data) {
    $competitionid = $data->CompetitionId;
    if (array_key_exists($competitionid, $listofcompetitions)) {
        $competitionurl = "https://www.soccerbet.rs/api/Prematch/GetCompetitionMatches?competitionId=$competitionid&timeFrameOption=4";
        $matchdata = json_decode(file_get_contents($competitionurl));

        foreach ($matchdata as $item) {
            $currentmatch = new match();
            if ($item->SportId == 1) {
                $tmpbets = $item->FavouriteBets;
                $allbets = $item->
                $currentmatch->setattribute('hometeam', $item->HomeCompetitorName);
                $currentmatch->setattribute('awayteam', $item->AwayCompetitorName);
                $currentmatch->setattribute('league', $listofcompetitions[$competitionid]);


                foreach ($tmpbets as $detail) {
                        $currentmatch->setattribute($detail->BetGameOutcomeId, $detail->Odds);

                }

            }
//            $currentmatch->addmatch();
            $listofmatches[] = $currentmatch;
            unset($currentmatch);
        }

    }

}

var_dump($listofmatches);