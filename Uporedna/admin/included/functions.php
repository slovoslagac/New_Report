<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 27.9.2016
 * Time: 11:02
 */

function clear_match_insert_table (){
    global $conn;
    $sql = "delete from ulaz_new";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function clear_odds_insert_table (){
    global $conn;
    $sql = "delete from ulaz_odds";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}