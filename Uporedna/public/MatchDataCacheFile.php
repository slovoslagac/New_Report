<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 7.8.2017
 * Time: 12:57
 */

require(join(DIRECTORY_SEPARATOR, array('..', 'includes', 'init.php')));

$team = '';
$i = 0;
$alldata = array();
$allStats = getAllMatchResultsFull();

foreach ($allStats as $as) {
    $i++;
    $sum = $as->valueFor + $as->valueOposite;
    if ($as->teamId != $team) {
        $tps = 1;
        $nds = 1;
        $ggs = 1;
        $ggtps = 1;
        $ktps = 1;
        $dtps = 1;
        $kks = 1;
        $dpps = 1;
        $team = $as->teamId;
        $alldata[$as->teamId] = new teamTmpData($as->teamId, $as->teamName);
    }

    $alldata[$as->teamId]->numMatch = $alldata[$as->teamId]->numMatch + 1;

//    Proveravamo golove 0-2 i 3+
    if ($sum >= 3) {
        $alldata[$as->teamId]->threePlus = $alldata[$as->teamId]->threePlus + 1;
        if ($tps == 1) {
            $alldata[$as->teamId]->threePlusSeria = $alldata[$as->teamId]->threePlusSeria + 1;
        }
        $nds = 2;
    } else {
        $alldata[$as->teamId]->zeroTwo = $alldata[$as->teamId]->zeroTwo + 1;
        $tps = 2;
        ($nds == 1) ? $alldata[$as->teamId]->zeroTwoSeria = $alldata[$as->teamId]->zeroTwoSeria + 1 : '';
    }

//    Trazimo GG i GG3+
    if ($as->valueFor > 0 && $as->valueOposite > 0) {
        $alldata[$as->teamId]->gg = $alldata[$as->teamId]->gg + 1;
        ($ggs == 1) ? $alldata[$as->teamId]->ggSeria = $alldata[$as->teamId]->ggSeria + 1 : '';
        if ($sum >= 3) {
            $alldata[$as->teamId]->ggtp = $alldata[$as->teamId]->ggtp + 1;
            ($ggtps == 1) ? $alldata[$as->teamId]->ggtpSeria = $alldata[$as->teamId]->ggtpSeria + 1 : '';
        } else {
            $ggtps = 2;
        }
    } else {
        $ggs = 2;
        $ggtps = 2;
    }

//    Proveravamo 1&3+ i prelaz 1-1
    if ($as->homeVisitor == 1) {
        if ($as->valueFor > $as->valueOposite && $sum >= 3) {
            $alldata[$as->teamId]->ktp = $alldata[$as->teamId]->ktp + 1;
            ($ktps == 1) ? $alldata[$as->teamId]->ktpSeria = $alldata[$as->teamId]->ktpSeria + 1 : '';
        } else {
            $ktps = 2;
        }

//        if ($as->valueFor > $as->valueOposite && $as->valueHtFor > $as->valueHtOposite) {
//            $alldata[$as->teamId]->kk = $alldata[$as->teamId]->kk + 1;
//            ($kks == 1) ? $alldata[$as->teamId]->kkSeria = $alldata[$as->teamId]->kkSeria + 1 : '';
//        } else {
//            $kks = 2;
//        }

    } else {
        if ($as->valueFor > $as->valueOposite && $sum >= 3) {
            $alldata[$as->teamId]->dtp = $alldata[$as->teamId]->dtp + 1;
            ($ktps == 1) ? $alldata[$as->teamId]->dtpSeria = $alldata[$as->teamId]->dtpSeria + 1 : '';
        } else {
            $dtps = 2;
        }
    }


// Proveravamo  2+I

//    if ($as->valueHtFor + $as->valueHtOposite >= 2) {
//        $alldata[$as->teamId]->dpp = $alldata[$as->teamId]->dpp + 1;
//        ($dpps == 1) ? $alldata[$as->teamId]->dppSeria = $alldata[$as->teamId]->dppSeria + 1 : '';
//    } else {
//        $dpps = 2;
//    }


}

//$cacheData = fopen('testData.json', 'w');
//fwrite($cacheData, json_encode($alldata));
//fclose($cacheData);
//$cacheData = fopen('testData.txt', 'w');
//$jsonData = file_get_contents('testData.json');
//$tmpData = json_decode($jsonData, true);

$serial = serialize($alldata);
file_put_contents('testData.txt', $serial, FILE_APPEND);



$s = file_get_contents('testData.txt');
$tmpData = unserialize($s);


var_dump($tmpData);


//foreach ($tmpData as $item){
//    echo $item->teamName.'<br>';
//}

