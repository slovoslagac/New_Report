<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 29.9.2016
 * Time: 14:14
 */
require(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$allUsersResults = new MatchTeamResults();

$allStats = $allUsersResults->getAllCompetitionResults();


//var_dump($allStats);

$alldata[] = '';
$team = '';
foreach ($allStats as $as) {
    $sum = $as->valueFor + $as->valueOposite;
    echo "$as->teamName ($as->homeVisitor) : $sum ($as->valueFor:$as->valueOposite)<br/>";
    if($as->teamId != $team){
        $team = $as->teamId;
        if($sum >=3) {
            if(returnObjectById($team,$alldata) == true) {

            } else {
                $alldata[] = new teamTmpData($team,$as->teamName,$sum);
            }

        }
    }
}

echo "<br/>";

var_dump($alldata);