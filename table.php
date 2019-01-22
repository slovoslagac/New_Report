<!doctype html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
</head>
<?php
include_once('tableData.php');
$cmpid = 1;
$seasonid = 25;

$data = getNormalTable($cmpid, $seasonid);
$htdata = getHTTable($cmpid,$seasonid);
$htdatadetails = array();

$translate = array("WIN" => "+", "DRAW" => "x", "LOSE" => "-");

foreach ($htdata as $tmp){
    $htdatadetails[$tmp->participant->id][0] = $tmp->overall->wins;
    $htdatadetails[$tmp->participant->id][1] = $tmp->overall->draws;
    $htdatadetails[$tmp->participant->id][2] = $tmp->overall->losses;
    $htdatadetails[$tmp->participant->id][3] = $tmp->homePlayed->wins;
    $htdatadetails[$tmp->participant->id][4] = $tmp->homePlayed->draws;
    $htdatadetails[$tmp->participant->id][5] = $tmp->homePlayed->losses;
    $htdatadetails[$tmp->participant->id][6] = $tmp->visitorPlayed->wins;
    $htdatadetails[$tmp->participant->id][7] = $tmp->visitorPlayed->draws;
    $htdatadetails[$tmp->participant->id][8] = $tmp->visitorPlayed->losses;
}



?>
<section id="tabs" class="project-tab">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                           role="tab" aria-controls="nav-home" aria-selected="true">Tabela</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                           role="tab" aria-controls="nav-profile" aria-selected="false">Proseci</a>
<!--                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"-->
<!--                           role="tab" aria-controls="nav-contact" aria-selected="false">Project Tab 3</a>-->
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th rowspan="2">Poz</th>
                                <th rowspan="2">Name</th>
                                <th colspan="7" class="text-center">Ukupno</th>
                                <th colspan="6" class="text-center">Kuci</th>
                                <th colspan="6" class="text-center">U gostima</th>
                            </tr>
                            <tr>
                                <th>mp</th>
                                <th>p</th>
                                <th>i</th>
                                <th>n</th>
                                <th>GR</th>
                                <th>B</th>
                                <th>Zadnjih 5</th>
                                <th>p</th>
                                <th>i</th>
                                <th>n</th>
                                <th>GR</th>
                                <th>B</th>
                                <th>Zadnjih 5</th>
                                <th>p</th>
                                <th>i</th>
                                <th>n</th>
                                <th>GR</th>
                                <th>B</th>
                                <th>Zadnjih 5</th>
                            </tr>
                            </thead>
                            <?php
                            foreach ($data as $item) {
                                $team = $item->participant->name;
                                $fulltableitem = $item->overall;
                                $fulltableL5 = $fulltableitem->lastFiveMatches;
                                $fulltableHF = $fulltableitem->halfTimeFullTime;
                                $hometableitem = $item->homePlayed;
                                $hometableL5 = $hometableitem->lastFiveMatches;
                                $visitortableitem = $item->visitorPlayed;
                                $visitortableL5 = $visitortableitem->lastFiveMatches;
                                $position = $fulltableitem->position;

                                ?>
                                <tr>
                                    <td><?php echo $position ?></td>
                                    <td><?php echo $team ?></td>
                                    <td><?php echo $fulltableitem->matchesPlayed ?></td>
                                    <td><?php echo $fulltableitem->wins ?></td>
                                    <td><?php echo $fulltableitem->draws ?></td>
                                    <td><?php echo $fulltableitem->losses ?></td>
                                    <td><?php echo "$fulltableitem->scored:$fulltableitem->received" ?></td>
                                    <td><?php echo $fulltableitem->rankingSystem ?></td>
                                    <td><?php echo $translate[$fulltableL5[0]], $translate[$fulltableL5[1]], $translate[$fulltableL5[2]], $translate[$fulltableL5[3]], $translate[$fulltableL5[4]] ?></td>
                                    <td><?php echo $hometableitem->wins ?></td>
                                    <td><?php echo $hometableitem->draws ?></td>
                                    <td><?php echo $hometableitem->losses ?></td>
                                    <td><?php echo "$hometableitem->scored:$hometableitem->received" ?></td>
                                    <td><?php echo $hometableitem->rankingSystem ?></td>
                                    <td><?php echo $translate[$hometableL5[0]], $translate[$hometableL5[1]], $translate[$hometableL5[2]], $translate[$hometableL5[3]], $translate[$hometableL5[4]] ?></td>
                                    <td><?php echo $visitortableitem->wins ?></td>
                                    <td><?php echo $visitortableitem->draws ?></td>
                                    <td><?php echo $visitortableitem->losses ?></td>
                                    <td><?php echo "$visitortableitem->scored:$visitortableitem->received" ?></td>
                                    <td><?php echo $visitortableitem->rankingSystem ?></td>
                                    <td><?php echo $translate[$visitortableL5[0]], $translate[$visitortableL5[1]], $translate[$visitortableL5[2]], $translate[$visitortableL5[3]], $translate[$visitortableL5[4]] ?></td>
                                </tr>
                            <?php } ?>

                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th rowspan="3">Poz</th>
                                <th rowspan="3">Name</th>
                                <th colspan="15" class="text-center">Ukupno</th>
                                <th colspan="6" class="text-center">Kuci</th>
                                <th colspan="6" class="text-center">U gostima</th>

                            </tr>
                            <tr>
                                <td colspan="9"></td>
                                <td colspan="3" class="text-center">Prosek golova</td>
                                <td colspan="3" class="text-center">1. poluvreme</td>
                                <td colspan="3" class="text-center">Prosek golova</td>
                                <td colspan="3" class="text-center">1. poluvreme</td>
                                <td colspan="3" class="text-center">Prosek golova</td>
                                <td colspan="3" class="text-center">1. poluvreme</td>
                            </tr>
                            <tr>
                                <td>1/1</td>
                                <td>1/X</td>
                                <td>1/2</td>
                                <td>X/1</td>
                                <td>X/X</td>
                                <td>X/2</td>
                                <td>2/1</td>
                                <td>2/X</td>
                                <td>2/2</td>
                                <td>Uk</td>
                                <td>Dao</td>
                                <td>Primio</td>
                                <th>p</th>
                                <th>i</th>
                                <th>n</th>
                                <td>Uk</td>
                                <td>Dao</td>
                                <td>Primio</td>
                                <th>p</th>
                                <th>i</th>
                                <th>n</th>
                                <td>Uk</td>
                                <td>Dao</td>
                                <td>Primio</td>
                                <th>p</th>
                                <th>i</th>
                                <th>n</th>

                            </tr>
                            </thead>
                            <?php
                            foreach ($data as $item) {
                                $team = $item->participant->name;
                                $participantid = $item->participant->id;
                                $fulltableitem = $item->overall;
                                $fulltableL5 = $fulltableitem->lastFiveMatches;
                                $fulltableHF = $fulltableitem->halfTimeFullTime;
                                $hometableitem = $item->homePlayed;
                                $hometableL5 = $hometableitem->lastFiveMatches;
                                $visitortableitem = $item->visitorPlayed;
                                $visitortableL5 = $visitortableitem->lastFiveMatches;
                                $position = $fulltableitem->position;

                                ?>
                                <tr>
                                    <td><?php echo $position ?></td>
                                    <td><?php echo $team ?></td>
                                    <td><?php echo $fulltableHF->WIN_WIN ?></td>
                                    <td><?php echo $fulltableHF->WIN_DRAW ?></td>
                                    <td><?php echo $fulltableHF->WIN_LOSE?></td>
                                    <td><?php echo $fulltableHF->DRAW_WIN?></td>
                                    <td><?php echo $fulltableHF->DRAW_DRAW?></td>
                                    <td><?php echo $fulltableHF->DRAW_LOSE?></td>
                                    <td><?php echo $fulltableHF->LOSE_WIN?></td>
                                    <td><?php echo $fulltableHF->LOSE_DRAW?></td>
                                    <td><?php echo $fulltableHF->LOSE_LOSE?></td>
                                    <td><?php echo number_format(($fulltableitem->scored + $fulltableitem->received) / $fulltableitem->matchesPlayed, 2)?></td>
                                    <td><?php echo number_format($fulltableitem->scored  / $fulltableitem->matchesPlayed, 2)?></td>
                                    <td><?php echo number_format($fulltableitem->received / $fulltableitem->matchesPlayed, 2)?></td>
                                    <td><?php echo $htdatadetails[$participantid][0]?></td>
                                    <td><?php echo $htdatadetails[$participantid][1]?></td>
                                    <td><?php echo $htdatadetails[$participantid][2]?></td>
                                    <td><?php echo number_format(($hometableitem->scored + $hometableitem->received) / $hometableitem->matchesPlayed, 2)?></td>
                                    <td><?php echo number_format($hometableitem->scored  / $hometableitem->matchesPlayed, 2)?></td>
                                    <td><?php echo number_format($hometableitem->received / $hometableitem->matchesPlayed, 2)?></td>
                                    <td><?php echo $htdatadetails[$participantid][3]?></td>
                                    <td><?php echo $htdatadetails[$participantid][4]?></td>
                                    <td><?php echo $htdatadetails[$participantid][5]?></td>
                                    <td><?php echo number_format(($visitortableitem->scored + $visitortableitem->received) / $visitortableitem->matchesPlayed, 2)?></td>
                                    <td><?php echo number_format($visitortableitem->scored  / $visitortableitem->matchesPlayed, 2)?></td>
                                    <td><?php echo number_format($visitortableitem->received / $visitortableitem->matchesPlayed, 2)?></td>
                                    <td><?php echo $htdatadetails[$participantid][6]?></td>
                                    <td><?php echo $htdatadetails[$participantid][7]?></td>
                                    <td><?php echo $htdatadetails[$participantid][8]?></td>

                                </tr>
                            <?php } ?>

                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <table class="table" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Contest Name</th>
                                <th>Date</th>
                                <th>Award Position</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</html>
