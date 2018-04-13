<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 23.9.2016
 * Time: 16:01
 */

require_once('config.php');


try {
    $conn = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo db_server.'bla bla <br>';
    echo "Error: " . $e->getMessage();
}


try {
    $conn_old = new PDO("mysql:host=$db_server_old;dbname=$db_name_old", $db_user_old, $db_pass_old);
    $conn_old->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo db_server_old.'bla bla <br>';
    echo "Error: " . $e->getMessage();
}

