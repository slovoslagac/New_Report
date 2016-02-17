<!doctype html>
<html>
<?php
require_once(join(DIRECTORY_SEPARATOR, array('..', 'init.php')));;
$css = 'css/admin.css';
$naslov_short = "Admin";
$naslov = "Spajanje takmičenja za odabranu kladionicu";
$kladionica_name = '';

include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));


$i = 1;
$Data1 = array();
$Data2 = array();
$source_id = 2;
$bookie = 'Soccer';


if (isset ($_GET ["bookie_id"]) != "") {
    $source_all = explode("__", $_GET['bookie_id']);

    $source_id = $source_all[0];
    $bookie = $source_all[1];
//    $bookie = $_GET ["source1"];
}
// echo $bookie;

include(join(DIRECTORY_SEPARATOR, array('db', 'connectingCompetitions.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'mozzartCompetitions.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'availableSources.php')));

$Data1 = $resultNMCMP;
$Data2 = $resultMZCMP;
$Data3 = $resultSources;


?>
<body>
<div id="container">
    <?php $btn1 = 'admin.php';
    $btn2 = 'adminRedosled.php';
    $btn3 = 'adminSpajanjeTakmicenja.php';
    $btn4 = 'adminSpajanjeMeceva.php';
    $btn5 = 'adminKontrolaTakmicenja.php';
    include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php'))); ?>
    <div id="function_data">
        <table id="exportTable">
            <thead>
            <tr class="naslov">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                    <td>
                        <select name="bookie_id">

                            <?php foreach ($Data3 as $D3) { ?>
                                <option value="<?php echo $D3['id']. "__" .$D3['name'] ?>" <?php if ($D3['id'] == $source_id) {
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


            <form method="post" action="<?php echo(join(DIRECTORY_SEPARATOR, array('saveCompetition.php'))) ?>">

                <input type="hidden" name="source" value="<?php echo $bookie ?>">

                <?php
                foreach ($Data1 as $srSource) {

                    if ($bookie != $srSource['src_name']) {
                        $source = $srSource['src_name'];
                        $source_id = $srSource['src_id'];
                        echo $source ?>


                    <?php }
                    $liga = $srSource['cmp_name'];
                    $liga_id = $srSource['cmp_id'] ?>


                    <tr class="row<?php echo($i++ & 1) ?>">
                        <td colspan="1"><input type="hidden" name="src_comp[]"
                                               value="<?php echo $liga_id . "__" . $srSource['cmp_name'] ?>"><?php echo $srSource['cmp_name'] ?>
                        </td>

                        <td class="dropdown"><input type="hidden">
                            <select name="mozz_comp[]">
                                <option value="0">Treba spojiti</option>
                                <?php
                                foreach ($Data2 as $cmpt) {
                                    $src_cmp_id = $cmpt['competition_id'];
                                    $src_cmp_name = $cmpt['competition_name']; ?>

                                    <option
                                        value="<?php echo $src_cmp_id . "__" . $src_cmp_name ?>"><?php echo $src_cmp_name ?></option> <?php } ?>
                            </select>
                        </td>
                    </tr>

                <?php } ?>

                <tr class="naslov">
                    <td colspan="2"><input accesskey="x" type="submit" value="Sačuvaj"/></td>
                </tr>

            </form>
            </tbody>
        </table>

    </div>
    <?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
</div>
</body>
</html>