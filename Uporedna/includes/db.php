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
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    echo db_server.'bla bla <br>';
    echo "Error: " . $e->getMessage();
}


try{
    $conn_oracle = new PDO("oci:dbname=".$tns_oracle,$db_username_oracle,$db_password_oracle);
}catch(PDOException $e){
//    echo ($e->getMessage());
}

//$conn_oracle = oci_connect($db_username_oracle, $db_password_oracle, $db_host_oracle);
//if (!$conn) {
//    $e = oci_error();
//    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
//}




