<?php

function getTableContent($cmpid, $seasonid)
{
    $data = "";
    $tableDetails = "";
    $tableArray = array();
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_PORT => "8080",
        CURLOPT_URL => "http://192.168.180.52:8080/statistic-service/tableplacement/find-table-placement",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"competitionId\":$cmpid, \"shouldGenerateTablePlacement\": false, \"seasonId\":$seasonid,\"competitionPhaseId\":1, \"sportId\": 1}",
        CURLOPT_HTTPHEADER => array(
            "Accept-Language: sr",
            "Content-Type: application/json",
            "Postman-Token: d4344da6-2abd-4954-b3bd-18de24fda580",
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response);
    }

    return $data;
}

function getNormalTable($cmpid, $seasonid)
{
    $data = getTableContent($cmpid, $seasonid);

    foreach ($data as $item) {
        if ($item->periodType == "NORMAL_TIME") {
            $tableDetails = $item->participantStats;
        }
    }

    foreach ($tableDetails as $tableItem) {
        $tableArray[$tableItem->overall->position] = $tableItem;
    }

    ksort($tableArray);
    return $tableArray;
}