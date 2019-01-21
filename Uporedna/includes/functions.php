<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 27.9.2016
 * Time: 11:02
 */

function clear_match_insert_table (){
    global $conn;
    $sql = "delete from ulaz_new";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function clear_odds_insert_table (){
    global $conn;
    $sql = "delete from ulaz_odds";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}


function get_all_teams_from_competition($cmpID, $seaspnId) {
    global $conn;
    $sql = $conn->query("");
    $sql->execute();
    $allTeamsByCompetition = $sql->fetchAll(PDO::FETCH_OBJ);
    return $allTeamsByCompetition ;
}

function getAllCompetitions()
{
    global $conn;
    $sql = $conn->query("select distinct alternative_id as competition_id, ic.name
FROM init_match im, init_competition ic
where im.competition_id = ic.id
and im.event_id in (select distinct event_id from init_event_results)
order by 2");
    $sql->execute();
    $allCompetition = $sql->fetchAll(PDO::FETCH_OBJ);
    return $allCompetition;
}

//function getObjectById($id, $array){
//    foreach ($array as $ar){
//        if ($ar->teamId == $id){
//            return true;
//        } else {
//            return false;
//        }
//    }
//}

//function getAllCompetitionResults($leagueId)
//{
//    global $conn;
//    $sql = $conn->query("SELECT m.start_time startTime, m.event_id matchId, r.participant_id teamId, t.name teamName, r.EVENT_RESULT_TYPE_ID resultTypeId, r.home_visitor homeVisitor, r.VALUE valueFor, r1.VALUE valueOposite, r2.VALUE valueHtFor, r3.VALUE valueHtOposite
//FROM init_match m, init_team t, init_event_results r, init_event_results r1, init_event_results r2, init_event_results r3
//WHERE m.event_id = r.event_id
//AND m.event_id = r1.event_id
//AND r.EVENT_RESULT_TYPE_ID = r1.EVENT_RESULT_TYPE_ID
//AND r.participant_id <> r1.participant_id
//and r.EVENT_RESULT_TYPE_ID = 1
//AND r.participant_id = t.id
//and m.event_id = r2.event_id
//and r.participant_id = r2.participant_id
//and r2.EVENT_RESULT_TYPE_ID=2
//and m.event_id = r3.event_id
//and r.participant_id <> r3.participant_id
//and r3.EVENT_RESULT_TYPE_ID=2
//AND m.season_id = 24
//AND m.competition_id = $leagueId
//ORDER BY r.participant_id, m.start_time  DESC");
//    $sql->execute();
//    $allCompetitionResults = $sql->fetchAll(PDO::FETCH_OBJ );
//    return $allCompetitionResults;
//}


function getAllCompetitionResults($leagueId)
{
    global $conn;
    $sql = $conn->query("select a.startTime, a.matchId, a.teamId, a.teamName, a.resultTypeId, a.homeVisitor, a.valueFor, a.valueOposite, r2.VALUE valueHtFor, r3.VALUE valueHtOposite, a.seasonId
from
(
SELECT m.start_time startTime, m.event_id matchId, r.participant_id teamId, t.name teamName, r.EVENT_RESULT_TYPE_ID resultTypeId, r.home_visitor homeVisitor, r.VALUE valueFor, r1.VALUE valueOposite, m.season_id as seasonId
FROM init_match m, init_team t, init_event_results r, init_event_results r1, init_competition c
WHERE m.event_id = r.event_id
and m.competition_id = c.id
AND m.event_id = r1.event_id
AND r.EVENT_RESULT_TYPE_ID = r1.EVENT_RESULT_TYPE_ID
AND r.participant_id <> r1.participant_id
and r.EVENT_RESULT_TYPE_ID = 1
AND r.participant_id = t.id
AND m.season_id in (28,27)
AND c.alternative_id = $leagueId) a
left join init_event_results r2 on r2.event_id = a.matchId and a.teamId = r2.participant_id and r2.EVENT_RESULT_TYPE_ID=2
left join init_event_results r3 on a.matchId = r3.event_id and a.teamId <> r3.participant_id and r3.EVENT_RESULT_TYPE_ID=2
ORDER BY a.teamId, a.startTime  DESC");
    $sql->execute();
    $allCompetitionResults = $sql->fetchAll(PDO::FETCH_OBJ );
    return $allCompetitionResults;
}


function getAllCompetitionResultsByRound($leagueId)
{
    global $conn;
    $sql = $conn->query("select a.matchRound, a.matchTime, a.homeTeam, a.awayTeam, a.homeTeamScore, a.awayTeamScore, hr1.VALUE as homeTeamHalfTimeScore, ar1.VALUE as awayTeamHalfTimeScore, cmp
from
(
select m.round as matchRound,m.start_time as matchTime, t.name as homeTeam, t1.name as awayTeam, hr.VALUE as homeTeamScore, ar.value as awayTeamScore, m.event_id as event_id, m.home_team_id as home_team_id, m.visitor_team_id as visitor_team_id, case when c.id = c.alternative_id then c.id else c.alternative_id + 1 end cmp
from init_match m, init_team t, init_team t1, init_event_results hr, init_event_results ar, init_competition c
where c.alternative_id = $leagueId
and m.competition_id = c.id
and m.season_id in (28,27)
and m.home_team_id =t.id
and m.visitor_team_id = t1.id
and hr.event_id = m.event_id
and hr.participant_id = m.home_team_id
and hr.EVENT_RESULT_TYPE_ID = 1
and ar.event_id = m.event_id
and ar.participant_id = m.visitor_team_id
and ar.EVENT_RESULT_TYPE_ID = 1 ) a
left join init_event_results hr1 on hr1.event_id = a.event_id and hr1.participant_id = a.home_team_id and hr1.EVENT_RESULT_TYPE_ID = 2
left join init_event_results ar1 on ar1.event_id = a.event_id and ar1.participant_id = a.visitor_team_id and ar1.EVENT_RESULT_TYPE_ID = 2
order by cmp, 1,2");
    $sql->execute();
    $allCompetitionResultsByRound = $sql->fetchAll(PDO::FETCH_OBJ );
    return $allCompetitionResultsByRound;
}

function getAllMatchResultsFT(){
    global $conn;
    $sql = $conn->prepare("select a.startTime, a.matchId, a.teamId, a.teamName, a.resultTypeId, a.homeVisitor, a.valueFor, a.valueOposite, a.seasonId
from
(
SELECT m.start_time startTime, m.event_id matchId, r.participant_id teamId, t.name teamName, r.EVENT_RESULT_TYPE_ID resultTypeId, r.home_visitor homeVisitor, r.VALUE valueFor, r1.VALUE valueOposite, m.season_id as seasonId
FROM init_match m, init_team t, init_event_results r, init_event_results r1
WHERE m.event_id = r.event_id
AND m.event_id = r1.event_id
AND r.EVENT_RESULT_TYPE_ID = r1.EVENT_RESULT_TYPE_ID
AND r.participant_id <> r1.participant_id
and r.EVENT_RESULT_TYPE_ID = 1
AND r.participant_id = t.id
and m.init_sport_id = 1
and m.phase in (1,79)
AND m.season_id in (28,27)) a
ORDER BY a.teamId, a.startTime  DESC
;");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_OBJ);
    return $result;
}


function getAllMatchResultsFull(){
    global $conn;
    $sql = $conn->prepare("select a.startTime, a.matchId, a.teamId, a.teamName, a.resultTypeId, a.homeVisitor, a.valueFor, a.valueOposite, r2.VALUE valueHtFor, r3.VALUE valueHtOposite, a.seasonId
from
(
SELECT m.start_time startTime, m.event_id matchId, r.participant_id teamId, t.name teamName, r.EVENT_RESULT_TYPE_ID resultTypeId, r.home_visitor homeVisitor, r.VALUE valueFor, r1.VALUE valueOposite, m.season_id as seasonId
FROM init_match m, init_team t, init_event_results r, init_event_results r1
WHERE m.event_id = r.event_id
AND m.event_id = r1.event_id
AND r.EVENT_RESULT_TYPE_ID = r1.EVENT_RESULT_TYPE_ID
AND r.participant_id <> r1.participant_id
and r.EVENT_RESULT_TYPE_ID = 1
AND r.participant_id = t.id
and m.init_sport_id = 1
and m.phase in (1,79)
AND m.season_id in (27,28)) a
left join init_event_results r2 on r2.event_id = a.matchId and a.teamId = r2.participant_id and r2.EVENT_RESULT_TYPE_ID=2
left join init_event_results r3 on a.matchId = r3.event_id and a.teamId <> r3.participant_id and r3.EVENT_RESULT_TYPE_ID=2
ORDER BY a.teamId, a.startTime
;");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_OBJ);
    return $result;
}