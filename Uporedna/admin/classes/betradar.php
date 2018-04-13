<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 28.9.2017
 * Time: 10:07
 */
class betradar
{
    public function getBetradarByImport(){
        global $conn;
        $sql= $conn->prepare("select id, DATE_FORMAT(date_time, '%d.%m.%Y %H:%i') date_time
from import
where source_id = 6
and id in (select distinct import_id from src_odds)
and date_time > now() - interval 25 day order by id desc ");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function deleteCurentImport($id) {
        global $conn;
        $sql = $conn->prepare("delete from src_odds where import_id = :id");
        $sql ->bindParam(':id', $id);
        $sql->execute();
    }

    public function deleteCurentOdds() {
        global $conn;
        $sql = $conn->prepare("delete from src_current_odds where source_id = 6");
        $sql->execute();
    }


}


