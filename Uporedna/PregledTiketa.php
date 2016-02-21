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
$i = 1;
$tmp_games = array();
$tmp_subgames = array();
$tmp_matches = array();
$SourceOdds = array();

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

$conn;
$SourceOdds;


//print_r($SourceOdds);
?>

<body>
<div id="container">
    <?php include(join(DIRECTORY_SEPARATOR, array('included', 'nas_helpmenu.php'))); ?>
    <div id="function_data">
        <table id="exportTable">
            <tr class="naslov">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                    <td class="placeholder">
                        <input type="text" placeholder="šifra tiketa (1155-7502829-1371)" name="sifra">

                    </td>
                    <td>
                        <input type="Submit" accesskey="w" value="Osveži"/>
                    </td>
                </form>
            </tr>
        </table>
        <table id="exportTable">

            <?php
            if ($sifraTiketa != '') {
            $sql = 'SELECT co.telebet_current_id AS id, so.value AS odd, so.handicap AS handicap, i.source_id AS source, ins.mozzart_game_id AS game_id, ins.mozzart_subgame_id AS subgame_id
FROM src_odds so, conn_match cm, init_current_offer co, import i, conn_subgame cs, init_subgame ins
WHERE so.src_match_id = cm.src_match_id
AND cm.init_match_id = co.event_id
and so.offer = 1
AND so.src_subgame_id = cs.src_subgame_id
AND cs.subgame_id = ins.id
AND so.import_id = i.id
AND co.list_type_id = 4
AND co.telebet_current_id IN ';

            $tm = join(',', $tmp_matches);
            $tg = join(',', $tmp_games);
            $tsg = join(',', $tmp_subgames);

            $sql .= '(' . $tm . ') ';
            $sql .= ' and ins.mozzart_game_id in (' . $tg . ')';
            $sql .= ' and ins.mozzart_subgame_id in (' . $tsg . ')';

//            echo $sql;

            include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlNewPDO.php')));
            $Odds = $conn->prepare($sql);

            $Odds->execute();
            $SourceOdds = $Odds->fetchAll(PDO::FETCH_ASSOC);
            $conn = null;


            ?>
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
            $mozzart_sum_odds = 1;
            $soccer_sum_odds = 1;
            $pwin_sum_odds = 1;
            $pinn_sum_odds = 1;
            foreach ($match_data as $md) {

                $tmp = $md->odds;
                $code = $md->match->id;

                ?>
                <tr class="row<?php echo($i++ & 1) ?>">
                    <td value="<?php echo $code ?>"><?php echo $md->match->matchNumber ?></td>
                    <td><?php echo $md->match->home ?></td>
                    <td><?php echo $md->match->visitor ?></td>
                    <td><?php echo $md->match->result ?></td>
                    <?php foreach ($md->odds as $tmpOdds) { ?>
                    <td><?php echo $tmpOdds->subGame->name;
                        $game_id = $tmpOdds->subGame->gameId;
                        $subgame_id = $tmpOdds->subGame->id; ?></td>
                    <td><?php echo $tmpOdds->odd . (empty($tmpOdds->specialOddValue) ? "" : "  ($tmpOdds->specialOddValue)") ;if($tmpOdds->odd > 0) { $mozzart_sum_odds *= $tmpOdds->odd;}?></td>
                    <td>
                        <?php }
                        foreach ($SourceOdds as $so) {
                            if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id && $so['source'] == 2) {
                                echo $so['odd']; if($so['odd'] > 0) { $soccer_sum_odds *= $so['odd'];}
                            }
                        } ?>
                    </td>
                    <td>
                        <?php
                        foreach ($SourceOdds as $so) {
                            if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id && $so['source'] == 4) {
                                echo $so['odd']; ($so['odd'] > 0)? $pinn_sum_odds *= $so['odd'] : "";
                            }
                        } ?>
                    </td>
                    <td>
                        <?php
                        foreach ($SourceOdds as $so) {
                            if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id && $so['source'] == 5) {
                                echo $so['odd']; ($so['odd'] > 0)? $pwin_sum_odds *= $so['odd'] : "";
                            }
                        } ?>
                    </td>
                </tr>

                <?php
            }


            ?>
            <tr>
                <td colspan="5">Kvota</td>
                <td><?php echo number_format($mozzart_sum_odds,2,',','.') ?></td>
                <td><?php echo number_format($soccer_sum_odds,2,',','.') ?></td>
                <td><?php echo number_format($pinn_sum_odds,2,',','.') ?></td>
                <td><?php echo number_format($pwin_sum_odds,2,',','.') ?></td>
            </tr>
            <tr>
                <td colspan="5">Ulog (<?php echo $currency ?>)</td>
                <td><?php echo $realAmountValue ?></td>
                <td><?php echo $realAmountValue ?></td>
                <td><?php echo $realAmountValue ?></td>
                <td><?php echo $realAmountValue ?></td>
            </tr>
            <tr>
                <td colspan="5">Bonus</td>
                <td><?php echo ($brutoBonus > 0) ? $brutoBonus . "%" : "-" ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5">Dobitak (<?php echo $currency ?>)</td>
                <td><?php echo $realPaymentValue ?></td>
                <td><?php echo ($realPaymentValue > 0) ? number_format($realAmountValue*$soccer_sum_odds,2,',','.') : $realPaymentValue ?></td>
                <td><?php echo ($realPaymentValue > 0) ? number_format($realAmountValue*$pinn_sum_odds,2,',','.') : $realPaymentValue ?></td>
                <td><?php echo ($realPaymentValue > 0) ? number_format($realAmountValue*$pwin_sum_odds,2,',','.') : $realPaymentValue ?></td>
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
