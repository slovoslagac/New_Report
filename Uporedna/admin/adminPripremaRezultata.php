<!doctype html>
<html>

<?php
require_once(join(DIRECTORY_SEPARATOR, array('..', 'init.php')));;
$css = 'css/admin.css';
$naslov_short = "Admin";
$naslov = "Priprema rezultata";
$kladionica_name = '';

include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));


// echo $bookie;

//$source_id = 2;
//$bookie = 'Soccer';
$source_id = 11;

$competition_id = 0;
$season_id = array();
$i = 1;

$result_type = array(1=>"prvo poluvreme", 2=>"konacan ishod",10=>"prvo poluvreme", 11=>"konacan ishod",12=> 'cetvrtina',13=> 'cetvrtina',14=> 'cetvrtina',15=> 'cetvrtina');
$period = array(1=>'',2=>'',10=>'',11=>'',12=> 1,13=>2,14=>3,15=>4);
$sportSource = array(1=>'Fudbal', 58=>'Američki Fudbal');

if (isset ($_GET ["bookie_id"]) != "") {
    $source_all = explode("__", $_GET['bookie_id']);
    if($source_all[0] != 0 ) {
        $source_id = $source_all[0];
        $bookie = $source_all[1];
//    $bookie = $_GET ["source1"];
    }
}


if (isset($_GET ["competition_id"]) != "") {
    $competition_id = $_GET['competition_id'];
}

if (isset($_GET ["season_id"]) != "") {
    $season_id = $_GET['season_id'];
}

//echo $season_id,"\t", $competition_id;

include(join(DIRECTORY_SEPARATOR, array('db', 'LeaguePreparation.php')));
include(join(DIRECTORY_SEPARATOR, array('db', 'availableSources.php')));

$Data1 = $resultLMR;
$Data2 = $resultS;
$Data3 = $resultL;
$Data4 = $resultSources;



?>
<body>
<div id="container">
    <?php
    include(join(DIRECTORY_SEPARATOR, array('included', 'adm_menu.php'))); ?>
    <div id="function_data">
        <table id="exportTable" class="size80">
            <tr class="title">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                    <td>
                        <select name="bookie_id">

                            <?php foreach ($Data4 as $D4) { ?>
                                <option value="<?php echo $D4['id']. "__" .$D4['name'] ?>" <?php if ($D4['id'] == $source_id) {
                                    echo 'selected="selected"';
                                } ?>><?php echo $D4['name'] ?>
                                </option>

                            <?php } ?>
                    </td>
                    <td>
                        <select name="competition_id">
                            <option value="0">Izaberi ligu</option>
                            <?php foreach ($Data3 as $D3) { ?>
                                <option
                                    value="<?php echo $D3['id'] ?>" <?php if ($D3['id'] == $competition_id) {
                                    echo 'selected="selected"';
                                } ?>><?php echo $D3['mozzart'] ?>
                                </option>

                            <?php } ?>

                        </select>
                    </td>
                    <td>
                        <select multiple name="season_id[]">
                            <?php foreach ($Data2 as $D2) { ?>}
                                <option value="<?php echo $D2['id'] ?>"<?php echo in_array($D2['id'],$season_id ) ? 'selected="selected"' : ''; ?>><?php echo $D2['name']?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input type="Submit" accesskey="w" value="Osveži"/>
                    </td>
                </form>
            </tr>
        </table>
        <table id="exportTable" class="size80">
            <colgroup>
                <col width="10%">
                <col width="6%">
                <col width="20%">
                <col width="20%">
                <col width="15%">
                <col width="8%">
                <col width="6%">
                <col width="15%">
            </colgroup>
            <thead>
            <tr class="title">
                <td>Datum</td>
                <td>Vreme</td>
                <td>Domaćin</td>
                <td>Gost</td>
                <td>Tip rezultata</td>
                <td>Rezultat</td>
                <td>Period</td>
                <td>Sport</td>
            </tr>

            </thead>
            <tbody>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                <?php
                foreach ($Data1 as $srSource)  { $sport = $srSource['sport_id'];
                    ?>
                    <tr class="row<?php echo($i++ & 1) ?>">
                        <td><?php echo $srSource['date'] ?></td>
                        <td><?php echo $srSource['time'] ?></td>
                        <td><?php echo $srSource['hometeam'] ?></td>
                        <td><?php echo $srSource['awayteam'] ?></td>
                        <td><?php echo $result_type[$srSource['resulttype']] ?></td>
                        <td><?php echo str_replace('-', ':', $srSource['result']) ?></td>
                        <td><?php echo $period[$srSource['resulttype']] ?></td>
                        <td><?php echo $sportSource[$sport]?></td>
                    </tr>

                <?php } ?>


            </form>
            </tbody>
        </table>

    </div>
</div>
<?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
</div>


</body>
</html>