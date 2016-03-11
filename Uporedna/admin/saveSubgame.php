<!doctype html>
<html>
<?php
require_once(join(DIRECTORY_SEPARATOR, array('..', 'init.php')));;
$css = 'css/admin.css';
$naslov_short = "Admin";
$naslov = "Spajena takmičenja za odabranu kladionicu";
$kladionica_name = '';

include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));


$i = 1;
$data = array();
$indexes = array();
$bookie = $_POST['source'];

// echo $_POST['source'];

// echo $bookie;
// fetch data
$_post = $_POST;
if (!empty($_post['src_sbg'])) {
    foreach ($_post['src_sbg'] as $index => $inv) {
        if ($_post['mozz_sbg'][$index] == 0) {
            continue;
        }

        $indexes[] = $index;
    }
}

//print_r($indexes);

// collect data for DB inserts
foreach ($indexes as $index) {
    // temporary data
    $tmp = array();

    $bookie_sbg_base = explode("__", $_post['src_sbg'][$index]);

    $tmp['src_comp'] = $bookie_sbg_base[0];
    $tmp['src_name'] = $bookie_sbg_base[1];


    $mozz_sbg_base = explode("__", $_post['mozz_sbg'][$index]);
    $tmp['mozz_comp'] = $mozz_sbg_base[0];
    $tmp['mozz_name'] = $mozz_sbg_base[1];

    $data[] = $tmp;
}


// print_r($data);

include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));

foreach ($data as $d) {

    $mozzGame = $d['mozz_comp'];
    $srcGame = $d['src_comp'];


    $query = '
INSERT INTO
conn_subgame (subgame_id, src_subgame_id)
VALUES
(:init_subgame_id, :src_subgame_id)
';

    $params = array(
        'init_subgame_id' => $mozzGame,
        'src_subgame_id' => $srcGame
    );

    $prepare = $conn->prepare($query);
    $prepare->execute($params);


}
$conn = null;

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
        <table id="exportTable" class="size60">
            <thead>

            <tr class="title">
                <td><?php echo $bookie ?></td>
                <td>Mozzart</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data as $d1) { ?>
                <tr class="row<?php echo($i++ & 1) ?>">
                    <td><?php echo $d1['src_name'] ?></td>
                    <td><?php echo $d1['mozz_name'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


</body>

</html>