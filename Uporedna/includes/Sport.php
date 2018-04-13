<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 22.12.2016
 * Time: 14:59
 */

class sport
{
    public $name;
    private $id;

    private function getAllSports()
    {
        global $conn;
        $sql = $conn->prepare("SELECT name, id FROM init_sport");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getSportById($val)
    {

        $array = $this->getAllSports();
        foreach ($array as $item) {
            if ($item->id == $val) {
                return $item->name;
            }
    }


    }
}


