<!doctype html>
<html xmlns="http://www.w3.org/1999/html">
<?php
/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 27.2.2016
 * Time: 13:26
 */
$css = 'css/osnova.css';
$naslov = "Uporedni pregled tiketa po šifri";
$naslov_short = "Pregled tiketa";
$sifraTiketa = '';
$curr_comment = '';
$i = 1;
$conn;
$tmp_games = array();
$tmp_subgames = array();
$tmp_matches = array();
$SourceOdds = array();
$SourcesArray = array(5, 2, 4);
$SourceSumArray = array(1, 1, 1);


if (isset($_GET["sifra"]) != "") {
    $sifraTiketa = $_GET["sifra"];
    $sifraTiketaParts = explode("-", $sifraTiketa);
    $uplatnoMesto = $sifraTiketaParts[0];
    $sifraTiketaShort = $sifraTiketaParts[1];
    $roundId = $sifraTiketaParts[2];
}


if (isset($_GET["comment"]) != "") {
    $curr_comment = $_GET["comment"];
    $curr_person = $_GET["comment_added_by"];
    $sifraTiketa = $_GET["curr_ticket_id"];
    $sifraTiketaParts = explode("-", $sifraTiketa);
    $uplatnoMesto = $sifraTiketaParts[0];
    $sifraTiketaShort = $sifraTiketaParts[1];
    $roundId = $sifraTiketaParts[2];
}


if ($curr_comment != "") {

    $sql_comment = "insert into ticket_comment (bookie_shop, round, ticket_id, comment, commented_by, show_comment)
values ( $uplatnoMesto,$roundId, $sifraTiketaShort, '$curr_comment', $curr_person, 1)";

//    echo $sql_comment;
    include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlNewPDO.php')));

    $insertComment = $conn->prepare($sql_comment);
    $insertComment->execute();
    $conn = null;
}


if (isset($_GET['delete'])) {
    $sifraTiketa = $_GET["curr_ticket_id"];
    $multiple = $_GET['delete_comment'];

    $j = 0;

    $sql = "UPDATE ticket_comment SET show_comment = 0  ";

    foreach ($multiple as $item_id) {
        $j++;
        if ($j == 1) {
            $sql .= "where id = " . $item_id . "";
        } else {
            $sql .= " Or id = " . $item_id . "";
        }

    }


    include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlNewPDO.php')));

    $deleteData = $conn->prepare($sql);

    $deleteData->execute();

    $conn = null;

    header("Location: Osnova.php?sifra=$sifraTiketa");

}

include(join(DIRECTORY_SEPARATOR, array('included', 'nas_header.php')));
include(join(DIRECTORY_SEPARATOR, array('query', 'GetTicketJSON.php')));
include(join(DIRECTORY_SEPARATOR, array('query', 'comments_info.php')));


//echo $ticketTime;
//echo microtime();
//echo date('d.m.Y H:i', $ticketTime / 1000);


?>


<body>
<div id="container">
    <?php include(join(DIRECTORY_SEPARATOR, array('included', 'nas_helpmenu.php'))); ?>
    <div class="title size50">
        <table>
            <tr>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                    <td>
                        <input type="text" placeholder="šifra tiketa (1155-7502829-1371)" name="sifra"
                               value="<?php echo $sifraTiketa ?>">
                    </td>
                    <td>
                        <input type="Submit" accesskey="w" value="Osveži"/>
                    </td>
<!--                    <td>-->
<!--                        <input type="button" id="btnExport" value=" Export Table data into Excel " />-->
<!--                    </td>-->
                </form>
            </tr>
        </table>
    </div>
    <div id="dvData">
        <div class="page_data size90">
            <?php
            if ($sifraTiketa != '') {
            include(join(DIRECTORY_SEPARATOR, array('query', 'SourceOdds.php')));


            ?>

            <table>
                <colgroup>
                    <col width="3%">
                    <col width="10%">
                    <col width="10%">
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <col width="6%">
                    <col width="6%">
                    <col width="6%">
                    <col width="6%">

                </colgroup>
                <thead>
                <tr class="title fontsize18">
                    <td>Šifra</td>
                    <td>Domaćin</td>
                    <td>Gost</td>
                    <td>Rezultat</td>
                    <td>Podigra</td>
                    <td>Tiket</td>
                    <td>Početak kola</td>
                    <td>Pwin</td>
                    <td>Soccer</td>
                    <td>Pinnbet</td>
                    <td>Početak kola</td>
                    <td>Pwin</td>
                    <td>Soccer</td>
                    <td>Pinnbet</td>
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
                        <!--Podaci koji se ispisuju direktno sa tiketa-->
                        <td value="<?php echo $code ?>"><?php echo $md->match->matchNumber ?></td>
                        <td><?php echo $md->match->home ?></td>
                        <td><?php echo $md->match->visitor ?></td>
                        <td><?php echo $md->match->result ?></td>
                        <?php foreach ($md->odds as $tmpOdds) { ?>
                        <td><?php echo $tmpOdds->game->shortName . " " . $tmpOdds->subGame->name;
                            $game_id = $tmpOdds->subGame->gameId;
                            $subgame_id = $tmpOdds->subGame->id; ?></td>
                        <td><?php $mozz_odd_value = number_format($tmpOdds->odd, 2, ',', '.');
                            echo $mozz_odd_value;
                            ($tmpOdds->odd > 0) ? $mozzart_sum_odds *= $tmpOdds->odd : "";
                            ?>
                        </td>
                    <!--Kvote Mozzart na početku kola-->
                        <td>
                            <?php }
                            foreach ($StartingOdds as $so) {
                                if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id) {

                                    echo str_replace(".", ",", $so['value']);
                                    ($so['value'] > 0) ? $mozzart_start_sum_odds *= $so['value'] : "";


                                }
                            } ?>
                        </td>

                        <!--Odgovarajuce kvote respektivno po kladionicama-->
                        <?php for ($k = 0; $k < 3; $k++) {
                            $curr_source = $SourcesArray[$k] ?>
                            <td>
                                <?php
                                foreach ($SourceOdds as $so) {
                                    if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id && $so['source'] == $curr_source) {
                                        echo str_replace(".", ",", $so['odd']);
                                        ($so['odd'] > 0) ? $SourceSumArray[$k] *= $so['odd'] : "";
                                    }
                                }
                                ?>
                            </td>

                        <?php } ?>
                        <!--Kvote favorit i 3+ Mozzart na početku kola-->
                        <td>
                            <?php
                            $oddki1 = '';
                            $oddki2 = '';
                            $oddki3 = '';
                            foreach ($StartingOdds as $so) {
                                ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 1) ? $oddki1 = str_replace(".", ",", $so['value']) : '';
                                ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 3) ? $oddki2 = str_replace(".", ",", $so['value']) : '';
                                ($so['id'] == $code && $so['game_id'] == 3 && $so['subgame_id'] == 4) ? $oddki3 = str_replace(".", ",", $so['value']) : '';
                            }
                            ?>
                            <div><?php
                                ($oddki1 > $oddki2) ? $fav = $oddki2 : $fav = $oddki1;
                                echo ($fav != "") ? $fav . "; " . $oddki3 : ""; ?>
                            </div>
                        </td>
                        <!--Kvote favorit i 3+ respektivno po kladionicama-->
                        <?php for ($k = 0; $k < 3; $k++) {
                            $curr_source = $SourcesArray[$k] ?>
                            <td>
                                <?php
                                $oddki1 = '';
                                $oddki2 = '';
                                $oddki3 = '';
                                foreach ($SourceOdds as $so) {
                                    ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 1 && $so['source'] == $curr_source) ? $oddki1 = str_replace(".", ",", $so['odd']) : '';
                                    ($so['id'] == $code && $so['game_id'] == 1 && $so['subgame_id'] == 3 && $so['source'] == $curr_source) ? $oddki2 = str_replace(".", ",", $so['odd']) : '';
                                    ($so['id'] == $code && $so['game_id'] == 3 && $so['subgame_id'] == 4 && $so['source'] == $curr_source) ? $oddki3 = str_replace(".", ",", $so['odd']) : '';
                                }

                                ?>
                                <div><?php
                                    ($oddki1 > $oddki2) ? $fav = $oddki2 : $fav = $oddki1;
                                    echo ($fav != "") ? $fav . "; " . $oddki3 : ""; ?>
                                </div>
                            </td>


                        <?php } ?>
                    </tr>
                <?php } ?>
                <!--Sumarne kolone-->
                <tr>
                    <td colspan="5">Kvota</td>
                    <td><?php echo number_format($mozzart_sum_odds, 2, ',', '.') ?></td>
                    <td><?php echo number_format($mozzart_start_sum_odds, 2, ',', '.') ?></td>
                    <?php
                    for ($k = 0; $k < 3; $k++) { ?>
                        <td>
                            <?php echo number_format($SourceSumArray[$k], 2, ',', '.') ?>
                        </td>

                    <?php } ?>
                </tr>
                <tr>
                    <td colspan="5">Ulog (<?php echo $currency ?>)</td>
                    <?php
                    for ($k = 0; $k < 5; $k++) { ?>
                        <td><?php echo $realAmountValue ?></td>
                    <?php } ?>
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
                    <?php
                    for ($k = 0; $k < 3; $k++) { ?>
                        <td><?php echo ($realPaymentValue > 0) ? number_format($realAmountValue * $SourceSumArray[$k], 2, ',', '.') : $realPaymentValue ?></td>
                    <?php } ?>
                </tr>

                </tbody>
            </table>

        </div>
        <div>
            <p>* kvote u desnim kolonama predstavljaju respektivno vrednost favorita i 3+</p>

        </div>
        <div class="comment size60">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                <input type="hidden" name="curr_ticket_id" value="<?php echo $sifraTiketa ?>">
                <div>
                    <select required name="comment_added_by">
                        <option value="">-</option>
                        <?php foreach ($oddsterList as $OL) { ?>
                            <option
                                value="<?php echo $OL['id'] ?>"><?php echo $OL['Name'] . " " . $OL['LastName'] ?></option>

                        <?php } ?>
                    </select>
                </div>
                <textarea name="comment"></textarea>
                <div>
                    <input type="submit" value="Sačuvaj">

                </div>
            </form>

        </div>
        <?php if (empty($SourceComments)) {
        } else { ?>
            <div class="old_comments size60">
                <h4>Prethodni komentari :</h4>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                    <input type="hidden" name="curr_ticket_id" value="<?php echo $sifraTiketa ?>">
                    <?php foreach ($SourceComments as $sc) { ?>
                        <div class="block">
                            <div class="italic fontsize14">
                                <p><input type="checkbox" value="<?php echo $sc['comment_id'] ?>"
                                          name="delete_comment[]"/></p>
                                <p><?php echo $sc['Name'] . " " . $sc['LastName'] . ", " . $sc['time'] ?></p>
                            </div>
                            <br>
                            <div class="fontsize18"><?php echo $sc['comment'] ?>
                            </div>

                        </div>
                        <br><br><br><br>

                    <?php } ?>
                    <div>
                        <input type="submit" value="Obriši selektovane komentare" name="delete">
                    </div>
                </form>
            </div>
        <?php }
        } ?>
    </div>
</div>

</body>
</html>

<script>
//    $("#btnExport").click(function (e) {
//        window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
//        e.preventDefault();
//    });

</script>
