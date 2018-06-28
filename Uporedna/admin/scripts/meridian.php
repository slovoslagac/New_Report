<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 19.6.2018.
 * Time: 13:13
 */

include ("../included/simple_html_dom.php");


$html = file_get_html("https://meridianbet.rs/sr/kladjenje/fudbal");

echo file_get_html('https://meridianbet.rs/sr/kladjenje/fudbal')->plaintext;
