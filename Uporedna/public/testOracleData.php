<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 8.10.2016
 * Time: 15:20
 */

require(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));



$myTmpData = new testEvent();

$tmpData = $myTmpData->getAllEvents();

foreach ($tmpData as $tm) {

    $myId = $tm->ID;
    $myDate = $tm->DATE_TIME;
    echo "$myId - $myDate <br/>";
}