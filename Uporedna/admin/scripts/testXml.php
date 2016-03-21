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

$xmldata = file_get_contents($url);
$data = json_decode($xmldata);

//echo $xmldata;

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

print_r($competitions);


//foreach($competitions as $c) {
//    echo $c->cmp_id." ". $c->cmp_name."<br>";
//}