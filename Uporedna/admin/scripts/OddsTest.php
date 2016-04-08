<?php

$code = 9450;
$source = 10;
$sql;

function get_match_odds($code, $source)
{

    $curr_url = "https://www.soccerbet.rs/api/Bet/GetAllMatchBets?Id=$code";
    $xmlMatchData = file_get_contents($curr_url);
    $curr_data = json_decode($xmlMatchData);
    $curr_match_odds = array();
    foreach ($curr_data as $cd) {
        foreach ($cd->BetGames as $bgm) {
            foreach ($bgm->BetGameOutcomes as $bgo) {
                $tmp_odds = array();
                $tmp_odds['bet_game'] = $bgo->Bet->BetGameName;
                $tmp_odds['bet_subgame'] = $bgo->Bet->BetGameOutcomeName;
                $tmp_odds['odd_value'] = $bgo->Bet->BetOdds;
                $tmp_odds['code'] = $code;

                $curr_match_odds[] = $tmp_odds;

            }
        }
    }


    $tmpOdds = fopen("Odds.txt", "w");
//    fwrite($tmpOdds,'column1'.";".'column2'.";".'column3'.";".'column4'.";".'column5'.";".'column6'."\n");

    foreach ($curr_match_odds as $d) {

        $betGame = $d['bet_game'];
        $betSubgame = $d['bet_subgame'];
        $OddValue = $d['odd_value'];
        $code = $d['code'];


        fwrite($tmpOdds,$code.";".$OddValue.";;".$betSubgame.";".$betGame.";".$source."\n");


    }

    fclose($tmpOdds);

    $db = mysqli_init();
    $db->real_connect("192.168.180.124","proske","proske1989","Uporedna_new");

    $db->query("LOAD DATA LOCAL INFILE 'Odds.txt' INTO TABLE ulaz_odds FIELDS TERMINATED BY ';' SET timestamp = CURRENT_TIMESTAMP ;");











//    $url = dirname(__DIR__);

//    echo $url;

//    $tmpOdds = fopen("Odds.txt", "w");

//    include('Odds.txt');
//    $connUrl = join(DIRECTORY_SEPARATOR, array('..','conn', 'mysqlAdminPDO.php'));
//    include($connUrl);


//    $sql ="LOAD DATA LOCAL INFILE 'Odds.txt'
//            INTO TABLE ulaz_odds
//            FIELDS TERMINATED BY ';'
//            OPTIONALLY ENCLOSED BY '\"'
//            LINES TERMINATED BY '\\n'";

//    $prepare = $conn->prepare($sql);
//    $prepare->execute();
//
//
//    $conn = null;
//    echo $sql;

//    exec("mysql -u proske -p proske1989 -e \"USE Uporedna_new;TRUNCATE ulaz_odds;LOAD DATA INFILE 'Odds.txt' INTO TABLE ulaz_odds;\"; ");
}



get_match_odds($code, $source);