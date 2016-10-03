<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 29.9.2016
 * Time: 13:15
 */
class MatchTeamResults
{
    private $startTime;
    private $matchId;
    private $teamId;
    private $teamName;
    private $resultTypeId;
    private $homeVisitor;
    private $valueFor;
    private $valueOposit;

    public function getAllCompetitionResults()
    {
        global $conn;
        $sql = $conn->query("SELECT m.start_time startTime, m.event_id matchId, r.participant_id teamId, t.name teamName, r.EVENT_RESULT_TYPE_ID resultTypeId, r.home_visitor homeVisitor, r.VALUE valueFor, r1.VALUE valueOposite
FROM init_match m, init_event_results r, init_team t, init_event_results r1
WHERE m.event_id = r.event_id
AND m.event_id = r1.event_id
AND r.EVENT_RESULT_TYPE_ID = r1.EVENT_RESULT_TYPE_ID
AND r.participant_id <> r1.participant_id
AND r.participant_id = t.id
AND m.season_id = 24
AND m.competition_id = 1
AND r.participant_id IN (32,23)
ORDER BY r.participant_id, m.start_time  DESC");
        $sql->execute();
        $allCompetitionResults = $sql->fetchAll(PDO::FETCH_OBJ);
        return $allCompetitionResults ;
    }


}