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


    static function sortByTPS($a, $b)
    {
        $al = strtolower($a->threePlusSeria);
        $bl = strtolower($b->threePlusSeria);
        if ($al == $bl) {
            $al = strtolower($a->threePlus);
            $bl = strtolower($b->threePlus);
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByNDS($a, $b)
    {
        $al = strtolower($a->zeroTwoSeria);
        $bl = strtolower($b->zeroTwoSeria);
        if ($al == $bl) {
            $al = strtolower($a->zeroTwo);
            $bl = strtolower($b->zeroTwo);
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByGGS($a, $b)
    {
        $al = strtolower($a->ggSeria);
        $bl = strtolower($b->ggSeria);
        if ($al == $bl) {
            $al = strtolower($a->gg);
            $bl = strtolower($b->gg);
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByGGTPS($a, $b)
    {
        $al = strtolower($a->ggtpSeria);
        $bl = strtolower($b->ggtpSeria);
        if ($al == $bl) {
            $al = strtolower($a->ggtp);
            $bl = strtolower($b->ggtp);
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByKTPS($a, $b)
    {
        $al = strtolower($a->ktpSeria);
        $bl = strtolower($b->ktpSeria);
        if ($al == $bl) {
            $al = strtolower($a->ktp);
            $bl = strtolower($b->ktp);
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByDTPS($a, $b)
    {
        $al = strtolower($a->dtpSeria);
        $bl = strtolower($b->dtpSeria);
        if ($al == $bl) {
            $al = strtolower($a->dtp);
            $bl = strtolower($b->dtp);
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByKKS($a, $b)
    {
        $al = strtolower($a->kkSeria);
        $bl = strtolower($b->kkSeria);
        if ($al == $bl) {
            $al = strtolower($a->kk);
            $bl = strtolower($b->kk);
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByDPPS($a, $b)
    {
        $al = strtolower($a->dppSeria);
        $bl = strtolower($b->dppSeria);
        if ($al == $bl) {
            $al = strtolower($a->dpp);
            $bl = strtolower($b->dpp);
        }
        return ($al > $bl) ? -1 : +1;
    }

}

