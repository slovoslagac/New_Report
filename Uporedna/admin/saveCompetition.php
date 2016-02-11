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
if (!empty($_post['src_comp'])) {
    foreach ($_post['src_comp'] as $index => $inv) {
        if ($_post['mozz_comp'][$index] == 0) {
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

    $bookie_cmp_base = explode("__", $_post['src_comp'][$index]);

    $tmp['src_comp'] = $bookie_cmp_base[0];
    $tmp['src_name'] = $bookie_cmp_base[1];


    $mozz_cmp_base = explode("__", $_post['mozz_comp'][$index]);
    $tmp['mozz_comp'] = $mozz_cmp_base[0];
    $tmp['mozz_name'] = $mozz_cmp_base[1];

    $data[] = $tmp;
}


// print_r($data);

include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlAdminPDO.php')));

foreach ($data as $d) {

    $competitionId = $d['mozz_comp'];
    $srcCompetitionId = $d['src_comp'];


    $query = '
INSERT INTO
conn_competition (init_competition_id, src_competition_id)
VALUES
(:init_competition_id, :src_competition_id)
';

    $params = array(
        'init_competition_id' => $competitionId,
        'src_competition_id' => $srcCompetitionId
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
        <table id="exportTable">
            <thead>

            <tr class="naslov">
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