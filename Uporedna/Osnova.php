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
$ticketTime = '';
$curr_currency = "RSD";
$currency ='' ;
$i = 1;
$conn;
$tmp_games = array();
$tmp_subgames = array();
$tmp_matches = array();

$SourceOdds = array();
//Raspored kladionica je
$SourcesArray = array(5, 2, 4);
$SourceSumArray = array(5=>1, 2=>1, 4=>1);
$SourceBonusArray = array(5=>0, 2=>0, 4=>0);
$days = array('Mon' => 'pon', 'Tue' => 'uto', 'Wed' => 'sre', 'Thu' => 'čet', 'Fri' => 'pet', 'Sat' => 'sub', 'Sun' => 'ned');
$ticket_hour = "";


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
    $url = $_SERVER['PHP_SELF'];
    header("Location: $url?sifra=$sifraTiketa");


}


include(join(DIRECTORY_SEPARATOR, array('included', 'nas_header.php')));
include(join(DIRECTORY_SEPARATOR, array('query', 'GetTicketJSON.php')));
include(join(DIRECTORY_SEPARATOR, array('query', 'comments_info.php')));

include(join(DIRECTORY_SEPARATOR, array('functions', 'bonuses.php')));


//echo $ticketTime;
//echo microtime();
//echo date('d.m.Y H:i', $ticketTime / 1000);


//echo ObracunBonusa(2, 8, 9);

$ticket_hour = date('G', $ticketTime / 1000);
$ticket_day = date('j.m.Y', $ticketTime / 1000);
$currency_day = date('N', $ticketTime / 1000);
//echo $ticket_hour;
//echo $ticket_day;



if($currency_day == 6) {
    $currency_date = date('j.m.Y', $ticketTime / 1000 - (24 * 60 * 60));
} elseif ($currency_day == 7) {
    $currency_date = date('j.m.Y', $ticketTime / 1000 - (48 * 60 * 60));
} else {
    $currency_date = date('j.m.Y', $ticketTime / 1000 );
}

switch($currency){
    case("BAM"):
        $currency_id = 7;
        break;
    case("MKD"):
        $currency_id = 6;
        break;
    case("RON"):
        $currency_id = 8;
        break;
    default:
        $currency_id = 1;
        $currency_value = 1;
        $curr_currency = $currency;
}


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
        <div class="page_data size95">
            <?php
            if ($sifraTiketa != '') {
            include(join(DIRECTORY_SEPARATOR, array('query', 'SourceOdds.php')));
            $currAmount = $realAmountValue * $currencyValue;
//            echo $currencyValue."<br>";
//            echo $realAmountValue."<br>";

            ?>

            <table>
                <colgroup>
                    <col width="3%">
                    <col width="5%">
                    <col width="8%">
                    <col width="8%">
                    <col width="6%">
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
                <tr class="title fontsize14 row bold">
                    <td colspan="6"><?php echo $sifraTiketa." - ". $businessUnits[$uplatnoMesto]?></td>
                    <td rowspan="2" class="mozzb">Kvota na tiketu</td>
                    <td colspan="4" class="grayb">Kvota kladionice na početku kola</td>
                    <td colspan="4" class="darkgrayb">Početak kola (ki, 3+)</td>

                </tr>
                <tr class="title fontsize14 row bold">
                    <td>Šifra</td>
                    <td>Vreme</td>
                    <td>Domaćin</td>
                    <td>Gost</td>
                    <td>Rezultat</td>
                    <td>Podigra</td>
                    <td class="mozzb">Mozzart</td>
                    <td class="yellowb">Pwin</td>
                    <td class="greenb">Soccer</td>
                    <td class="grayb">Pinnbet</td>
                    <td class="mozzb">Mozzart</td>
                    <td class="yellowb">Pwin</td>
                    <td class="greenb">Soccer</td>
                    <td class="grayb">Pinnbet</td>
                </tr>
                </thead>
                <tbody>
                <?php
                $mozzart_sum_odds = 1;
                $mozzart_start_sum_odds = 1;
                $soccer_sum_odds = 1;
                $pwin_sum_odds = 1;
                $pinn_sum_odds = 1;
                $num_of_rows = 0;
                $num_of_winner_rows = 0;

                foreach ($match_data as $md) {
                    $num_of_rows++;
                    $tmp = $md->odds;
                    $code = $md->match->id;
                    $tmp_odds = array();

                    ?>

                    <tr class="row">
                        <!--Podaci koji se ispisuju direktno sa tiketa-->
                        <?php $match_code = $md->match->matchNumber; ?>

                        <td value="<?php echo $code ?>" class="<?php echo ($oddtype[$code]==64)? "red":""?>"><?php echo $match_code ?></td>
                        <?php $match_time = date('H:i', $md->match->startTime / 1000);
                        $match_date = date('D', $md->match->startTime / 1000); ?>

                        <td><?php echo ($days[$match_date] != "") ? "$days[$match_date] $match_time" : "$match_date $match_time";; ?></td>
                        <td><?php echo $md->match->home ?></td>
                        <td><?php echo $md->match->visitor ?></td>
                        <td><?php echo $md->match->result ?></td>
                        <?php foreach ($md->odds as $tmpOdds) { ?>
                            <td><?php echo $tmpOdds->game->shortName . " " . $tmpOdds->subGame->name;
                                $game_id = $tmpOdds->subGame->gameId;
                                ($tmpOdds->status == "WINNER") ? $num_of_winner_rows++ : "";
                                $subgame_id = $tmpOdds->subGame->id; ?></td>
                            <?php $mozz_odd_value = number_format($tmpOdds->odd, 2, ',', '.');

                            $tmp_odds[1] = $mozz_odd_value;

                            ($tmpOdds->odd > 0) ? $mozzart_sum_odds *= $tmpOdds->odd : "";

                        }
                        // Kvote Mozzart na početku kola
                        foreach ($StartingOdds as $so) {
                            if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id) {
                                $tmp_odds[0] = str_replace(".", ",", $so['value']);
//                                    echo str_replace(".", ",", $so['value']);
                                ($so['value'] > 0) ? $mozzart_start_sum_odds *= $so['value'] : "";


                            }

                        } ?>

                        <!--Odgovarajuce kvote respektivno po kladionicama-->
                        <?php for ($k = 0; $k < 3; $k++) {
                            $curr_source = $SourcesArray[$k] ;

                            foreach ($SourceOdds as $so) {
                                if ($so['id'] == $code && $so['game_id'] == $game_id && $so['subgame_id'] == $subgame_id && $so['source'] == $curr_source) {
                                    $tmp_odds[$curr_source] = str_replace(".", ",", $so['odd']);
                                    ($so['odd'] > 0) ? $SourceSumArray[$curr_source] *= $so['odd'] : "";

                                }
                            }
                            if(array_key_exists($curr_source,$tmp_odds)) {} else {$SourceSumArray[$curr_source] *= str_replace(",", ".", $tmp_odds[1]); };

                             }

//                        foreach ($SourcesArray as $so) { echo $so.":".$tmp_odds[1]."-".$SourceSumArray[$so]."; ------";
//                            if(array_key_exists($so,$tmp_odds)) {} else {$SourceSumArray[$so] *= $tmp_odds[1]; echo $so.":".$tmp_odds[1]."-".$SourceSumArray[$so]."____________";}
//                        }
//                        print_r($SourceSumArray)."<br>";
//                          echo "<br>";
                        $min_odd = min($tmp_odds);
                        $max_odd = max($tmp_odds);
                        if ($min_odd == $max_odd) {
                            $max_odd = 1;
                            $min_odd = 1;
                        }

                        ?>

                        <td class="bold <?php $odd = $tmp_odds[1]; if ($odd == $max_odd) { echo "red";} elseif ($odd == $min_odd) {echo "green";} ?>">
                            <?php echo $odd; ?>
                        </td>
                        <td class="bold <?php $odd = $tmp_odds[0]; if ($odd == $max_odd) { echo "red"; } elseif ($odd == $min_odd) {  echo "green"; } ?>">
                            <?php echo $odd; ?>
                        </td>
                        <?php for ($k = 0; $k < 3; $k++) { $curr_source = $SourcesArray[$k];
                            if(array_key_exists($curr_source,$tmp_odds))
                            { ?>
                                 <td class="bold <?php $odd = $tmp_odds[$curr_source];  if ($odd == $max_odd) {  echo "red"; } elseif ($odd == $min_odd) { echo "green"; } ?>">
                                    <?php echo $odd; ?>
                                 </td>
                            <?php
                            }  else {
                                ?>
                                <td class="bold blue">
                                    <?php  echo $tmp_odds[1];?>
                                </td>

                            <?php }  }  ?>

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
                <tr class="midgrayb bold">
                    <td colspan="6">Ulog (<?php echo $curr_currency ?>)</td>
                    <?php
                    for ($k = 0; $k < 5; $k++) { ?>
                        <td><?php echo number_format($currAmount, 2, ',', '.') ?></td>
                    <?php } ?>
                    <td colspan="4"></td>
                </tr>

                <tr class="row">
                    <td colspan="6">Kvota</td>
                    <td><?php echo number_format($mozzart_sum_odds, 2, ',', '.') ?></td>
                    <td><?php echo number_format($mozzart_start_sum_odds, 2, ',', '.') ?></td>
                    <?php
                    foreach ($SourcesArray as $k) { ?>
                        <td>
                            <?php echo number_format($SourceSumArray[$k], 2, ',', '.') ?>
                        </td>

                    <?php } ?>
                    <td colspan="4"></td>
                </tr>
                <tr class="row">
                    <td colspan="6">Dobitak (<?php echo $curr_currency ?>)</td>

                    <td><?php echo number_format($brutoPaymentWithoutBonusValues * $currencyValue, 2, ',', '.') ?></td>
                    <?php if ($num_of_winner_rows == $num_of_rows) { ?>
                        <td><?php echo ($realPaymentValue > 0) ? number_format($currAmount * $mozzart_start_sum_odds, 2, ',', '.') : $realPaymentValue ?></td>
                        <?php
                        foreach ($SourcesArray as $k) { ?>
                            <td><?php echo ($realPaymentValue > 0) ? number_format(($currAmount * $SourceSumArray[$k]) , 2, ',', '.') : $realPaymentValue ?></td>
                        <?php }
                    } else { ?>
                        <td><?php echo number_format($realPaymentValue, 2, ',', '.') ?></td>
                        <?php for ($k = 0; $k < 3; $k++) { ?>
                            <td>0</td>
                            <?php
                        }
                    }
                    ?>
                    <td colspan="4"></td>
                </tr>

                <tr class="bonusb">
                    <td colspan="6">Bonus</td>
                    <td><?php echo ($brutoBonus > 0) ? $brutoBonus . "%" : "0%" ?></td>
                    <td><?php echo ($brutoBonus > 0) ? $brutoBonus . "%" : "0%" ?></td>
                    <?php
                    foreach ($SourcesArray as $k) {
                        $SourceBonusArray[$k] = ObracunBonusa($k, $num_of_rows, $ticket_hour, $ticket_day); ?>
                        <td><?php echo $SourceBonusArray[$k] . "%"; ?></td>
                        <?php
                    }

                    ?>
                    <td colspan="4"></td>
                </tr>
                <tr class="bonusb">
                    <td colspan="6">Iznos bonusa</td>

                    <td><?php echo number_format($bonusRealValue, 2, ',', '.') ?></td>
                    <?php if ($num_of_winner_rows == $num_of_rows) { ?>
                        <td><?php echo ($realPaymentValue > 0) ? number_format($currAmount * $mozzart_start_sum_odds * $brutoBonus / 100, 2, ',', '.') : $realPaymentValue ?></td>
                        <?php
                        foreach ($SourcesArray as $k) { ?>
                            <td><?php echo ($realPaymentValue > 0) ? number_format(($currAmount * $SourceSumArray[$k] * $SourceBonusArray[$k] / 100), 2, ',', '.') : $realPaymentValue ?></td>
                        <?php }
                    } else { ?>
                        <td><?php echo number_format($realPaymentValue, 2, ',', '.') ?></td>
                        <?php for ($k = 0; $k < 3; $k++) { ?>
                            <td>0</td>
                            <?php
                        }
                    }
                    ?>
                    <td colspan="4"></td>
                </tr>


                <?php
                $tmp_sums = array();
                $max_sum;
                $min_sum;

                $tmp_sums [1] = number_format($realPaymentValue * $currencyValue, 2, ',', '.') ;
                if ($num_of_winner_rows == $num_of_rows)
                    {
                        ($realPaymentValue > 0) ? $tmp_sums [0] = number_format($currAmount * $mozzart_start_sum_odds * (1 + $brutoBonus / 100), 2, ',', '.') : $realPaymentValue ;
                        foreach ($SourcesArray as $k)
                        {
                            ($realPaymentValue > 0) ? $tmp_sums [$k] = number_format(($currAmount * $SourceSumArray[$k] * (1 + $SourceBonusArray[$k] / 100)), 2, ',', '.') : $realPaymentValue;
                        }
                    }  else  {

                        $tmp_sums [0] = number_format($realPaymentValue * $currencyValue, 2, ',', '.');
                        foreach ($SourcesArray as $k) {  $tmp_sums [$k] = 0; }

                    }

                $min_sum = min($tmp_sums);
                $max_sum = max($tmp_sums);
                if ($min_sum == $max_sum) {
                    $max_sum = 1;
                    $min_sum = 1;
                }
//                echo $min_sum." ".$max_sum."<br>";

                ?>

                <tr class="grayb bold">
                    <td colspan="6">Za isplatu (<?php echo $curr_currency ?>)</td>
                    <td class="<?php $odd = $tmp_sums[1]; if ($odd == $max_sum) { echo "red";} elseif ($odd == $min_sum) {echo "green";}?>"><?php echo $tmp_sums [1]?></td>
                    <td class="<?php $odd = $tmp_sums[0]; if ($odd == $max_sum) { echo "red";} elseif ($odd == $min_sum) {echo "green";}?>"><?php echo $tmp_sums [0]?></td>
                    <?php foreach ($SourcesArray as $k) { ?>
                    <td class="<?php $odd = $tmp_sums[$k]; if ($odd == $max_sum) { echo "red";} elseif ($odd == $min_sum) {echo "green";}?>"><?php echo $tmp_sums [$k]?></td>
                    <?php   }   ?>
                    <td colspan="4"> </td>
                </tr>
                <tr>
                    <td colspan="15"></td>
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
