<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 29.9.2016
 * Time: 14:14
 */
require(join(DIRECTORY_SEPARATOR, array('..', 'includes', 'init.php')));

//$leagueId = 1;
//$leagueName = 'Engleska 1';
//$tmpSeason = array(23 => '2016', 24 => '2016/2017');


$allCompetition = getAllCompetitions();


if (isset($_POST['countryId'])) {
    $leagueId = $_POST['countryId'];
    foreach ($allCompetition as $ac) {
        if ($ac->competition_id == $leagueId) {
            $leagueName = $ac->name;
        }
    }
}


$allStats = getAllMatchResultsFull();


echo "<br>";

$alldata = array();
$team = '';

$i = 0;
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

echo "<br/>";


//    echo "$al->teamName 3+:$al->threePlus ($al->numMatch) 0-2: $al->zeroTwo ($al->numMatch) <br/>";


//var_dump($alldata);

usort($alldata, array("teamTmpData", "sortByTPS"));

if(isset($_POST["nd"])){
    usort($alldata, array("teamTmpData", "sortByNDS"));
}

if(isset($_POST["tp"])){
    usort($alldata, array("teamTmpData", "sortByTPS"));
}

if(isset($_POST["gg"])){
    usort($alldata, array("teamTmpData", "sortByGGS"));
}
if(isset($_POST["ggtp"])){
    usort($alldata, array("teamTmpData", "sortByGGTPS"));
}
if(isset($_POST["ktp"])){
    usort($alldata, array("teamTmpData", "sortByKTPS"));
}
if(isset($_POST["dtp"])){
    usort($alldata, array("teamTmpData", "sortByDTPS"));
}



?>

<html>
<head>
    <meta charset="UTF-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="../css/seria.css" rel="stylesheet">
</head>
<body>


<h1>Serije </h1>


<table class="table table-striped header-fixed table-bordered" id="myTable">
    <colgroup>
        <col width="5%">
        <col width="10%">
        <col width="5%">
        <?php for($k=0;$k<18;$k++) {?>
            <col width="5%">
        <?php }?>
    </colgroup>

    <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
    <tr class="center" >
        <th class="center" >R.Br.</th>
        <th class="center" >Team</th>
        <th class="center" >Br</th>
        <th><input type="submit" name="tp" value="3+"></th>
        <th class="center" >3+S</th>
        <th class="center" >%</th>
        <th><input type="submit" name="nd" value="0-2"></th>
        <th class="center" >0-2S</th>
        <th class="center" >%</th>
        <th><input type="submit" name="gg" value="gg"></th>
        <th class="center">ggS</th>
        <th class="center">%</th>
        <th><input type="submit" name="ggtp" value="ggtp"></th>
        <th class="center">ggtpS</th>
        <th class="center" >%</th>
        <th><input type="submit" name="ktp" value="1&3+"></th>
        <th class="center" >1&3+S</th>
        <th class="center" >%</th>
        <th><input type="submit" name="dtp" value="2&3+"></th>
        <th class="center" >2&3+S</th>
        <th class="center" >%</th>
    </tr>
    </form>

    <?php
    $i=1;
    foreach ($alldata as $al) { if ($al->numMatch >= 10) {
        ?>
        <tr>
            <td class="center"><?php echo $i?></td>
            <td><?php echo $al->teamName ?></td>
            <td class="center"><?php echo $al->numMatch ?></td>
            <td class="center"><?php echo $al->threePlus ?></td>
            <td class="center"><?php echo $al->threePlusSeria ?></td>
            <td class="center"><?php $percent = round($al->threePlus / $al->numMatch * 100, 2);  echo "$percent" ?></td>
            <td class="center"><?php echo $al->zeroTwo ?></td>
            <td class="center"><?php echo $al->zeroTwoSeria ?></td>
            <td class="center"><?php $percent = round($al->zeroTwo / $al->numMatch * 100, 2); echo "$percent" ?></td>
            <td class="center"><?php echo $al->gg ?></td>
            <td class="center"><?php echo $al->ggSeria ?></td>
            <td class="center"><?php $percent = round($al->gg / $al->numMatch * 100, 2);  echo "$percent" ?></td>
            <td class="center"><?php echo $al->ggtp ?></td>
            <td class="center"><?php echo $al->ggtpSeria ?></td>
            <td class="center"><?php $percent = round($al->ggtp / $al->numMatch * 100, 2);  echo "$percent" ?></td>
            <td class="center"><?php echo $al->ktp ?></td>
            <td class="center"><?php echo $al->ktpSeria ?></td>
            <td class="center"><?php $percent = round($al->ktp / $al->numMatch * 100, 2);   echo "$percent" ?></td>
            <td class="center"><?php echo $al->dtp ?></td>
            <td class="center"><?php echo $al->dtpSeria ?></td>
            <td class="center"><?php $percent = round($al->dtp / $al->numMatch * 100, 2);   echo "$percent" ?></td>
        </tr>

        <?php $i++;
    } }
    ?>
    <!--            </tbody>-->
</table>



</body>
</html>
