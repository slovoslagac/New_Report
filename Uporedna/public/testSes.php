<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 4.5.2017
 * Time: 15:29
 */

$sesion = new sesj

//echo $_SESSION["id"];
var_dump($_SESSION);

session_cache_limiter('private');
$cache_limiter = session_cache_limiter();

echo $cache_limiter;