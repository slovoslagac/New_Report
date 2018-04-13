<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 27.7.2016
 * Time: 12:16
 */


//win DS = "\", Mac/Linux DS = "/"
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:' . DS . 'AppServ' . DS . 'www' . DS . 'New_Report' . DS . 'Uporedna');
defined('ADMIN_PATH') ? null : define('ADMIN_PATH', SITE_ROOT . DS . 'admin' . DS . 'included');
defined('CLASS_PATH') ? null : define('CLASS_PATH', SITE_ROOT . DS . 'admin' . DS . 'classes');


/*echo SITE_ROOT;
echo "<br/>";

echo LIB_PATH;*/

//echo CLASS_PATH;


require ADMIN_PATH . DS . 'config.php';
require ADMIN_PATH . DS . 'db.php';
require ADMIN_PATH . DS . 'functions.php';
//require CLASS_PATH . DS. 'Match.php';
require CLASS_PATH . DS . 'betradar.php';


