<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 29.9.2016
 * Time: 14:14
 */
require(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$leagueId = 1;
$leagueName = 'Engleska 1';
$tmpSeason = array(23=>'2016',24=>'2016/2017');


$allCompetition = getAllCompetitions();


if (isset($_POST['countryId'])) {
    $leagueId = $_POST['countryId'];
    foreach ($allCompetition as $ac) {
        if ($ac->competition_id == $leagueId) {
            $leagueName = $ac->name;
        }
    }
}


$allStats = getAllCompetitionResults($leagueId);
$allStatsByRound = getAllCompetitionResultsByRound($leagueId);


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

        if ($as->valueFor > $as->valueOposite && $as->valueHtFor > $as->valueHtOposite) {
            $alldata[$as->teamId]->kk = $alldata[$as->teamId]->kk + 1;
            ($kks == 1) ? $alldata[$as->teamId]->kkSeria = $alldata[$as->teamId]->kkSeria + 1 : '';
        } else {
            $kks = 2;
        }

    } else {
        if ($as->valueFor > $as->valueOposite && $sum >= 3) {
            $alldata[$as->teamId]->dtp = $alldata[$as->teamId]->dtp + 1;
            ($ktps == 1) ? $alldata[$as->teamId]->dtpSeria = $alldata[$as->teamId]->dtpSeria + 1 : '';
        } else {
            $dtps = 2;
        }
    }

// Proveravamo  2+I

    if ($as->valueHtFor + $as->valueHtOposite >= 2) {
        $alldata[$as->teamId]->dpp = $alldata[$as->teamId]->dpp + 1;
        ($dpps == 1) ? $alldata[$as->teamId]->dppSeria = $alldata[$as->teamId]->dppSeria + 1 : '';
    } else {
        $dpps = 2;
    }


}

echo "<br/>";


//    echo "$al->teamName 3+:$al->threePlus ($al->numMatch) 0-2: $al->zeroTwo ($al->numMatch) <br/>";


//var_dump($alldata);

?>

<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        table, td, tr, tbody {
            border: solid 1px black;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        td {
            word-wrap: break-word;
        }

        div {

            float: left;
            margin: 1% 1% 1% 1%;
        }

        h1, h2, h3, p {
            text-align: center;
        }

        .w23 {
            width: 23%;
        }

        .w18 {
            width: 18%;
        }


    </style>
</head>
<body>


<h1>Serije <?php $thisSeason =$allStats[0]->seasonId; $curSeason = $tmpSeason[$thisSeason]; echo "$leagueName  za sezonu $curSeason" ?></h1>
<form action="teamCompetitionStats.php" method="post">
    <p>Odaberi ligu :
        <select name="countryId">
            <?php foreach ($allCompetition as $ac) { ?>
                <option
                    value="<?php echo $ac->competition_id ?>" <?php echo ($leagueId == $ac->competition_id) ? 'selected' : ''; ?>><?php echo $ac->name ?></option>
            <?php } ?>
        </select>

        <input type="submit" value="Osveži">
    </p>

</form>
<div class="w23">

    <table>
        <colgroup>
            <col width="40%">
            <col width="10%">
            <col width="15%">
            <col width="20%">
            <col width="15%">
        </colgroup>
        <thead>
        <tr>
            <td>Team</td>
            <td>Br</td>
            <td>3+</td>
            <td>3+ Ser</td>
            <td>%</td>
        </tr>
        </thead>
        <tbody>
        <?php
        usort($alldata, array("teamTmpData", "sortByTPS"));
        foreach ($alldata as $al) {
            ?>
            <tr>
                <td><?php echo $al->teamName ?></td>
                <td><?php echo $al->numMatch ?></td>
                <td><?php echo $al->threePlus ?></td>
                <td><?php echo $al->threePlusSeria ?></td>
                <td><?php $percent = round($al->threePlus / $al->numMatch * 100, 2);
                    echo "$percent" ?></td>
            </tr>

            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<div class="w23">
    <table>
        <colgroup>
            <col width="40%">
            <col width="10%">
            <col width="15%">
            <col width="20%">
            <col width="15%">
        </colgroup>
        <tr>
            <td>Team</td>
            <td>Br</td>
            <td>0-2</td>
            <td>0-2 Ser</td>
            <td>%</td>
        </tr>
        <?php
        usort($alldata, array("teamTmpData", "sortByNDS"));
        foreach ($alldata as $al) {
            ?>
            <tr>
                <td><?php echo $al->teamName ?></td>
                <td><?php echo $al->numMatch ?></td>
                <td><?php echo $al->zeroTwo ?></td>
                <td><?php echo $al->zeroTwoSeria ?></td>
                <td><?php $percent = round($al->zeroTwo / $al->numMatch * 100, 2);
                    echo "$percent" ?></td>
            </tr>

            <?php
        }
        ?>
    </table>
</div>

<div class="w23">
    <table>
        <colgroup>
            <col width="40%">
            <col width="10%">
            <col width="15%">
            <col width="20%">
            <col width="15%">
        </colgroup>
        <tr>
            <td>Team</td>
            <td>Br</td>
            <td>GG</td>
            <td>GG Ser</td>
            <td>%</td>
        </tr>
        <?php
        usort($alldata, array("teamTmpData", "sortByGGS"));
        foreach ($alldata as $al) {
            ?>
            <tr>
                <td><?php echo $al->teamName ?></td>
                <td><?php echo $al->numMatch ?></td>
                <td><?php echo $al->gg ?></td>
                <td><?php echo $al->ggSeria ?></td>
                <td><?php $percent = round($al->gg / $al->numMatch * 100, 2);
                    echo "$percent" ?></td>
            </tr>

            <?php
        }
        ?>
    </table>
</div>
<div class="w23">
    <table>
        <colgroup>
            <col width="40%">
            <col width="10%">
            <col width="15%">
            <col width="20%">
            <col width="15%">
        </colgroup>
        <tr>
            <td>Team</td>
            <td>Br</td>
            <td>GG3+</td>
            <td>GG3+ Ser</td>
            <td>%</td>
        </tr>
        <?php
        usort($alldata, array("teamTmpData", "sortByGGTPS"));
        foreach ($alldata as $al) {
            ?>
            <tr>
                <td><?php echo $al->teamName ?></td>
                <td><?php echo $al->numMatch ?></td>
                <td><?php echo $al->ggtp ?></td>
                <td><?php echo $al->ggtpSeria ?></td>
                <td><?php $percent = round($al->ggtp / $al->numMatch * 100, 2);
                    echo "$percent" ?></td>
            </tr>

            <?php
        }
        ?>
    </table>
</div>

<div class="w23">
    <table>
        <colgroup>
            <col width="40%">
            <col width="10%">
            <col width="15%">
            <col width="20%">
            <col width="15%">
        </colgroup>
        <tr>
            <td>Team</td>
            <td>Br</td>
            <td>1&3+</td>
            <td>1&3+ Ser</td>
            <td>%</td>
        </tr>
        <?php
        usort($alldata, array("teamTmpData", "sortByKTPS"));
        foreach ($alldata as $al) {
            ?>
            <tr>
                <td><?php echo $al->teamName ?></td>
                <td><?php echo $al->numMatch ?></td>
                <td><?php echo $al->ktp ?></td>
                <td><?php echo $al->ktpSeria ?></td>
                <td><?php $percent = round($al->ktp / $al->numMatch * 100, 2);
                    echo "$percent" ?></td>
            </tr>

            <?php
        }
        ?>
    </table>
</div>
<div class="w23">
    <table>
        <colgroup>
            <col width="40%">
            <col width="10%">
            <col width="15%">
            <col width="20%">
            <col width="15%">
        </colgroup>
        <tr>
            <td>Team</td>
            <td>Br</td>
            <td>2&3+</td>
            <td>2&3+ Ser</td>
            <td>%</td>
        </tr>
        <?php
        usort($alldata, array("teamTmpData", "sortByDTPS"));
        foreach ($alldata as $al) {
            ?>
            <tr>
                <td><?php echo $al->teamName ?></td>
                <td><?php echo $al->numMatch ?></td>
                <td><?php echo $al->dtp ?></td>
                <td><?php echo $al->dtpSeria ?></td>
                <td><?php $percent = round($al->dtp / $al->numMatch * 100, 2);
                    echo "$percent" ?></td>
            </tr>

            <?php
        }
        ?>
    </table>
</div>
<div class="w23">
    <table>
        <colgroup>
            <col width="40%">
            <col width="10%">
            <col width="15%">
            <col width="20%">
            <col width="15%">
        </colgroup>
        <tr>
            <td>Team</td>
            <td>Br</td>
            <td>1-1</td>
            <td>1-1 Ser</td>
            <td>%</td>
        </tr>
        <?php
        usort($alldata, array("teamTmpData", "sortByKKS"));
        foreach ($alldata as $al) {
            ?>
            <tr>
                <td><?php echo $al->teamName ?></td>
                <td><?php echo $al->numMatch ?></td>
                <td><?php echo $al->kk ?></td>
                <td><?php echo $al->kkSeria ?></td>
                <td><?php $percent = round($al->kk / $al->numMatch * 100, 2);
                    echo "$percent" ?></td>
            </tr>

            <?php
        }
        ?>
    </table>
</div>
<div class="w23">
    <table>
        <colgroup>
            <col width="40%">
            <col width="10%">
            <col width="15%">
            <col width="20%">
            <col width="15%">
        </colgroup>
        <tr>
            <td>Team</td>
            <td>Br</td>
            <td>2+I</td>
            <td>2+I Ser</td>
            <td>%</td>
        </tr>
        <?php
        usort($alldata, array("teamTmpData", "sortByDPPS"));
        foreach ($alldata as $al) {
            ?>
            <tr>
                <td><?php echo $al->teamName ?></td>
                <td><?php echo $al->numMatch ?></td>
                <td><?php echo $al->dpp ?></td>
                <td><?php echo $al->dppSeria ?></td>
                <td><?php $percent = round($al->dpp / $al->numMatch * 100, 2);
                    echo "$percent" ?></td>
            </tr>

            <?php
        }
        ?>
    </table>
</div>
<h1>Rezultati po kolima</h1>
<?php $currentRound = 0;
foreach ($allStatsByRound as $asr) {
if ($currentRound == $asr->matchRound)  { ?>
    <tr>
        <td><?php echo $asr->homeTeam ?></td>
        <td><?php echo $asr->awayTeam ?></td>
        <td><?php echo "$asr->homeTeamScore : $asr->awayTeamScore" ?></td>
        <td><?php echo "($asr->homeTeamHalfTimeScore : $asr->awayTeamHalfTimeScore)" ?></td>
    </tr>

<?php } elseif ($currentRound == 0) { ?>
<div class="w18">
    <h3><?php $currentRound = $asr->matchRound;
        echo "$currentRound. kolo" ?></h3>
    <table>
        <colgroup>
            <col width="30%">
            <col width="30%">
            <col width="20%">
            <col width="20%">
        </colgroup>
        <tr>
            <td>Domacin</td>
            <td>Gost</td>
            <td>FT</td>
            <td>HT</td>
        </tr>
        <tr>
            <td><?php echo $asr->homeTeam ?></td>
            <td><?php echo $asr->awayTeam ?></td>
            <td><?php echo "$asr->homeTeamScore : $asr->awayTeamScore" ?></td>
            <td><?php echo "($asr->homeTeamHalfTimeScore : $asr->awayTeamHalfTimeScore)" ?></td>
        </tr>
        <?php
        } else { ?>
    </table>
</div>

<div class="w18">
    <h3><?php $currentRound = $asr->matchRound;
        echo "$currentRound. kolo" ?></h3>
    <table>
        <colgroup>
            <col width="30%">
            <col width="30%">
            <col width="20%">
            <col width="20%">
        </colgroup>
        <tr>
            <td>Domacin</td>
            <td>Gost</td>
            <td>FT</td>
            <td>HT</td>
        </tr>
        <tr>
            <td><?php echo $asr->homeTeam ?></td>
            <td><?php echo $asr->awayTeam ?></td>
            <td><?php echo "$asr->homeTeamScore : $asr->awayTeamScore" ?></td>
            <td><?php echo "($asr->homeTeamHalfTimeScore : $asr->awayTeamHalfTimeScore)" ?></td>
        </tr>

        <?php
        }


        } ?>
    </table>
</div>

</body>
</html>
