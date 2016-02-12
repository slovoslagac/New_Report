<!doctype html>
<html>
<?php
require_once(join(DIRECTORY_SEPARATOR, array('..', 'init.php')));;
$css = 'css/admin.css';
$naslov_short = "Admin";
$naslov = "Povezivanje mečeva";
$kladionica = "";
include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));


$i = 0;

$data = array();

$source_id = 2;
$bookie = 'Soccer';


if (isset ($_GET ["bookie_id"]) != "") {
    $source_all = explode("__", $_GET['bookie_id']);

    $source_id = $source_all[0];
    $bookie = $source_all[1];
//    $bookie = $_GET ["source1"];
}
// echo $bookie;

include(join(DIRECTORY_SEPARATOR, array('db', 'connectingMatches.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'mozzartMatches.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'availableSources.php')));

$Data1 = $ShowMatch;
$Data2 = $ShowMozzMatch;
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
            <tr class="naslov">
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
                    </td>
                </form>
            </tr>
            </thead>
            <tbody>
            <form method="post" action="saveMatches.php">

                <?php
                include(join(DIRECTORY_SEPARATOR, array('included', 'mec_colgroup_table.php')));
//                include(join(DIRECTORY_SEPARATOR, array('included', 'mec_table_header.php')));
                $current_league = '';
                foreach ($Data1 as $d) {

                    if ($d['competition_name'] != $current_league) {
                        $current_league = $d['competition_name']; $current_league_id = $d['competition_id']?>

                        <tr class="podnaslov">
                            <td colspan="2"><?php echo $current_league ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="row<?php echo($i++ & 1) ?>">
                        <td><?php echo $d['home_name'] . " - " . $d['visitor_name'] ?></td>
                        <td>
                            <select name="mozz_match[]">
                                <?php foreach ($Data2 as $d2) {
                                    if ($d2['mozz_cmp_id'] == $current_league_id) { ?>
                                        <option><?php echo $d2['mozz_home_team_name']." - ".$d2['mozz_visitor_team_name'] ?></option>

                                <?php
                                    }
                                }
?>
                            </select>
                        </td>
                    </tr>

                    <?php
                } ?>

                <tr class="naslov">
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
