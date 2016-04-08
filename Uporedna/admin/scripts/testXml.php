<?php
/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 21.3.2016
 * Time: 23:04
 */

$url = 'https://www.soccerbet.rs/api/Filter/GetFilterConfiguration?TimeFilterId=7';
$url1 = 'https://www.soccerbet.rs/api/Match/GetFilteredScheduledMatches?ItemsPerPage=50&CurrentPage=1&SortOrderFilterId=1&TimeFilterId=7&CompetitionIds=77';
$url2 = 'https://www.soccerbet.rs/api/Bet/GetAllMatchBets?Id=1819';
$source = 10;

$xmldata = file_get_contents($url);
$data = json_decode($xmldata);

$connUrl = join(DIRECTORY_SEPARATOR, array('..','conn', 'mysqlAdminPDO.php'));
include($connUrl);

$trncSql ='truncate ulaz_new; truncate ulaz_odds;';

$delete = $conn -> prepare($trncSql);
$delete -> execute();

$conn = null;


$competitions = array();

foreach ($data->SportVMs as $sports) {
    if ($sports->Id == 1) {
        foreach ($sports->CountryVMs as $cmpc) {
            foreach ($cmpc->CompetitionVMs as $cmp) {
                $tmp = array();
                $tmp ['cmp_id'] = $cmp->Id;
                $tmp['cmp_name'] = $cmp->Name;

                array_push($competitions,$tmp);
            }
        }
    }
}

//print_r($competitions);


include 'xmltest.php';
include 'OddsTest.php';

foreach($competitions as $c) {
    $curr_cmp_id = $c['cmp_id'];
    $curr_cmp_name =  $c['cmp_name'];
    $curr_url = "https://www.soccerbet.rs/api/Match/GetFilteredScheduledMatches?ItemsPerPage=50&CurrentPage=1&SortOrderFilterId=1&TimeFilterId=7&CompetitionIds=$curr_cmp_id";
    get_matches($curr_url,$curr_cmp_id,$curr_cmp_name, $conn,$source);
//    $xmlMatchData = file_get_contents($curr_url);
//    $curr_data = json_decode($xmlMatchData);
//
//    echo $curr_url."<br>";
//    $match_data[] = $curr_match_data;
//
}


//    foreach($match_data as $m) {
//        print_r($m);
//        echo"<br />";
//    }


