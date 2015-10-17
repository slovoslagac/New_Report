<!doctype html>
<html>
<?php 
require_once('init.php');
$css='css/index_new.css';
$naslov_short="Bookmaking";
$naslov="Bookmaking osnovna strana";


include(join(DIRECTORY_SEPARATOR, array('included', 'main_header.php')));

?>
    <body>
        <div id="container">
            <?php $btn1='index.php';$btn2='Podrska/index.php';$btn3='Teletext/index.php';$btn4='Verif/index.php';
            include(join(DIRECTORY_SEPARATOR, array('included', 'main_menu.php')));?> 
            <div id="function_data">
                
            </div>
            <?php include(join(DIRECTORY_SEPARATOR, array('included', 'main_footer.php'))); ?>
        </div>
    </body>
</html>