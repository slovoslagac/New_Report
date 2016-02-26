<!doctype html>
<html>
<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 18.2.2016
 * Time: 13:15
 * Updated: 25.2.2016 16:25
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
$SourcesArray = array(2, 4, 5);
//echo $sifraTiketa . "prva \n";


if (isset($_GET["sifra"]) != "") {
    $sifraTiketa = $_GET["sifra"];
    $sifraTiketaParts = explode("-", $sifraTiketa);
    $uplatnoMesto = $sifraTiketa[0];
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
<table id="container">
    <?php include(join(DIRECTORY_SEPARATOR, array('included', 'nas_helpmenu.php'))); ?>
    <div id="function_data">
        <table id="exportTable">
            <tr class="naslov">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                    <td class="placeholder">
                        <input type="text" placeholder="šifra tiketa (1155-7502829-1371)" name="sifra"
                               value="<?php echo $sifraTiketa ?>">

                    </td>
                    <td>
                        <input type="Submit" accesskey="w" value="Osveži"/>
                    </td>
                </form>
            </tr>
        </table>
        <table id="exportTable">
            <colgroup>
                <col width="5%">
                <col width="10%">
                <col width="10%">
                <col width="20%">
                <col width="5%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
            </colgroup>

            <?php
            if ($sifraTiketa != '') {
            include(join(DIRECTORY_SEPARATOR, array('query', 'SourceOdds.php')));

            ?>
            <thead>
            <tr class="naslov">
                <td>Šifra</td>
                <td>Domaćin</td>
                <td>Gost</td>
                <td>Rezultat</td>
                <td>Podigra</td>
                <td>Kvota na tiketu</td>
                <td>Početak kola</td>
                <td>Soccer</td>
                <td>Pinnbet</td>
                <td>Pwin</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $mozzart_sum_odds = 1;
            $mozzart_start_sum_odds = 1;
            $soccer_sum_odds = 1;
            $pwin_sum_odds = 1;
            $pinn_sum_odds = 1;
            foreach ($match_data as $md) {

                $tmp = $md->odds;
                $code = $md->match->id;

                ?>
                <tr class="row">
                    <td value="<?php echo $code ?>"><?php echo $md->match->matchNumber ?></td>
                    <td><?php echo $md->match->home ?></td>
                    <td><?php echo $md->match->visitor ?></td>
                    <td><?php echo $md->match->result ?></td>
                    <?php foreach ($md->odds as $tmpOdds) { ?>
                    <td><?php echo $tmpOdds->subGame->name;
                        $game_id = $tmpOdds->subGame->gameId;
                        $subgame_id = $tmpOdds->subGame->id; ?></td>
                    <td><?php $mozz_odd_value = number_format($tmpOdds->odd, 2, ',', '.');
                        echo $mozz_odd_value;
                        $oddki1 = '';
                        $oddki2 = '';
                        $oddki3 = '';

                        ?>
                    </td>
                    <td>
                        <?php }
                        $oddki1 = '';
                        $oddki2 = '';
                        $oddki3 = '';
                        foreach ($StartingOdds as $so) {
                            ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 1) ? $oddki1 = $so['value'] : '';
                            ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 3) ? $oddki2 = $so['value'] : '';
                            ($so['id'] == $code && $so['game_id'] == 3 && $so['subgame_id'] == 4) ? $oddki3 = $so['value'] : '';
                        }
                        foreach ($StartingOdds as $so) {
                            if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id) {

                                echo $so['value'] . "&nbsp;&nbsp;";
                                if ($so['value'] > 0) {
                                    $mozzart_start_sum_odds *= $so['value'];

                                }
                                ?>
                                <div><?php
                                echo ($oddki1 > $oddki2) ? "(" . $oddki2 . "," . $oddki3 . ")" : "(" . $oddki1 . "," . $oddki3 . ")"; ?>
                                </div><?php
                            }
                        } ?>
                    </td>
                    <td>
                        <?php
                        $oddki1 = '';
                        $oddki2 = '';
                        $oddki3 = '';
                        foreach ($SourceOdds as $so) {
                            ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 1 && $so['source'] == 2) ? $oddki1 = $so['odd'] : '';
                            ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 3 && $so['source'] == 2) ? $oddki2 = $so['odd'] : '';
                            ($so['id'] == $code && $so['game_id'] == 3 && $so['subgame_id'] == 4 && $so['source'] == 2) ? $oddki3 = $so['odd'] : '';
                        }
                        foreach ($SourceOdds as $so) {
                            if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id && $so['source'] == 2) {

                                echo $so['odd'] . "&nbsp;&nbsp;";
                                if ($so['odd'] > 0) {
                                    $soccer_sum_odds *= $so['odd'];

                                }
                                ?>
                                <div><?php
                                echo ($oddki1 > $oddki2) ? "(" . $oddki2 . "," . $oddki3 . ")" : "(" . $oddki1 . "," . $oddki3 . ")"; ?>
                                </div><?php
                            }
                        } ?>
                    </td>

                    <td>
                        <?php
                        $oddki1 = '';
                        $oddki2 = '';
                        $oddki3 = '';
                        foreach ($SourceOdds as $so) {
                            ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 1 && $so['source'] == 4) ? $oddki1 = $so['odd'] : '';
                            ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 3 && $so['source'] == 4) ? $oddki2 = $so['odd'] : '';
                            ($so['id'] == $code && $so['game_id'] == 3 && $so['subgame_id'] == 4 && $so['source'] == 4) ? $oddki3 = $so['odd'] : '';
                        }
                        foreach ($SourceOdds as $so) {
                            if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id && $so['source'] == 4) {
                                echo $so['odd'] . "&nbsp;&nbsp;";
                                ($so['odd'] > 0) ? $pinn_sum_odds *= $so['odd'] : "";
                                ?>
                                <div><?php
                                echo ($oddki1 > $oddki2) ? "(" . $oddki2 . "," . $oddki3 . ")" : "(" . $oddki1 . "," . $oddki3 . ")"; ?>
                                </div><?php
                            }
                        } ?>
                    </td>
                    <td>
                        <?php
                        $oddki1 = '';
                        $oddki2 = '';
                        $oddki3 = '';
                        foreach ($SourceOdds as $so) {
                            ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 1 && $so['source'] == 5) ? $oddki1 = $so['odd'] : '';
                            ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 3 && $so['source'] == 5) ? $oddki2 = $so['odd'] : '';
                            ($so['id'] == $code && $so['game_id'] == 3 && $so['subgame_id'] == 4 && $so['source'] == 5) ? $oddki3 = $so['odd'] : '';
                        }
                        foreach ($SourceOdds as $so) {
                            if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id && $so['source'] == 5) {
                                echo $so['odd'] . "&nbsp;&nbsp;";
                                ($so['odd'] > 0) ? $pwin_sum_odds *= $so['odd'] : "";
                                ?>
                                <div><?php
                                echo ($oddki1 > $oddki2) ? "(" . $oddki2 . "," . $oddki3 . ")" : "(" . $oddki1 . "," . $oddki3 . ")"; ?>
                                </div><?php
                            }
                        }

                        ?>
                    </td>


                </tr>

                <?php
            }


            ?>
            <tr>
                <td colspan="5">Kvota</td>
                <td><?php echo number_format($mozzart_sum_odds, 2, ',', '.') ?></td>
                <td><?php echo number_format($mozzart_start_sum_odds, 2, ',', '.') ?></td>
                <td><?php echo number_format($soccer_sum_odds, 2, ',', '.') ?></td>
                <td><?php echo number_format($pinn_sum_odds, 2, ',', '.') ?></td>
                <td><?php echo number_format($pwin_sum_odds, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="5">Ulog (<?php echo $currency ?>)</td>
                <td><?php echo $realAmountValue ?></td>
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
                <td></td>
            </tr>
            <tr>
                <td colspan="5">Dobitak (<?php echo $currency ?>)</td>
                <td><?php echo number_format($realPaymentValue, 2, ',', '.') ?></td>
                <td><?php echo ($realPaymentValue > 0) ? number_format($realAmountValue * $mozzart_start_sum_odds * (1 + $brutoBonus / 100), 2, ',', '.') : $realPaymentValue ?></td>
                <td><?php echo ($realPaymentValue > 0) ? number_format($realAmountValue * $soccer_sum_odds, 2, ',', '.') : $realPaymentValue ?></td>
                <td><?php echo ($realPaymentValue > 0) ? number_format($realAmountValue * $pinn_sum_odds, 2, ',', '.') : $realPaymentValue ?></td>
                <td><?php echo ($realPaymentValue > 0) ? number_format($realAmountValue * $pwin_sum_odds, 2, ',', '.') : $realPaymentValue ?></td>
            </tr>

            <?php
            }
            ?>


            </tbody>

        </table>

        <p>* kvote u zagradi predstavljaju respektivno vrednost favorita i 3+</p>

    </div>

<!--    --><?php
//    if ($sifraTiketa != "") {
//        ?>


<!--        --><?php
//    }
//
//    ?>


<!--</div>-->
<!--    <table id="exportTable">-->
<!--        <input type="text" value="blablablalbla">-->
<!---->
    </table>


</body>
</html>
