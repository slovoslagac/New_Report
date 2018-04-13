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


$allStats = getAllMatchResultsFT();


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

?>

<html>
<head>
    <meta charset="UTF-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, p {
            text-align: center;
        }

        .scroll {
            /*width: 25%;*/
            height: 800px !important;
            overflow: scroll;
        }

        .w18 {
            width: 18%;
        }


    </style>
</head>
<body>


<h1>Serije </h1>


<table class="table table-striped header-fixed table-bordered" id="myTable">
    <tr>
        <th class="center" onclick="sortTableText(0)">Team</th>
        <th class="center" onclick="sortTable(1)">Br</th>
        <th class="center" onclick="sortTable(2)">3+</th>
        <th class="center" onclick="sortTableText(3)">3+ Ser</th>
        <th class="center" onclick="sortTable(4)">%</th>
        <th class="center" onclick="sortTable(5)">0-2</th>
        <th class="center" onclick="sortTableText(6)">0-2 Ser</th>
        <th class="center" onclick="sortTable(7)">%</th>
        <th class="center" onclick="sortTable(8)">gg</th>
        <th class="center" onclick="sortTableText(9)">gg Ser</th>
        <th class="center" onclick="sortTable(10)">%</th>
        <th class="center" onclick="sortTable(11)">ggtp</th>
        <th class="center" onclick="sortTableText(12)">ggtp Ser</th>
        <th class="center" onclick="sortTable(13)">%</th>
        <th class="center" onclick="sortTable(14)">1&3+</th>
        <th class="center" onclick="sortTableText(15)">1&3+ Ser</th>
        <th class="center" onclick="sortTable(16)">%</th>
        <th class="center" onclick="sortTable(17)">2&3+</th>
        <th class="center" onclick="sortTableText(18)">2&3+ Ser</th>
        <th class="center" onclick="sortTable(19)">%</th>
    </tr>


    <?php
    $i = 0;
    usort($alldata, array("teamTmpData", "sortByTPS"));

    foreach ($alldata as $al) {

        ?>
        <tr>
            <td><?php echo $al->teamName ?></td>
            <td><?php echo $i?></td>
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

        <?php $i++; if($i > 400){ break;};
    }

    ?>
    <!--            </tbody>-->
</table>

<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("myTable");
        switching = true;
        //Set the sorting direction to ascending:
        dir = "desc";
        /*Make a loop that will continue until
         no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
             first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                 one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /*check if the two rows should switch place,
                 based on the direction, asc or desc:*/
                if (dir == "asc") {
                    if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                 and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                //Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /*If no switching has been done AND the direction is "asc",
                 set the direction to "desc" and run the while loop again.*/
                if (switchcount == 0 && dir == "desc") {
                    dir = "asc";
                    switching = true;
                }
            }
        }
    }

    function sortTableText(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("myTable");
        switching = true;
        //Set the sorting direction to ascending:
        dir = "desc";
        /*Make a loop that will continue until
         no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
             first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                 one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /*check if the two rows should switch place,
                 based on the direction, asc or desc:*/
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }

            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                 and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                //Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /*If no switching has been done AND the direction is "asc",
                 set the direction to "desc" and run the while loop again.*/
                if (switchcount == 0 && dir == "desc") {
                    dir = "asc";
                    switching = true;
                }
            }
        }
    }
</script>

</body>
</html>
