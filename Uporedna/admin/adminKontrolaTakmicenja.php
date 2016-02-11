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

include(join(DIRECTORY_SEPARATOR, array('db', 'controlCompetitions.php')));

$Data1 = $resultACC;
$bookie = '';
$i = 1;




if(isset($_GET['delete'])){
    $multiple = $_GET['delete_selection'];

    $j = 0 ;

    $sql = "Delete from conn_competition ";

    foreach($multiple as $item_id) { $j ++;
        if ($j ==1) {
            $sql .= "where id = ". $item_id . "";
        } else {
            $sql .= " Or id = ". $item_id . "";
        }

    }




    include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));

    $deleteData = $conn -> prepare($sql);

    $deleteData ->execute();

    $conn = null;

    header("Location: adminKontrolaTakmicenja.php");

}



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
            <colgroup>
                <col width="20%">
                <col width="30%">
                <col width="50%">
                <col width="10%">
            </colgroup>
            <thead>
            <tr class="naslov">
                <td>Kladionica</td>
                <td>Takmičenje</td>
                <td>Mozzart Takmičenje</td>
                <td>Obriši</td>
            </tr>

            </thead>
            <tbody>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                <?php
                foreach ($Data1 as $srSource) { ?>


                    <tr class="row<?php echo($i++ & 1) ?>">
                        <td><?php echo $srSource['source_name'] ?></td>
                        <td><?php echo $srSource['competition'] ?></td>
                        <td><?php echo $srSource['mozzart_competition'] ?></td>
                        <td>
                            <input type="checkbox" name="delete_selection[]" value="<?php echo $srSource['conn_id'] ?>">
                        </td>
                    </tr>

                <?php } ?>

                <tr class="naslov">
                    <td colspan="4"><input accesskey="x" type="submit" name="delete" value="Sačuvaj"/></td>
                </tr>

            </form>
            </tbody>
        </table>

    </div>
    <?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
</div>
</body>
</html>