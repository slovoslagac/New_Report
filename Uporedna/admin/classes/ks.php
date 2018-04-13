<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 9.2.2018
 * Time: 15:29
 */
class ks
{
    private $id;
    private $kip;
    private $ki6;
    private $kic;
    private $ugp;
    private $ug6;
    private $ugc;

    public function setValues($id, $kip, $ki6, $kic, $ugp, $ug6, $ugc)
    {
        $this->id = $id;
        $this->kip = $kip;
        $this->ki6 = $ki6;
        $this->kic = $kic;
        $this->ugp = $ugp;
        $this->ug6 = $ug6;
        $this->ugc = $ugc;
    }

    public function addValue(){
        global $conn;
        $sql= $conn->prepare('insert into ks_competition (competition_id,kip,ki6,kic,ugp,ug6,ugc) VALUES (:id, :kip, :ki6, :kic, :ugp, :ug6, :ugc)');
        $sql->bindParam(':id', $this->id);
        $sql->bindParam(':kip', $this->kip);
        $sql->bindParam(':ki6', $this->ki6);
        $sql->bindParam(':kic', $this->kic);
        $sql->bindParam(':ugp', $this->ugp);
        $sql->bindParam(':ug6', $this->ug6);
        $sql->bindParam(':ugc', $this->ugc);
        $sql->execute();
    }

    public function deleteValue(){
        global $conn;
        $sql = $conn->prepare('delete from ks_competition where competition_id = :id');
        $sql->bindParam(':id', $this->id);
        $sql->execute();
    }
}