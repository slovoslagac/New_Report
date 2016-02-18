<!doctype html>
<html>
<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 18.2.2016
 * Time: 13:15
 */
$css = 'css/tiketi.css';
$naslov = "Uporedni pregled tiketa po šifri";
$naslov_short = "Pregled tiketa";
$sifraTiketa = '';
$i=1;
$tmp_games = array ();
$tmp_subgames = array ();
$tmp_matches = array();

//echo $sifraTiketa . "prva \n";


if (isset($_GET["sifra"]) != "") {
    $sifraTiketa = $_GET["sifra"];
}

//if (isset ( $_GET["trziste"] ) != "") {
//    $region=$_GET["trziste"];
//};

//echo $sifraTiketa . "blaaaa \n";

include(join(DIRECTORY_SEPARATOR, array('included', 'nas_header.php')));
include(join(DIRECTORY_SEPARATOR, array('query', 'GetTicketJSON.php')));


$sql = "select * from src_odds where id in ";

$tm = join(',',$tmp_matches);
$tg = join(',',$tmp_games);
$tsg = join(',',$tmp_subgames);

$sql .="(".$tm. ") ";
$sql .=" and game_id in (".$tg.")";
$sql .=" and subgame_id in (".$tsg.")";

echo $sql;
?>

<body>
<div id="container">
    <?php include(join(DIRECTORY_SEPARATOR, array('included', 'nas_helpmenu.php'))); ?>
    <div id="function_data">
        <table id="exportTable">
            <tr class="naslov">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                    <td class="placeholder">
                        <input type="text" placeholder="unesi sifru tiketa (1155-7502829-1371)" name="sifra">

                    </td>
                    <td>
                        <input type="Submit" accesskey="w" value="Osveži"/>
                    </td>
                </form>
            </tr>
        </table>
        <table id="exportTable">

            <?php
            if ($sifraTiketa != '') { ?>
            <thead>
            <tr class="naslov">
                <td>Šifra</td>
                <td>Domaćin</td>
                <td>Gost</td>
                <td>Rezultat</td>
                <td>Podigra</td>
                <td>Kvota</td>
                <td>Soccer</td>
                <td>Pinnbet</td>
                <td>Pwin</td>
            </tr>
            </thead>
            <tbody>
            <?php


            foreach ($match_data as $md) {

                $tmp = $md->odds;
                ?>
                <tr class="row<?php echo($i++ & 1) ?>">
                    <td><?php echo $md->match->matchNumber ?></td>
                    <td><?php echo $md->match->home ?></td>
                    <td><?php echo $md->match->visitor ?></td>
                    <td><?php echo $md->match->result ?></td>
                    <?php foreach ($md->odds as $tmpOdds) { ?>
                        <td><?php echo $tmpOdds->subGame->name ?></td>
                        <td><?php echo $tmpOdds->odd .(empty($tmpOdds->specialOddValue) ? "" : "  ($tmpOdds->specialOddValue)" )?></td>

                    <?php } ?>


                </tr>

                <?php
            }


            ?>
            <tr>
                <td colspan="5">Ulog (<?php echo $currency?>)</td>
                <td><?php echo $realAmountValue ?></td>
            </tr>
            <tr>
                <td colspan="5">Bonus</td>
                <td><?php echo ($brutoBonus > 0) ? $brutoBonus."%" : "-" ?></td>
            </tr>
            <tr>
                <td colspan="5">Dobitak (<?php echo $currency?>)</td>
                <td><?php echo $realPaymentValue ?></td>
            </tr>

            <?php
            }
            ?>


            </tbody>
        </table>

    </div>

</div>

</body>
</html>
