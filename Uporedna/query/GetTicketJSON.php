<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 18.2.2016
 * Time: 13:29
 */

if ($sifraTiketa != "") {

    $url = "https://api.mozzartbet.com/MozzartWS/external.json/ticket-status?ticketId=$sifraTiketa&languageId=1";
    $json = file_get_contents($url);
    $json_data = json_decode($json);

    $ticket_data = array();
    $ticket_data = $json_data[0];
    $tmp_games = array ();
    $tmp_subgames = array ();
    $tmp_matches = array();
//foreach ($ticket_data as $td){
//    foreach ($js as $j){
//        $league_data[] = $j;
//    }
//}

    $match_data = $ticket_data->rows;

    foreach ($match_data as $m) {
        $tmp_matches[] = $m->match->id;
        foreach ($m->odds as $mo) {
            if (in_array($mo->game->id, $tmp_games, true)) {

            } else {
                $tmp_games[] = $mo->game->id;
            }
            if (in_array($mo->subGame->id, $tmp_subgames, true)) {

            } else {
                $tmp_subgames[] = $mo->subGame->id;
            }
        }
    }



//print_r($match_data);

//print_r($json_data[0]);

    $realAmount = $ticket_data->netoAmount;
    $realAmTmp = explode(" ", $realAmount);
    $realAmountValue = $realAmTmp[0];
    $currency = $realAmTmp[1];
    $realPayment = $ticket_data->netoPayment;
    $realPaymentTmp =explode(" ", $realPayment);
    $realPaymentValue = $realPaymentTmp[0];
    $brutoPayment = $ticket_data->brutoPayment;
    $brutoPaymentTmp = explode(" ", $brutoPayment);
    $brutoPaymentValue = $brutoPaymentTmp[0];
    $brutoPaymentWithoutBonus = $ticket_data->brutoPaymentWithoutBonus;
    $brutoPaymentWithoutBonusTmp = explode(" ", $brutoPaymentWithoutBonus);
    $brutoPaymentWithoutBonusValues = $brutoPaymentWithoutBonusTmp[0];
    if ($brutoPaymentWithoutBonusValues > 0) {
        $brutoBonus = intval(($brutoPaymentValue - $brutoPaymentWithoutBonusValues) / $brutoPaymentWithoutBonusValues * 100);
    } else {
        $brutoBonus = 0;
    }
} else {}