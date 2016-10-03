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


function get_all_teams_from_competition($cmpID, $seaspnId) {
    global $conn;
    $sql = $conn->query("");
    $sql->execute();
    $allTeamsByCompetition = $sql->fetchAll(PDO::FETCH_OBJ);
    return $allTeamsByCompetition ;
}

function returnObjectById($id, $array){
    foreach ($array as $ar){
        if ($ar->id == $id){
            echo "$ar->object <br/>";
        }
    }
}