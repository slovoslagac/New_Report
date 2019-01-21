<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 20.8.2018.
 * Time: 15:46
 */

class stanleymatch
{
    public $hometeam = null;
    public $awayteam = null;
    public $OT_ONE = null;
    public $competition = null;

    public function setAttr($attr, $value)
    {
        $this->$attr = $value;
    }

    public function insertMatch(){
        global $conn;
        $sql = $conn->prepare('insert into stenlybetro3 (domacin ,gost ,ki_1 ,ki_x ,ki_2 ,ug02 ,ug3p, liga) VALUES (:ht, :vt, :ki1, :kix, :ki2, :ug02, :ugtp, :cmp)');
        $sql->bindParam(':ht', $this->hometeam);
        $sql->bindParam(':vt', $this->awayteam);
        $sql->bindParam(':ki1', $this->OT_ONE);
        $sql->bindParam(':kix', $this->OT_CROSS);
        $sql->bindParam(':ki2', $this->OT_TWO);
        $sql->bindParam(':ug02', $this->OT_UNDER);
        $sql->bindParam(':ugtp', $this->OT_OVER);
        $sql->bindParam(':cmp', $this->competition);
        $sql->execute();
    }
}