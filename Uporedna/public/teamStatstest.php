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


$s = file_get_contents('testData.txt');

$alldata = unserialize($s);


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

if(isset($_POST["tps"])){
    sortArrayByKey($allStats, "threePlusSeria");
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
        <th class="center" ><input type="submit" name="tps" value="3+S"></th>
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
    foreach ($alldata as $al) {
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
    }
    ?>
    <!--            </tbody>-->
</table>



</body>
</html>
