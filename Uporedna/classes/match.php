<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.11.2017
 * Time: 11:44
 */

class match
{
    protected $hometeam;
    protected $awayteam;
    protected $league;
    protected $ki1;
    protected $kix;
    protected $ki2;
    protected $tp;
    protected $gg;

    public function setattribute($atr, $value){
        $this->$atr = $value;
    }

    public function getattribute($atr){
        return $this->$atr;
    }

    public function addmatch(){
        global $conn;
        $sql=$conn->prepare('insert into soccer3 (liga, domacin, gost, ki_1, ki_x, ki_2, ug3p, gg) values (:lg, :ht, :vt, :k1, :kx, :k2, :tp, :gg)');
        $sql->bindParam(":lg", $this->league);
        $sql->bindParam(":ht", $this->hometeam);
        $sql->bindParam(":vt", $this->awayteam);
        $sql->bindParam(":k1", $this->ki1);
        $sql->bindParam(":kx", $this->kix);
        $sql->bindParam(":k2", $this->ki2);
        $sql->bindParam(":tp", $this->tp);
        $sql->bindParam(":gg", $this->gg);
        $sql->execute();
    }
}

//$match = new match();
//
//$match->setattribute('hometeam', 'Rad');
//
//var_dump($match);

