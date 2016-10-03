<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 29.9.2016
 * Time: 14:14
 */
require(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$allUsersResults = new MatchTeamResults();

$allStats = $allUsersResults->getAllCompetitionResults();


//echo "<br>";
$alldata = array();
$team = '';

$i = 0;
foreach ($allStats as $as) {
    $i++;
    $sum = $as->valueFor + $as->valueOposite;
    if ($as->teamId != $team) {
        $tps = 1;
        $team = $as->teamId;
        $alldata[$as->teamId] = new teamTmpData($as->teamId, $as->teamName);
    }

    $alldata[$as->teamId]->numMatch = $alldata[$as->teamId]->numMatch + 1;

//    Proveravamo golove 0-2 i 3+
    if ($sum >= 3) {
        $alldata[$as->teamId]->threePlus = $alldata[$as->teamId]->threePlus + 1;
        if($tps==1){$alldata[$as->teamId]->threePlusSeria = $alldata[$as->teamId]->threePlusSeria + 1;}
    } else {
        $alldata[$as->teamId]->zeroTwo = $alldata[$as->teamId]->zeroTwo + 1;
        $tps = 2;
    }

//    Trazimo GG i GG3+
    if ($as->valueFor > 0 && $as->valueOposite > 0) {
        $alldata[$as->teamId]->gg = $alldata[$as->teamId]->gg + 1;
        if ($sum >= 3) {
            $alldata[$as->teamId]->ggThreePlus = $alldata[$as->teamId]->ggThreePlus + 1;
        }
    }

}

echo "<br/>";


//    echo "$al->teamName 3+:$al->threePlus ($al->numMatch) 0-2: $al->zeroTwo ($al->numMatch) <br/>";


//var_dump($alldata);

?>

<html>
<head>
    <style>
        table, td, tr {
            border: solid 1px black;
        }


    </style>
</head>
</head>
<body>
<table>
    <tr>
        <td>Team</td>
        <td>Br.Mec</td>
        <td>0-2</td>
        <td>3+</td>
        <td>3+ Seria</td>
        <td>gg</td>
        <td>gg3+</td>
    </tr>
    <?php
    foreach ($alldata as $al) {
        ?>
        <tr>
            <td><?php echo $al->teamName ?></td>
            <td><?php echo $al->numMatch ?></td>
            <td><?php echo $al->zeroTwo ?></td>
            <td><?php echo $al->threePlus ?></td>
            <td><?php echo $al->threePlusSeria ?></td>
            <td><?php echo $al->gg ?></td>
            <td><?php echo $al->ggThreePlus ?></td>
        </tr>

        <?php
    }
    ?>
</table>
<br/>

<table>
    <tr>
        <td>Team</td>
        <td>Br.Mec</td>
        <td>0-2</td>
        <td>3+</td>
        <td>3+ Seria</td>
        <td>gg</td>
        <td>gg3+</td>
    </tr>
    <?php
    usort($alldata, array("teamTmpData", "sortByTPS"));
    foreach ($alldata as $al) {
        ?>
        <tr>
            <td><?php echo $al->teamName ?></td>
            <td><?php echo $al->numMatch ?></td>
            <td><?php echo $al->zeroTwo ?></td>
            <td><?php echo $al->threePlus ?></td>
            <td><?php echo $al->threePlusSeria ?></td>
            <td><?php echo $al->gg ?></td>
            <td><?php echo $al->ggThreePlus ?></td>
        </tr>

        <?php
    }
    ?>
</table>
<br/>

<table>
    <tr>
        <td>Team</td>
        <td>Br.Mec</td>
        <td>0-2</td>
        <td>3+</td>
        <td>3+ Seria</td>
        <td>gg</td>
        <td>gg3+</td>
    </tr>
    <?php
    usort($alldata, array("teamTmpData", "sortByND"));
    foreach ($alldata as $al) {
        ?>
        <tr>
            <td><?php echo $al->teamName ?></td>
            <td><?php echo $al->numMatch ?></td>
            <td><?php echo $al->zeroTwo ?></td>
            <td><?php echo $al->threePlus ?></td>
            <td><?php echo $al->threePlusSeria ?></td>
            <td><?php echo $al->gg ?></td>
            <td><?php echo $al->ggThreePlus ?></td>
        </tr>

        <?php
    }
    ?>
</table>
</body>
</html>
<?php
echo "<br>";
foreach ($allStats as $as) {

    echo "($i) $as->teamName ($as->homeVisitor) : $sum ($as->valueFor:$as->valueOposite)<br/>";

}
?>