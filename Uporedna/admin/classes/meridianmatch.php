<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 20.8.2018.
 * Time: 15:46
 */

class meridian
{
    public $hometeam = null;
    public $awayteam = null;
    public $competition = null;
    public $ki1 = null;
    public $kix = null;
    public $ki2 = null;
    public $tp = null;
    public $gg = null;

    private $allcodes = array(28=>'gg', 221=>'ki1', 222=>'kix', 223 =>'ki2', 295 => 'tp', 'home'=>'hometeam', 'away'=>'awayteam', 'cmp'=>'competition');

    public function setAttr($attr, $value)
    {
        if(array_key_exists($attr, $this->allcodes)) {
            $at = $this->allcodes[$attr];
            $this->$at = $value;
        }
    }

    public function insertMatch(){
        global $conn;
        $sql = $conn->prepare('insert into meridian3 (domacin ,gost ,ki_1 ,ki_x ,ki_2, ug3p, gg, liga) VALUES (:ht, :vt, :ki1, :kix, :ki2, :ugtp, :gg, :cmp)');
        $sql->bindParam(':ht', $this->hometeam);
        $sql->bindParam(':vt', $this->awayteam);
        $sql->bindParam(':ki1', $this->ki1);
        $sql->bindParam(':kix', $this->kix);
        $sql->bindParam(':ki2', $this->ki2);
        $sql->bindParam(':gg', $this->gg);
        $sql->bindParam(':ugtp', $this->tp);
        $sql->bindParam(':cmp', $this->competition);
        $sql->execute();
    }
}