<!doctype html>
<html>
<?php
require_once(join(DIRECTORY_SEPARATOR, array('..', 'init.php')));;
$css = 'css/admin.css';
$naslov_short = "Admin";
$naslov = "Spajanje takmičenja za odabranu kladionicu";
$kladionica_name = '';

include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));


// echo $bookie;

//$source_id = 2;
//$bookie = 'Soccer';
$source_id = '';
$i = 1;

if (isset ($_GET ["bookie_id"]) != "") {
    $source_all = explode("__", $_GET['bookie_id']);
    if($source_all[0] != 0 ) {
        $source_id = $source_all[0];
        $bookie = $source_all[1];
//    $bookie = $_GET ["source1"];
    }
}

include(join(DIRECTORY_SEPARATOR, array('db', 'controlTeams.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'availableSources.php')));

$Data1 = $resultACT;
$Data3 = $resultSources;





if (isset($_GET['delete'])) {
    $multiple = $_GET['delete_selection'];

    $j = 0;

    $sql = "DELETE FROM conn_team ";

    foreach ($multiple as $item_id) {
        $j++;
        if ($j == 1) {
            $sql .= "where id = " . $item_id . "";
        } else {
            $sql .= " Or id = " . $item_id . "";
        }

    }


    include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));

    $deleteData = $conn->prepare($sql);

    $deleteData->execute();

    $conn = null;

    header("Location: adminKontrolaTimova.php");

}


?>
<body>
<div id="container">
    <?php
    include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php'))); ?>
    <div id="function_data">
        <table id="exportTable" class="size60">
            <tr class="naslov">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                    <td>
                        <select name="bookie_id">
                            <option value="0">Sve kladionice</option>
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
        </table>
        <table id="exportTable" class="size60">

            <colgroup>
                <col width="20%">
                <col width="30%">
                <col width="50%">
                <col width="10%">
            </colgroup>
            <thead>
            <tr class="naslov">
                <td>Kladionica</td>
                <td>Mozzart tim</td>
                <td>Tim</td>
                <td>Obriši</td>
            </tr>

            </thead>
            <tbody>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                <?php
                foreach ($Data1 as $srSource) { ?>


                    <tr class="row<?php echo($i++ & 1) ?>">
                        <td><?php echo $srSource['source_name'] ?></td>
                        <td><?php echo $srSource['mozzart_team_name'] ?></td>
                        <td><?php echo $srSource['src_team_name'] ?></td>
                        <td>
                            <input type="checkbox" name="delete_selection[]" value="<?php echo $srSource['conn_id'] ?>">
                        </td>
                    </tr>

                <?php } ?>

                <tr class="naslov">
                    <td colspan="4"><input accesskey="x" type="submit" name="delete" value="Obriši"/></td>
                </tr>

            </form>
            </tbody>
        </table>

    </div>
    <?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
</div>
</body>
</html>