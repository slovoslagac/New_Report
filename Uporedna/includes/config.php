<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 27.7.2016
 * Time: 12:16
 */

$db_server = "192.168.180.124";
$db_user = "proske";
$db_pass = "proske1989";
$db_name = "Uporedna_new";



$tns_oracle = "
(DESCRIPTION =
      (ADDRESS =
        (PROTOCOL = TCP)
        (HOST = 192.168.0.170)
        (PORT = 1521)
      )
      (CONNECT_DATA =
        (SERVER=dedicated)
        (SERVICE_NAME = csdb)
      )
 )
       ";

//$db_username_oracle = 'proske';
//$db_password_oracle = 'proske21';
//$db_host_oracle='192.168.0.160/sscsdb';

$db_username_oracle = 'proske';
$db_password_oracle = 'proske21';
$db_host_oracle='192.168.0.170/csdb';
?>