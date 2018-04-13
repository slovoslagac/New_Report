<!doctype html>
<html>
<?php
require_once(join(DIRECTORY_SEPARATOR, array('..', 'init.php')));;
$naslov_short = "Admin";
$naslov = "Naslovna strana admin dela";
$kladionica_name = '';
$css = 'css/admin.css';

include(join(DIRECTORY_SEPARATOR, array('included', 'adm_header.php')));

if (isset ($_GET["kladionica"]) != "") {
    $kladionica_name = $_GET["kladionica"];
    include(join(DIRECTORY_SEPARATOR, array('db', 'spajanje.php')));

};

if (isset ($_POST["parser"]) != "") {
    $value = $_POST["parser"];
    switch ($value) {
        case('maxbet'):
            include(join(DIRECTORY_SEPARATOR, array('scripts', 'maxbet.php')));
            break;
        case('balkanbet'):
//            include(join(DIRECTORY_SEPARATOR, array('scripts', 'BalkanBetNew.php')));
            break;
        default:

    }

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
        <form method="post">
            <div class="region">
                <h2>Srbija</h2>
                <hr>
                <h3>Skidanje kvota</h3>
                <button type="submit" name="parser" value="maxbet">Maxbet</button>
                <button type="submit" name="parser" value="balkanbet">Balkanbet</button>
        </form>
        <hr>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
            <h3>Povezivanje utakmica</h3>
            <button type="submit" name="kladionica" value="balkanbet">Balkanbet</button>
            <button type="submit" name="kladionica" value="meridian">Meridian</button>
            <button type="submit" name="kladionica" value="maxbet">Maxbet</button>
            <button type="submit" name="kladionica" value="planetwin">PlanetWin365</button>
            <button type="submit" name="kladionica" value="pinbet">Pinbet</button>
            <button type="submit" name="kladionica" value="soccer">Soccer</button>
        </form>
    </div>
    <div class="region">
        <h2>Rumunija</h2>
        <hr>

    </div>
    <div class="region">
        <h2>Bosna</h2>
        <hr>
    </div>
    <div class="region">
        <h2>Hrvatska</h2>
        <hr>
        <button type="submit" name="kladionica" value="germanija">Germanija</button>
        <button type="submit" name="kladionica" value="supersport">Supersport</button>
    </div>

</div>
<?php include(join(DIRECTORY_SEPARATOR, array('included', 'adm_footer.php'))); ?>
</div>
</body>
</html>