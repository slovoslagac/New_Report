<!doctype html>
<html>
<?php
require_once(join(DIRECTORY_SEPARATOR, array('..', 'init.php')));;
$css = 'css/admin.css';
$naslov_short = "Admin";
$naslov = "Povezivanje timova";
$kladionica = "";
include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));


$i = 0;

$data = array();

$source_id = 11;
$bookie = 'Xscores';
$koef = 1;
$sport ='';
$sportArray = array(1=>'Fudbal', 4=>'Hokej', 58=>'Američki fudbal', 7=>'Rukomet', 8=>'Bejzbol');

if (isset ($_GET ["bookie_id"]) != "") {
    $source_all = explode("__", $_GET['bookie_id']);

    $source_id = $source_all[0];
    $bookie = $source_all[1];
    if (isset($_GET['sve'])) {
        $koef = 0;
    } else {
        $koef = 1;
    }
//    $bookie = $_GET ["source1"];
}
// echo $bookie;



include(join(DIRECTORY_SEPARATOR, array('db', 'connectingTeams.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'mozzartTeams.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'availableSources.php')));

$Data1 = $ShowTeam ;
$Data2 = $ShowMozTeam;
$Data3 = $resultSources;

$j = 1;

?>
<body>
<div id="container">
    <?php $btn1 = 'admin.php';
    $btn2 = 'adminRedosled.php';
    $btn3 = 'adminSpajanjeTakmicenja.php';
    $btn4 = 'adminSpajanjeMeceva.php';
    $btn5 = 'adminKontrolaTakmicenja.php';
    include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php'))); ?>
    <div id="match_data" class="size60">
        <table id="exportTable">
            <thead>
            <tr class="title">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                    <td>
                        <select name="bookie_id">

                            <?php foreach ($Data3 as $D3) { ?>
                                <option
                                    value="<?php echo $D3['id'] . "__" . $D3['name'] ?>" <?php if ($D3['id'] == $source_id) {
                                    echo 'selected="selected"';
                                } ?>><?php echo $D3['name'] ?>
                                </option>

                            <?php } ?>

                        </select>

                    </td>
                    <td>
                        <input type="Submit" accesskey="w" value="Osveži"/>
                        </select><input name="sve" type="checkbox" <?php echo ($koef==0)?"checked" : ""?>>
                    </td>
                </form>
            </tr>
            </thead>
            <tbody>
            <form action="saveTeams.php" method="post">
                <input type="hidden" name="source" value="<?php echo $bookie ?>">

                <?php
                include(join(DIRECTORY_SEPARATOR, array('included', 'mec_colgroup_table.php')));
                //                include(join(DIRECTORY_SEPARATOR, array('included', 'mec_table_header.php')));
                $current_league = '';
                if ($koef == 1) {


                foreach ($Data1 as $d) {

                    if ($d['sport_id'] != $sport) {
                        $sport = $d['sport_id'];
                        ?>

                        <tr class="podnaslov">
                            <td colspan="2"> <?php echo $sportArray[$sport] ?></td>
                        </tr>
                    <?php }

                    if ($d['competition_name'] != $current_league) {
                        $current_league = $d['competition_name'];
                        $current_league_id = $d['competition_id'] ?>

                        <tr class="podnaslov">
                            <td colspan="2"> <?php echo $current_league?></td>
                        </tr>
                    <?php } ?>
                    <tr class="row<?php echo($i++ & 1) ?>">
                        <td><input type="hidden" name="source_team[]" value="<?php echo $d['team_id']. "__" . $d['team_name']?>">
                            <?php echo $d['team_name']?></td>
                        <td>
                            <select name="mozz_team[]">
                                <option value="0">Treba povezati</option>

                                <?php foreach ($Data2 as $d2) {

                                        if ($d2['competition_id'] == $current_league_id and $d2['sport_id'] == $sport) {  ?>
                                            <option
                                                value="<?php echo $d2['team_id'] . "__" . $d2['team_name'] ?>"><?php echo $d2['team_name'] ?></option>

                                            <?php
                                        }
                                    }

                                ?>
                            </select>
                        </td>
                    </tr>

                    <?php
                }} else {
                    foreach ($Data1 as $d) {

                        if ($d['sport_id'] != $sport) {
                            $sport = $d['sport_id'];
                            ?>

                            <tr class="podnaslov">
                                <td colspan="2"> <?php echo $sportArray[$sport] ?></td>
                            </tr>
                        <?php }

                        if ($d['competition_name'] != $current_league) {
                            $current_league = $d['competition_name'];
                            $current_league_id = $d['competition_id'] ?>

                            <tr class="podnaslov">
                                <td colspan="2"> <?php echo $current_league ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="row<?php echo($i++ & 1) ?>">
                            <td><input type="hidden" name="source_team[]" value="<?php echo $d['team_id']. "__" . $d['team_name']?>">
                                <?php echo $d['team_name']?></td>
                            <td>
                                <select name="mozz_team[]">
                                    <option value="0">Treba povezati</option>

                                    <?php foreach ($Data2 as $d2) {
                                        if ($d2['sport_id'] == $sport){ echo $sport;
                                       ?>
                                            <option value="<?php echo  $d2['team_id']. "__" . $d2['team_name'] ?>"><?php echo $d2['team_name']?></option>

                                            <?php

                                    }}
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <?php
                    } }

                ?>

                <tr class="title">
                    <td colspan="2"><input type="submit" value="Sačuvaj" accesskey="x"/></td>
                </tr>

            </tbody>
        </table>

        </form>

    </div>

    <?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
</div>
</body>
</html>
