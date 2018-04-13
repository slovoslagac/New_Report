<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 29.9.2016
 * Time: 14:24
 */
class teamTmpData
{
    public $teamId;
    public $teamName;
    public $threePlus;
    public $threePlusSeria;
    public $zeroTwo;
    public $zeroTwoSeria;
    public $gg;
    public $ggSeria;
    public $ggtp;
    public $ggtpSeria;
    public $ktp;
    public $ktpSeria;
    public $dtp;
    public $dtpSeria;
    public $kk;
    public $kkSeria;
    public $dpp;
    public $dppSeria;
    public $numMatch;


    public function __construct($id,$name)
    {
        $this->teamId=$id;
        $this->teamName =$name;
    }


    static function sortByTest($a, $b, $c, $d)
    {
        $t1 = $b->
        $al = strtolower($a->$c);
        $bl = strtolower($b->$c);
        if ($al == $bl) {
            $al = strtolower($a->$d);
            $bl = strtolower($b->$d);
        }
        return ($al > $bl) ? -1 : +1;
    }
    static function sortByTPS($a, $b)
    {
        $al = strtolower($a->threePlus);
        $bl = strtolower($b->threePlus);
        if ($al == $bl) {
            $al = strtolower($a->teamName);
            $bl = strtolower($b->teamName);
            return ($al < $bl) ? -1 : +1;
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByNDS($a, $b)
    {
        $al = strtolower($a->zeroTwo);
        $bl = strtolower($b->zeroTwo);
        if ($al == $bl) {
            $al = strtolower($a->teamName);
            $bl = strtolower($b->teamName);
            return ($al < $bl) ? -1 : +1;
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByGGS($a, $b)
    {
        $al = strtolower($a->gg);
        $bl = strtolower($b->gg);
        if ($al == $bl) {
            $al = strtolower($a->teamName);
            $bl = strtolower($b->teamName);
            return ($al < $bl) ? -1 : +1;
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByGGTPS($a, $b)
    {
        $al = strtolower($a->ggtp);
        $bl = strtolower($b->ggtp);
        if ($al == $bl) {
            $al = strtolower($a->teamName);
            $bl = strtolower($b->teamName);
            return ($al < $bl) ? -1 : +1;
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByKTPS($a, $b)
    {
        $al = strtolower($a->ktp);
        $bl = strtolower($b->ktp);
        if ($al == $bl) {
            $al = strtolower($a->teamName);
            $bl = strtolower($b->teamName);
            return ($al < $bl) ? -1 : +1;
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByDTPS($a, $b)
    {
        $al = strtolower($a->dtp);
        $bl = strtolower($b->dtp);
        if ($al == $bl) {
            $al = strtolower($a->teamName);
            $bl = strtolower($b->teamName);
            return ($al < $bl) ? -1 : +1;
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByKKS($a, $b)
    {
        $al = strtolower($a->kk);
        $bl = strtolower($b->kk);
        if ($al == $bl) {
            $al = strtolower($a->teamName);
            $bl = strtolower($b->teamName);
            return ($al < $bl) ? -1 : +1;
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByDPPS($a, $b)
    {
        $al = strtolower($a->dpp);
        $bl = strtolower($b->dpp);
        if ($al == $bl) {
            $al = strtolower($a->teamName);
            $bl = strtolower($b->teamName);
            return ($al < $bl) ? -1 : +1;
        }
        return ($al > $bl) ? -1 : +1;
    }

}

