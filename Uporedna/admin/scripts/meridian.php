<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 19.6.2018.
 * Time: 13:13
 */

require_once('/conn/mysqlAdminPDOold.php');
include ("/conn/oracle.php");
include ("/classes/meridianmatch.php");

$matchid = null;
$home = null;
$away = null;
$cmp = null;
$allmatches = array();
$tmpmatch = new meridian;

$array= oci_parse($conn_oracle, "select *
from
(
select m.id matchid, home_team_name home_team, m.AWAY_TEAM_NAME away_team, odd_data_id odd_id, odd_value value, cmp.region_NAME ||' ' || cmp.name competition, time_received, m.START_TIME, ROW_NUMBER () OVER (PARTITION BY m.id, home_team_name, m.AWAY_TEAM_NAME, odd_data_id  ORDER BY time_received DESC) rn, TO_CHAR(mov.TIME_RECEIVED, 'DD.MM.YYYY HH24:Mi:ss')
from LISTPARSER.MERIDIAN_MATCH_ODD mo, LISTPARSER.MERIDIAN_MATCH_ODD_VALUE mov, LISTPARSER.MERIDIAN_TELEBET_GAME mtg, LISTPARSER.MERIDIAN_MATCH m, LISTPARSER.MERIDIAN_COMPETITION cmp
where  mo.ID = mov.ODD_ID
and m.COMPETITION_ID = cmp.id
and mo.MATCH_ID = m.ID
and mtg.MERIDIAN_GAME_ID = mo.GAME_ID
and mtg.MERIDIAN_subgame = mov.SUBGAME_NAME
and m.SPORT_ID = 58
and m.START_TIME > sysdate
) a
where rn = 1
order by 6,1,4 desc, 2");

oci_execute($array);

while (($row = oci_fetch_object($array)) != false) {


    if($matchid == null || $matchid != $row->MATCHID) {
        array_push($allmatches, $tmpmatch);
        unset($tmpmatch);
        $tmpmatch = new meridian;
        $home = $row->HOME_TEAM;
        $away = $row->AWAY_TEAM;
        $cmp = $row->COMPETITION;
        $matchid = $row->MATCHID;

        $tmpmatch->setAttr("home", $home);
        $tmpmatch->setAttr("away", $away);
        $tmpmatch->setAttr("cmp", $cmp);

//        var_dump($tmpmatch);
    }

        $tmpmatch->setAttr($row->ODD_ID, $row->VALUE);
//    echo "$row->MATCHID, $row->HOME_TEAM, $row->AWAY_TEAM, $row->ODD_ID, $row->VALUE, $row->START_TIME, $row->COMPETITION \n";



}

//var_dump($allmatches);

$del = 'DELETE FROM meridian3';
$prep = $conn->prepare($del);
$prep->execute();


foreach ($allmatches as $item) {
    $match = new meridian();
    $match = $item;
    $match->insertMatch();
    unset($match);
}

echo "Pozvezujem utakmice <br>";
$con_game_ig = 'call spajanje_meridian';
$prep = $conn->prepare($con_game_ig);
$prep->execute();
$conn = null;