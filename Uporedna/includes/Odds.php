<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 6.3.2017
 * Time: 13:45
 */
class Odds
{
    public $gameName;
    public $subgameName;
    public $gameHandicap;
    public $oddValue;
    public $matchId;

    public function __construct($game, $subgame, $handicap = '', $value, $matchid)
    {
        $this->gameName = $game;
        $this->subgameName = $subgame;
        $this->gameHandicap = $handicap;
        $this->oddValue = $value;
        $this->matchId = $matchid;
    }

}