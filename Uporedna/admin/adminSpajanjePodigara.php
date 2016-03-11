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

include(join(DIRECTORY_SEPARATOR, array('db', 'connectingSubgames.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'mozzartSubgames.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'availableSources.php')));

$Data1 = $ShowSubgames;
$Data2 = $resultMSBG;
$Data3 = $resultSources;

$j = 1;


?>
<body>
<div id="container">
    <?php
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
                    </td>
                    <!--                    <td>Obrnuto domaćinstvo</td>-->
                </form>
            </tr>
            </thead>
            <tbody>
            <form method="post" action="<?php echo(join(DIRECTORY_SEPARATOR, array('saveSubgame.php'))) ?>">

                <input type="hidden" name="source" value="<?php echo $bookie ?>">

                <?php
                foreach ($Data1 as $D1) {


                    $game = $D1['game'];
                    $subgame = $D1['subgame']; ?>


                    <tr class="row<?php echo($i++ & 1) ?>">
                        <td colspan="1"><input type="hidden" name="src_sbg[]"
                                               value="<?php echo $D1['id']. "__" .$game . " " . $subgame ?>"><?php echo ($game != "") ? $game . " " . $subgame : $subgame ?>
                        </td>
                        <td>
                            <select name="mozz_sbg[]">
                                <option value="0">Treba Spojiti</option>
                                <?php
                                foreach ($Data2 as $msbg) {
                                    $mz_game = $msbg['game_name'];
                                    $mz_subgame = $msbg['subgame_name'];
                                    $mz_id = $msbg['id']?>

                                    <option value="<?php echo $mz_id. "__" .$mz_game. " " .$mz_subgame ?>"> <?php echo $mz_game." - ".$mz_subgame ?>  </option>
                                    <?php         } ?>

                            </select>
                        </td>
                    </tr>

                <?php } ?>

                <tr class="title">
                    <td colspan="2"><input accesskey="x" type="submit" value="Sačuvaj"/></td>
                </tr>

            </form>
        </table>


    </div>

    <?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
</div>
</body>
</html>
