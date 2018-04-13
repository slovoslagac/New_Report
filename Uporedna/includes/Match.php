<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 23.9.2016
 * Time: 15:02
 */
class Match
{
    public $league;
    public $home_team;
    public $visitor_team;
    public $league_id;
    public $home_team_id;
    public $visitor_team_id;
    public $match;
    public $match_id;
    public $source_id;
    public $start_time;
    public $season;
    public $round;
    public $sport;

    public function __construct($league, $leagueid, $hteam, $hteamid, $vteam, $vteamid, $match, $match_id, $source_id, $sport, $start_time = '', $season = '', $round = '')
    {
        $this->league = $league;
        $this->league_id = $leagueid;
        $this->home_team = $hteam;
        $this->home_team_id = $hteamid;
        $this->visitor_team = $vteam;
        $this->visitor_team_id = $vteamid;
        $this->match = $match;
        $this->match_id = $match_id;
        $this->source_id = $source_id;
        $this->start_time = $start_time;
        $this->season = $season;
        $this->round = $round;
        $this->sport = $sport;
    }

    public function insert_new_match() {

    }

    public function add_match()
    {

        global $conn;
        $le = $this->league;
        $leId = $this->league_id;
        $hoTe = $this->home_team;
        $hoTeId = $this->home_team_id;
        $viTe = $this->visitor_team;
        $viTeId = $this->visitor_team_id;
        $ma = $this->match;
        $maId = $this->match_id;
        $so = $this->source_id;
        $se = $this->season;
        $st = $this->start_time;
        $ro = $this->round;
        $sp = $this->sport;
        $insert_new_match = $conn->prepare("insert into ulaz_new (starttime ,liga_id ,liga ,utk_id ,utakmica ,dom_id ,dom ,gost_id ,gost ,source ,season ,round, sport_id)
                                            values(:st, :leId, :le, :maId, :ma, :hoTeId, :hoTe, :viTeId, :viTe, :so, :se, :ro, :sp)");
        $insert_new_match->bindParam(':st', $st);
        $insert_new_match->bindParam(':leId', $leId);
        $insert_new_match->bindParam(':le', $le);
        $insert_new_match->bindParam(':maId', $maId);
        $insert_new_match->bindParam(':ma', $ma);
        $insert_new_match->bindParam(':hoTeId', $hoTeId);
        $insert_new_match->bindParam(':hoTe', $hoTe);
        $insert_new_match->bindParam(':viTeId', $viTeId);
        $insert_new_match->bindParam(':viTe', $viTe);
        $insert_new_match->bindParam(':so', $so);
        $insert_new_match->bindParam(':se', $se);
        $insert_new_match->bindParam(':ro', $ro);
        $insert_new_match->bindParam(':sp', $sp);
        $insert_new_match->execute();

    }

    public function getAllMatches() {

    }
}