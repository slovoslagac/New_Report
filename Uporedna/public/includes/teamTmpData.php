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

    public function __construct($id,$name,$tp)
    {
        $this->teamId=$id;
        $this->teamName =$name;
        $this->threePlus = $tp;
    }

}

