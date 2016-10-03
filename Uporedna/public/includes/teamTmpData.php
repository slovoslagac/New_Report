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
    public $gg;
    public $ggThreePlus;
    public $numMatch;
    public $sortVal = 'threePlusSeria';

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
            return 0;
        }
        return ($al > $bl) ? -1 : +1;
    }

    static function sortByND($a, $b)
    {
        $al = strtolower($a->zeroTwo);
        $bl = strtolower($b->zeroTwo);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? -1 : +1;
    }

}

