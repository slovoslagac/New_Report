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
defined('ADMIN_PATH') ? null : define('ADMIN_PATH', SITE_ROOT . DS . 'public' . DS . 'includes');



require ADMIN_PATH . DS . 'config.php';
require ADMIN_PATH . DS . 'db.php';
require ADMIN_PATH . DS . 'functions.php';
require ADMIN_PATH . DS . 'Match.php';
require ADMIN_PATH . DS . 'MatchTeamResults.php';
require ADMIN_PATH . DS . 'teamTmpData.php';


